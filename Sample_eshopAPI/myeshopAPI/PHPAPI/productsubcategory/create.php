<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/productsubcategory.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();
 
$productsubcategory = new Productsubcategory($db);
$data = json_decode(file_get_contents("php://input"));

if(!isEmpty($data->Name)){
	
    
$productsubcategory->ProductCategoryID = $data->ProductCategoryID;
if(!isEmpty($data->Name)) { 
$productsubcategory->Name = $data->Name;
} else { 
$productsubcategory->Name = '';
}
 	$lastInsertedId=$productsubcategory->create();
    if($lastInsertedId!=0){
        http_response_code(201);
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
    else{
        http_response_code(503);
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create productsubcategory","document"=> ""));
    }
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create productsubcategory. Data is incomplete.","document"=> ""));
}
?>
