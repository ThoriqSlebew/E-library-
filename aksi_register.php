<?php
include "koneksi.php";

$user = $_POST['username'];
$psw = $_POST['password'];
$email = $_POST['email'];

$sql = "INSERT INTO pengguna (username, password, email) VALUES ('$user', '$psw', '$email')";
$query = $koneksi->query($sql);

if ($query === true) {
    header('location: login.php');
} else {
    echo 'errrrroorrr';
}
?>
 