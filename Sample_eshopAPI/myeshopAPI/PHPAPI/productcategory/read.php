<?php
include_once '../config/header.php';
include_once '../config/database.php';
include_once '../objects/productcategory.php';
include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$productcategory = new Productcategory($db);

$productcategory->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$productcategory->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

$stmt = $productcategory->read();
$num = $stmt->rowCount();
if($num>0){
    $productcategory_arr=array();
	$productcategory_arr["pageno"]=$productcategory->pageNo;
	$productcategory_arr["pagesize"]=$productcategory->no_of_records_per_page;
    $productcategory_arr["total_count"]=$productcategory->total_record_count();
    $productcategory_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $productcategory_item=array(
            
"ProductCategoryID" => $ProductCategoryID,
"Name" => $Name
        );
         array_push($productcategory_arr["records"], $productcategory_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "productcategory found","document"=> $productcategory_arr));
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No productcategory found.","document"=> ""));
}
 


