<?php

include '../koneksi.php';

// Cek apakah form dikirimkan dengan method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form
    $judul = $_POST["judul"];
    $kategori = $_POST["kategori"];
    $gambar = addslashes(file_get_contents($_FILES['gambar']['tmp_name']));
    $pengarang = $_POST["pengarang"];
    $penerbit = $_POST["penerbit"];
    $sinopsis = $_POST["sinopsis"];
    $jumlah_buku = $_POST["jumlah_buku"];

    // Lakukan validasi atau manipulasi data jika diperlukan

    // Lakukan proses penyimpanan data ke dalam database atau penyimpanan file gambar ke dalam direktori tertentu

    // Query untuk menyimpan data ke dalam tabel buku
    $sql = "INSERT INTO buku (judul, id_kategori, gambar, pengarang, penerbit, sinopsis, jumlah_buku) VALUES ('$judul', '$kategori', '$gambar', '$pengarang', '$penerbit', '$sinopsis', $jumlah_buku)";
    mysqli_query($koneksi, $sql);
    header('location: buku.php');
}
?>
