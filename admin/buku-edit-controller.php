<?php
include '../koneksi.php';

// Cek apakah form dikirimkan dengan method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form
    $id_buku = $_POST["id_buku"];
    $judul = $_POST["judul"];
    
    $kategori = $_POST["kategori"];
    $pengarang = $_POST["pengarang"];
    $penerbit = $_POST["penerbit"];
    $sinopsis = $_POST["sinopsis"];
    $jumlah_buku = $_POST["jumlah_buku"];
    if ($_FILES['gambar']['tmp_name']){
        
        $gambar = addslashes(file_get_contents($_FILES['gambar']['tmp_name']));
    }

    // Lakukan validasi atau manipulasi data jika diperlukan
    if ($gambar){
        mysqli_query($koneksi, "UPDATE buku SET judul='$judul', id_kategori='$kategori', gambar='$gambar', pengarang='$pengarang', penerbit='$penerbit', sinopsis='$sinopsis', jumlah_buku=$jumlah_buku WHERE id_buku=$id_buku"); 
    } else{
        mysqli_query($koneksi, "UPDATE buku SET judul='$judul', id_kategori='$kategori', pengarang='$pengarang', penerbit='$penerbit', sinopsis='$sinopsis', jumlah_buku=$jumlah_buku WHERE id_buku=$id_buku"); 
    }

    // Lakukan proses penyimpanan data ke dalam database atau penyimpanan file gambar ke dalam direktori tertentu

    // Query untuk update data buku
    
    header('location: buku.php');
}
?>
