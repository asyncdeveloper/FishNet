<?php
defined('DB_SERVER') ? null : define('DB_SERVER', 'localhost');
// defined('DB_USER')   ? null : define('DB_USER', 'id981499_sheyi');
defined('DB_USER')   ? null : define('DB_USER', 'sheyi');
defined('DB_PASS')   ? null : define('DB_PASS', 'nbvhgfytrm');
defined('DB_NAME')   ? null : define('DB_NAME', 'hackernest');
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die("Error Connecting to Database");
session_start();
if(isset($_SESSION['id'])){
    if(intval($_SESSION['id'])){
        //Update Last login
        mysqli_query($connection,"UPDATE users SET last_login=NOW() WHERE id='{$_SESSION['id']}' ");
    }
}