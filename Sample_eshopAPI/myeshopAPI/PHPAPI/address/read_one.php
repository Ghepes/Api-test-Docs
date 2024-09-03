<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/address.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$address = new Address($db);

$address->AddressId = isset($_GET['id']) ? $_GET['id'] : die();
$address->readOne();
 
if($address->AddressId!=null){
    $address_arr = array(
        
"AddressId" => $address->AddressId,
"Password" => html_entity_decode($address->Password),
"CustomerId" => $address->CustomerId,
"AptNumber" => $address->AptNumber,
"HouseNumber" => $address->HouseNumber,
"Street" => $address->Street,
"ZipCode" => $address->ZipCode,
"City" => $address->City,
"StateName" => $address->StateName,
"Country" => $address->Country,
"Contact" => $address->Contact
    );
    http_response_code(200);
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "address found","document"=> $address_arr));
}
else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "address does not exist.","document"=> ""));
}
?>
