<?php
class Orders{
 
    private $conn;
    private $table_name = "orders";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
	
public $OrderId;
public $CustomerId;
public $PaymentId;
public $DateCreated;
public $DateShipped;
public $ShippingId;
public $Status;
    
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  WHERE LOWER(t.CustomerId) LIKE ? OR LOWER(t.PaymentId) LIKE ?  OR LOWER(t.DateCreated) LIKE ?  OR LOWER(t.DateShipped) LIKE ?  OR LOWER(t.ShippingId) LIKE ?  OR LOWER(t.Status) LIKE ? ";
		$stmt = $this->conn->prepare($query);
		$searchKey="%".strtolower($searchKey)."%";
		
$stmt->bindParam(1, $searchKey);
$stmt->bindParam(2, $searchKey);
$stmt->bindParam(3, $searchKey);
$stmt->bindParam(4, $searchKey);
$stmt->bindParam(5, $searchKey);
$stmt->bindParam(6, $searchKey);
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  WHERE ".$where."";
		
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
		$query = "SELECT  t.* FROM ". $this->table_name ." t  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}
	function search($searchKey){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		$query = "SELECT  t.* FROM ". $this->table_name ." t  WHERE LOWER(t.CustomerId) LIKE ? OR LOWER(t.PaymentId) LIKE ?  OR LOWER(t.DateCreated) LIKE ?  OR LOWER(t.DateShipped) LIKE ?  OR LOWER(t.ShippingId) LIKE ?  OR LOWER(t.Status) LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		$stmt = $this->conn->prepare($query);
		$searchKey="%".strtolower($searchKey)."%";
		
$stmt->bindParam(1, $searchKey);
$stmt->bindParam(2, $searchKey);
$stmt->bindParam(3, $searchKey);
$stmt->bindParam(4, $searchKey);
$stmt->bindParam(5, $searchKey);
$stmt->bindParam(6, $searchKey);
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
		$query = "SELECT  t.* FROM ". $this->table_name ." t  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  t.* FROM ". $this->table_name ." t  WHERE t.OrderId = ? LIMIT 0,1";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->OrderId);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$num = $stmt->rowCount();
		if($num>0){
			
$this->OrderId = $row['OrderId'];
$this->CustomerId = $row['CustomerId'];
$this->PaymentId = $row['PaymentId'];
$this->DateCreated = $row['DateCreated'];
$this->DateShipped = $row['DateShipped'];
$this->ShippingId = $row['ShippingId'];
$this->Status = $row['Status'];
		}
		else{
			$this->OrderId=null;
		}
	}
	function create(){
		$query ="INSERT INTO ".$this->table_name." SET CustomerId=:CustomerId,PaymentId=:PaymentId,DateCreated=:DateCreated,DateShipped=:DateShipped,ShippingId=:ShippingId,Status=:Status";
		$stmt = $this->conn->prepare($query);
		
$this->CustomerId=htmlspecialchars(strip_tags($this->CustomerId));
$this->PaymentId=htmlspecialchars(strip_tags($this->PaymentId));
$this->DateCreated=htmlspecialchars(strip_tags($this->DateCreated));
$this->DateShipped=htmlspecialchars(strip_tags($this->DateShipped));
$this->ShippingId=htmlspecialchars(strip_tags($this->ShippingId));
$this->Status=htmlspecialchars(strip_tags($this->Status));
		
$stmt->bindParam(":CustomerId", $this->CustomerId);
$stmt->bindParam(":PaymentId", $this->PaymentId);
$stmt->bindParam(":DateCreated", $this->DateCreated);
$stmt->bindParam(":DateShipped", $this->DateShipped);
$stmt->bindParam(":ShippingId", $this->ShippingId);
$stmt->bindParam(":Status", $this->Status);
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
		return 0;
	}
	function update(){
		$query ="UPDATE ".$this->table_name." SET CustomerId=:CustomerId,PaymentId=:PaymentId,DateCreated=:DateCreated,DateShipped=:DateShipped,ShippingId=:ShippingId,Status=:Status WHERE OrderId = :OrderId";
		$stmt = $this->conn->prepare($query);
		
$this->CustomerId=htmlspecialchars(strip_tags($this->CustomerId));
$this->PaymentId=htmlspecialchars(strip_tags($this->PaymentId));
$this->DateCreated=htmlspecialchars(strip_tags($this->DateCreated));
$this->DateShipped=htmlspecialchars(strip_tags($this->DateShipped));
$this->ShippingId=htmlspecialchars(strip_tags($this->ShippingId));
$this->Status=htmlspecialchars(strip_tags($this->Status));
$this->OrderId=htmlspecialchars(strip_tags($this->OrderId));
		
$stmt->bindParam(":CustomerId", $this->CustomerId);
$stmt->bindParam(":PaymentId", $this->PaymentId);
$stmt->bindParam(":DateCreated", $this->DateCreated);
$stmt->bindParam(":DateShipped", $this->DateShipped);
$stmt->bindParam(":ShippingId", $this->ShippingId);
$stmt->bindParam(":Status", $this->Status);
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

	
}
?>
