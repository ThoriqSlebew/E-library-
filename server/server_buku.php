<?php
error_reporting(1); // error ditampilkan 


include "Database.php";
// buat objek baru dari class Database
$abc = new Database();

// function untuk menghapus selain huruf dan angka 
if(isset($_SERVER ['HTTP_ORIGIN'])){
    header("Access-Control-Allow-Origin:{$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials:true');
    header('Access-Control-Max-Age:86400');
}
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header('Access-Control-Allow-Method:OPTIONS GET, POST, OPTIONS');
    if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS)']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    exit(0);
}

$postdata = file_get_contents("php://input");

function filter($data)
{
    $data = preg_replace('/[^a-zA-Z0-9]/', ' ', $data);
    return $data;
    unset($data);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode($postdata);
    $id_buku = $data->id_buku; // Ubah 'id barang' menjadi 'id_buku'
    $judul = $data->judul; // Ubah 'id barang' menjadi 'id_buku'
    // $nama_kategori = $data->nama_kategori;
    $pengarang = $data->pengarang;
    $penerbit = $data->penerbit;
    $sinopsis = $data->sinopsis;
    $jumlah_buku = $data->jumlah_buku;
    $aksi=$data->aksi;

    if ($aksi == 'tambah') {
        $data2 = array(
            'id_buku' => $id_buku,
            'judul' => $judul,
            // 'nama_kategori' => $nama_kategori,
            'pengarang' => $pengarang,
            'penerbit' => $penerbit,
            'sinopsis' => $sinopsis,
            'jumlah_buku' => $jumlah_buku,
        );

        $abc->tambah_buku($data2);
    } elseif ($aksi == 'ubah') {
        $data2 = array(
            'id_buku' => $id_buku,
            'judul' => $judul,
            // 'nama_kategori' => $nama_kategori,
            'pengarang' => $pengarang,
            'penerbit' => $penerbit,
            'sinopsis' => $sinopsis,
            'jumlah_buku' => $jumlah_buku,
        );
        $abc->ubah_buku($data2);
    } elseif ($aksi == 'hapus') { // Ubah '=' menjadi '==' untuk memeriksa kesamaan
        $abc->hapus_buku($id_buku);
    }

    // hapus variabel dari memori
    unset($input, $data, $data2, $id_buku, $judul, $pengarang, $penerbit, $sinopsis, $jumlah_buku, $aksi, $abc);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') 
    {
    if (($_GET['aksi'] == 'tampil') and (isset($_GET['id_buku'])) )
    {   $id_buku = filter($_GET['id_buku']); // Ubah 'id barang' menjadi 'id_buku'
        $data = $abc->tampil_buku($id_buku); // Ubah 'tampil data' menjadi 'tampil_data'
        echo json_encode($data);
    } else 
        { //menampilkan semua data
        $data = $abc->tampil_semua_buku();
        echo json_encode($data);
        }
        unset($postdata, $data, $id_buku, $abc);
    }

?>