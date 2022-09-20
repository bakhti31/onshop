<?php 

/**
 * 
 */



class SQLnya
{
	public $conn;
	private $host = "localhost";
	private $uname = "root";
	private $upass = "root";
	private $dbname = "onshop";
	function __construct()
	{
		$this->conn = new mysqli($this->host,$this->uname,$this->upass,$this->dbname);
	}
	public function select($table,$specific="")
	{
		$sql 	= "SELECT * FROM $table $specific";
		$query 	= $this->conn->query($sql);
		return $query;

	}
}



/**
 * 
 */
class Items extends SQLnya
{
	
	public function list()
	{
		return $this->select("items");
	}
	public function show($id)
	{
		return $this->select("items", "WHERE item_id=$id");
	}
}

/**
 * 
 */
class Admin extends Items
{
	public function login($u,$p)
	{
		$result = $this->select("users","WHERE 
			username = '".$u."' AND
			password = '".$p."'
			");
		if ($result->num_rows < 1) {
			return False;
		}
		return True;
	}
}

// $host = "localhost";
// $uname = "root";
// $upass = "root";
// $dbname = "onshop";
// $db = new SQLnya($host,$uname,$upass,$dbname);



 ?>