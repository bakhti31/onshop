<?php 
require "config/db.php";
$db = new Items;
$id = $_GET[id];
$data = $db->select("items","WHERE item_id=$id");

 ?>


 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<title><?=$_GET[id]?></title>
 </head>
 <body>
 	<?php while ($row = $data->fetch_assoc()): ?>
 	Nama produk : <?=$row[name]?><br>
 	Harga produk : <?=$row[price]?>
 	<?php endwhile ?>
    <a href="/onshop">Back</a>
 </body>
 </html>