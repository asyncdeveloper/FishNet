<?php
require_once "includes/database.php";
if(!empty($_POST['id'])){
    $id = $_POST['id'];
    $userInfo = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM users WHERE id='$id'"));
    $currentTime = date('Y-m-d H:i:s', time());
    $datetime1 = new DateTime($currentTime);
    $datetime2 = new DateTime($userInfo['last_login']);
    $interval = $datetime1->diff($datetime2);
    $hrs  = (int) $interval->format('%i');
    $mins = (int)$interval->format('%h');
    if($mins == 0 && $hrs==0){
        $userInfo['isActive'] = 1;
    }else{
        if($mins>2  || $hrs>0)
            $userInfo['isActive'] = 0;
        else
            $userInfo['isActive'] = 1;
    }

    echo json_encode($userInfo);
}
