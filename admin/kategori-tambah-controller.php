<?php

include '../koneksi.php';

// Cek apakah form dikirimkan dengan method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form
    $nama_kategori = $_POST["nama_kategori"];
    $klasifikasi = $_POST["klasifikasi"];

    $sql = "INSERT INTO kategori_buku (nama_kategori, klasifikasi) VALUES ('$nama_kategori', '$klasifikasi')";
    mysqli_query($koneksi, $sql);
    header('location: kategori.php');
}
?>