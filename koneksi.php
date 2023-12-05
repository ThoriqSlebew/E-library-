<?php
$host = 'localhost';
$user = 'root'; 
$password = '';
$database = 'pemweb'; 

$koneksi = new mysqli($host, $user, $password, $database, 3309);

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}
?>
