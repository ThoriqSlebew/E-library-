<?php

include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Ambil id buku yang akan dihapus dari parameter URL
    $id_pinjam= $_GET["id"];

    // Query untuk menghapus data buku berdasarkan id
    $sql = "DELETE FROM peminjaman WHERE id_pinjam = $id_pinjam";
    
    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        echo "pengguna berhasil dihapus";
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($koneksi);
    }

    // Redirect ke halaman buku.php
    header("Location: pinjaman.php");
    exit();
}

?>