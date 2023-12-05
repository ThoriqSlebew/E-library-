<?php

include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Ambil id buku yang akan dihapus dari parameter URL
    $id_pengguna = $_GET["id"];

    // Query untuk menghapus data buku berdasarkan id
    $sql = "DELETE FROM pengguna WHERE id_pengguna = $id_pengguna";
    
    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        echo "pengguna berhasil dihapus";
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($koneksi);
    }

    // Redirect ke halaman buku.php
    header("Location: pengguna.php");
    exit();
}

?>