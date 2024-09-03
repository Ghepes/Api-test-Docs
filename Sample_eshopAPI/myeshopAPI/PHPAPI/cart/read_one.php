<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/cart.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);

$cart->CartId = isset($_GET['id']) ? $_GET['id'] : die();
$cart->readOne();
 
if($cart->CartId!=null){
    $cart_arr = array(
        
"CartId" => $cart->CartId,
"DateCreated" => $cart->DateCreated,
"Password" => html_entity_decode($cart->Password),
"CustomerId" => $cart->CustomerId
    );
    http_response_code(200);
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "cart found","document"=> $cart_arr));
}
else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "cart does not exist.","document"=> ""));
}
?>
