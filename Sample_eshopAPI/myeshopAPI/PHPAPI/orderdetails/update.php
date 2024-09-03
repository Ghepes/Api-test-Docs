<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/orderdetails.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$orderdetails = new Orderdetails($db);

$data = json_decode(file_get_contents("php://input"));
$orderdetails->OrderId = $data->OrderId;

if(!isEmpty($data->ProductId)
&&!isEmpty($data->Quantity)
&&!isEmpty($data->UnitCost)){

if(!isEmpty($data->ProductId)) { 
$orderdetails->ProductId = $data->ProductId;
} else { 
$orderdetails->ProductId = '';
}
$orderdetails->ProductName = $data->ProductName;
if(!isEmpty($data->Quantity)) { 
$orderdetails->Quantity = $data->Quantity;
} else { 
$orderdetails->Quantity = '';
}
if(!isEmpty($data->UnitCost)) { 
$orderdetails->UnitCost = $data->UnitCost;
} else { 
$orderdetails->UnitCost = '';
}
if($orderdetails->update()){
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
else{
    http_response_code(503);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update orderdetails","document"=> ""));
}
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update orderdetails. Data is incomplete.","document"=> ""));
}
?>
