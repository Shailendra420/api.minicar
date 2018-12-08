<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods, GET');

include_once '../../Database.php';
include_once '../../DbTables/Manufacturer.php';

$database = new Database();
$db = $database->connect();
// echo $db;exit();
$manufacturer = new Manufacturer($db);

$result = $manufacturer->read();

$num = $result->rowCount();


if($num > 0) {
    $manufacturer_arr = array();
    // $manufacturer_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // echo $row['model_name'];
        extract($row);

        $model_item = array(
            'manufacturer_name' => $manufacturer_name,
            'manufacturer_id' => $manufacturer_id
        );

        array_push($manufacturer_arr, $model_item);
    }
    echo json_encode($manufacturer_arr);
} else {
    echo json_encode(
        array(
            'message' => 'No post found.'
        )
    );
}