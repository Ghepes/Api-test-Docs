<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/deliverypartner.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$deliverypartner = new Deliverypartner($db);

$data = json_decode(file_get_contents("php://input"));
$deliverypartner->DeliveryPartnerId = $data->DeliveryPartnerId;

if(true){

$deliverypartner->AptNumber = $data->AptNumber;
$deliverypartner->HouseNumber = $data->HouseNumber;
$deliverypartner->Street = $data->Street;
$deliverypartner->Zipcode = $data->Zipcode;
$deliverypartner->City = $data->City;
$deliverypartner->StateName = $data->StateName;
$deliverypartner->Country = $data->Country;
$deliverypartner->Contact = $data->Contact;
if($deliverypartner->update()){
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
else{
    http_response_code(503);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update deliverypartner","document"=> ""));
}
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update deliverypartner. Data is incomplete.","document"=> ""));
}
?>
