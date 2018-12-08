<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, X-Requested-With');

include_once '../../Database.php';
include_once '../../DbTables/Model.php';

$database = new Database();
$db = $database->connect();

$model = new Model($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
// echo $data;exit;
// echo $data;exit;
$model->model_id = $data->data;

// $model->model_name = $data->model;
// $model->count = $data->count;
// $model->manufacturer_id = $data->manufacturer;

// Create post
if($model->update()) {
    echo json_encode(
        array("message" => "Update Succes")
    );
} else {
    echo json_encode(
        array("message" => "Update Failed")
    );
}