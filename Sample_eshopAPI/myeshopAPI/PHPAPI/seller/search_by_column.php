<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/seller.php';
include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();

$seller = new Seller($db);

$data = json_decode(file_get_contents("php://input"));
$orAnd = isset($_GET['orAnd']) ? $_GET['orAnd'] : "OR";

$seller->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$seller->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

$stmt = $seller->searchByColumn($data,$orAnd);

$num = $stmt->rowCount();
if($num>0){
    $seller_arr=array();
	$seller_arr["pageno"]=$seller->pageNo;
	$seller_arr["pagesize"]=$seller->no_of_records_per_page;
    $seller_arr["total_count"]=$seller->search_record_count($data,$orAnd);
    $seller_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $seller_item=array(
            
"SellerID" => $SellerID,
"SellerName" => $SellerName,
"AptNumber" => $AptNumber,
"HouseNumber" => $HouseNumber,
"Street" => $Street,
"City" => $City,
"StateName" => $StateName,
"Country" => $Country,
"Zipcode" => $Zipcode,
"Contact" => $Contact
        );
 
        array_push($seller_arr["records"], $seller_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "seller found","document"=> $seller_arr));
    
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No seller found.","document"=> ""));
}
 


