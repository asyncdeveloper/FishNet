<?php
require_once "includes/database.php";
session_start();
if(!empty($_POST)){
    //$currentTime = "2018-02-15 19:49:41";
    //$lastLogin   = "2018-02-15 14:43:37";
    $user = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM users where id='{$_POST['id']}'"));
    $lastLogin = $user['last_login'];
    $currentTime = date('Y-m-d H:i:s', time());
    $datetime1 = new DateTime($currentTime);
    $datetime2 = new DateTime($lastLogin);
    $interval = $datetime1->diff($datetime2);
    $hrs  = (int) $interval->format('%i');
    $mins = (int)$interval->format('%h');
    if($mins == 0 && $hrs==0){
        echo "1";
    }else{
        if($mins>2  || $hrs>0)
            echo "0";
        else
            echo "1";
    }

    exit();
}
