<?php
require_once "includes/database.php";
for($i=0;$i<=10;$i++){
    $username =
        mysqli_query($connection,"INSERT INTO (username,first_name,last_name,email,password,
        country,city,address,about me,postalcode,species
        ) 
      VALUES () ");
}