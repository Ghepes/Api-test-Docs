<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/customers.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$customers = new Customers($db);

$customers->CustomerId = isset($_GET['id']) ? $_GET['id'] : die();
$customers->readOne();
 
if($customers->CustomerId!=null){
    $customers_arr = array(
        
"CustomerId" => $customers->CustomerId,
"FirstName" => $customers->FirstName,
"LastName" => $customers->LastName,
"Phone" => $customers->Phone,
"Email" => $customers->Email,
"DateOfBirth" => $customers->DateOfBirth,
"Password" => html_entity_decode($customers->Password)
    );
    http_response_code(200);
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "customers found","document"=> $customers_arr));
}
else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "customers does not exist.","document"=> ""));
}
?>
