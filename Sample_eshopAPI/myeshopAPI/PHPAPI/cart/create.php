<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/cart.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();
 
$cart = new Cart($db);
$data = json_decode(file_get_contents("php://input"));

if(true){
	
    
$cart->DateCreated = $data->DateCreated;
$cart->CustomerId = $data->CustomerId;
 	$lastInsertedId=$cart->create();
    if($lastInsertedId!=0){
        http_response_code(201);
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> $lastInsertedId));
    }
    else{
        http_response_code(503);
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create cart","document"=> ""));
    }
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create cart. Data is incomplete.","document"=> ""));
}
?>
