<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/shippinginfo.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$shippinginfo = new Shippinginfo($db);

$shippinginfo->ShippingId = isset($_GET['id']) ? $_GET['id'] : die();
$shippinginfo->readOne();
 
if($shippinginfo->ShippingId!=null){
    $shippinginfo_arr = array(
        
"ShippingId" => $shippinginfo->ShippingId,
"DeliveryPartnerId" => $shippinginfo->DeliveryPartnerId,
"ShippingCost" => $shippinginfo->ShippingCost,
"ShippingType" => $shippinginfo->ShippingType
    );
    http_response_code(200);
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "shippinginfo found","document"=> $shippinginfo_arr));
}
else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "shippinginfo does not exist.","document"=> ""));
}
?>
