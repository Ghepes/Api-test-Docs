<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/shippinginfo.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();
 
$shippinginfo = new Shippinginfo($db);
$data = json_decode(file_get_contents("php://input"));

if(true){
	
    
$shippinginfo->DeliveryPartnerId = $data->DeliveryPartnerId;
$shippinginfo->ShippingCost = $data->ShippingCost;
$shippinginfo->ShippingType = $data->ShippingType;
 	$lastInsertedId=$shippinginfo->create();
    if($lastInsertedId!=0){
        http_response_code(201);
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
    else{
        http_response_code(503);
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create shippinginfo","document"=> ""));
    }
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create shippinginfo. Data is incomplete.","document"=> ""));
}
?>
