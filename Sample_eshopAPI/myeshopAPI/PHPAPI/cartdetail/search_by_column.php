<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/cartdetail.php';
include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();

$cartdetail = new Cartdetail($db);

$data = json_decode(file_get_contents("php://input"));
$orAnd = isset($_GET['orAnd']) ? $_GET['orAnd'] : "OR";

$cartdetail->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$cartdetail->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

$stmt = $cartdetail->searchByColumn($data,$orAnd);

$num = $stmt->rowCount();
if($num>0){
    $cartdetail_arr=array();
	$cartdetail_arr["pageno"]=$cartdetail->pageNo;
	$cartdetail_arr["pagesize"]=$cartdetail->no_of_records_per_page;
    $cartdetail_arr["total_count"]=$cartdetail->search_record_count($data,$orAnd);
    $cartdetail_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $cartdetail_item=array(
            
"CartId" => $CartId,
"ProductId" => $ProductId
        );
 
        array_push($cartdetail_arr["records"], $cartdetail_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "cartdetail found","document"=> $cartdetail_arr));
    
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No cartdetail found.","document"=> ""));
}
 


