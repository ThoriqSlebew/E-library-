<?php

include '../koneksi.php';

// Cek apakah form dikirimkan dengan method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "INSERT INTO pengguna (username, email, password ) VALUES ('$username', '$email','$password')";
    mysqli_query($koneksi, $sql);
    header('location: pengguna.php');
}
?>