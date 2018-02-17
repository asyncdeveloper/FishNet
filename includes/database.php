<?php
defined('DB_SERVER') ? null : define('DB_SERVER', 'localhost');
// defined('DB_USER')   ? null : define('DB_USER', 'id981499_sheyi');
defined('DB_USER')   ? null : define('DB_USER', 'sheyi');
defined('DB_PASS')   ? null : define('DB_PASS', 'nbvhgfytrm');
defined('DB_NAME')   ? null : define('DB_NAME', 'hackernest');
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die("Error Connecting to Database");

if(isset($_SESSION['id'])){
    if(intval($_SESSION['id'])){
        mysqli_query($connection,"UPDATE users SET last_login=NOW() WHERE id='{$_SESSION['id']}' ");
    }
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start()
?>

