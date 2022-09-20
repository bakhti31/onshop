<?php 
require 'config/db.php'; 
$db = new Items();
$data = $db->select('items');

// $response = file_get_contents('http://localhost/onshop/config/api.php?f=read');
// $response = json_decode($response,true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Febi shop</title>
</head>
<body>	
	<h1>Febi shop</h1>
	<ul>
		<?php while($row = $data->fetch_assoc() ): ?>
		<li><a href="detail.php?id=<?=$row[item_id]?>"><?=$row[name]?></a></li>
		<?php endwhile ?>
	</ul>
	<a href="admin/">Halaman Admin</a>
</body>
</html>