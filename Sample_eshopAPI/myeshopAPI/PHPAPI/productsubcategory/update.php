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
$productsubcategory->ProductSubCategoryID = $data->ProductSubCategoryID;

if(!isEmpty($data->Name)){

$productsubcategory->ProductCategoryID = $data->ProductCategoryID;
if(!isEmpty($data->Name)) { 
$productsubcategory->Name = $data->Name;
} else { 
$productsubcategory->Name = '';
}
if($productsubcategory->update()){
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
else{
    http_response_code(503);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update productsubcategory","document"=> ""));
}
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update productsubcategory. Data is incomplete.","document"=> ""));
}
?>
