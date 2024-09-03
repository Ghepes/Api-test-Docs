<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/orders.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$orders = new Orders($db);

$orders->OrderId = isset($_GET['id']) ? $_GET['id'] : die();
$orders->readOne();
 
if($orders->OrderId!=null){
    $orders_arr = array(
        
"OrderId" => $orders->OrderId,
"CustomerId" => $orders->CustomerId,
"PaymentId" => $orders->PaymentId,
"DateCreated" => $orders->DateCreated,
"DateShipped" => $orders->DateShipped,
"ShippingId" => $orders->ShippingId,
"Status" => $orders->Status
    );
    http_response_code(200);
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "orders found","document"=> $orders_arr));
}
else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "orders does not exist.","document"=> ""));
}
?>
