<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/review.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$review = new Review($db);

$review->ReviewId = isset($_GET['id']) ? $_GET['id'] : die();
$review->readOne();
 
if($review->ReviewId!=null){
    $review_arr = array(
        
"ReviewId" => $review->ReviewId,
"Rating" => $review->Rating,
"Comments" => $review->Comments,
"CustomerId" => $review->CustomerId,
"ProductId" => $review->ProductId
    );
    http_response_code(200);
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "review found","document"=> $review_arr));
}
else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "review does not exist.","document"=> ""));
}
?>
