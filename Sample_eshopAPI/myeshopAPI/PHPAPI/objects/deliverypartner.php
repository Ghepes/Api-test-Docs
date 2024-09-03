<?php
class Deliverypartner{
 
    private $conn;
    private $table_name = "deliverypartner";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
	
public $DeliveryPartnerId;
public $AptNumber;
public $HouseNumber;
public $Street;
public $Zipcode;
public $City;
public $StateName;
public $Country;
public $Contact;
    
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  WHERE LOWER(t.AptNumber) LIKE ? OR LOWER(t.HouseNumber) LIKE ?  OR LOWER(t.Street) LIKE ?  OR LOWER(t.Zipcode) LIKE ?  OR LOWER(t.City) LIKE ?  OR LOWER(t.StateName) LIKE ?  OR LOWER(t.Country) LIKE ?  OR LOWER(t.Contact) LIKE ? ";
		$stmt = $this->conn->prepare($query);
		$searchKey="%".strtolower($searchKey)."%";
		
$stmt->bindParam(1, $searchKey);
$stmt->bindParam(2, $searchKey);
$stmt->bindParam(3, $searchKey);
$stmt->bindParam(4, $searchKey);
$stmt->bindParam(5, $searchKey);
$stmt->bindParam(6, $searchKey);
$stmt->bindParam(7, $searchKey);
$stmt->bindParam(8, $searchKey);
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
		$query = "SELECT  t.* FROM ". $this->table_name ." t  WHERE LOWER(t.AptNumber) LIKE ? OR LOWER(t.HouseNumber) LIKE ?  OR LOWER(t.Street) LIKE ?  OR LOWER(t.Zipcode) LIKE ?  OR LOWER(t.City) LIKE ?  OR LOWER(t.StateName) LIKE ?  OR LOWER(t.Country) LIKE ?  OR LOWER(t.Contact) LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		$stmt = $this->conn->prepare($query);
		$searchKey="%".strtolower($searchKey)."%";
		
$stmt->bindParam(1, $searchKey);
$stmt->bindParam(2, $searchKey);
$stmt->bindParam(3, $searchKey);
$stmt->bindParam(4, $searchKey);
$stmt->bindParam(5, $searchKey);
$stmt->bindParam(6, $searchKey);
$stmt->bindParam(7, $searchKey);
$stmt->bindParam(8, $searchKey);
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
		$query = "SELECT  t.* FROM ". $this->table_name ." t  WHERE t.DeliveryPartnerId = ? LIMIT 0,1";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->DeliveryPartnerId);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$num = $stmt->rowCount();
		if($num>0){
			
$this->DeliveryPartnerId = $row['DeliveryPartnerId'];
$this->AptNumber = $row['AptNumber'];
$this->HouseNumber = $row['HouseNumber'];
$this->Street = $row['Street'];
$this->Zipcode = $row['Zipcode'];
$this->City = $row['City'];
$this->StateName = $row['StateName'];
$this->Country = $row['Country'];
$this->Contact = $row['Contact'];
		}
		else{
			$this->DeliveryPartnerId=null;
		}
	}
	function create(){
		$query ="INSERT INTO ".$this->table_name." SET AptNumber=:AptNumber,HouseNumber=:HouseNumber,Street=:Street,Zipcode=:Zipcode,City=:City,StateName=:StateName,Country=:Country,Contact=:Contact";
		$stmt = $this->conn->prepare($query);
		
$this->AptNumber=htmlspecialchars(strip_tags($this->AptNumber));
$this->HouseNumber=htmlspecialchars(strip_tags($this->HouseNumber));
$this->Street=htmlspecialchars(strip_tags($this->Street));
$this->Zipcode=htmlspecialchars(strip_tags($this->Zipcode));
$this->City=htmlspecialchars(strip_tags($this->City));
$this->StateName=htmlspecialchars(strip_tags($this->StateName));
$this->Country=htmlspecialchars(strip_tags($this->Country));
$this->Contact=htmlspecialchars(strip_tags($this->Contact));
		
$stmt->bindParam(":AptNumber", $this->AptNumber);
$stmt->bindParam(":HouseNumber", $this->HouseNumber);
$stmt->bindParam(":Street", $this->Street);
$stmt->bindParam(":Zipcode", $this->Zipcode);
$stmt->bindParam(":City", $this->City);
$stmt->bindParam(":StateName", $this->StateName);
$stmt->bindParam(":Country", $this->Country);
$stmt->bindParam(":Contact", $this->Contact);
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
		return 0;
	}
	function update(){
		$query ="UPDATE ".$this->table_name." SET AptNumber=:AptNumber,HouseNumber=:HouseNumber,Street=:Street,Zipcode=:Zipcode,City=:City,StateName=:StateName,Country=:Country,Contact=:Contact WHERE DeliveryPartnerId = :DeliveryPartnerId";
		$stmt = $this->conn->prepare($query);
		
$this->AptNumber=htmlspecialchars(strip_tags($this->AptNumber));
$this->HouseNumber=htmlspecialchars(strip_tags($this->HouseNumber));
$this->Street=htmlspecialchars(strip_tags($this->Street));
$this->Zipcode=htmlspecialchars(strip_tags($this->Zipcode));
$this->City=htmlspecialchars(strip_tags($this->City));
$this->StateName=htmlspecialchars(strip_tags($this->StateName));
$this->Country=htmlspecialchars(strip_tags($this->Country));
$this->Contact=htmlspecialchars(strip_tags($this->Contact));
$this->DeliveryPartnerId=htmlspecialchars(strip_tags($this->DeliveryPartnerId));
		
$stmt->bindParam(":AptNumber", $this->AptNumber);
$stmt->bindParam(":HouseNumber", $this->HouseNumber);
$stmt->bindParam(":Street", $this->Street);
$stmt->bindParam(":Zipcode", $this->Zipcode);
$stmt->bindParam(":City", $this->City);
$stmt->bindParam(":StateName", $this->StateName);
$stmt->bindParam(":Country", $this->Country);
$stmt->bindParam(":Contact", $this->Contact);
$stmt->bindParam(":DeliveryPartnerId", $this->DeliveryPartnerId);
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
				if($columnName!='DeliveryPartnerId'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE DeliveryPartnerId = :DeliveryPartnerId"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='DeliveryPartnerId'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":DeliveryPartnerId", $this->DeliveryPartnerId);
			$stmt->execute();

			if($stmt->rowCount()) {
				return true;
			} else {
				return false;
			}
	}
	function delete(){
		$query = "DELETE FROM " . $this->table_name . " WHERE DeliveryPartnerId = ? ";
		$stmt = $this->conn->prepare($query);
		$this->DeliveryPartnerId=htmlspecialchars(strip_tags($this->DeliveryPartnerId));
		$stmt->bindParam(1, $this->DeliveryPartnerId);
	 	$stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
}
?>
