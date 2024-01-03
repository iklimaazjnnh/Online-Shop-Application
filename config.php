<?php
    $hostname = 'localhost';
    $name = 'root';
    $password = '';
    $dbname   = 'shop_db';

    $conn = mysqli_connect($hostname, $name, $password, $dbname) or die ('Gagal terhubung ke database');
?>