<?php
require_once "includes/database.php";
if(!empty($_POST['id'])){
    $receiver = $_POST['id'];
    $loggedInUser = $_SESSION['id'];
    $result = mysqli_query(
        $connection, "SELECT * FROM messages WHERE sender='$loggedInUser' OR receiver='$loggedInUser' ORDER BY id ASC "
    );
    $userMessages =array();
    while($row =mysqli_fetch_assoc($result)){
        $message    = $row['message'];
        $timeSent   = $row['time_sent'];
        $sender     = $row['sender'];
        $receiver   = $row['receiver'];
        $status     = $row['status'];
        $userMessages[] = array(
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
