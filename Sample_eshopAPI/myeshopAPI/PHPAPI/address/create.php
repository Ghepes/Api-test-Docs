<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/address.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();
 
$address = new Address($db);
$data = json_decode(file_get_contents("php://input"));

if(true){
	
    
$address->CustomerId = $data->CustomerId;
$address->AptNumber = $data->AptNumber;
$address->HouseNumber = $data->HouseNumber;
$address->Street = $data->Street;
$address->ZipCode = $data->ZipCode;
$address->City = $data->City;
$address->StateName = $data->StateName;
$address->Country = $data->Country;
$address->Contact = $data->Contact;
 	$lastInsertedId=$address->create();
    if($lastInsertedId!=0){
        http_response_code(201);
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
    else{
        http_response_code(503);
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create address","document"=> ""));
    }
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create address. Data is incomplete.","document"=> ""));
}
?>
