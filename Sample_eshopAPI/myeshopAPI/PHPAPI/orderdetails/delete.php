<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/orderdetails.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$orderdetails = new Orderdetails($db);

$data = json_decode(file_get_contents("php://input"));

$orderdetails->OrderId = $data->OrderId;

if($orderdetails->delete()){
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Orderdetails was deleted","document"=> ""));
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to delete orderdetails.","document"=> ""));
}
?>
