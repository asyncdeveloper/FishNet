<?php
require_once "includes/database.php";
$states =array();
if(!empty($_POST)){
    $countryId = $_POST['country'];
    $resultSet = mysqli_query(
        $connection, "SELECT * FROM states WHERE country_id='$countryId' ORDER BY name"
    );
    while($row =mysqli_fetch_assoc($resultSet)){
        $id         = $row['id'];
        $name       = $row['name'];
        $states[] = array(
            "id"          =>  $id,
            "name"        =>  $name
        );
    }
    // encoding array to json format
    echo json_encode($states);
}else{
    echo json_encode($states);
}
