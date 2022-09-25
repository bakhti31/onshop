<?php 
require '../config/db.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];
if ($username) {
	
	$admin = new Admin();
	if($admin->login($username,$password)){
		$_SESSION['username'] = $username;
	}else{
		echo "Wrong identity";
	}

	// $_SESSION['username'] = $username;
}

if (@$_GET['logout']) {
	session_destroy();
	unset($_SESSION);
	header("Location: /onshop/admin");
	exit;
}

if ($_SESSION) { 
	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	Welcome <?=$_SESSION['username'];?>
	<ul>

		<li><a href="?list=1">Daftar Pesanan</a></li>
		<li><a href="?done=1">Daftar Terkirim</a></li>
		<li><a href="?logout=true">Keluar</a></li>
	</ul>

	<?php if ($_GET['done']): ?>
		
	<?php endif ?>
	<?php if ($_GET['list']==1): ?>
		<table border=1>
			<tr>
				<th>Nama</th>
				<th>Pesanan</th>
				<th>Banyak</th>
				<th>Aksi</th>
			</tr>
			<?php 
				$response = file_get_contents('http://localhost/onshop/config/api.php?f=read');
				$response = json_decode($response,true);
			 ?>
			 <?php foreach ($response['data'] as $res): ?>
			 	<tr>
			 		<td><?php echo $res['name'] ?></td>
			 		<td><?php echo $res['price'] ?></td>
			 		<td><?php echo $res['item_id'] ?></td>
			 		<td><a href="?delete=<?php echo $res['item_id'] ?>">Hapus</a></td>
			 	</tr>
			 <?php endforeach ?>
		</table>
	<?php endif ?>
</body>
</html>




<?php }else{ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<form action="" method="post">
		<input type="text" name="username">
		<input type="password" name="password">
		<input type="submit" value="Masuk">
	</form>
	<a href="/onshop">I am not admin</a>
</body>
</html>
	<?php
}

 ?>