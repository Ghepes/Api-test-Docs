<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/returns.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$returns = new Returns($db);

$returns->ReturnId = isset($_GET['id']) ? $_GET['id'] : die();
$returns->readOne();
 
if($returns->ReturnId!=null){
    $returns_arr = array(
        
"ReturnId" => $returns->ReturnId,
"Password" => html_entity_decode($returns->Password),
"CustomerId" => $returns->CustomerId,
"DeliveryPartnerId" => $returns->DeliveryPartnerId,
"ShippingId" => $returns->ShippingId,
"OrderId" => $returns->OrderId,
"ProductName" => $returns->ProductName,
"ProductId" => $returns->ProductId,
"ReturnDate" => $returns->ReturnDate,
"Description" => $returns->Description
    );
    http_response_code(200);
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "returns found","document"=> $returns_arr));
}
else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "returns does not exist.","document"=> ""));
}
?>
