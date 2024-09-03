<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/warehouse.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();
 
$warehouse = new Warehouse($db);
$data = json_decode(file_get_contents("php://input"));

if(true){
	
    
$warehouse->Street = $data->Street;
$warehouse->Zipcode = $data->Zipcode;
$warehouse->City = $data->City;
$warehouse->StateName = $data->StateName;
$warehouse->Country = $data->Country;
$warehouse->Contact = $data->Contact;
 	$lastInsertedId=$warehouse->create();
    if($lastInsertedId!=0){
        http_response_code(201);
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
    else{
        http_response_code(503);
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create warehouse","document"=> ""));
    }
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create warehouse. Data is incomplete.","document"=> ""));
}
?>
