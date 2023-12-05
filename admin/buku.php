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
$data_buku = mysqli_query($koneksi, "SELECT * FROM buku, kategori_buku where buku.id_kategori = kategori_buku.id_kategori ");

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

<body >
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
        <h3 class="pt-5">Daftar Buku</h3>
        <p class="pb-3">Kelola Data.</p>
        <button type="button" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Data</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">judul</th>
                    <th scope="col">Kategori</th>
                    <!-- <th scope="col">gambar</th> -->
                    <th scope="col">pengarang</th>
                    <th scope="col">penerbit</th>
                    <th scope="col">Sinopsis</th>
                    <th scope="col">jumlah_buku</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($buku = mysqli_fetch_assoc($data_buku)) :
                    $gambarSrc = "data:image/*;base64," . base64_encode($buku['gambar']);
                ?>
                    
                        <tr>
                            <td scope="col"><?= $no++ ?></td>
                            <td scope="col"><?= $buku["judul"] ?></td>
                            <td scope="col"><?= $buku["nama_kategori"] ?></td>
                            <!-- <td scope="col"><img src="<?= $gambarSrc ?>" alt="cover" style="width: 100px;"></td> -->
                            <td scope="col"><?= $buku["pengarang"] ?></td>
                            <td scope="col"><?= $buku["penerbit"] ?></td>
                            <td scope="col"><?= $buku["sinopsis"] ?></td>
                            <td scope="col"><?= $buku["jumlah_buku"] ?></td>
                        
                        <td scope="col">
                            <div class="d-flex justify-content-around gap-2">
                                <a href="#" class="btn btn-warning btn-circle btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $buku["id_buku"] ?>">
                                    Edit
                                </a>
                                <div class="modal fade" id="editModal<?= $buku["id_buku"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit data</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="user d-flex flex-column gap-2"  action="buku-edit-controller.php" method="post">
                                                    <input type="hidden" class="form-control" name="id_buku" value="<?= $buku["id_buku"] ?>">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="judul" name="judul" value="<?= $buku["judul"] ?>" required>
                                                    </div>

                                                    <select class="form-select" name="kategori" aria-label="Default select example">
                                                        <?php
                                                        $data_kategori = mysqli_query($koneksi, "SELECT * FROM kategori_buku");
                                                        while ($kategori = mysqli_fetch_assoc($data_kategori)) :
                                                        ?>
                                                            <option value="<?= $kategori["id_kategori"] ?>"><?= $kategori["nama_kategori"] ?></option>
                                                        <?php endwhile ?>
                                                    </select>

                                                    <!-- <div class="form-group">
                                                        <input type="file" class="form-control" name="gambar" accept="image/*">
                                                    </div> -->
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="pengarang" name="pengarang" value="<?= $buku["pengarang"] ?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="penerbit" name="penerbit" value="<?= $buku["penerbit"] ?>" required>
                                                    </div>
                                                    <label for="sinopsis">sinopsis</label>
                                                    <textarea class="form-control" id="sinopsis" rows="5" name="sinopsis" required><?= $buku["sinopsis"] ?></textarea>
                                                    <div class="form-group">
                                                        <input type="number" class="form-control" placeholder="jumalah_buku" name="jumlah_buku" value="<?= $buku["jumlah_buku"] ?>" required>
                                                    </div>
                                                    <button type="submit" name="edit" class="btn btn-warning p-2 mt-3 fw-semibold">
                                                        Edit
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-danger btn-circle btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $buku["id_buku"] ?>">
                                    Hapus
                                </a>
                                <div class="modal fade" id="hapusModal<?= $buku["id_buku"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Yakin mau dihapus?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">Pilih "Hapus" jika kamu yakin untuk menghapus buku "<?= $buku["judul"] ?>".</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                                <a class="btn btn-dark" href="buku-hapus-controller.php?id=<?= $buku["id_buku"] ?>">Hapus</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Daftar buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="user d-flex flex-column gap-2" enctype="multipart/form-data" action="buku-tambah-controller.php" method="post">
                        <input type="hidden" class="form-control" name="id_buku" value="<?= $buku["id_buku"] ?>">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="judul" name="judul" required>
                        </div>

                        <select class="form-select" name="kategori" aria-label="Default select example">
                            <?php
                            $data_kategori = mysqli_query($koneksi, "SELECT * FROM kategori_buku");
                            while ($kategori = mysqli_fetch_assoc($data_kategori)) :
                            ?>
                                <option value="<?= $kategori["id_kategori"] ?>"><?= $kategori["nama_kategori"] ?></option>
                            <?php endwhile ?>
                        </select>

                        <!-- <div class="form-group">
                            <input type="file" class="form-control" name="gambar" accept="image/*">
                        </div> -->
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="pengarang" name="pengarang" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="penerbit" name="penerbit" required>
                        </div>
                        <textarea id="sinopsis" rows="5" placeholder="sinopsis" name="sinopsis" required> </textarea>


                        <div class="form-group">
                            <input type="number" class="form-control" placeholder="jumlah_buku" name="jumlah_buku" required>
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
                adalah perpustakaan digital yang menyediakan akses mudah ke berbagai koleksi buku, jurnal, dan sumber daya lainnya secara online. Nikmati kebebasan membaca dan belajar di mana saja, kapan saja.
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

</body>

</html>