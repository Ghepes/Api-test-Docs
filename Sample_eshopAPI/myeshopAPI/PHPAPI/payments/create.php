<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/payments.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();
 
$payments = new Payments($db);
$data = json_decode(file_get_contents("php://input"));

if(!isEmpty($data->PaymentType)
&&!isEmpty($data->PaymentTotal)
&&!isEmpty($data->PaymentDate)
&&!isEmpty($data->ExpiryDate)
&&!isEmpty($data->CVV)
&&!isEmpty($data->CardNumber)){
	
    
if(!isEmpty($data->PaymentType)) { 
$payments->PaymentType = $data->PaymentType;
} else { 
$payments->PaymentType = '';
}
if(!isEmpty($data->PaymentTotal)) { 
$payments->PaymentTotal = $data->PaymentTotal;
} else { 
$payments->PaymentTotal = '';
}
if(!isEmpty($data->PaymentDate)) { 
$payments->PaymentDate = $data->PaymentDate;
} else { 
$payments->PaymentDate = '';
}
if(!isEmpty($data->ExpiryDate)) { 
$payments->ExpiryDate = $data->ExpiryDate;
} else { 
$payments->ExpiryDate = '';
}
if(!isEmpty($data->CVV)) { 
$payments->CVV = $data->CVV;
} else { 
$payments->CVV = '';
}
if(!isEmpty($data->CardNumber)) { 
$payments->CardNumber = $data->CardNumber;
} else { 
$payments->CardNumber = '';
}
 	$lastInsertedId=$payments->create();
    if($lastInsertedId!=0){
        http_response_code(201);
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
    else{
        http_response_code(503);
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create payments","document"=> ""));
    }
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create payments. Data is incomplete.","document"=> ""));
}
?>
