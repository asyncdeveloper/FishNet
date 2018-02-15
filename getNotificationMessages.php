<?php
require_once "includes/database.php";
if(true){
    $loggedInUser = $_SESSION['id'];
    $lastLoginTime = mysqli_fetch_array(mysqli_query(
        $connection, "SELECT last_login FROM users WHERE id='$loggedInUser'"
    ));
    $lastLoginTime = array_shift($lastLoginTime);

    $result = mysqli_query(
        $connection, "SELECT * FROM messages WHERE time_sent>'$lastLoginTime' AND ( sender='$loggedInUser' OR receiver='$loggedInUser')  ORDER BY id LIMIT 5"
    );
    $userMessages =array();
    while($row =mysqli_fetch_assoc($result)){
        $id             = $row['id'];
        $sender         = $row['sender'];
        $receiver       = $row['receiver'];
        if($sender==$loggedInUser){
            $userid = $receiver;
        }else{
            $userid = $sender;
        }
        $userNameSet    = mysqli_query($connection,"SELECT * FROM users WHERE id='$userid'");
        $userName       = mysqli_fetch_array($userNameSet);
        $userName       = $userName['username'];
        $message        = $row['message'];
        $timeSent       = $row['time_sent'];
        $sender         = $row['sender'];
        $receiver       = $row['receiver'];
        $status         = $row['status'];
        $userMessages[] = array(
            "id"          =>  $id,
            "username"    =>  $userName,
            "sender"      =>  $sender,
            "receiver"    =>  $receiver,
            "message"     =>  $message,
            "read"        =>  $status,
            "timeSent"    =>  $timeSent,
        );
    }
    // encoding array to json format
    echo json_encode($userMessages);
}
