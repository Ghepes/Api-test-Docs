<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/review.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$review = new Review($db);

$searchKey = isset($_GET['key']) ? $_GET['key'] : die();
$review->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$review->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

$stmt = $review->search($searchKey);
$num = $stmt->rowCount();
 
if($num>0){
    $review_arr=array();
	$review_arr["pageno"]=$review->pageNo;
	$review_arr["pagesize"]=$review->no_of_records_per_page;
    $review_arr["total_count"]=$review->search_count($searchKey);
    $review_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $review_item=array(
            
"ReviewId" => $ReviewId,
"Rating" => $Rating,
"Comments" => $Comments,
"CustomerId" => $CustomerId,
"ProductId" => $ProductId
        );
        array_push($review_arr["records"], $review_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "review found","document"=> $review_arr));
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No review found.","document"=> ""));
}
 


