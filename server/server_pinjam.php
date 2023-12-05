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
    $id_pinjam = $data->id_pinjam; // Ubah 'id barang' menjadi 'id_pinjam'
    $tanggal = $data->tanggal; // Ubah 'id barang' menjadi 'id_pinjam'
    // $nama_kategori = $data->nama_kategori;
    $jumlah = $data->jumlah;
    $alamat = $data->alamat;
    $aksi=$data->aksi;

    if ($aksi == 'tambah') {
        $data2 = array(
            'id_pinjam' => $id_pinjam,
            'tanggal' => $tanggal,
            'jumlah' => $jumlah,
            'alamat' => $alamat,
        );

        $abc->tambah_peminjaman($data2);
    } elseif ($aksi == 'ubah') {
        $data2 = array(
            'id_pinjam' => $id_pinjam,
            'tanggal' => $tanggal,// 'nama_kategori' => $nama_kategori,
            'jumlah' => $jumlah,
            'alamat' => $alamat,
        );
        $abc->ubah_peminjaman($data2);
    } elseif ($aksi == 'hapus') { // Ubah '=' menjadi '==' untuk memeriksa kesamaan
        $abc->hapus_peminjaman($id_pinjam);
    }

    // hapus variabel dari memori
    unset($input, $data, $data2, $id_pinjam, $tanggal, $jumlah, $alamat, $aksi, $abc);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') 
    {
    if (($_GET['aksi'] == 'tampil') and (isset($_GET['id_pinjam'])) )
    {   $id_pinjam = filter($_GET['id_pinjam']); // Ubah 'id barang' menjadi 'id_pinjam'
        $data = $abc->tampil_pinjam($id_pinjam); // Ubah 'tampil data' menjadi 'tampil_data'
        echo json_encode($data);
    } else 
        { //menampilkan semua data
        $data = $abc->tampil_semua_pinjam();
        echo json_encode($data);
        }
        unset($postdata, $data, $id_pinjam, $abc);
    }

?>