<?php
include 'koneksi.php';
session_start();
$username = $_SESSION['username'];
if (!isset($username)) {
  $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
  header('Location: login.php');
}
if (isset($_SESSION['pesan_sukses'])) {
  $pesan_sukses = $_SESSION['pesan_sukses'];
  // Menghapus pesan sukses dari session
  unset($_SESSION['pesan_sukses']);

}
$safe_username = mysqli_real_escape_string($koneksi, $username);
$result = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username='$safe_username'");
$pengguna = mysqli_fetch_assoc($result);

$data_buku = mysqli_query($koneksi, "SELECT * FROM buku");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Library</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

</head>

<body style="background-color: orange;">
<?php if (isset($pesan_sukses)) : ?>
        <div class="alert alert-success alert-dismissible fade show " role="alert">
            <?php echo $pesan_sukses; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

  <nav class="navbar navbar-expand-lg bg-body-tertiary " style="background-color: yellow;">
    <div class="container">
      <a class="navbar-brand" href="#">E-Library</a>
      <?php
      if ($_SESSION['username'] == 'Admin') : ?>
        <button class="btn btn-warning ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
          =
        </button>
      <?php endif ?>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" id="searchInput" placeholder="goleki" aria-label="Search">
          </form>
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
  <?php
  if ($_SESSION['username'] == 'Admin') :
  ?>
    <aside class="offcanvas offcanvas-start border-top" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel" style="margin-top: 64px; width: 15%">
      <div class="offcanvas-body">
        <a href="index.php" class="btn btn-secondary w-100 mb-2">Dashboard</a>
        <a href="admin/kategori.php" class="btn btn-outline-secondary w-100 mb-2">Daftar kategori</a>
        <a href="admin/buku.php" class="btn btn-outline-secondary w-100 mb-2">Daftar buku</a>
        <a href="admin/pengguna.php" class="btn btn-outline-secondary w-100 mb-2">Daftar Pengguna</a>
        <a href="admin/pinjaman.php" class="btn btn-outline-secondary w-100 mb-2">Daftar Pinjaman</a>
      </div>
    </aside>
  <?php endif ?>

  <!-- cards -->
  <div class="container">
    <h3 class="pt-5">Selamat Datang, <?= $pengguna['username'] ?></h3>
    <?php
    if ($_SESSION['username'] != 'Admin') :
    ?>
      <p class="pb-3">Pilih buku yang kamu inginkan</p>
    <?php endif ?>

    <?php
    if ($_SESSION['username'] == 'Admin') :
    ?>
      <p class="pb-3">Silahkan kelola Pustaka</p>
    <?php endif ?>

    <div class="d-flex flex-wrap ">
      <?php
      while ($buku = mysqli_fetch_assoc($data_buku)) :
        $gambarSrc = "data:image/*;base64," . base64_encode($buku['gambar']);
        $sinopsis = $buku["sinopsis"];
        $sinopsisWords = explode(" ", $sinopsis);
        $sinopsisLimited = implode(" ", array_slice($sinopsisWords, 0, 25));
      ?>
        <div class="card mb-3 ms-2" style="width: 19rem; ">
          <a href="detail-buku.php?id=<?= $buku["id_buku"] ?>" class="card text-decoration-none">
            <img src="<?= $gambarSrc ?>" class="card-img-top" style="width: 300px; height: 300px ; object-fit: contain;" alt="<?= $buku["judul"] ?>" />
            <div class="card-body">
              <h5 class="fw-bold"><?= $buku["judul"] ?></h5>
              <div style="font-size: small">
                <p class="card-text m-0" style="font-size: small">Pengarang: <?= $buku["pengarang"] ?></p>
                <p class="m-0">Sinopsis: <?= $sinopsisLimited ?><?= count($sinopsisWords) > 40 ? '...' : '' ?></p>
              </div>
            </div>
          </a>
        </div>
      <?php endwhile ?>
    </div>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Anda yakin Ingin Keluar?</h5>
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
    </div>

    


    <!-- footer -->
    <footer class="mt-5 bg-warning" style="height: 12rem">
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
    <script>
        function caribuku() {
            var input = document.getElementById("searchInput").value.toLowerCase();
            var cards = document.getElementsByClassName("card");

            for (var i = 0; i < cards.length; i++) {
                var card = cards[i];
                var namabuku = card.getElementsByClassName("fw-bold")[0].textContent.toLowerCase();

                if (namabuku.indexOf(input) > -1) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            }
        }

        document.getElementById("searchInput").addEventListener("input", caribuku);
    </script>
</body>


</html>