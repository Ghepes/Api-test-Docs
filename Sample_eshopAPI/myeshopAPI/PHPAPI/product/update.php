<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$data = json_decode(file_get_contents("php://input"));
$product->ProductID = $data->ProductID;

if(!isEmpty($data->ProductName)
&&!isEmpty($data->Price)
&&!isEmpty($data->Manufacturer)
&&!isEmpty($data->ProductDimension)
&&!isEmpty($data->ProductWeight)
&&!isEmpty($data->SellerName)
&&!isEmpty($data->Rating)
&&!isEmpty($data->DateOfManufacture)){

$product->ProductCategoryID = $data->ProductCategoryID;
$product->ProductSubCategoryID = $data->ProductSubCategoryID;
if(!isEmpty($data->ProductName)) { 
$product->ProductName = $data->ProductName;
} else { 
$product->ProductName = '';
}
if(!isEmpty($data->Price)) { 
$product->Price = $data->Price;
} else { 
$product->Price = '';
}
if(!isEmpty($data->Manufacturer)) { 
$product->Manufacturer = $data->Manufacturer;
} else { 
$product->Manufacturer = '';
}
if(!isEmpty($data->ProductDimension)) { 
$product->ProductDimension = $data->ProductDimension;
} else { 
$product->ProductDimension = '';
}
if(!isEmpty($data->ProductWeight)) { 
$product->ProductWeight = $data->ProductWeight;
} else { 
$product->ProductWeight = '';
}
$product->SellerID = $data->SellerID;
if(!isEmpty($data->SellerName)) { 
$product->SellerName = $data->SellerName;
} else { 
$product->SellerName = '';
}
if(!isEmpty($data->Rating)) { 
$product->Rating = $data->Rating;
} else { 
$product->Rating = '';
}
if(!isEmpty($data->DateOfManufacture)) { 
$product->DateOfManufacture = $data->DateOfManufacture;
} else { 
$product->DateOfManufacture = '';
}
$product->ProductImage = $data->ProductImage;
if($product->update()){
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
else{
    http_response_code(503);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update product","document"=> ""));
}
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update product. Data is incomplete.","document"=> ""));
}
?>
