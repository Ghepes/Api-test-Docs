<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/productcategory.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();
 
$productcategory = new Productcategory($db);
$data = json_decode(file_get_contents("php://input"));

if(!isEmpty($data->Name)){
	
    
if(!isEmpty($data->Name)) { 
$productcategory->Name = $data->Name;
} else { 
$productcategory->Name = '';
}
 	$lastInsertedId=$productcategory->create();
    if($lastInsertedId!=0){
        http_response_code(201);
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
    else{
        http_response_code(503);
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create productcategory","document"=> ""));
    }
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create productcategory. Data is incomplete.","document"=> ""));
}
?>
