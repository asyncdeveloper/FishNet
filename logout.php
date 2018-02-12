<?php
if(isset($_SESSION['id']) || isset($_SESSION['username'])){
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    header("location: login.php");
}else{
    header("location: login.php");
}