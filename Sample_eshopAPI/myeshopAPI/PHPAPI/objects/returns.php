<?php
class Returns{
 
    private $conn;
    private $table_name = "returns";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
	
public $ReturnId;
public $CustomerId;
public $DeliveryPartnerId;
public $OrderId;
public $ProductId;
public $ReturnDate;
public $Description;
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join customers q on t.CustomerId = q.CustomerId  WHERE LOWER(t.CustomerId) LIKE ? OR LOWER(t.DeliveryPartnerId) LIKE ?  OR LOWER(t.OrderId) LIKE ?  OR LOWER(t.ProductId) LIKE ?  OR LOWER(t.ReturnDate) LIKE ?  OR LOWER(t.Description) LIKE ? ";
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join customers q on t.CustomerId = q.CustomerId  WHERE ".$where."";
		
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
		$query = "SELECT  q.Password, t.* FROM ". $this->table_name ." t  join customers q on t.CustomerId = q.CustomerId  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}
	function search($searchKey){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		$query = "SELECT  q.Password, t.* FROM ". $this->table_name ." t  join customers q on t.CustomerId = q.CustomerId  WHERE LOWER(t.CustomerId) LIKE ? OR LOWER(t.DeliveryPartnerId) LIKE ?  OR LOWER(t.OrderId) LIKE ?  OR LOWER(t.ProductId) LIKE ?  OR LOWER(t.ReturnDate) LIKE ?  OR LOWER(t.Description) LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
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
		$query = "SELECT  q.Password, t.* FROM ". $this->table_name ." t  join customers q on t.CustomerId = q.CustomerId  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  q.Password, t.* FROM ". $this->table_name ." t  join customers q on t.CustomerId = q.CustomerId  WHERE t.ReturnId = ? LIMIT 0,1";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->ReturnId);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$num = $stmt->rowCount();
		if($num>0){
			
$this->ReturnId = $row['ReturnId'];
$this->CustomerId = $row['CustomerId'];
$this->Password = $row['Password'];
$this->DeliveryPartnerId = $row['DeliveryPartnerId'];
$this->OrderId = $row['OrderId'];
$this->ProductId = $row['ProductId'];
$this->ReturnDate = $row['ReturnDate'];
$this->Description = $row['Description'];
		}
		else{
			$this->ReturnId=null;
		}
	}
	function create(){
		$query ="INSERT INTO ".$this->table_name." SET CustomerId=:CustomerId,DeliveryPartnerId=:DeliveryPartnerId,OrderId=:OrderId,ProductId=:ProductId,ReturnDate=:ReturnDate,Description=:Description";
		$stmt = $this->conn->prepare($query);
		
$this->CustomerId=htmlspecialchars(strip_tags($this->CustomerId));
$this->DeliveryPartnerId=htmlspecialchars(strip_tags($this->DeliveryPartnerId));
$this->OrderId=htmlspecialchars(strip_tags($this->OrderId));
$this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
$this->ReturnDate=htmlspecialchars(strip_tags($this->ReturnDate));
$this->Description=htmlspecialchars(strip_tags($this->Description));
		
$stmt->bindParam(":CustomerId", $this->CustomerId);
$stmt->bindParam(":DeliveryPartnerId", $this->DeliveryPartnerId);
$stmt->bindParam(":OrderId", $this->OrderId);
$stmt->bindParam(":ProductId", $this->ProductId);
$stmt->bindParam(":ReturnDate", $this->ReturnDate);
$stmt->bindParam(":Description", $this->Description);
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
		return 0;
	}
	function update(){
		$query ="UPDATE ".$this->table_name." SET CustomerId=:CustomerId,DeliveryPartnerId=:DeliveryPartnerId,OrderId=:OrderId,ProductId=:ProductId,ReturnDate=:ReturnDate,Description=:Description WHERE ReturnId = :ReturnId";
		$stmt = $this->conn->prepare($query);
		
$this->CustomerId=htmlspecialchars(strip_tags($this->CustomerId));
$this->DeliveryPartnerId=htmlspecialchars(strip_tags($this->DeliveryPartnerId));
$this->OrderId=htmlspecialchars(strip_tags($this->OrderId));
$this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
$this->ReturnDate=htmlspecialchars(strip_tags($this->ReturnDate));
$this->Description=htmlspecialchars(strip_tags($this->Description));
$this->ReturnId=htmlspecialchars(strip_tags($this->ReturnId));
		
$stmt->bindParam(":CustomerId", $this->CustomerId);
$stmt->bindParam(":DeliveryPartnerId", $this->DeliveryPartnerId);
$stmt->bindParam(":OrderId", $this->OrderId);
$stmt->bindParam(":ProductId", $this->ProductId);
$stmt->bindParam(":ReturnDate", $this->ReturnDate);
$stmt->bindParam(":Description", $this->Description);
$stmt->bindParam(":ReturnId", $this->ReturnId);
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
				if($columnName!='ReturnId'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE ReturnId = :ReturnId"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='ReturnId'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":ReturnId", $this->ReturnId);
			$stmt->execute();

			if($stmt->rowCount()) {
				return true;
			} else {
				return false;
			}
	}
	function delete(){
		$query = "DELETE FROM " . $this->table_name . " WHERE ReturnId = ? ";
		$stmt = $this->conn->prepare($query);
		$this->ReturnId=htmlspecialchars(strip_tags($this->ReturnId));
		$stmt->bindParam(1, $this->ReturnId);
	 	$stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
function readByCustomerId(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  q.Password, t.* FROM ". $this->table_name ." t  join customers q on t.CustomerId = q.CustomerId  WHERE t.CustomerId = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->CustomerId);

$stmt->execute();
return $stmt;
}

}
?>
