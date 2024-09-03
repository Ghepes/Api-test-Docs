<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/cartdetail.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$cartdetail = new Cartdetail($db);

$cartdetail->CartId = isset($_GET['id']) ? $_GET['id'] : die();
$cartdetail->readOne();
 
if($cartdetail->CartId!=null){
    $cartdetail_arr = array(
        
"CartId" => $cartdetail->CartId,
"ProductId" => $cartdetail->ProductId
    );
    http_response_code(200);
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "cartdetail found","document"=> $cartdetail_arr));
}
else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "cartdetail does not exist.","document"=> ""));
}
?>
