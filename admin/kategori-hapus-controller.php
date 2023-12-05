<?php

include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Ambil id buku yang akan dihapus dari parameter URL
    $id_kategori = $_GET["id"];

    // Query untuk menghapus data buku berdasarkan id
    $sql = "DELETE FROM kategori_buku WHERE id_kategori= $id_kategori";
    
    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        echo "kategori berhasil dihapus";
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($koneksi);
    }

    // Redirect ke halaman buku.php
    header("Location: kategori.php");
    exit();
}

?>
