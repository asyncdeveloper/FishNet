<?php
require_once "includes/database.php";
if(!empty($_POST)){
    //$currentTime = "2018-02-15 19:49:41";
    //$lastLogin   = "2018-02-15 14:43:37";
    $user = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM users where id='{$_POST['id']}'"));
    $lastLogin = $user['last_login'];
    $currentTime = date('Y-m-d H:i:s', time());
    $datetime1 = new DateTime($currentTime);
    $datetime2 = new DateTime($lastLogin);
    $interval = $datetime1->diff($datetime2);

    if($interval->format('%h') > 0){
        //More dan an hr
        $hrs  = $interval->format('%i');
        $mins = $interval->format('%h');
        echo "0";

    }else{
        //Less than hr
        $hrs  = $interval->format('%i');
        $mins = $interval->format('%h');
        if($mins>2  || $hrs>0)
            echo "0";
        else
            echo "1";
    }
}
