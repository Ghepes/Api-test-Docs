<?php
class Shippinginfo{
 
    private $conn;
    private $table_name = "shippinginfo";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
	
public $ShippingId;
public $DeliveryPartnerId;
public $ShippingCost;
public $ShippingType;
public $AptNumber;
    
    public function __construct($db){
        $this->conn = $db;
    }

	function total_record_count() {
		$query = "select count(1) as total from ". $this->table_name ."";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['total'];
	}

	function search_count($searchKey) {
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join deliverypartner ii on t.DeliveryPartnerId = ii.DeliveryPartnerId  WHERE LOWER(t.DeliveryPartnerId) LIKE ? OR LOWER(t.ShippingCost) LIKE ?  OR LOWER(t.ShippingType) LIKE ? ";
		$stmt = $this->conn->prepare($query);
		$searchKey="%".strtolower($searchKey)."%";
		
$stmt->bindParam(1, $searchKey);
$stmt->bindParam(2, $searchKey);
$stmt->bindParam(3, $searchKey);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['total'];
	}
	
	function search_record_count($columnArray,$orAnd){
		$where="";
		foreach ($columnArray as $col) {
			$columnName=htmlspecialchars(strip_tags($col->columnName));
			$columnLogic=$col->columnLogic;
			if($where==""){
				$where="LOWER(t.".$columnName . ") ".$columnLogic." :".$columnName;
			}else{
				$where=$where." ". $orAnd ." LOWER(t." . $columnName . ") ".$columnLogic." :".$columnName;
			}
		}
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join deliverypartner ii on t.DeliveryPartnerId = ii.DeliveryPartnerId  WHERE ".$where."";
		
		$stmt = $this->conn->prepare($query);
		$paramCount=1;
		foreach ($columnArray as $col) {
			$columnName=htmlspecialchars(strip_tags($col->columnName));
		if(strtoupper($col->columnLogic)=="LIKE"){
		$columnValue="%".strtolower($col->columnValue)."%";
		}else{
		$columnValue=strtolower($col->columnValue);
		}
			$stmt->bindValue(":".$columnName, $columnValue);
			$paramCount++;
		}
		
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 $num = $stmt->rowCount();
		if($num>0){
			return $row['total'];
		}else{
			return 0;
		}
	}
	function read(){
		if(isset($_GET["pageNo"])){
			$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		$query = "SELECT  ii.AptNumber, t.* FROM ". $this->table_name ." t  join deliverypartner ii on t.DeliveryPartnerId = ii.DeliveryPartnerId  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}
	function search($searchKey){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		$query = "SELECT  ii.AptNumber, t.* FROM ". $this->table_name ." t  join deliverypartner ii on t.DeliveryPartnerId = ii.DeliveryPartnerId  WHERE LOWER(t.DeliveryPartnerId) LIKE ? OR LOWER(t.ShippingCost) LIKE ?  OR LOWER(t.ShippingType) LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		$stmt = $this->conn->prepare($query);
		$searchKey="%".strtolower($searchKey)."%";
		
$stmt->bindParam(1, $searchKey);
$stmt->bindParam(2, $searchKey);
$stmt->bindParam(3, $searchKey);
		$stmt->execute();
		return $stmt;
	}
	function searchByColumn($columnArray,$orAnd){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		$where="";
		
		foreach ($columnArray as $col) {
			$columnName=htmlspecialchars(strip_tags($col->columnName));
			$columnLogic=$col->columnLogic;
			if($where==""){
				$where="LOWER(t.".$columnName . ") ".$columnLogic." :".$columnName;
			}else{
				$where=$where." ". $orAnd ." LOWER(t." . $columnName . ") ".$columnLogic." :".$columnName;
			}
		}
		$query = "SELECT  ii.AptNumber, t.* FROM ". $this->table_name ." t  join deliverypartner ii on t.DeliveryPartnerId = ii.DeliveryPartnerId  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
		$stmt = $this->conn->prepare($query);
		$paramCount=1;
		foreach ($columnArray as $col) {
			$columnName=htmlspecialchars(strip_tags($col->columnName));
			if(strtoupper($col->columnLogic)=="LIKE"){
			$columnValue="%".strtolower($col->columnValue)."%";
			}else{
			$columnValue=strtolower($col->columnValue);
			}
			$stmt->bindValue(":".$columnName, $columnValue);
			$paramCount++;
		}
		
		$stmt->execute();
		return $stmt;
	}
	
	

	function readOne(){
		$query = "SELECT  ii.AptNumber, t.* FROM ". $this->table_name ." t  join deliverypartner ii on t.DeliveryPartnerId = ii.DeliveryPartnerId  WHERE t.ShippingId = ? LIMIT 0,1";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->ShippingId);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$num = $stmt->rowCount();
		if($num>0){
			
$this->ShippingId = $row['ShippingId'];
$this->DeliveryPartnerId = $row['DeliveryPartnerId'];
$this->AptNumber = $row['AptNumber'];
$this->ShippingCost = $row['ShippingCost'];
$this->ShippingType = $row['ShippingType'];
		}
		else{
			$this->ShippingId=null;
		}
	}
	function create(){
		$query ="INSERT INTO ".$this->table_name." SET DeliveryPartnerId=:DeliveryPartnerId,ShippingCost=:ShippingCost,ShippingType=:ShippingType";
		$stmt = $this->conn->prepare($query);
		
$this->DeliveryPartnerId=htmlspecialchars(strip_tags($this->DeliveryPartnerId));
$this->ShippingCost=htmlspecialchars(strip_tags($this->ShippingCost));
$this->ShippingType=htmlspecialchars(strip_tags($this->ShippingType));
		
$stmt->bindParam(":DeliveryPartnerId", $this->DeliveryPartnerId);
$stmt->bindParam(":ShippingCost", $this->ShippingCost);
$stmt->bindParam(":ShippingType", $this->ShippingType);
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
		return 0;
	}
	function update(){
		$query ="UPDATE ".$this->table_name." SET DeliveryPartnerId=:DeliveryPartnerId,ShippingCost=:ShippingCost,ShippingType=:ShippingType WHERE ShippingId = :ShippingId";
		$stmt = $this->conn->prepare($query);
		
$this->DeliveryPartnerId=htmlspecialchars(strip_tags($this->DeliveryPartnerId));
$this->ShippingCost=htmlspecialchars(strip_tags($this->ShippingCost));
$this->ShippingType=htmlspecialchars(strip_tags($this->ShippingType));
$this->ShippingId=htmlspecialchars(strip_tags($this->ShippingId));
		
$stmt->bindParam(":DeliveryPartnerId", $this->DeliveryPartnerId);
$stmt->bindParam(":ShippingCost", $this->ShippingCost);
$stmt->bindParam(":ShippingType", $this->ShippingType);
$stmt->bindParam(":ShippingId", $this->ShippingId);
		$stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
	}
	function update_patch($jsonObj) {
			$query ="UPDATE ".$this->table_name. " SET ";
			$setValue="";
			$colCount=1;
			foreach($jsonObj as $key => $value) 
			{
				$columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='ShippingId'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE ShippingId = :ShippingId"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='ShippingId'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":ShippingId", $this->ShippingId);
			$stmt->execute();

			if($stmt->rowCount()) {
				return true;
			} else {
				return false;
			}
	}
	function delete(){
		$query = "DELETE FROM " . $this->table_name . " WHERE ShippingId = ? ";
		$stmt = $this->conn->prepare($query);
		$this->ShippingId=htmlspecialchars(strip_tags($this->ShippingId));
		$stmt->bindParam(1, $this->ShippingId);
	 	$stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
function readByDeliveryPartnerId(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  ii.AptNumber, t.* FROM ". $this->table_name ." t  join deliverypartner ii on t.DeliveryPartnerId = ii.DeliveryPartnerId  WHERE t.DeliveryPartnerId = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->DeliveryPartnerId);

$stmt->execute();
return $stmt;
}

}
?>
