<?php
session_start();
include "koneksi.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $user = $_POST['username'];
    $psw = $_POST['password'];

    $sql = "SELECT * FROM pengguna WHERE username='$user' AND password='$psw'";
    $query = $koneksi->query($sql);

    if ($query->num_rows == 1) {
        $data = $query->fetch_array();
        $_SESSION['username'] = $data['username'];
            header("location: index.php");
        
    } else {
        die("Username atau password salah <a href=\"javascript:history.back()\">kembali</a>");
    }
}
?>
