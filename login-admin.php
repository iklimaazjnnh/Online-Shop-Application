
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Shopping Cart </title>
    <link rel="stylesheet" href="css/style-admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body id="bg-login">
    <div class="box-login">
        <h2>Login</h2>
        <form action="" method="POST">
            <input type="text" name="user" placeholder="Username" class="input-control">
            <input type="password" name="pass" placeholder="Password" class="input-control">
            <input type="submit" name="submit" value="Login" class="btn">		
        </form>
        <?php 
            if(isset($_POST['submit'])) {
                session_start();
                include 'config.php';
                
            $user = mysqli_real_escape_string($conn,$_POST['user']);
            $pass = mysqli_real_escape_string($conn,$_POST['pass']);

            $cek = mysqli_query($conn, "SELECT * FROM table_admin WHERE username = '".$user."' AND password = '".($pass)."'");
            if (mysqli_num_rows($cek) > 0){
                $d = mysqli_fetch_object($cek);
                $_SESSION['status_login'] = true;
                $_SESSION['a_global'] = $d;
                $_SESSION['id'] = $d->id_admin;
                echo '<script>window.location="dashboard.php"</script>';
            }else{
                echo '<script>alert("Username atau Password salah!")</script>';
            }
            }
        ?>
    </div>
</body>
</html>