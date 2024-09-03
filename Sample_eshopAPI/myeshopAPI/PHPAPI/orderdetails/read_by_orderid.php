<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/orderdetails.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$orderdetails = new Orderdetails($db);

$orderdetails->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$orderdetails->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
$orderdetails->OrderId = isset($_GET['OrderId']) ? $_GET['OrderId'] : die();

$stmt = $orderdetails->readByOrderId();
$num = $stmt->rowCount();

if($num>0){
    $orderdetails_arr=array();
	$orderdetails_arr["pageno"]=$orderdetails->pageNo;
	$orderdetails_arr["pagesize"]=$orderdetails->no_of_records_per_page;
    $orderdetails_arr["total_count"]=$orderdetails->total_record_count();
    $orderdetails_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $orderdetails_item=array(
            
"ShippingId" => $ShippingId,
"OrderId" => $OrderId,
"ProductName" => $ProductName,
"ProductId" => $ProductId,
"ProductName" => $ProductName,
"Quantity" => $Quantity,
"UnitCost" => $UnitCost
        );
        array_push($orderdetails_arr["records"], $orderdetails_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "orderdetails found","document"=> $orderdetails_arr));
    
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No orderdetails found.","document"=> ""));
}
 


