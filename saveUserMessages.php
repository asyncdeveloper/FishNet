<?php
require_once "includes/database.php";
session_start();
if(!empty($_POST) && sizeof($_POST)==3){
    $message    = $_POST['body'];
    $sender     = $_POST['sender_id'];
    $receiver   = $_POST['receiver_id'];
    if(mysqli_query($connection,"INSERT INTO messages (message,sender,receiver) VALUES('$message','$sender','$receiver')"))
        echo 1;
}
