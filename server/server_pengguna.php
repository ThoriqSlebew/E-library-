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
    $id_pengguna = $data->id_pengguna; // Ubah 'id barang' menjadi 'id_pengguna'
    $username = $data->username; // Ubah 'id barang' menjadi 'id_pengguna'// $nama_kategori = $data->nama_kategori;
    $password = $data->password;
    $email = $data->email;
    $no_telp = $data->no_telp;
    $aksi=$data->aksi;

    if ($aksi == 'tambah') {
        $data2 = array(
            'id_pengguna' => $id_pengguna,
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'no_telp' => $no_telp,
        );

        $abc->tambah_pengguna($data2);
    } elseif ($aksi == 'ubah') {
        $data2 = array(
            'id_pengguna' => $id_pengguna,
            'username' => $username,// 'nama_kategori' => $nama_kategori,
            'password' => $password,
            'email' => $email,
            'no_telp' => $no_telp,
        );
        $abc->ubah_pengguna($data2);
    } elseif ($aksi == 'hapus') { // Ubah '=' menjadi '==' untuk memeriksa kesamaan
        $abc->hapus_pengguna($id_pengguna);
    }

    // hapus variabel dari memori
    unset($input, $data, $data2, $id_pengguna, $username, $password, $alamat,$no_telp, $aksi, $abc);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') 
    {
    if (($_GET['aksi'] == 'tampil') and (isset($_GET['id_pengguna'])) )
    {   $id_pengguna = filter($_GET['id_pengguna']); // Ubah 'id barang' menjadi 'id_pengguna'
        $data = $abc->tampil_pengguna($id_pengguna); // Ubah 'tampil data' menjadi 'tampil_data'
        echo json_encode($data);
    } else 
        { //menampilkan semua data
        $data = $abc->tampil_semua_pengguna();
        echo json_encode($data);
        }
        unset($postdata, $data, $id_pengguna, $abc);
    }

?>