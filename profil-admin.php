<?php
 session_start();
 include 'config.php';
 if($_SESSION['status_login'] != true){
    echo '<script>window.location="login-admin.php"</script>';
}

$query = mysqli_query($conn, "SELECT * FROM table_admin ORDER BY id_admin = '".$_SESSION['id']."'");
$d = mysqli_fetch_object($query);



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Shalu's Sweet Shop</title>
    <link rel="stylesheet" href="css/style-admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
            <h3>Profil</h3>
            <div class="box">
                <form action="" method="POST">
                <input type="text" name="nama" placeholder="Nama Lengkap" class="input-control" value="<?php echo $d->nm_admin ?>" required>
                    <input type="text" name="user" placeholder="Username" class="input-control" value="<?php echo $d->username ?>" required>
                    <input type="text" name="hp" placeholder="No Hp" class="input-control" value="<?php echo $d->admin_tlp ?>" required>
                    <input type="email" name="email" placeholder="Email" class="input-control" value="<?php echo $d->admin_email ?>" required>
                    <input type="submit" name="submit" value="Ubah Profil" class="btn">
                </form>
                <?php 
                    if(isset($_POST['submit'])){
                        $nama   = ucwords($_POST['nama']);
                        $user   = $_POST['user'];
                        $hp     = $_POST['hp'];
                        $email  = $_POST['email'];

                        $update = mysqli_query($conn, "UPDATE table_admin SET
                                nm_admin = '".$nama."', 
                                username = '".$user."', 
                                admin_tlp = '".$hp."', 
                                admin_email = '".$email."' 
                               
                                WHERE id_admin = '".$d->id_admin."'");
                        if($update){
                            echo '<script>alert("Ubah data berhasil")</script>';
                            echo '<script>window.location="profil-admin.php"</script>';
                        }else{
                            echo 'gagal'.mysqli_error($conn);
                        }
                    }
                ?>
            </div>

            <h3>Ubah Password</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="password" name="pass1" placeholder="Password Baru" class="input-control" required>
                    <input type="password" name="pass2" placeholder="Konfirmasi Password Baru" class="input-control" required>
                    <input type="submit" name="ubah_password" value="Ubah Password" class="btn">
                </form>
                <?php 
                    if(isset($_POST['ubah_password'])){     
                        $pass1   = $_POST['pass1'];
                        $pass2   = $_POST['pass2'];

                        if($pass2 != $pass1){
                            echo '<script>alert("Konfirmasi Password Baru tidak sesuai")</script>';
                        }else{
                            $u_pass = mysqli_query($conn, "UPDATE table_admin SET
                                password = '".$pass1."'
                                WHERE id_admin = '".$d->id_admin."'");
                            if($u_pass){
                                echo '<script>alert("Ubah data berhasil")</script>';
                                echo '<script>window.location="profil-admin.php"</script>';
                            }else{
                                echo 'gagal'.mysqli_error($conn); 
                            }
                        }  
                    }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <small>&copy; 2023 - Shalu's Sweet Shop</small>
        </div>
    </footer>
</body>
</html>
