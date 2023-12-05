<?php

include '../koneksi.php';

// Cek apakah form dikirimkan dengan method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form
    $id_kategori = $_POST["id_kategori"];
    $nama_kategori = $_POST["nama_kategori"];
    $klasifikasi = $_POST["klasifikasi"];

    $sql = "UPDATE kategori_buku SET nama_kategori='$nama_kategori', klasifikasi='$klasifikasi' WHERE id_kategori=$id_kategori";
    mysqli_query($koneksi, $sql);
    header('location: kategori.php');
}
?>