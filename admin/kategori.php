<?php
include '../koneksi.php';
session_start();
$username = $_SESSION['username'];
if (!isset($username)) {
    $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
    header('Location: login.php');
}
$safe_username = mysqli_real_escape_string($koneksi, $username);
$result = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username='$safe_username'");
$pengguna = mysqli_fetch_assoc($result);

$no = 1;
$data_kategori = mysqli_query($koneksi, "SELECT * FROM kategori_buku");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - E-Library</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom sticky-top">
        <div class="container py-1">
            <a class="navbar-brand" href="../index.php">E-library</a>
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

                            <?php
                            if ($_SESSION['username'] != 'Admin') :
                            ?>
                                <li>
                                    <a class="dropdown-item" href="riwayat.php">Riwayat</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                            <?php endif ?>

                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <aside class="offcanvas offcanvas-start border-top" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel" style="margin-top: 64px; width: 15%">
        <div class="offcanvas-body">
            <a href="../index.php" class="btn btn-secondary w-100 mb-2">Dashboard</a>
            <a href="kategori.php" class="btn btn-outline-secondary w-100 mb-2">Daftar kategori</a>
            <a href="buku.php" class="btn btn-outline-secondary w-100 mb-2">Daftar buku</a>
            <a href="pengguna.php" class="btn btn-outline-secondary w-100 mb-2">Daftar Pengguna</a>
            <a href="pinjaman.php" class="btn btn-outline-secondary w-100 mb-2">Daftar Pinjaman</a>
        </div>
    </aside>

    <main class="container">
        <h3 class="pt-5">Daftar Kategori</h3>
        <p class="pb-3">Kelola Kategori</p>
        <button type="button" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Kategori</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Klasifikasi</th>

                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($kategori = mysqli_fetch_assoc($data_kategori)) :
                ?>
                    
                        <tr>
                            <td scope="col"><?= $no++ ?></td>
                            <td scope="col"><?= $kategori["nama_kategori"] ?></td>
                            <td scope="col"><?= $kategori["klasifikasi"] ?></td>

                        
                        <td scope="col">
                            <div class="d-flex justify-content-around gap-2">
                                <a href="#" class="btn btn-warning btn-circle btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $kategori["id_kategori"] ?>">
                                    Edit
                                </a>
                                <div class="modal fade" id="editModal<?= $kategori["id_kategori"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit data</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="user d-flex flex-column gap-2" enctype="multipart/form-data" action="kategori-edit-controller.php" method="post">
                                                    <input type="hidden" class="form-control" name="id_kategori" value="<?= $kategori["id_kategori"] ?>">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="nama kategori" name="nama_kategori" value="<?= $kategori["nama_kategori"] ?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="klasifikasi" value="<?= $kategori["klasifikasi"] ?>" required>
                                                    </div>
                                                    <button type="submit" name="edit" class="btn btn-warning p-2 mt-3 fw-semibold">
                                                        Edit
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-danger btn-circle btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $kategori["id_kategori"] ?>">
                                    Hapus
                                </a>
                                <div class="modal fade" id="hapusModal<?= $kategori["id_kategori"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Yakin mau dihapus?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">Pilih "Hapus" jika kamu yakin untuk menghapus kategori "<?= $kategori["nama_kategori"] ?>".</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                                <a class="btn btn-dark" href="kategori-hapus-controller.php?id=<?= $kategori["id_kategori"] ?>">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        </tr>
                    <?php endwhile ?>
            </tbody>
        </table>
    </main>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Beneran mau keluar?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Pilih "Logout" jika kamu ingin mengakhiri sesimu.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    <a class="btn btn-dark" href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Daftar Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="user d-flex flex-column gap-2" enctype="multipart/form-data" action="kategori-tambah-controller.php" method="post">
                        <input type="hidden" class="form-control" name="id_kategori" value="<?= $kategori["id_kategori"] ?>">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="kategori" name="nama_kategori" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="klasifikasi" name="klasifikasi" required>
                        </div>
                        <button type="submit" name="tambah" class="btn btn-warning p-2 mt-3 fw-semibold">
                            tambah
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer class="mt-5 bg-warning ">
    <div class="d-flex justify-content-around pt-5">
        <div class="col-4">
            <h1>E-Library</h1>
            <p>
                E-Library Mantab adalah perpustakaan digital yang menyediakan akses mudah ke berbagai koleksi buku, jurnal, dan sumber daya lainnya secara online. Nikmati kebebasan membaca dan belajar di mana saja, kapan saja.
            </p>
        </div>
        <div class="col-4">
            <h3>Discover More!</h3>
            <p>
                Temukan berbagai koleksi yang menarik dan bermanfaat di E-Library Mantab. Tersedia buku-buku terbaru, jurnal ilmiah, majalah populer, dan banyak lagi. Tingkatkan pengetahuan Anda dengan menjelajahi dunia pengetahuan yang tak terbatas.
            </p>
    </div>
</footer>



    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    

    </script>



        
    </body>
   </html>