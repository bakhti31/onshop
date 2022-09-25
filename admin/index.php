<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require "../config/db.php";
$admin = new Admin;
$error = 0;
if (@$_POST['email']) {
	$email=$_POST['email'];
	$password = $_POST['pass'];
	if(!$admin->login($email,$password)){
		$error = 1;
	}
	$error = 0;
	$_SESSION['username'] = $email;
}

if (@$_GET['logout']) {
	unset($_SESSION['username']);
	session_destroy();
	header('Location: /onshop/admin ');
	exit();
}

if (@$_GET['delete']) {
	$id = $_GET['delete'];
	if (!$admin->delete_item($id)) {
		echo "Gagal Menghapus Item $id";
	}
}
if (@$_GET['hapus']) {
	$id = $_GET['hapus'];
	if (!$admin->delete_order($id)) {
		echo "Gagal Menghapus Orderan $id";
	}
}
if (@$_GET['done']) {
	$id = $_GET['done'];
	if (!$admin->make_history($id)) {
		echo "Gagal Menyelesaikan Pesanan";
	}
}


if (@$_POST['product']) {
	$name = $_POST['product'];
	$price = $_POST['price'];
	$image=$_FILES['img'];
	$images = $_POST['url']?:$image['name'];
	
	$id = $admin->add_item($name,$price,$images);
	if ($id) {
		if ($image["name"]) {
			if (mkdir("../images/".$id, 0755)) {
				echo "Berhasil Membuat Folder";
			}
			$fileloc = "../images/".$id."/".$image['name'];
			echo $fileloc;
			echo (move_uploaded_file($image['tmp_name'], $fileloc))?"Berhasil":"Error";
			echo $id;
		}
		
	}else{
		$error = 1;
		echo "Failed";
	}
}

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
 	<title>Admin Page</title>
 </head>
 <body>
	<div class="container-fliud">
    <!-- navigasi -->
     <nav class="navbar navbar-light" style="background-color: #DCD6F7;">
       <a class="navbar-brand" href="/onshop">
         <i class="bi bi-bag-heart"></i>
         Febi Shop
       </a>
     </nav> 
  	</div>
 	<div class="container">
 	<?php if (@$_SESSION['username']): ?>

 		<div class="row">
 			<div class="col-2">
				<nav class="navbar bg-light">
				  <!-- Links -->
				  <ul class="navbar-nav">
				    <li class="nav-item">
				      <a class="nav-link" href="?items=1">Daftar Produk</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link" href="?orders=1">Daftar Pesanan</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link" href="?history=1">Daftar Selesai</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link" href="?logout=1">Keluar</a>
				    </li>
				  </ul>
				</nav>
 			</div>
 			<div class="col">
 				<?php if(@$_GET['orders']): ?>
 					<table class="table table-striped table-hover text-center table-bordered">
 						<thead class="thead thead-dark">
 							<th scope="col">ID Pesanan </th>
 							<th scope="col">Produk</th>
 							<th scope="col">Kuantitas </th>
 							<th scope="col">Nama Penerima </th>
 							<th scope="col">Alamat Pengiriman</th>
 							<th scope="col">Catatan</th>
 							<th scope="col" colspan="2">Aksi</th>
 						</thead>
 						<?php $product = $admin->list_order(); ?>
						<?php while($row = $product->fetch_assoc()): ?>
						<tr>
							<td><?=$row['order_id']?></td>
							<td><?=$admin->item_name($row['item_id'])?></td>
							<td><?=$row['qty']?></td>
							<td><?=$row['receiver_name']?></td>
							<td><?=$row['address']?></td>
							<td><?=$row['note']?></td>
							<td><a href="?hapus=<?=$row['order_id']?>" class="btn btn-danger">Hapus </a></td>
 								<td><a href="?done=<?=$row['order_id']?>" class="btn btn-warning">Ubah</a></td>
						</tr>
						<?php endwhile ?>
 						<!-- <tr>
 							<td>2131</td>
 							<td>Produk B</td>
 							<td>2</td>
 							<td>Penajam</td>
 							<td><button class="btn btn-danger">Hapus</button></td>
 							<td><button class="btn btn-primary">Selesai</button></td>
 						</tr> -->
 					</table>
 				<?php elseif(@$_GET['history']): ?>
 					<table class="table table-striped table-hover text-center table-bordered">
 						<thead class="thead thead-dark">
 							<th scope="col">ID Pesanan </th>
 							<th scope="col">Produk</th>
 							<th scope="col">Kuantitas </th>
 							<th scope="col">Nama Penerima </th>
 							<th scope="col">Alamat Pengiriman</th>
 							<th scope="col">Catatan</th>
 						</thead>
 						<?php $product = $admin->list_history(); ?>
						<?php while($row = $product->fetch_assoc()): ?>
						<tr>
							<td><?=$row['order_id']?></td>
							<td><?=$admin->item_name($row['item_id'])?></td>
							<td><?=$row['qty']?></td>
							<td><?=$row['receiver_name']?></td>
							<td><?=$row['address']?></td>
							<td><?=$row['note']?></td>
						</tr>
						<?php endwhile ?>
 						<!-- <tr>
 							<td>2131</td>
 							<td>Produk B</td>
 							<td>2</td>
 							<td>Penajam</td>
 							<td><button class="btn btn-danger">Hapus</button></td>
 							<td><button class="btn btn-primary">Selesai</button></td>
 						</tr> -->
 					</table>


				<?php elseif(@$_GET['add']): ?>
					<form class="form" method="post" enctype="multipart/form-data">
					  <label class="sr-only" for="inlineFormInputName2">Nama Produk</label>
					  <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="Nama Produk" name="product">

					  <label class="sr-only" for="inlineFormInputGroupUsername2">Harga Produk</label>
					  <div class="input-group mb-2 mr-sm-2">
					    <div class="input-group-prepend">
					      <div class="input-group-text">Rp.</div>
					    </div>
					    <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Harga Produk" name="price">
					  </div>
					  <div class="mb-2">
					    <label for="formFileMultiple" class="form-label">Gambar Produk</label>
					    <input class="form-control" type="file" id="formFileMultiple" name="img">
					  </div>
					  <label for="url">Atau Dengan Url Gambar</label>
					  <input type="text" class="form-control mb-3" id="url" name="url">
					  <button type="submit" class="btn btn-primary mb-2">Tambah</button>
					</form>

				<?php elseif(@$_GET['edit']): ?>
					<form class="form" method="post" enctype="multipart/form-data">
					  <input type="hidden" disabled value="<?=$_GET['edit'];?>" name="id">

					  <label class="sr-only" for="inlineFormInputName2">Nama Produk</label>
					  <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="Nama Produk" name="product" value="">

					  <label class="sr-only" for="inlineFormInputGroupUsername2">Harga Produk</label>
					  <div class="input-group mb-2 mr-sm-2">
					    <div class="input-group-prepend">
					      <div class="input-group-text">Rp.</div>
					    </div>
					    <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Harga Produk" name="price" value="">
					  </div>
					  <div class="mb-2">
					    <label for="formFileMultiple" class="form-label">Gambar Produk</label>
					    <input class="form-control" type="file" id="formFileMultiple" name="img">
					  </div>
					  <label for="url">Atau Dengan Url Gambar</label>
					  <input type="text" class="form-control mb-3" id="url" placeholder="https://avatars.githubusercontent.com/u/27219734" name="url" value="">
					  <button type="submit" class="btn btn-primary mb-2">Tambah</button>
					</form>




 				<?php else: ?>
 					<a href="?add=1" class="btn btn-primary">Tambah Produk</a>
 					<div class="table-responsive">
 						<table class="table table-striped table-hover text-center table-bordered">
 							<thead class="thead thead-dark">
 								<th scope="col">Produk ID </th>
 								<th scope="col">Nama </th>
 								<th scope="col">Harga </th>
 								<th scope="col">Gambar </th>
 								<th scope="col" colspan="2">Aksi</th>
 							</thead>
 							<?php $product = $admin->list_product(); ?>



 							<?php while($row = $product->fetch_assoc()): ?>
 							<tr>
 								<td><?=$row['item_id']?></td>
 								<td><?=$row['name']?></td>
 								<td>Rp. <?=$row['price']?></td>
 								<td><img src="<?=strpos($row['image'], 'https')===0?$row['image']:"../images/".$row['item_id']."/".$row['image']?>" alt="" class="img-thumbnail rounded"></td>
 								<td><a href="?delete=<?=$row['item_id']?>" class="btn btn-danger">Hapus </a></td>
 								<td><a href="?edit=<?=$row['item_id']?>" class="btn btn-warning">Ubah</a></td>
 							</tr>
 							<?php endwhile ?>



 						</table>
 					</div>
 				<?php endif ?>
 			</div>
 		</div>
 		
 	<?php else: ?>
 		<form method="post">
 		  <div class="form-group">
 		    <label for="email">Nama Pemakai:</label>
 		    <input type="username" class="form-control" placeholder="Nama Pemakai" id="email" name="email">
 		  </div>
 		  <div class="form-group">
 		    <label for="pwd">Kata Sandi:</label>
 		    <input type="password" class="form-control" placeholder="Kata Sandi" id="pwd" name='pass'>
 		  </div>
 		  <button type="submit" class="btn btn-primary">Submit</button>
 		</form>
 	<?php endif ?>
 	</div>
 </body>
 </html>