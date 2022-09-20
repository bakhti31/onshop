<?php 


/**
 * 
 */
class SQLnya
{
    public $conn; //Membuat koneksi
    public $queries; //Menyimpan query
    public function __construct($host,$username,$password,$db)
    {
        // global $conn
        $this->conn=mysqli_connect($host,$username,$password,$db)or die('Sorry Connection to database Error');
    }
    public function query($value)
    {
        // global $conn;
        $query=mysqli_query($this->conn,$value);
        if ($query) {
            $this->queries=$query;
            return $this;
        }else{
            $error=mysqli_error($this->conn);
            echo $error;
            return $error;
        }
    }
    public function insert($table,$field,$value)
    {
        return query("INSERT INTO $table($field) VALUES ($value)");
    }
    public function row($query='')
    {
        if ($query) {
            return mysqli_num_rows($query);
        }
        else{
            return mysqli_num_rows($this->queries);
        }   
    }

    public function fetch($query="")
    {
        if ($query) {
            return mysqli_fetch_assoc($query);
        }
        else{
            return mysqli_fetch_assoc($this->queries);
        }
    }
}
/**
 * 
 */
class user extends SQLnya
{
    public function login($username,$password)
    {
        // global $this->query;
        $sql=$this->query('SELECT * FROM user WHERE username="$username" AND password="$password"');
        if ($sql->row() < 1) {
            return $sql;
        }else{
            return false;
        }
    }
}

class items extends SQLnya
{
    public function listing($query="")
    {
        $sql=$this->query('SELECT * FROM items WHERE name LIKE "%pro%"')->fetch();
        return $sql;
    }
}


$test=new items("localhost","root","root","onshop");
$fetch = $test->listing();
foreach ($fetch as $row) {
    print_r($row);
}
// $query=$test->login('bakhti','password');
// // print_r($test->fetch($query));
// // echo $test->row();
// $fetch=$test->fetch($query);
// foreach ($fetch as $ar=>$val) {
//     print_r($val);
//     echo "<br>";
// }

 ?>