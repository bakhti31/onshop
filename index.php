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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<title>Febi shop</title>
</head>
<body>	



	<div class="container-fluids">
		<!-- navigasi -->
		<nav class="navbar navbar-light" style="background-color: #DCD6F7;">
		  <a class="navbar-brand" href="/onshop">
		    <i class="bi bi-bag-heart"></i>
		    Febi Shop
		  </a>

		  <a href="admin/" class="navbar navbar-light">
		  	<i class="bi bi-person"></i>Halaman Admin
		  </a>
		</nav>
		<!-- Produk -->
		<div class="card-deck m-2">
		  
		  <?php while($row = $data->fetch_assoc() ): ?> <!-- Menampilkan Semua -->
		  <div class="card">
		    <img class="card-img-top" src="<?=strpos($row['image'], 'https')===0?$row['image']:"images/".$row['item_id']."/".$row['image']?>" alt="Card image cap">
		    <div class="card-body">
		      <h5 class="card-title"><?=$row[name]?></h5>
		      <p class="card-text">Rp <?=$row[price]?></p>
		    </div>
		    <div class="card-footer">
		      <!-- <small class="text-muted">Last updated 3 mins ago</small> -->
		      <a href="detail.php?id=<?=$row[item_id]?>">Pesan <?=$row[name]?></a>
		    </div>
		  </div>
		  <?php endwhile ?>
		  
		</div>



		<nav class="navbar sticky-top navbar-light bg-light text-center">
		  <a class="navbar-brand" href="#">FebiShop&copy;2022</a>
		</nav>
	</div>
	




	 <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>