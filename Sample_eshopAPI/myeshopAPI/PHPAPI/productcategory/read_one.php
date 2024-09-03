<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/productcategory.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$productcategory = new Productcategory($db);

$productcategory->ProductCategoryID = isset($_GET['id']) ? $_GET['id'] : die();
$productcategory->readOne();
 
if($productcategory->ProductCategoryID!=null){
    $productcategory_arr = array(
        
"ProductCategoryID" => $productcategory->ProductCategoryID,
"Name" => $productcategory->Name
    );
    http_response_code(200);
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "productcategory found","document"=> $productcategory_arr));
}
else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "productcategory does not exist.","document"=> ""));
}
?>
