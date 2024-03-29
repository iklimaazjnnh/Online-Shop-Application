<?php

@include 'config.php';

if(isset($_POST['order_btn'])){

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $flat = $_POST['flat'];
   $street = $_POST['street'];
   $city = $_POST['city'];
   $state = $_POST['state'];
   $country = $_POST['country'];
   $total_product = $_POST['total_products'];
   $pin_code = $_POST['pin_code'];

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
   $price_total = 0;
   $product_name = array();

   if(mysqli_num_rows($cart_query) > 0){
       while($product_item = mysqli_fetch_assoc($cart_query)){
           $product_name[] = $product_item['name'] .' ('. $product_item['quantity'] .') ';
           $product_price =  ($product_item['price'] * $product_item['quantity']);
           $price_total += $product_price;
       };
   }
   

   $total_product = implode(', ',$product_name);
   $detail_query = mysqli_query($conn, "INSERT INTO `order`(name, number, email, method, flat, street, city, state, country, pin_code, total_products, total_price) VALUES('$name','$number','$email','$method','$flat','$street','$city','$state','$country','$pin_code','$total_product','$price_total')") or die('query failed');

   if($cart_query && $detail_query){
      mysqli_query($conn, "DELETE FROM `cart`");
      echo "
      <div class='order-message-container'>
      <div class='message-container'>
         <h3>thank you for shopping!</h3>
         <div class='order-detail'>
            <span>".$total_product."</span>
            <span class='total'> total : Rp.".$price_total." </span>
         </div>
         <div class='customer-details'>
            <p> Nama              : <span>".$name."</span> </p>
            <p> Nomer Telpon      : <span>".$number."</span> </p>
            <p> Email             : <span>".$email."</span> </p>
            <p> Alamat            : <span>".$flat.", ".$street.", ".$city.", ".$state.", ".$country." - ".$pin_code."</span> </p>
            <p> Metode Pembayaran : <span>".$method."</span> </p>
            <p>(*Produk dikirim setelah pembayaran*)</p>
         </div>
            <a href='products.php' class='btn'>Lanjut Belanja</a>
         </div>
      </div>
      ";
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

<section class="checkout-form">

   <h1 class="heading">Selesaikan Pesanan</h1>

   <form action="" method="post">

   <div class="display-order">

   <?php
$select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
$total = 0;
$grand_total = 0;

if(mysqli_num_rows($select_cart) > 0){
    while($fetch_cart = mysqli_fetch_assoc($select_cart)){
        $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
        $grand_total += $total_price;
        ?>
        <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
        <?php
    }
} else {
    echo "<div class='display-order'><span>Your cart is empty!</span></div>";
}
?>

      <span class="grand-total"> Total Harga : <?= $grand_total; ?> </span>
   </div>

      <div class="flex">
         <div class="inputBox">
            <span>Nama</span>
            <input type="text" placeholder="Nama Kamu" name="name" required>
         </div>
         <div class="inputBox">
            <span>Nomer Telepon</span>
            <input type="number" placeholder="Nomer Kamu" name="number" required>
         </div>
         <div class="inputBox">
            <span>Email</span>
            <input type="email" placeholder="Email Kamu" name="email" required>
         </div>
         <div class="inputBox">
            <span>Metode Pembayaran</span>
            <select name="method">
               <option value="cash on delivery" selected>cash on devlivery</option>
               <option value="credit cart">credit cart</option>
               <option value="paypal">paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Jl. Rumah</span>
            <input type="text" placeholder="co jalan rumah" name="flat" required>
         </div>
         <div class="inputBox">
            <span>Alamat Lengkap</span>
            <input type="text" placeholder="co Alamat Lengkap" name="street" required>
         </div>
         <div class="inputBox">
            <span>Kota</span>
            <input type="text" placeholder="co Depok" name="city" required>
         </div>
         <div class="inputBox">
            <span>Ibu Kota</span>
            <input type="text" placeholder="co Jawa Barat" name="state" required>
         </div>
         <div class="inputBox">
            <span>Negara</span>
            <input type="text" placeholder="co Indonesia" name="country" required>
         </div>
         <div class="inputBox">
            <span>Kode Pos</span>
            <input type="text" placeholder="co 12345" name="pin_code" required>
         </div>
      </div>
      <input type="submit" value="Pesan Sekarang" name="order_btn" class="btn">
   </form>

</section>

</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>