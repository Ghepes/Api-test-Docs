<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/payments.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$payments = new Payments($db);

$searchKey = isset($_GET['key']) ? $_GET['key'] : die();
$payments->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$payments->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

$stmt = $payments->search($searchKey);
$num = $stmt->rowCount();
 
if($num>0){
    $payments_arr=array();
	$payments_arr["pageno"]=$payments->pageNo;
	$payments_arr["pagesize"]=$payments->no_of_records_per_page;
    $payments_arr["total_count"]=$payments->search_count($searchKey);
    $payments_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $payments_item=array(
            
"PaymentId" => $PaymentId,
"PaymentType" => $PaymentType,
"PaymentTotal" => $PaymentTotal,
"PaymentDate" => $PaymentDate,
"ExpiryDate" => $ExpiryDate,
"CVV" => $CVV,
"CardNumber" => $CardNumber
        );
        array_push($payments_arr["records"], $payments_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "payments found","document"=> $payments_arr));
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No payments found.","document"=> ""));
}
 


