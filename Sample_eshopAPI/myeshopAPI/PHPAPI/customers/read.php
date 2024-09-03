<?php
include_once '../config/header.php';
include_once '../config/database.php';
include_once '../objects/customers.php';
include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$customers = new Customers($db);

$customers->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$customers->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

$stmt = $customers->read();
$num = $stmt->rowCount();
if($num>0){
    $customers_arr=array();
	$customers_arr["pageno"]=$customers->pageNo;
	$customers_arr["pagesize"]=$customers->no_of_records_per_page;
    $customers_arr["total_count"]=$customers->total_record_count();
    $customers_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $customers_item=array(
            
"CustomerId" => $CustomerId,
"FirstName" => $FirstName,
"LastName" => $LastName,
"Phone" => $Phone,
"Email" => $Email,
"DateOfBirth" => $DateOfBirth,
"Password" => html_entity_decode($Password)
        );
         array_push($customers_arr["records"], $customers_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "customers found","document"=> $customers_arr));
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No customers found.","document"=> ""));
}
 


