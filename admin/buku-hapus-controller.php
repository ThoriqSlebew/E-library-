<?php

include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Ambil id buku yang akan dihapus dari parameter URL
    $id_buku = $_GET["id"];

    // Query untuk menghapus data buku berdasarkan id
    $sql = "DELETE FROM buku WHERE id_buku = $id_buku";
    
    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        echo "Buku berhasil dihapus";
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($koneksi);
    }

    // Redirect ke halaman buku.php
    header("Location: buku.php");
    exit();
}

?>
