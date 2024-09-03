<?php
class Customers{
 
    private $conn;
    private $table_name = "customers";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
	
public $CustomerId;
public $FirstName;
public $LastName;
public $Phone;
public $Email;
public $DateOfBirth;
public $Password;
    
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  WHERE LOWER(t.FirstName) LIKE ? OR LOWER(t.LastName) LIKE ?  OR LOWER(t.Phone) LIKE ?  OR LOWER(t.Email) LIKE ?  OR LOWER(t.DateOfBirth) LIKE ?  OR LOWER(t.Password) LIKE ? ";
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
		$query = "SELECT  t.* FROM ". $this->table_name ." t  WHERE LOWER(t.FirstName) LIKE ? OR LOWER(t.LastName) LIKE ?  OR LOWER(t.Phone) LIKE ?  OR LOWER(t.Email) LIKE ?  OR LOWER(t.DateOfBirth) LIKE ?  OR LOWER(t.Password) LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
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
		$query = "SELECT  t.* FROM ". $this->table_name ." t  WHERE t.CustomerId = ? LIMIT 0,1";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->CustomerId);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$num = $stmt->rowCount();
		if($num>0){
			
$this->CustomerId = $row['CustomerId'];
$this->FirstName = $row['FirstName'];
$this->LastName = $row['LastName'];
$this->Phone = $row['Phone'];
$this->Email = $row['Email'];
$this->DateOfBirth = $row['DateOfBirth'];
$this->Password = $row['Password'];
		}
		else{
			$this->CustomerId=null;
		}
	}
	function create(){
		$query ="INSERT INTO ".$this->table_name." SET FirstName=:FirstName,LastName=:LastName,Phone=:Phone,Email=:Email,DateOfBirth=:DateOfBirth,Password=:Password";
		$stmt = $this->conn->prepare($query);
		
$this->FirstName=htmlspecialchars(strip_tags($this->FirstName));
$this->LastName=htmlspecialchars(strip_tags($this->LastName));
$this->Phone=htmlspecialchars(strip_tags($this->Phone));
$this->Email=htmlspecialchars(strip_tags($this->Email));
$this->DateOfBirth=htmlspecialchars(strip_tags($this->DateOfBirth));
$this->Password=htmlspecialchars(strip_tags($this->Password));
		
$stmt->bindParam(":FirstName", $this->FirstName);
$stmt->bindParam(":LastName", $this->LastName);
$stmt->bindParam(":Phone", $this->Phone);
$stmt->bindParam(":Email", $this->Email);
$stmt->bindParam(":DateOfBirth", $this->DateOfBirth);
$stmt->bindParam(":Password", $this->Password);
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
		return 0;
	}
	function update(){
		$query ="UPDATE ".$this->table_name." SET FirstName=:FirstName,LastName=:LastName,Phone=:Phone,Email=:Email,DateOfBirth=:DateOfBirth,Password=:Password WHERE CustomerId = :CustomerId";
		$stmt = $this->conn->prepare($query);
		
$this->FirstName=htmlspecialchars(strip_tags($this->FirstName));
$this->LastName=htmlspecialchars(strip_tags($this->LastName));
$this->Phone=htmlspecialchars(strip_tags($this->Phone));
$this->Email=htmlspecialchars(strip_tags($this->Email));
$this->DateOfBirth=htmlspecialchars(strip_tags($this->DateOfBirth));
$this->Password=htmlspecialchars(strip_tags($this->Password));
$this->CustomerId=htmlspecialchars(strip_tags($this->CustomerId));
		
$stmt->bindParam(":FirstName", $this->FirstName);
$stmt->bindParam(":LastName", $this->LastName);
$stmt->bindParam(":Phone", $this->Phone);
$stmt->bindParam(":Email", $this->Email);
$stmt->bindParam(":DateOfBirth", $this->DateOfBirth);
$stmt->bindParam(":Password", $this->Password);
$stmt->bindParam(":CustomerId", $this->CustomerId);
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
				if($columnName!='CustomerId'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE CustomerId = :CustomerId"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='CustomerId'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":CustomerId", $this->CustomerId);
			$stmt->execute();

			if($stmt->rowCount()) {
				return true;
			} else {
				return false;
			}
	}
	function delete(){
		$query = "DELETE FROM " . $this->table_name . " WHERE CustomerId = ? ";
		$stmt = $this->conn->prepare($query);
		$this->CustomerId=htmlspecialchars(strip_tags($this->CustomerId));
		$stmt->bindParam(1, $this->CustomerId);
	 	$stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
}
?>
