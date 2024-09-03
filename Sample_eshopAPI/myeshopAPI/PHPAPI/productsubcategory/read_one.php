<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/productsubcategory.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$productsubcategory = new Productsubcategory($db);

$productsubcategory->ProductSubCategoryID = isset($_GET['id']) ? $_GET['id'] : die();
$productsubcategory->readOne();
 
if($productsubcategory->ProductSubCategoryID!=null){
    $productsubcategory_arr = array(
        
"ProductSubCategoryID" => $productsubcategory->ProductSubCategoryID,
"ProductCategoryID" => $productsubcategory->ProductCategoryID,
"Name" => $productsubcategory->Name
    );
    http_response_code(200);
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "productsubcategory found","document"=> $productsubcategory_arr));
}
else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "productsubcategory does not exist.","document"=> ""));
}
?>
