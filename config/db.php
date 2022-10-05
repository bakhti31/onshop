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
	public function insert($table,$value)
	{
		$sql = "INSERT INTO $table VALUES ($value)";
		$query = $this->conn->query($sql);
		if ($query === TRUE) {
			return $this->conn->insert_id;
		}else{
			echo "Errornya ".$this->conn->error;
		}
		
	}
	public function delete($table, $column, $value)
	{
		$sql = "DELETE FROM $table WHERE $column = $value";
		$query = $this->conn->query($sql);
		return $query;
	}
	public function update($table,$set, $where)
	{
		$sql = "UPDATE $table SET $set WHERE $where";
		// echo $sql;
		$query = $this->conn->query($sql);
		// echo $this->conn->error;
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
	public function order($id,$name,$phone,$qty,$address,$note)
	{
		return $this->insert("orders(item_id,receiver_name,phone,qty,address,note)","'$id','$name','$phone','$qty','$address','$note'");
	}
}

/**
 * 
 */
class Admin extends SQLnya
{

	public function item_name($id)
	{
		$query = $this->select("items", "WHERE item_id=$id");
		$result = $query->fetch_assoc();
		return $result['name'];
	}
	public function login($u,$p)
	{
		$result = $this->select("users","WHERE 
			username = '".$u."' AND
			password = '".$p."' AND
			is_admin = 1
			");
		return ($result->num_rows < 1)?False:True;
	}
	public function show_item($id)
	{
		return $this->select("items", "WHERE item_id=$id");
	}
	public function list_product()
	{
		return $this->select('items');
	}
	public function list_order()
	{
		return $this->select('orders','WHERE status = 0');
	}
	public function list_history()
	{
		return $this->select('orders','WHERE status = 1');
	}
	public function delete_order($id)
	{
		return $this->delete('orders','order_id',$id);
	}
	public function delete_item($id)
	{
		return $this->delete('items','item_id',$id);
	}
	public function make_history($id)
	{
		return $this->update("orders","`status` = '1'","order_id = $id ");
	}
	public function update_item($id, $name, $price, $image)
	{
		return $this->update("items","'name' = '$name', 'price' = '$price', 'image' = '$image'","item_id = $id");
	}
	public function add_item($name, $price, $images)
	{
		return $this->insert('items(name,price,image)',"'$name','$price','$images'");
	}
}

// $host = "localhost";
// $uname = "root";
// $upass = "root";
// $dbname = "onshop";
// $db = new SQLnya($host,$uname,$upass,$dbname);



 ?>