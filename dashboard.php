<?php
    session_start();
    if($_SESSION['status_login'] != true){
        echo '<script>window.location="login-admin.php"</script>';
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | TokoKue </title>
    <link rel="stylesheet" href="css/style-admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body>
 <!-- header -->

 <header class="header">
        <div class="flex">
            <a href="#" class="logo">Shalu's Sweet Shop</a>
            <nav class="navbar">
                <a href="dashboard.php"><i class="fas fa-gauge"></i></a>
                <a href="profil-admin.php"><i class="fas fa-user"></i></a>
                <a href="admin.php"><i class="fas fa-cart-plus"></i></a>
                <a href="logout-admin.php">Logout</a>
            </nav>
        </div>
    </header>

    <!--Content-->
    <div class="section">
        <div class="container">
            <h1>Dashboard</h1>
            <div class="box">
                <h2>Selamat Datang <?php echo $_SESSION['a_global']->nm_admin ?> </h2>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
    <div class="container">
        <small>Copyright &copy, 2023 - Shalu's Sweet Shop</small>
    </div>
</footer>
</body>
</html>