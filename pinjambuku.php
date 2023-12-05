<?php
include 'koneksi.php';
session_start();
$username = $_SESSION['username'];
if (!isset($username)) {
    $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
    header('Location: login.php');

    
}

$safe_username = mysqli_real_escape_string($koneksi, $username);
$result = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username='$safe_username'");
$pengguna = mysqli_fetch_assoc($result);

$id_buku = $_GET['id'];
$data_buku = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku=$id_buku");
$buku = mysqli_fetch_assoc($data_buku);

$judul = $buku['judul'];
$pengarang = $buku['pengarang'];
$gambarSrc = "data:image/*;base64," . base64_encode($buku['gambar']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>pinjam buku <?= $judul ?></title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/bootstrap-icons/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="style/style.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom sticky-top">
        <div class="container py-1">
            <a class="navbar-brand" href="index.php">E-Library</a>
            <?php
            if ($_SESSION['username'] == 'Admin') :
            ?>
                <button class="btn btn-warning ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
                    =
                </button>
            <?php endif ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $pengguna['username'] ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-3">
                            <li>
                                <p class="h6 m-3 text-center"><?= $pengguna['username'] ?></p>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            

                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container w-50">
        <form action="pinjambuku-controller.php" method="POST">
            <fieldset>
                <legend>Silahkan Isi Form Berikut untuk meminjam buku <strong><?= $buku['judul'] ?></strong></legend>
                <input type="hidden" class="form-control" name="id_buku" value="<?= $buku["id_buku"] ?>">
                <input type="hidden" class="form-control" name="id_pengguna" value="<?= $pengguna["id_pengguna"] ?>">

                <div class="mb-3">
                    <input type="date" class="form-control" name="tanggal" required>
                </div>
                <div class="mb-3">
                    <input type="number" class="form-control" name="jumlah" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="alamat" required>
                </div>
                <button type="submit" class="btn btn-warning">Pinjam</button>
            </fieldset>
        </form>
    </main>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah anda Yakin ingin keluar?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Pilih "Logout" jika kamu ingin mengakhiri sesimu.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    <a class="btn btn-dark" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5 bg-warning fixed-bottom">
    <div class="d-flex justify-content-around pt-5">
        <div class="col-4">
            <h1>E-Library</h1>
            <p>
                 perpustakaan digital yang menyediakan akses mudah ke berbagai koleksi buku, jurnal, dan sumber daya lainnya secara online. Nikmati kebebasan membaca dan belajar di mana saja, kapan saja.
            </p>
        </div>
        <div class="col-4">
            <h3>Discover More!</h3>
            <p>
                Temukan berbagai koleksi yang menarik dan bermanfaat di E-Library Mantab. Tersedia buku-buku terbaru, jurnal ilmiah, majalah populer, dan banyak lagi. Tingkatkan pengetahuan Anda dengan menjelajahi dunia pengetahuan yang tak terbatas.
            </p>
    </div>
</footer>


    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
