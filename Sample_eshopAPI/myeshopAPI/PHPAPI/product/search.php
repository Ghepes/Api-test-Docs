<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$searchKey = isset($_GET['key']) ? $_GET['key'] : die();
$product->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$product->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

$stmt = $product->search($searchKey);
$num = $stmt->rowCount();
 
if($num>0){
    $product_arr=array();
	$product_arr["pageno"]=$product->pageNo;
	$product_arr["pagesize"]=$product->no_of_records_per_page;
    $product_arr["total_count"]=$product->search_count($searchKey);
    $product_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $product_item=array(
            
"ProductID" => $ProductID,
"Name" => $Name,
"ProductCategoryID" => $ProductCategoryID,
"Name" => $Name,
"ProductSubCategoryID" => $ProductSubCategoryID,
"ProductName" => $ProductName,
"Price" => $Price,
"Manufacturer" => $Manufacturer,
"ProductDimension" => $ProductDimension,
"ProductWeight" => $ProductWeight,
"SellerName" => $SellerName,
"SellerID" => $SellerID,
"SellerName" => $SellerName,
"Rating" => $Rating,
"DateOfManufacture" => $DateOfManufacture,
"ProductImage" => html_entity_decode($ProductImage)
        );
        array_push($product_arr["records"], $product_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "product found","document"=> $product_arr));
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No product found.","document"=> ""));
}
 


