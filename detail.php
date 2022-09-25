<?php 
require "config/db.php";
$db = new Items;
$id = $_GET[id];
$data = $db->select("items","WHERE item_id=$id");
$sukses = 0;
if (@$_POST['user']) {
   $user    = $_POST['user'];
   $phone   = $_POST['phone'];
   $qty     = $_POST['quantity'];
   $address = $_POST['address'];
   $note    = $_POST['note'];
   if($db->order($id,$user,$phone,$qty,$address,$note)){
      $sukses = 1;
   }else{
      echo "Failed Bois";
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
 	<title>Detail produk <?=$_GET[id]?></title>
 </head>
 <body>
   
 	<div class="container-fliud">
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
   </div>
   <?php if ($sukses==1): ?>
   <div class="alert alert-info alert-dismissible fade show" role="alert">
     <strong>Sukses</strong> Nantikan Pesan di nomor telepon anda!
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>
   </div>   
   <?php endif ?>
   <div class="container">

      <?php while ($row = $data->fetch_assoc()): ?>
      <div class="card">
        <img class="card-img-top" src="<?=strpos($row['image'], 'https')===0?$row['image']:"images/".$row['item_id']."/".$row['image']?>" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title"><?=$row[name]?></h5>
          <!-- <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p> -->
          <p class="card-text"><small class="text-muted"><?=$row[price]?></small></p>
        </div>
      </div>
      <?php endwhile ?>
      <h2>Pesan Sekarang</h2>
      <form method="post">
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="validationDefault01">Nama Pemesan :</label>
            <input type="text" name="user" class="form-control" id="validationDefault01" placeholder="Nama Penerima" value="" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="validationDefault02">Telepon / Handphone</label>
            <input type="phone" name="phone" class="form-control" id="validationDefault02" placeholder="Nomor Telpon Penerima" value="" required>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-2 mb-2">
            <label for="validationDefault03">Kuantitas</label>
            <input type="number" name="quantity" class="form-control" id="validationDefault03" min="1" placeholder="Banyak Pesanan" required>
          </div>
          <div class="col-md-10 mb-2">
            <label for="validationDefault04">Catatan</label>
            <textarea class="form-control" name="note" id="validationDefault04" placeholder="Contoh: Tuliskan Selamat Ulang Tahun" rows="2"></textarea>
          </div>
        </div>
        <div class="form-group">
           <label for="exampleFormControlTextarea1">Alamat Pengiriman</label>
           <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="3" required></textarea>
         </div>
        <button class="btn btn-primary" type="submit">Kirim</button>
      </form>   
      <a href="/onshop" class="btn btn-lg"><i class="bi bi-arrow-left-circle-fill"></i> Kembali ke List Produk</a>
   </div>
   <nav class="navbar sticky-top navbar-light bg-light">
     <a class="navbar-brand" href="#">FebiShop&copy;2022</a>
   </nav>


   

  <!--  <form action="" method="post">
      <table>
         <tr>
            <td>Nama Pemesan :</td>
            <td><input type="text" name="user"></td>
         </tr>
         <tr>
            <td>Jumlah Pesanan :</td>
            <td><input type="number" name="quantity"></td>
         </tr>
         <tr>
            <td>Alamat Pengiriman :</td>
            <td><textarea name="address" id="" cols="30" rows="10"></textarea></td>
         </tr>
         <tr>
            <td>Contact</td>
            <td><input type="phone" name="phone"></td>
         </tr>
         <tr>
            <td colspan="2"><input type="submit" value="kirim"></td>
         </tr>
      </table>
      Nama Pemesan : <input type="text">
      Jumlah pesanan : <input type="number">
      <br>
      Alamat Pengiriman : <textarea name="" id="" cols="30" rows="10"></textarea>
      <br>
      <input type="submit" value="kirim">
   </form> -->
 	
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 </body>
 </html>