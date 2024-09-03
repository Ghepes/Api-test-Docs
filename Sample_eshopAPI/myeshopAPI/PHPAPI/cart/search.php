<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/cart.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);

$searchKey = isset($_GET['key']) ? $_GET['key'] : die();
$cart->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$cart->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

$stmt = $cart->search($searchKey);
$num = $stmt->rowCount();
 
if($num>0){
    $cart_arr=array();
	$cart_arr["pageno"]=$cart->pageNo;
	$cart_arr["pagesize"]=$cart->no_of_records_per_page;
    $cart_arr["total_count"]=$cart->search_count($searchKey);
    $cart_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $cart_item=array(
            
"CartId" => $CartId,
"DateCreated" => $DateCreated,
"Password" => html_entity_decode($Password),
"CustomerId" => $CustomerId
        );
        array_push($cart_arr["records"], $cart_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "cart found","document"=> $cart_arr));
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No cart found.","document"=> ""));
}
 


