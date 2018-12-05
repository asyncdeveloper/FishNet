<?php
require_once "includes/database.php";
session_start();
$files = $_FILES;
if(!empty($files)) {
    foreach ($files as $file) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        if ($file['size'] > 5000000) {
            echo "-2";
            exit();
        }
        $supportedImg = array('jpeg', 'jpg', 'png', 'psd');
        if (!in_array($ext, $supportedImg)) {
            echo "-3";
            exit();
        }
        else{  // issa profilefoto
            $foto = time().".$ext";
            if (move_uploaded_file($file['tmp_name'], "profile_photo/" . $foto)) {
                $id   = $_SESSION['id'];
                $foto ="profile_photo/$foto";
                $qry = mysqli_query($connection,"UPDATE users SET image='$foto' WHERE id='$id'") ;
                if($qry){
                    echo "1";
                    exit();
                }
            }
            else{
                echo "-4";
                exit();
            }
        }
    }
}
