<?php 
	require_once 'db.php';
	if (function_exists($_GET['f'])) {
		$_GET['f']();
	}

	function C()
	{
		echo "Create";
	}
	function read()
	{
		$data = new Items();
		$id = $_GET['id'];
		$result = $data->select("items");
		if ($id) {
			$result = $data->show($id);	
		}
		while ($row = $result->fetch_assoc()) {
			$d[] = $row;
		}
		if(!$d){
			$response = array(
				'status' => 0,
				'message' => 'no data found',
				'data' => ''
			);
		}else{
			$response = array(
				'status' => 1,
				'message' => 'success',
				'data' => $d,
			);
		}
		header("Content-Type: application/json");
		echo json_encode($response);
	}
	function U()
	{
		echo "Update";
	}
	function D()
	{
		echo "Delete";
	}




 ?>