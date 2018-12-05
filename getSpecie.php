<?php
require_once "includes/database.php";
session_start();

if(!empty($_POST['name'])){
    $search = $_POST['name'];
    $result = mysqli_query(
        $connection, "SELECT * FROM species WHERE name like '%$search%' OR species LIKE '%$search%' OR genus LIKE '%$search%' LIMIT 1"
    );
    $resultSpecies =array();
    while($val =mysqli_fetch_assoc($result)){
        $id          =$val['id'];
        $name        =$val['name'];
        $importance = $val['Importance'];
        $comments   = $val['comments'];
        $genus     = $val['genus'];
        $dangerous  = $val['dangerous'];
        $usedForAquaculture = $val['UsedforAquaculture'];
        $species    = $val['species'];
        $images		= "Fishes/$name.jpg";
        $resultSpecies[] = array(
            "id"            =>  $id,
            "name"          =>  $name,
            "importance"    =>  $importance,
            "comment"       =>  $comments,
            "genus"                   =>  $genus,
            "dangerous"             =>  $dangerous,
            "UsedforAquaculture"         =>  $usedForAquaculture,
            "species"       =>  $species,
            "images"        =>  $images
        );
    }
    // encoding array to json format
    echo json_encode($resultSpecies);
}
