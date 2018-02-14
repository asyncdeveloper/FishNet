<?php
require_once "includes/database.php";
if(!empty($_POST['id'])){
    $id = $_POST['id'];
    $userInfo = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM users WHERE id='$id'"));

    echo json_encode($userInfo);
}
