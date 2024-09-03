<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/deliverypartner.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$deliverypartner = new Deliverypartner($db);

$deliverypartner->DeliveryPartnerId = isset($_GET['id']) ? $_GET['id'] : die();
$deliverypartner->readOne();
 
if($deliverypartner->DeliveryPartnerId!=null){
    $deliverypartner_arr = array(
        
"DeliveryPartnerId" => $deliverypartner->DeliveryPartnerId,
"AptNumber" => $deliverypartner->AptNumber,
"HouseNumber" => $deliverypartner->HouseNumber,
"Street" => $deliverypartner->Street,
"Zipcode" => $deliverypartner->Zipcode,
"City" => $deliverypartner->City,
"StateName" => $deliverypartner->StateName,
"Country" => $deliverypartner->Country,
"Contact" => $deliverypartner->Contact
    );
    http_response_code(200);
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "deliverypartner found","document"=> $deliverypartner_arr));
}
else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "deliverypartner does not exist.","document"=> ""));
}
?>
