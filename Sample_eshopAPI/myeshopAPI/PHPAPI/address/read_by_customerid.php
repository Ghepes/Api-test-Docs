<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/address.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$address = new Address($db);

$address->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$address->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;
$address->CustomerId = isset($_GET['CustomerId']) ? $_GET['CustomerId'] : die();

$stmt = $address->readByCustomerId();
$num = $stmt->rowCount();

if($num>0){
    $address_arr=array();
	$address_arr["pageno"]=$address->pageNo;
	$address_arr["pagesize"]=$address->no_of_records_per_page;
    $address_arr["total_count"]=$address->total_record_count();
    $address_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $address_item=array(
            
"AddressId" => $AddressId,
"Password" => html_entity_decode($Password),
"CustomerId" => $CustomerId,
"AptNumber" => $AptNumber,
"HouseNumber" => $HouseNumber,
"Street" => $Street,
"ZipCode" => $ZipCode,
"City" => $City,
"StateName" => $StateName,
"Country" => $Country,
"Contact" => $Contact
        );
        array_push($address_arr["records"], $address_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "address found","document"=> $address_arr));
    
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No address found.","document"=> ""));
}
 


