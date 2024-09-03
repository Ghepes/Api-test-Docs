<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/orderdetails.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$orderdetails = new Orderdetails($db);

$orderdetails->OrderId = isset($_GET['id']) ? $_GET['id'] : die();
$orderdetails->readOne();
 
if($orderdetails->OrderId!=null){
    $orderdetails_arr = array(
        
"ShippingId" => $orderdetails->ShippingId,
"OrderId" => $orderdetails->OrderId,
"ProductName" => $orderdetails->ProductName,
"ProductId" => $orderdetails->ProductId,
"ProductName" => $orderdetails->ProductName,
"Quantity" => $orderdetails->Quantity,
"UnitCost" => $orderdetails->UnitCost
    );
    http_response_code(200);
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "orderdetails found","document"=> $orderdetails_arr));
}
else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "orderdetails does not exist.","document"=> ""));
}
?>
