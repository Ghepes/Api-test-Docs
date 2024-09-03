<?php
include_once '../config/header.php';
include_once '../config/database.php';
include_once '../objects/warehouse.php';
include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$warehouse = new Warehouse($db);

$warehouse->pageNo = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$warehouse->no_of_records_per_page = isset($_GET['pagesize']) ? $_GET['pagesize'] : 30;

$stmt = $warehouse->read();
$num = $stmt->rowCount();
if($num>0){
    $warehouse_arr=array();
	$warehouse_arr["pageno"]=$warehouse->pageNo;
	$warehouse_arr["pagesize"]=$warehouse->no_of_records_per_page;
    $warehouse_arr["total_count"]=$warehouse->total_record_count();
    $warehouse_arr["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $warehouse_item=array(
            
"WarehouseId" => $WarehouseId,
"Street" => $Street,
"Zipcode" => $Zipcode,
"City" => $City,
"StateName" => $StateName,
"Country" => $Country,
"Contact" => $Contact
        );
         array_push($warehouse_arr["records"], $warehouse_item);
    }
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "warehouse found","document"=> $warehouse_arr));
}else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No warehouse found.","document"=> ""));
}
 


