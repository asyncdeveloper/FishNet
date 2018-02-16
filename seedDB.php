<?php
require_once "includes/database.php";
$jsonData   =  file_get_contents('FISH_JSON/catfish.json');
$data       = json_decode($jsonData,true);
foreach ($data as $val){
    $name   = $val[0]['FBname'];
    $details = explode(",",$val[0]['Author']);
    $author = $details[0];
    $year   = $details[1];
    $importance = $val[0]['Importance'];
    $comments   = $val[0]['Comments'];
    $weight     = $val[0]['Weight'];
    $aquarium   = $val[0]['Aquarium'];
    $usedForAquaculture = $val[0]['UsedforAquaculture'];

    //print_r($val);

}

