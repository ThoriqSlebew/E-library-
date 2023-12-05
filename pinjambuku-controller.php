<?php
include 'koneksi.php';
session_start();




// Memastikan bahwa form telah disubmit

// Mengambil data dari form
$id_buku = $_POST['id_buku'];
$id_pengguna = $_POST['id_pengguna'];
$tanggal = $_POST['tanggal'];
$jumlah = $_POST['jumlah'];
$alamat = $_POST['alamat'];

// Memasukkan data pinjaman ke tabel pinjaman
$query = "INSERT INTO peminjaman (id_buku, id_pengguna, tanggal, jumlah, alamat) VALUES ('$id_buku', '$id_pengguna', '$tanggal', '$jumlah', '$alamat')";
$result = mysqli_query($koneksi, $query);

if ($result) {
    // Set pesan sukses ke session
    $_SESSION['pesan_sukses'] = "Buku anda akan segera dikirimkan ke alamat $alamat ";

    // Redirect ke halaman utama (index.php) setelah data berhasil ditambahkan
    header('Location: index.php');
    exit();
} else {
    // Jika terjadi kesalahan saat memasukkan data, tampilkan pesan error atau redirect ke halaman error
    echo "Terjadi kesalahan. Silakan coba lagi.";
}
