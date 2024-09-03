<?php
class Orderdetails{
 
    private $conn;
    private $table_name = "orderdetails";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
	
public $OrderId;
public $ProductId;
public $ProductName;
public $Quantity;
public $UnitCost;
public $ShippingId;
    
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join orders iii on t.OrderId = iii.OrderId  WHERE LOWER(t.ProductId) LIKE ? OR LOWER(t.ProductName) LIKE ?  OR LOWER(t.Quantity) LIKE ?  OR LOWER(t.UnitCost) LIKE ? ";
		$stmt = $this->conn->prepare($query);
		$searchKey="%".strtolower($searchKey)."%";
		
$stmt->bindParam(1, $searchKey);
$stmt->bindParam(2, $searchKey);
$stmt->bindParam(3, $searchKey);
$stmt->bindParam(4, $searchKey);
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join orders iii on t.OrderId = iii.OrderId  WHERE ".$where."";
		
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
		$query = "SELECT  iii.ShippingId, t.* FROM ". $this->table_name ." t  join orders iii on t.OrderId = iii.OrderId  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}
	function search($searchKey){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		$query = "SELECT  iii.ShippingId, t.* FROM ". $this->table_name ." t  join orders iii on t.OrderId = iii.OrderId  WHERE LOWER(t.ProductId) LIKE ? OR LOWER(t.ProductName) LIKE ?  OR LOWER(t.Quantity) LIKE ?  OR LOWER(t.UnitCost) LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		$stmt = $this->conn->prepare($query);
		$searchKey="%".strtolower($searchKey)."%";
		
$stmt->bindParam(1, $searchKey);
$stmt->bindParam(2, $searchKey);
$stmt->bindParam(3, $searchKey);
$stmt->bindParam(4, $searchKey);
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
		$query = "SELECT  iii.ShippingId, t.* FROM ". $this->table_name ." t  join orders iii on t.OrderId = iii.OrderId  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  iii.ShippingId, t.* FROM ". $this->table_name ." t  join orders iii on t.OrderId = iii.OrderId  WHERE t.OrderId = ? LIMIT 0,1";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->OrderId);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$num = $stmt->rowCount();
		if($num>0){
			
$this->OrderId = $row['OrderId'];
$this->ShippingId = $row['ShippingId'];
$this->ProductId = $row['ProductId'];
$this->ProductName = $row['ProductName'];
$this->Quantity = $row['Quantity'];
$this->UnitCost = $row['UnitCost'];
		}
		else{
			$this->OrderId=null;
		}
	}
	function create(){
		$query ="INSERT INTO ".$this->table_name." SET ProductId=:ProductId,ProductName=:ProductName,Quantity=:Quantity,UnitCost=:UnitCost";
		$stmt = $this->conn->prepare($query);
		
$this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
$this->ProductName=htmlspecialchars(strip_tags($this->ProductName));
$this->Quantity=htmlspecialchars(strip_tags($this->Quantity));
$this->UnitCost=htmlspecialchars(strip_tags($this->UnitCost));
		
$stmt->bindParam(":ProductId", $this->ProductId);
$stmt->bindParam(":ProductName", $this->ProductName);
$stmt->bindParam(":Quantity", $this->Quantity);
$stmt->bindParam(":UnitCost", $this->UnitCost);
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
		return 0;
	}
	function update(){
		$query ="UPDATE ".$this->table_name." SET ProductId=:ProductId,ProductName=:ProductName,Quantity=:Quantity,UnitCost=:UnitCost WHERE OrderId = :OrderId";
		$stmt = $this->conn->prepare($query);
		
$this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
$this->ProductName=htmlspecialchars(strip_tags($this->ProductName));
$this->Quantity=htmlspecialchars(strip_tags($this->Quantity));
$this->UnitCost=htmlspecialchars(strip_tags($this->UnitCost));
$this->OrderId=htmlspecialchars(strip_tags($this->OrderId));
		
$stmt->bindParam(":ProductId", $this->ProductId);
$stmt->bindParam(":ProductName", $this->ProductName);
$stmt->bindParam(":Quantity", $this->Quantity);
$stmt->bindParam(":UnitCost", $this->UnitCost);
$stmt->bindParam(":OrderId", $this->OrderId);
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
				if($columnName!='OrderId'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE OrderId = :OrderId"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='OrderId'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":OrderId", $this->OrderId);
			$stmt->execute();

			if($stmt->rowCount()) {
				return true;
			} else {
				return false;
			}
	}
	function delete(){
		$query = "DELETE FROM " . $this->table_name . " WHERE OrderId = ? ";
		$stmt = $this->conn->prepare($query);
		$this->OrderId=htmlspecialchars(strip_tags($this->OrderId));
		$stmt->bindParam(1, $this->OrderId);
	 	$stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
function readByOrderId(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  iii.ShippingId, t.* FROM ". $this->table_name ." t  join orders iii on t.OrderId = iii.OrderId  WHERE t.OrderId = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->OrderId);

$stmt->execute();
return $stmt;
}

}
?>
