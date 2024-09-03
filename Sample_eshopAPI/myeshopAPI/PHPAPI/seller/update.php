<?php
include_once '../config/header.php';
include_once '../config/helper.php';
include_once '../config/database.php';
include_once '../objects/seller.php';
include_once '../token/validatetoken.php';

$database = new Database();
$db = $database->getConnection();

$seller = new Seller($db);

$data = json_decode(file_get_contents("php://input"));
$seller->SellerID = $data->SellerID;

if(!isEmpty($data->SellerName)
&&!isEmpty($data->AptNumber)
&&!isEmpty($data->HouseNumber)
&&!isEmpty($data->Street)
&&!isEmpty($data->City)
&&!isEmpty($data->StateName)
&&!isEmpty($data->Country)
&&!isEmpty($data->Zipcode)
&&!isEmpty($data->Contact)){

if(!isEmpty($data->SellerName)) { 
$seller->SellerName = $data->SellerName;
} else { 
$seller->SellerName = '';
}
if(!isEmpty($data->AptNumber)) { 
$seller->AptNumber = $data->AptNumber;
} else { 
$seller->AptNumber = '';
}
if(!isEmpty($data->HouseNumber)) { 
$seller->HouseNumber = $data->HouseNumber;
} else { 
$seller->HouseNumber = '';
}
if(!isEmpty($data->Street)) { 
$seller->Street = $data->Street;
} else { 
$seller->Street = '';
}
if(!isEmpty($data->City)) { 
$seller->City = $data->City;
} else { 
$seller->City = '';
}
if(!isEmpty($data->StateName)) { 
$seller->StateName = $data->StateName;
} else { 
$seller->StateName = '';
}
if(!isEmpty($data->Country)) { 
$seller->Country = $data->Country;
} else { 
$seller->Country = '';
}
if(!isEmpty($data->Zipcode)) { 
$seller->Zipcode = $data->Zipcode;
} else { 
$seller->Zipcode = '';
}
if(!isEmpty($data->Contact)) { 
$seller->Contact = $data->Contact;
} else { 
$seller->Contact = '';
}
if($seller->update()){
    http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
else{
    http_response_code(503);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update seller","document"=> ""));
}
}
else{
    http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update seller. Data is incomplete.","document"=> ""));
}
?>
