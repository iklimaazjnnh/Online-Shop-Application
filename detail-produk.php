<?php
@include 'config.php';



$produk = mysqli_query($conn, "SELECT * FROM product WHERE id_product = '".$_GET['id']."' ");
$p = mysqli_fetch_object($produk);

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM `product` WHERE name LIKE '%$search%'";
$select_products = mysqli_query($conn, $query);

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php
if(isset($message)) {
   foreach($message as $msg) {
      echo '<div class="message"><span>'.$msg.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i></div>';
   }
}
?>

<?php include 'header.php'; ?>

<div class="container">

   <section class="products">


      <!-- search -->
      <div class="search">
         <div class="container">
            <form action="search.php" method="GET">
               <input type="text" name="search" placeholder="Cari Produk" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
               <input type="submit" name="cari" value="Cari Produk">
            </form>
         </div>
      </div>

 
      <div class="container"> 
      <form action="" method="post">
      <h1 class="heading">Detail Produk</h1>
            <div class="box">
                <div class="col-2">
                   <img src="images/<?php echo $p->image ?>" width="70%" alt="">
                </div>
                <div class="col-2">
                   <h3><?php echo $p->name ?></h3>
                   <h4>Rp. <?php echo number_format ($p->price) ?></h4>
                    <p>Deskripsi :<br>
                        <?php echo $p->detail ?>
                    </p>
                </div>
            </div>
         </div>
      </form>


<!-- custom js file link -->
<script src="js/script.js"></script>

</body>
</html>
