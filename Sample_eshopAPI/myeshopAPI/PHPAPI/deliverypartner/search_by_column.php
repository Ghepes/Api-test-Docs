<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/deliverypartner.php';
include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();

$deliverypartner = new Deliverypartner($db);

$data = json_decode(file_get_contents("php://input"));
$orAnd = isset($_GET['orAnd']) ? $_GET['orAnd'] : "OR";

$deliverypartner->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$deliverypartner->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

$stmt = $deliverypartner->searchByColumn($data,$orAnd);

$num = $stmt->rowCount();
if($num>0){
    $deliverypartner_arr=array();
	$deliverypartner_arr["pageno"]=$deliverypartner->pageNo;
	$deliverypartner_arr["pagesize"]=$deliverypartner->no_of_records_per_page;
    $deliverypartner_arr["total_count"]=$deliverypartner->search_record_count($data,$orAnd);
    $deliverypartner_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $deliverypartner_item=array(
            
"DeliveryPartnerId" => $DeliveryPartnerId,
"AptNumber" => $AptNumber,
"HouseNumber" => $HouseNumber,
"Street" => $Street,
"Zipcode" => $Zipcode,
"City" => $City,
"StateName" => $StateName,
"Country" => $Country,
"Contact" => $Contact
        );
 
        array_push($deliverypartner_arr["records"], $deliverypartner_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "deliverypartner found","document"=> $deliverypartner_arr));
    
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No deliverypartner found.","document"=> ""));
}
 


