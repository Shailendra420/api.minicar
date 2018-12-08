<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, X-Requested-With');

include_once '../../Database.php';
include_once '../../DbTables/Manufacturer.php';

$database = new Database();
$db = $database->connect();

$manufacturer = new Manufacturer($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
// echo $data;exit;
// echo $data;exit;

$manufacturer->manufacturer_name = $data->data;

// Create post
if($manufacturer->insert()) {
    echo json_encode(
        array("message" => "Post created")
    );
} else {
    echo json_encode(
        array("message" => "Post Not created")
    );
}