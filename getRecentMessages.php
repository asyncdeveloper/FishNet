<?php
require_once "includes/database.php";
session_start();
if(!empty($_POST['id'])){
    $receiver       =  $_POST['id'];
    $loggedInUser   =  $_SESSION['id'];
    $lastMsgId      =  $_POST['lastMsgId'];
    $result = mysqli_query(
        $connection, "SELECT * FROM messages WHERE  id>$lastMsgId AND ( sender='$receiver' OR receiver='$receiver') ORDER BY id"
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
