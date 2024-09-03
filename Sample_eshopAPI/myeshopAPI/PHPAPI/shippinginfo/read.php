<?php
include_once '../config/header.php';
include_once '../config/database.php';
include_once '../objects/shippinginfo.php';
include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$shippinginfo = new Shippinginfo($db);

$shippinginfo->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$shippinginfo->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

$stmt = $shippinginfo->read();
$num = $stmt->rowCount();
if($num>0){
    $shippinginfo_arr=array();
	$shippinginfo_arr["pageno"]=$shippinginfo->pageNo;
	$shippinginfo_arr["pagesize"]=$shippinginfo->no_of_records_per_page;
    $shippinginfo_arr["total_count"]=$shippinginfo->total_record_count();
    $shippinginfo_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $shippinginfo_item=array(
            
"ShippingId" => $ShippingId,
"DeliveryPartnerId" => $DeliveryPartnerId,
"ShippingCost" => $ShippingCost,
"ShippingType" => $ShippingType
        );
         array_push($shippinginfo_arr["records"], $shippinginfo_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "shippinginfo found","document"=> $shippinginfo_arr));
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No shippinginfo found.","document"=> ""));
}
 


