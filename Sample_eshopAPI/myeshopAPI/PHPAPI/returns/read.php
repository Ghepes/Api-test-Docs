<?php
include_once '../config/header.php';
include_once '../config/database.php';
include_once '../objects/returns.php';
include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$returns = new Returns($db);

$returns->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$returns->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

$stmt = $returns->read();
$num = $stmt->rowCount();
if($num>0){
    $returns_arr=array();
	$returns_arr["pageno"]=$returns->pageNo;
	$returns_arr["pagesize"]=$returns->no_of_records_per_page;
    $returns_arr["total_count"]=$returns->total_record_count();
    $returns_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $returns_item=array(
            
"ReturnId" => $ReturnId,
"Password" => html_entity_decode($Password),
"CustomerId" => $CustomerId,
"DeliveryPartnerId" => $DeliveryPartnerId,
"ShippingId" => $ShippingId,
"OrderId" => $OrderId,
"ProductName" => $ProductName,
"ProductId" => $ProductId,
"ReturnDate" => $ReturnDate,
"Description" => $Description
        );
         array_push($returns_arr["records"], $returns_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "returns found","document"=> $returns_arr));
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No returns found.","document"=> ""));
}
 


