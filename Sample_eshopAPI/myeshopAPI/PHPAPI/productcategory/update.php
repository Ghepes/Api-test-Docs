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
$productcategory->ProductCategoryID = $data->ProductCategoryID;

if(!isEmpty($data->Name)){

if(!isEmpty($data->Name)) { 
$productcategory->Name = $data->Name;
} else { 
$productcategory->Name = '';
}
if($productcategory->update()){
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
else{
    http_response_code(503);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update productcategory","document"=> ""));
}
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update productcategory. Data is incomplete.","document"=> ""));
}
?>
