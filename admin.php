<?php

@include 'config.php';

if(isset($_POST['add_product'])){
   $p_name = $_POST['p_name'];
   $p_detail = $_POST['p_detail'];
   $p_price = $_POST['p_price'];
   $p_image = $_FILES['p_image']['name'];
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_image_folder = 'uploaded_img/'.$p_image;

   $insert_query = mysqli_query($conn, "INSERT INTO `product`(name, detail, price, image) VALUES('$p_name','$p_detail', '$p_price', '$p_image')") or die('query failed');

   if($insert_query){
      move_uploaded_file($p_image_tmp_name, $p_image_folder);
      $message[] = 'product add succesfully';
   }else{
      $message[] = 'could not add the product';
   }
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "DELETE FROM `product` WHERE id_product = $delete_id ") or die('query failed');
   if($delete_query){
      header('location:admin.php');
      $message[] = 'product has been deleted';
   }else{
      header('location:admin.php');
      $message[] = 'product could not be deleted';
   };
};

if(isset($_POST['update_product'])){
   $update_p_id = $_POST['update_p_id'];
   $update_p_name = $_POST['update_p_name'];
   $update_p_detail = $_POST['update_p_detail'];
   $update_p_price = $_POST['update_p_price'];
   $update_p_image = $_FILES['update_p_image']['name'];
   $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
   $update_p_image_folder = 'uploaded_img/'.$update_p_image;

   $update_query = mysqli_query($conn, "UPDATE `product` SET name = '$update_p_name', detail = '$update_p_detail', price = '$update_p_price', image = '$update_p_image' WHERE id_product = '$update_p_id'");

   if($update_query){
      move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
      $message[] = 'product updated succesfully';
      header('location:admin.php');
   }else{
      $message[] = 'product could not be updated';
      header('location:admin.php');
   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>

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

<header class="header">

   <div class="flex">

      <a href="#" class="logo">Shalu's Sweet Shop</a>

      <nav class="navbar">
          <a href="dashboard.php"><i class="fas fa-gauge"></i></a>
         <a href="profil-admin.php"><i class="fas fa-user"></i></a>
         <a href="admin.php"><i class="fas fa-cart-plus"></i></a>
         <a href="logout-admin.php">Logout</a>
      </nav>

      <div id="menu-btn" class="fas fa-bars"></div>

   </div>

</header>


<div class="container">

<section>

<form action="" method="post" class="add-product-form" enctype="multipart/form-data">
   <h3>Tambahkan Produk Baru</h3>
   <input type="text" name="p_name" placeholder="Nama Produk" class="box" required>
   <input type="text" name="p_detail" placeholder="Deskripsi Produk" class="box" required>
   <input type="number" name="p_price" min="0" placeholder="Harga" class="box" required>
   <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
   <input type="submit" value="Tambahkan Produk" name="add_product" class="btn">
</form>

</section>

<section class="display-product-table">
<div class="search">
      <form action="" method="get" class="search-form">
         <input type="text" name="search" placeholder="Cari Produk" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
         <input type="submit" value="Cari" class="search-btn">
      </form>
   </div>
   <table>

   <table>

      <thead>
         <th>Gambar Produk</th>
         <th>Nama Produk</th>
         <th>Deskripsi Produk</th>
         <th>Harga Produk</th>
         <th>Aksi</th>
      </thead>

      <tbody>

         <?php
         
         if (isset($_GET['search'])) {
            $searchKeyword = $_GET['search'];
            $select_products = mysqli_query($conn, "SELECT * FROM `product` WHERE name LIKE '%$searchKeyword%' OR detail LIKE '%$searchKeyword%'");
         } else {
            $select_products = mysqli_query($conn, "SELECT * FROM `product`");
         }
         
            if(mysqli_num_rows($select_products) > 0){
               while($row = mysqli_fetch_assoc($select_products)){
         ?>

         <tr>
            <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['detail']; ?></td>
            <td>Rp.<?php echo number_format($row['price']); ?></td>
            <td>
               <a href="admin.php?delete=<?php echo $row['id_product']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> Hapus </a>
               <a href="admin.php?edit=<?php echo $row['id_product']; ?>" class="option-btn"> <i class="fas fa-edit"></i> Edit </a>
            </td>
         </tr>

         <?php
            };    
            }else{
               echo "<div class='empty'>no product added</div>";
            };
         ?>
      </tbody>
   </table>

</section>

<section class="edit-form-container">

   <?php
   
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($conn, "SELECT * FROM `product` WHERE id_product = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
         while($fetch_edit = mysqli_fetch_assoc($edit_query)){
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <img src="uploaded_img/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id_product']; ?>">
      <input type="text" class="box" required name="update_p_name" placeholder="Nama Produk" value="<?php echo $fetch_edit['name']; ?>">
      <input type="text area" class="box" required name="update_p_detail" placeholder="Deskripsi Produk" value="<?php echo $fetch_edit['detail']; ?>">
      <input type="number" min="0" class="box" required name="update_p_price" placeholder="Harga Produk" value="<?php echo number_format ($fetch_edit['price']); ?>">
      <input type="file" class="box" required name="update_p_image" placeholder="Gambar Produk" accept="image/png, image/jpg, image/jpeg">
      <input type="submit" value="update the prodcut" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-edit" class="option-btn">
   </form>

   <?php
            };
         };
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      };
   ?>

</section>

</div>

  <!-- Footer -->
  <footer>
        <div class="container">
            <small>&copy; 2023 - Shalu's Sweet Shop</small>
        </div>
    </footer>
</body>
</html>



<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>