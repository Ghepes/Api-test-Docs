<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/orders.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();
 
$orders = new Orders($db);
$data = json_decode(file_get_contents("php://input"));

if(!isEmpty($data->PaymentId)
&&!isEmpty($data->DateShipped)
&&!isEmpty($data->ShippingId)
&&!isEmpty($data->Status)){
	
    
$orders->CustomerId = $data->CustomerId;
if(!isEmpty($data->PaymentId)) { 
$orders->PaymentId = $data->PaymentId;
} else { 
$orders->PaymentId = '';
}
$orders->DateCreated = $data->DateCreated;
if(!isEmpty($data->DateShipped)) { 
$orders->DateShipped = $data->DateShipped;
} else { 
$orders->DateShipped = '';
}
if(!isEmpty($data->ShippingId)) { 
$orders->ShippingId = $data->ShippingId;
} else { 
$orders->ShippingId = '';
}
if(!isEmpty($data->Status)) { 
$orders->Status = $data->Status;
} else { 
$orders->Status = '';
}
 	$lastInsertedId=$orders->create();
    if($lastInsertedId!=0){
        http_response_code(201);
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
    else{
        http_response_code(503);
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create orders","document"=> ""));
    }
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create orders. Data is incomplete.","document"=> ""));
}
?>
