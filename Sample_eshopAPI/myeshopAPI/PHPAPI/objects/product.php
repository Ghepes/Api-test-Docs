<?php
class Product{
 
    private $conn;
    private $table_name = "product";
	public $pageNo = 1;
	public  $no_of_records_per_page=30;
	
public $ProductID;
public $ProductCategoryID;
public $ProductSubCategoryID;
public $ProductName;
public $Price;
public $Manufacturer;
public $ProductDimension;
public $ProductWeight;
public $SellerID;
public $SellerName;
public $Rating;
public $DateOfManufacture;
public $ProductImage;
public $Name;
    
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join productcategory ppp on t.ProductCategoryID = ppp.ProductCategoryID  WHERE LOWER(t.ProductCategoryID) LIKE ? OR LOWER(t.ProductSubCategoryID) LIKE ?  OR LOWER(t.ProductName) LIKE ?  OR LOWER(t.Price) LIKE ?  OR LOWER(t.Manufacturer) LIKE ?  OR LOWER(t.ProductDimension) LIKE ?  OR LOWER(t.ProductWeight) LIKE ?  OR LOWER(t.SellerID) LIKE ?  OR LOWER(t.SellerName) LIKE ?  OR LOWER(t.Rating) LIKE ?  OR LOWER(t.DateOfManufacture) LIKE ?  OR LOWER(t.ProductImage) LIKE ? ";
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
$stmt->bindParam(9, $searchKey);
$stmt->bindParam(10, $searchKey);
$stmt->bindParam(11, $searchKey);
$stmt->bindParam(12, $searchKey);
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
		$query = "SELECT count(1) as total FROM ". $this->table_name ." t  join productcategory ppp on t.ProductCategoryID = ppp.ProductCategoryID  WHERE ".$where."";
		
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
		$query = "SELECT  ppp.Name, t.* FROM ". $this->table_name ." t  join productcategory ppp on t.ProductCategoryID = ppp.ProductCategoryID  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}
	function search($searchKey){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		$query = "SELECT  ppp.Name, t.* FROM ". $this->table_name ." t  join productcategory ppp on t.ProductCategoryID = ppp.ProductCategoryID  WHERE LOWER(t.ProductCategoryID) LIKE ? OR LOWER(t.ProductSubCategoryID) LIKE ?  OR LOWER(t.ProductName) LIKE ?  OR LOWER(t.Price) LIKE ?  OR LOWER(t.Manufacturer) LIKE ?  OR LOWER(t.ProductDimension) LIKE ?  OR LOWER(t.ProductWeight) LIKE ?  OR LOWER(t.SellerID) LIKE ?  OR LOWER(t.SellerName) LIKE ?  OR LOWER(t.Rating) LIKE ?  OR LOWER(t.DateOfManufacture) LIKE ?  OR LOWER(t.ProductImage) LIKE ?  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
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
$stmt->bindParam(9, $searchKey);
$stmt->bindParam(10, $searchKey);
$stmt->bindParam(11, $searchKey);
$stmt->bindParam(12, $searchKey);
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
		$query = "SELECT  ppp.Name, t.* FROM ". $this->table_name ." t  join productcategory ppp on t.ProductCategoryID = ppp.ProductCategoryID  WHERE ".$where." LIMIT ".$offset." , ". $this->no_of_records_per_page."";
		
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
		$query = "SELECT  ppp.Name, t.* FROM ". $this->table_name ." t  join productcategory ppp on t.ProductCategoryID = ppp.ProductCategoryID  WHERE t.ProductID = ? LIMIT 0,1";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->ProductID);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$num = $stmt->rowCount();
		if($num>0){
			
$this->ProductID = $row['ProductID'];
$this->ProductCategoryID = $row['ProductCategoryID'];
$this->Name = $row['Name'];
$this->ProductSubCategoryID = $row['ProductSubCategoryID'];
$this->ProductName = $row['ProductName'];
$this->Price = $row['Price'];
$this->Manufacturer = $row['Manufacturer'];
$this->ProductDimension = $row['ProductDimension'];
$this->ProductWeight = $row['ProductWeight'];
$this->SellerID = $row['SellerID'];
$this->SellerName = $row['SellerName'];
$this->Rating = $row['Rating'];
$this->DateOfManufacture = $row['DateOfManufacture'];
$this->ProductImage = $row['ProductImage'];
		}
		else{
			$this->ProductID=null;
		}
	}
	function create(){
		$query ="INSERT INTO ".$this->table_name." SET ProductCategoryID=:ProductCategoryID,ProductSubCategoryID=:ProductSubCategoryID,ProductName=:ProductName,Price=:Price,Manufacturer=:Manufacturer,ProductDimension=:ProductDimension,ProductWeight=:ProductWeight,SellerID=:SellerID,SellerName=:SellerName,Rating=:Rating,DateOfManufacture=:DateOfManufacture,ProductImage=:ProductImage";
		$stmt = $this->conn->prepare($query);
		
$this->ProductCategoryID=htmlspecialchars(strip_tags($this->ProductCategoryID));
$this->ProductSubCategoryID=htmlspecialchars(strip_tags($this->ProductSubCategoryID));
$this->ProductName=htmlspecialchars(strip_tags($this->ProductName));
$this->Price=htmlspecialchars(strip_tags($this->Price));
$this->Manufacturer=htmlspecialchars(strip_tags($this->Manufacturer));
$this->ProductDimension=htmlspecialchars(strip_tags($this->ProductDimension));
$this->ProductWeight=htmlspecialchars(strip_tags($this->ProductWeight));
$this->SellerID=htmlspecialchars(strip_tags($this->SellerID));
$this->SellerName=htmlspecialchars(strip_tags($this->SellerName));
$this->Rating=htmlspecialchars(strip_tags($this->Rating));
$this->DateOfManufacture=htmlspecialchars(strip_tags($this->DateOfManufacture));
$this->ProductImage=htmlspecialchars(strip_tags($this->ProductImage));
		
$stmt->bindParam(":ProductCategoryID", $this->ProductCategoryID);
$stmt->bindParam(":ProductSubCategoryID", $this->ProductSubCategoryID);
$stmt->bindParam(":ProductName", $this->ProductName);
$stmt->bindParam(":Price", $this->Price);
$stmt->bindParam(":Manufacturer", $this->Manufacturer);
$stmt->bindParam(":ProductDimension", $this->ProductDimension);
$stmt->bindParam(":ProductWeight", $this->ProductWeight);
$stmt->bindParam(":SellerID", $this->SellerID);
$stmt->bindParam(":SellerName", $this->SellerName);
$stmt->bindParam(":Rating", $this->Rating);
$stmt->bindParam(":DateOfManufacture", $this->DateOfManufacture);
$stmt->bindParam(":ProductImage", $this->ProductImage);
		if($stmt->execute()){
			return  $this->conn->lastInsertId();
		}
		return 0;
	}
	function update(){
		$query ="UPDATE ".$this->table_name." SET ProductCategoryID=:ProductCategoryID,ProductSubCategoryID=:ProductSubCategoryID,ProductName=:ProductName,Price=:Price,Manufacturer=:Manufacturer,ProductDimension=:ProductDimension,ProductWeight=:ProductWeight,SellerID=:SellerID,SellerName=:SellerName,Rating=:Rating,DateOfManufacture=:DateOfManufacture,ProductImage=:ProductImage WHERE ProductID = :ProductID";
		$stmt = $this->conn->prepare($query);
		
$this->ProductCategoryID=htmlspecialchars(strip_tags($this->ProductCategoryID));
$this->ProductSubCategoryID=htmlspecialchars(strip_tags($this->ProductSubCategoryID));
$this->ProductName=htmlspecialchars(strip_tags($this->ProductName));
$this->Price=htmlspecialchars(strip_tags($this->Price));
$this->Manufacturer=htmlspecialchars(strip_tags($this->Manufacturer));
$this->ProductDimension=htmlspecialchars(strip_tags($this->ProductDimension));
$this->ProductWeight=htmlspecialchars(strip_tags($this->ProductWeight));
$this->SellerID=htmlspecialchars(strip_tags($this->SellerID));
$this->SellerName=htmlspecialchars(strip_tags($this->SellerName));
$this->Rating=htmlspecialchars(strip_tags($this->Rating));
$this->DateOfManufacture=htmlspecialchars(strip_tags($this->DateOfManufacture));
$this->ProductImage=htmlspecialchars(strip_tags($this->ProductImage));
$this->ProductID=htmlspecialchars(strip_tags($this->ProductID));
		
$stmt->bindParam(":ProductCategoryID", $this->ProductCategoryID);
$stmt->bindParam(":ProductSubCategoryID", $this->ProductSubCategoryID);
$stmt->bindParam(":ProductName", $this->ProductName);
$stmt->bindParam(":Price", $this->Price);
$stmt->bindParam(":Manufacturer", $this->Manufacturer);
$stmt->bindParam(":ProductDimension", $this->ProductDimension);
$stmt->bindParam(":ProductWeight", $this->ProductWeight);
$stmt->bindParam(":SellerID", $this->SellerID);
$stmt->bindParam(":SellerName", $this->SellerName);
$stmt->bindParam(":Rating", $this->Rating);
$stmt->bindParam(":DateOfManufacture", $this->DateOfManufacture);
$stmt->bindParam(":ProductImage", $this->ProductImage);
$stmt->bindParam(":ProductID", $this->ProductID);
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
				if($columnName!='ProductID'){
				if($colCount===1){
					$setValue = $columnName."=:".$columnName;
				}else{
					$setValue = $setValue . "," .$columnName."=:".$columnName;
				}
				$colCount++;
				}
			}
			$setValue = rtrim($setValue,',');
			$query = $query . " " . $setValue . " WHERE ProductID = :ProductID"; 
			$stmt = $this->conn->prepare($query);
			foreach($jsonObj as $key => $value) 
			{
			    $columnName=htmlspecialchars(strip_tags($key));
				if($columnName!='ProductID'){
				$colValue=htmlspecialchars(strip_tags($value));
				$stmt->bindValue(":".$columnName, $colValue);
				}
			}
			$stmt->bindParam(":ProductID", $this->ProductID);
			$stmt->execute();

			if($stmt->rowCount()) {
				return true;
			} else {
				return false;
			}
	}
	function delete(){
		$query = "DELETE FROM " . $this->table_name . " WHERE ProductID = ? ";
		$stmt = $this->conn->prepare($query);
		$this->ProductID=htmlspecialchars(strip_tags($this->ProductID));
		$stmt->bindParam(1, $this->ProductID);
	 	$stmt->execute();

	 if($stmt->rowCount()) {
			return true;
		} else {
		   return false;
		}
		 
	}

	
function readByProductCategoryID(){

if (isset($_GET["pageNo"]))
{
$this->pageNo =$_GET["pageNo"]; } 
$offset = ($this->pageNo - 1) * $this->no_of_records_per_page;
$query = "SELECT  ppp.Name, t.* FROM ". $this->table_name ." t  join productcategory ppp on t.ProductCategoryID = ppp.ProductCategoryID  WHERE t.ProductCategoryID = ? LIMIT ".$offset." , ". $this->no_of_records_per_page."";

$stmt = $this->conn->prepare( $query );
$stmt->bindParam(1, $this->ProductCategoryID);

$stmt->execute();
return $stmt;
}

}
?>
