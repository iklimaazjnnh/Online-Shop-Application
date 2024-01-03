<?php

@include 'config.php';


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
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
   
<?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

?>

<?php include 'header.php'; ?>

  

<div class="container">

<section class="products">

   <h1 class="heading">Produk</h1>

<!-- search -->
  <div class="search">
        <div class="container">
            <form action="search.php">
            <input type="text" name="search" placeholder="Cari Produk" value="<?php echo $_GET['search'] ?>">
            <input type="submit" name="cari" value="Cari Produk">
            </form>
        </div>
    </div>
    <div class="box-container">

<?php
if(mysqli_num_rows($select_products) > 0){
   while($fetch_product = mysqli_fetch_assoc($select_products)){
?> 

<form action="" method="post">
   <div class="box">
      <form action="" method="post">
         <div class="box">
             <a href="detail-produk.php?id=<?php echo $fetch_product['id_product'] ?>">
            <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
            <h3><?php echo $fetch_product['name']; ?></h3>
            <div class="price">RP.<?php echo number_format ($fetch_product['price']); ?></div>
            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
            <input type="submit" class="btn" value="add to cart" name="add_to_cart">
         </div>
      </form>

      <?php
         };
      } else {
         echo "<div class='message'><span>No products found.</span></div>";
      }
      ?>

   </div>

</section>

</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>