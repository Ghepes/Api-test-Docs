<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/review.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();
 
$review = new Review($db);
$data = json_decode(file_get_contents("php://input"));

if(true){
	
    
$review->Rating = $data->Rating;
$review->Comments = $data->Comments;
$review->CustomerId = $data->CustomerId;
$review->ProductId = $data->ProductId;
 	$lastInsertedId=$review->create();
    if($lastInsertedId!=0){
        http_response_code(201);
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
    else{
        http_response_code(503);
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create review","document"=> ""));
    }
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create review. Data is incomplete.","document"=> ""));
}
?>
