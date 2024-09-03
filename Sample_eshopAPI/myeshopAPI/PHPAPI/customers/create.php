<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/customers.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();
 
$customers = new Customers($db);
$data = json_decode(file_get_contents("php://input"));

if(!isEmpty($data->Password)){
	
    
$customers->FirstName = $data->FirstName;
$customers->LastName = $data->LastName;
$customers->Phone = $data->Phone;
$customers->Email = $data->Email;
$customers->DateOfBirth = $data->DateOfBirth;
if(!isEmpty($data->Password)) { 
$customers->Password = $data->Password;
} else { 
$customers->Password = 'TEST';
}
 	$lastInsertedId=$customers->create();
    if($lastInsertedId!=0){
        http_response_code(201);
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
    else{
        http_response_code(503);
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create customers","document"=> ""));
    }
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create customers. Data is incomplete.","document"=> ""));
}
?>
