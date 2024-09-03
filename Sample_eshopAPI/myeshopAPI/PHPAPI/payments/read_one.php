<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/payments.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$payments = new Payments($db);

$payments->PaymentId = isset($_GET['id']) ? $_GET['id'] : die();
$payments->readOne();
 
if($payments->PaymentId!=null){
    $payments_arr = array(
        
"PaymentId" => $payments->PaymentId,
"PaymentType" => $payments->PaymentType,
"PaymentTotal" => $payments->PaymentTotal,
"PaymentDate" => $payments->PaymentDate,
"ExpiryDate" => $payments->ExpiryDate,
"CVV" => $payments->CVV,
"CardNumber" => $payments->CardNumber
    );
    http_response_code(200);
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "payments found","document"=> $payments_arr));
}
else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "payments does not exist.","document"=> ""));
}
?>
