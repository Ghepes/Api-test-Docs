<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$product->ProductID = isset($_GET['id']) ? $_GET['id'] : die();
$product->readOne();
 
if($product->ProductID!=null){
    $product_arr = array(
        
"ProductID" => $product->ProductID,
"Name" => $product->Name,
"ProductCategoryID" => $product->ProductCategoryID,
"Name" => $product->Name,
"ProductSubCategoryID" => $product->ProductSubCategoryID,
"ProductName" => $product->ProductName,
"Price" => $product->Price,
"Manufacturer" => $product->Manufacturer,
"ProductDimension" => $product->ProductDimension,
"ProductWeight" => $product->ProductWeight,
"SellerName" => $product->SellerName,
"SellerID" => $product->SellerID,
"SellerName" => $product->SellerName,
"Rating" => $product->Rating,
"DateOfManufacture" => $product->DateOfManufacture,
"ProductImage" => html_entity_decode($product->ProductImage)
    );
    http_response_code(200);
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "product found","document"=> $product_arr));
}
else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "product does not exist.","document"=> ""));
}
?>
