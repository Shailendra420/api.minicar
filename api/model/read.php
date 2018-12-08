<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods, GET');

include_once '../../Database.php';
include_once '../../DbTables/Model.php';

$database = new Database();
$db = $database->connect();
// echo $db;exit();
$model = new Model($db);

$result = $model->read();

$num = $result->rowCount();


if($num > 0) {
    $model_arr = array();
    // $model_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // echo $row['model_name'];
        extract($row);

        $model_item = array(
            'model_id' => $model_id,
            'manufacturer_name' => $manufacturer_name,
            'model_name' => $model_name,
            'count' => $count
        );

        array_push($model_arr, $model_item);
    }
    echo json_encode($model_arr);
} else {
    echo json_encode(
        array(
            'message' => 'No post found.'
        )
    );
}