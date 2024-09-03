<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/seller.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$seller = new Seller($db);

$seller->SellerID = isset($_GET['id']) ? $_GET['id'] : die();
$seller->readOne();
 
if($seller->SellerID!=null){
    $seller_arr = array(
        
"SellerID" => $seller->SellerID,
"SellerName" => $seller->SellerName,
"AptNumber" => $seller->AptNumber,
"HouseNumber" => $seller->HouseNumber,
"Street" => $seller->Street,
"City" => $seller->City,
"StateName" => $seller->StateName,
"Country" => $seller->Country,
"Zipcode" => $seller->Zipcode,
"Contact" => $seller->Contact
    );
    http_response_code(200);
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "seller found","document"=> $seller_arr));
}
else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "seller does not exist.","document"=> ""));
}
?>
