<?php
require_once "includes/database.php";
session_start();
$jsonData   =  file_get_contents('species.json');
$data       = json_decode($jsonData,true);
foreach ($data['data'] as $key => $val){

    $name        =$val['FBname'];
    $importance = $val['Importance'];
    $comments   = $val['Comments'];
    $genus     = $val['Genus'];
    $dangerous  = $val['Dangerous'];
    $usedForAquaculture = $val['UsedforAquaculture'];
    $species    = $val['Species'];
	$images		= "Fishes/$name.jpg";

    //echo $name."<br>";
	//$qry = mysqli_query($connection, "INSERT INTO species(name,genus,comments,dangerous,species,Importance,UsedforAquaculture,image) VALUES('$name','$genus','$comments','$dangerous','$species','$importance','$usedForAquaculture','$images')");



}

