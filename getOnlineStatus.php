<?php
require_once "includes/database.php";
if(!empty($_POST)){
    $user = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM users where id='{$_POST['id']}'"));
    $lastLogin = $user['last_login'];
    $currentTime = date('Y-m-d h:i:s', time());
    $diffInSeconds = strtotime($currentTime) - strtotime($lastLogin);
    if($diffInSeconds>60){
        echo 0;
    }else{
        echo 1;
    }
}
