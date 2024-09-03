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
$orAnd = isset($_GET['orAnd']) ? $_GET['orAnd'] : "OR";

$productsubcategory->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$productsubcategory->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

$stmt = $productsubcategory->searchByColumn($data,$orAnd);

$num = $stmt->rowCount();
if($num>0){
    $productsubcategory_arr=array();
	$productsubcategory_arr["pageno"]=$productsubcategory->pageNo;
	$productsubcategory_arr["pagesize"]=$productsubcategory->no_of_records_per_page;
    $productsubcategory_arr["total_count"]=$productsubcategory->search_record_count($data,$orAnd);
    $productsubcategory_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $productsubcategory_item=array(
            
"ProductSubCategoryID" => $ProductSubCategoryID,
"ProductCategoryID" => $ProductCategoryID,
"Name" => $Name
        );
 
        array_push($productsubcategory_arr["records"], $productsubcategory_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "productsubcategory found","document"=> $productsubcategory_arr));
    
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No productsubcategory found.","document"=> ""));
}
 


