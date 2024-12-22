<?php
// Koneksi database
$host = "localhost";      
$user = "root";          
$password = "";           
$database = "db_auliapool"; 

$conn = mysqli_connect($host, $user, $password, $database);

// Periksa koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
