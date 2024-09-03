<?php
class Payments{
 
    private $conn;
    private $table_name = "payments";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
	
public $PaymentId;
public $PaymentType;
public $PaymentTotal;
public $PaymentDate;
public $ExpiryDate;
public $CVV;
public $CardNumber;
    
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  WHERE LOWER(t.PaymentType) LIKE ? OR LOWER(t.PaymentTotal) LIKE ?  OR LOWER(t.PaymentDate) LIKE ?  OR LOWER(t.ExpiryDate) LIKE ?  OR LOWER(t.CVV) LIKE ?  OR LOWER(t.CardNumber) LIKE ? ";
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
		$query = "SELECT  t.* FROM ". $this->table_name ." t  WHERE LOWER(t.PaymentType) LIKE ? OR LOWER(t.PaymentTotal) LIKE ?  OR LOWER(t.PaymentDate) LIKE ?  OR LOWER(t.ExpiryDate) LIKE ?  OR LOWER(t.CVV) LIKE ?  OR LOWER(t.CardNumber) LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
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
		$query = "SELECT  t.* FROM ". $this->table_name ." t  WHERE t.PaymentId = ? LIMIT 0,1";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->PaymentId);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$num = $stmt->rowCount();
		if($num>0){
			
$this->PaymentId = $row['PaymentId'];
$this->PaymentType = $row['PaymentType'];
$this->PaymentTotal = $row['PaymentTotal'];
$this->PaymentDate = $row['PaymentDate'];
$this->ExpiryDate = $row['ExpiryDate'];
$this->CVV = $row['CVV'];
$this->CardNumber = $row['CardNumber'];
		}
		else{
			$this->PaymentId=null;
		}
	}
	function create(){
		$query ="INSERT INTO ".$this->table_name." SET PaymentType=:PaymentType,PaymentTotal=:PaymentTotal,PaymentDate=:PaymentDate,ExpiryDate=:ExpiryDate,CVV=:CVV,CardNumber=:CardNumber";
		$stmt = $this->conn->prepare($query);
		
$this->PaymentType=htmlspecialchars(strip_tags($this->PaymentType));
$this->PaymentTotal=htmlspecialchars(strip_tags($this->PaymentTotal));
$this->PaymentDate=htmlspecialchars(strip_tags($this->PaymentDate));
$this->ExpiryDate=htmlspecialchars(strip_tags($this->ExpiryDate));
$this->CVV=htmlspecialchars(strip_tags($this->CVV));
$this->CardNumber=htmlspecialchars(strip_tags($this->CardNumber));
		
$stmt->bindParam(":PaymentType", $this->PaymentType);
$stmt->bindParam(":PaymentTotal", $this->PaymentTotal);
$stmt->bindParam(":PaymentDate", $this->PaymentDate);
$stmt->bindParam(":ExpiryDate", $this->ExpiryDate);
$stmt->bindParam(":CVV", $this->CVV);
$stmt->bindParam(":CardNumber", $this->CardNumber);
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
		return 0;
	}
	function update(){
		$query ="UPDATE ".$this->table_name." SET PaymentType=:PaymentType,PaymentTotal=:PaymentTotal,PaymentDate=:PaymentDate,ExpiryDate=:ExpiryDate,CVV=:CVV,CardNumber=:CardNumber WHERE PaymentId = :PaymentId";
		$stmt = $this->conn->prepare($query);
		
$this->PaymentType=htmlspecialchars(strip_tags($this->PaymentType));
$this->PaymentTotal=htmlspecialchars(strip_tags($this->PaymentTotal));
$this->PaymentDate=htmlspecialchars(strip_tags($this->PaymentDate));
$this->ExpiryDate=htmlspecialchars(strip_tags($this->ExpiryDate));
$this->CVV=htmlspecialchars(strip_tags($this->CVV));
$this->CardNumber=htmlspecialchars(strip_tags($this->CardNumber));
$this->PaymentId=htmlspecialchars(strip_tags($this->PaymentId));
		
$stmt->bindParam(":PaymentType", $this->PaymentType);
$stmt->bindParam(":PaymentTotal", $this->PaymentTotal);
$stmt->bindParam(":PaymentDate", $this->PaymentDate);
$stmt->bindParam(":ExpiryDate", $this->ExpiryDate);
$stmt->bindParam(":CVV", $this->CVV);
$stmt->bindParam(":CardNumber", $this->CardNumber);
$stmt->bindParam(":PaymentId", $this->PaymentId);
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
				if($columnName!='PaymentId'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE PaymentId = :PaymentId"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='PaymentId'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":PaymentId", $this->PaymentId);
			$stmt->execute();

			if($stmt->rowCount()) {
				return true;
			} else {
				return false;
			}
	}
	function delete(){
		$query = "DELETE FROM " . $this->table_name . " WHERE PaymentId = ? ";
		$stmt = $this->conn->prepare($query);
		$this->PaymentId=htmlspecialchars(strip_tags($this->PaymentId));
		$stmt->bindParam(1, $this->PaymentId);
	 	$stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
}
?>
