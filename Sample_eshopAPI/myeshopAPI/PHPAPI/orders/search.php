<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/orders.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$orders = new Orders($db);

$searchKey = isset($_GET['key']) ? $_GET['key'] : die();
$orders->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$orders->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

$stmt = $orders->search($searchKey);
$num = $stmt->rowCount();
 
if($num>0){
    $orders_arr=array();
	$orders_arr["pageno"]=$orders->pageNo;
	$orders_arr["pagesize"]=$orders->no_of_records_per_page;
    $orders_arr["total_count"]=$orders->search_count($searchKey);
    $orders_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $orders_item=array(
            
"OrderId" => $OrderId,
"CustomerId" => $CustomerId,
"PaymentId" => $PaymentId,
"DateCreated" => $DateCreated,
"DateShipped" => $DateShipped,
"ShippingId" => $ShippingId,
"Status" => $Status
        );
        array_push($orders_arr["records"], $orders_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "orders found","document"=> $orders_arr));
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No orders found.","document"=> ""));
}
 


