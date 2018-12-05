<?php
require_once "includes/database.php";
$cities =array();
if(!empty($_POST)){
    $stateId = $_POST['state'];
    $resultSet = mysqli_query(
        $connection, "SELECT * FROM cities WHERE state_id='$stateId' ORDER BY name"
    );
    while($row =mysqli_fetch_assoc($resultSet)){
        $id         = $row['id'];
        $name       = $row['name'];
        $cities[] = array(
            "id"          =>  $id,
            "name"        =>  $name
        );
    }
    // encoding array to json format
    echo json_encode($cities);
}else{
    echo json_encode($cities);
}
