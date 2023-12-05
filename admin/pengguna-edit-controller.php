<?php

include '../koneksi.php';

// Cek apakah form dikirimkan dengan method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form
    $id_pengguna = $_POST["id_pengguna"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    $sql = "UPDATE pengguna SET username='$username', password='password' email='$email' WHERE id_pengguna=$id_pengguna";
    mysqli_query($koneksi, $sql);
    header('location: pengguna.php');
}
?>