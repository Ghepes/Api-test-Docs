<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/warehouse.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$warehouse = new Warehouse($db);

$warehouse->WarehouseId = isset($_GET['id']) ? $_GET['id'] : die();
$warehouse->readOne();
 
if($warehouse->WarehouseId!=null){
    $warehouse_arr = array(
        
"WarehouseId" => $warehouse->WarehouseId,
"Street" => $warehouse->Street,
"Zipcode" => $warehouse->Zipcode,
"City" => $warehouse->City,
"StateName" => $warehouse->StateName,
"Country" => $warehouse->Country,
"Contact" => $warehouse->Contact
    );
    http_response_code(200);
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "warehouse found","document"=> $warehouse_arr));
}
else{
    http_response_code(404);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "warehouse does not exist.","document"=> ""));
}
?>
