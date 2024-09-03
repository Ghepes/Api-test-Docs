<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/returns.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$returns = new Returns($db);

$data = json_decode(file_get_contents("php://input"));
$returns->ReturnId = $data->ReturnId;

if(!isEmpty($data->CustomerId)
&&!isEmpty($data->DeliveryPartnerId)
&&!isEmpty($data->OrderId)
&&!isEmpty($data->ProductId)
&&!isEmpty($data->ReturnDate)){

if(!isEmpty($data->CustomerId)) { 
$returns->CustomerId = $data->CustomerId;
} else { 
$returns->CustomerId = '';
}
if(!isEmpty($data->DeliveryPartnerId)) { 
$returns->DeliveryPartnerId = $data->DeliveryPartnerId;
} else { 
$returns->DeliveryPartnerId = '';
}
if(!isEmpty($data->OrderId)) { 
$returns->OrderId = $data->OrderId;
} else { 
$returns->OrderId = '';
}
if(!isEmpty($data->ProductId)) { 
$returns->ProductId = $data->ProductId;
} else { 
$returns->ProductId = '';
}
if(!isEmpty($data->ReturnDate)) { 
$returns->ReturnDate = $data->ReturnDate;
} else { 
$returns->ReturnDate = '';
}
$returns->Description = $data->Description;
if($returns->update()){
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
else{
    http_response_code(503);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update returns","document"=> ""));
}
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update returns. Data is incomplete.","document"=> ""));
}
?>
