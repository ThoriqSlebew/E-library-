<?php
error_reporting(1); // error ditampilkan
class Database
{
    private $host = "localhost";
    private $dbname = "pemweb";
    private $user = "root";
    private $password = "";
    private $port = "3309";
    private $conn;

    // function yang pertama kali di-load saat class dipanggil
    public function __construct()
    {
        // koneksi database 
        try {
            $this->conn = new PDO("mysql:host=$this->host;port=$this->port; dbname=$this->dbname; charset=utf8", $this->user, $this->password);

        } catch (PDOException $e) {
            echo "Koneksi gagal";
        }
    }

    // ==================================== TAMPIL DATA ====================================

    public function tampil_buku($id_buku)
    {
        $query = $this->conn->prepare("select id_buku, judul, pengarang, penerbit, sinopsis, jumlah_buku from buku where id_buku=?");
        $query->execute(array($id_buku));
        // mengambil satu data dengan fetch
        $data = $query->fetch(PDO::FETCH_ASSOC); // mengembalikan data
        return $data;
        // hapus variable dari memory
        $query->closeCursor();
        unset($id_buku, $data);
    }
    public function tampil_kategori($id_kategori)
    {
        $query = $this->conn->prepare("select id_kategori, nama_kategori, klasifikasi from kategori_buku where id_kategori=?");
        $query->execute(array($id_kategori));
        // mengambil satu data dengan fetch
        $data = $query->fetch(PDO::FETCH_ASSOC); // mengembalikan data
        return $data;
        // hapus variable dari memory
        $query->closeCursor();
        unset($id_kategori, $data);
    }
    public function tampil_pinjam($id_pinjam)
    {
        $query = $this->conn->prepare("select id_pinjam, tanggal, jumlah, penerbit, alamat from peminjaman where id_pinjam=?");
        $query->execute(array($id_pinjam));
        // mengambil satu data dengan fetch
        $data = $query->fetch(PDO::FETCH_ASSOC); // mengembalikan data
        return $data;
        // hapus variable dari memory
        $query->closeCursor();
        unset($id_pinjam, $data);
    }
    public function tampil_pengguna($id_pengguna)
    {
        $query = $this->conn->prepare("select id_pengguna, username, password, email, no_telp from pengguna where id_pengguna=?");
        $query->execute(array($id_pengguna));
        // mengambil satu data dengan fetch
        $data = $query->fetch(PDO::FETCH_ASSOC); // mengembalikan data
        return $data;
        // hapus variable dari memory
        $query->closeCursor();
        unset($id_buku, $data);
    }

    // ==================================== TAMPIL SEMUA DATA ====================================

    public function tampil_semua_buku()
    {
        $query = $this->conn->prepare("select id_buku, judul, pengarang, penerbit,sinopsis, jumlah_buku  from buku order by id_buku");
        $query->execute();
        // mengambil banyak data dengan fetchAll
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
        $query->closeCursor();
        unset($data);
    }
    public function tampil_semua_kategori()
    {
        $query = $this->conn->prepare("select id_kategori, nama_kategori, klasifikasi  from kategori_buku order by id_kategori");
        $query->execute();
        // mengambil banyak data dengan fetchAll
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
        $query->closeCursor();
        unset($data);
    }
    public function tampil_semua_pinjam()
    {
        $query = $this->conn->prepare("select id_pinjam, tanggal, jumlah, alamat from peminjaman order by id_pinjam");
        $query->execute();
        // mengambil banyak data dengan fetchAll
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
        $query->closeCursor();
        unset($data);
    }
    public function tampil_semua_pengguna()
    {
        $query = $this->conn->prepare("select id_pengguna, username, password, email,no_telp  from pengguna order by id_pengguna");
        $query->execute();
        // mengambil banyak data dengan fetchAll
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
        $query->closeCursor();
        unset($data);
    }

    // ==================================== TAMBAH DATA ====================================

    public function tambah_buku($data)
    {
        $query = $this->conn->prepare("insert ignore into buku (id_buku, judul, pengarang, penerbit, sinopsis, jumlah_buku ) values (?,?,?,?,?,?,)");
        $query->execute(array($data['id_buku'], $data['judul'], $data['pengarang'], $data['penerbit'],$data['sinopsis'],$data['jumlah_buku']));
        $query->closeCursor();
        unset($data);
    }
    public function tambah_kategori($data)
    {
        $query = $this->conn->prepare("insert ignore into kategori_buku (id_kategori, nama_kategori, klasifikasi) values (?,?,?,)");
        $query->execute(array($data['id_kategori'], $data['nama_kategori'], $data['klasifikasi']));
        $query->closeCursor();
        unset($data);
    }
    public function tambah_peminjaman($data)
    {
        $query = $this->conn->prepare("insert ignore into peminjaman (id_pinjam, tanggal, jumlah, alamat) values (?,?,?,?,)");
        $query->execute(array($data['id_pinjam'], $data['tanggal'], $data['jumlah'], $data['alamat']));
        $query->closeCursor();
        unset($data);
    }
    public function tambah_pengguna($data)
    {
        $query = $this->conn->prepare("insert ignore into pengguna (id_pengguna, username, password, email, no_telp ) values (?,?,?,?,?,)");
        $query->execute(array($data['id_pengguna'], $data['username'], $data['password'], $data['email'],$data['no_telp']));
        $query->closeCursor();
        unset($data);
    }
// ==================================== UBAH DATA ====================================
    public function ubah_buku($data)
{
    try {
        $query = $this->conn->prepare("UPDATE buku SET judul=?,  pengarang=?, penerbit=?, sinopsis=?, jumlah_buku? WHERE id_buku=?");
        $query->execute(array($data['judul'], $data['pengarang'], $data['penerbit'],$data['sinopsis'],$data['jumlah_buku'],  $data['id_buku']));
        $query->closeCursor();
        unset($data);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        // Handle any database-related errors here.
        // You can log the error, display a user-friendly message, or take appropriate action.
    }
}

public function ubah_kategori($data)
{
    try {
        $query = $this->conn->prepare("UPDATE kategori_buku SET nama_kategori=?,  klasifikasi=? WHERE id_kategori=?");
        $query->execute(array($data['nama_kategori'], $data['klasifikasi'],  $data['id_buku']));
        $query->closeCursor();
        unset($data);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        // Handle any database-related errors here.
        // You can log the error, display a user-friendly message, or take appropriate action.
    }
}
public function ubah_peminjaman($data)
{
    try {
        $query = $this->conn->prepare("UPDATE peminjaman SET tanggal=?,  jumlah=?, alamat=? WHERE id_pinjam=?");
        $query->execute(array($data['tanggal'], $data['jumlah'], $data['alamat'],  $data['id_pinjam']));
        $query->closeCursor();
        unset($data);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        // Handle any database-related errors here.
        // You can log the error, display a user-friendly message, or take appropriate action.
    }
}
public function ubah_pengguna($data)
{
    try {
        $query = $this->conn->prepare("UPDATE pengguna SET username=?,  password=?, email=?, no_telp=? WHERE id_pengguna=?");
        $query->execute(array($data['username'], $data['password'], $data['email'],$data['no_telp'],  $data['id_pengguna']));
        $query->closeCursor();
        unset($data);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        // Handle any database-related errors here.
        // You can log the error, display a user-friendly message, or take appropriate action.
    }
}

// ==================================== HAPUS DATA ====================================

    public function hapus_buku($id_buku)
    {
        $query = $this->conn->prepare("delete from buku where id_buku=?");
        $query->execute(array($id_buku));
        $query->closeCursor();
        unset($id_buku);
    }
    public function hapus_kategori($id_kategori)
    {
        $query = $this->conn->prepare("delete from kategori_buku where id_kategori=?");
        $query->execute(array($id_kategori));
        $query->closeCursor();
        unset($id_kategori);
    }
    public function hapus_peminjaman($id_pinjam)
    {
        $query = $this->conn->prepare("delete from buku where id_pinjam=?");
        $query->execute(array($id_pinjam));
        $query->closeCursor();
        unset($id_pinjam);
    }
    public function hapus_pengguna($id_pengguna)
    {
        $query = $this->conn->prepare("delete from buku where id_pengguna=?");
        $query->execute(array($id_pengguna));
        $query->closeCursor();
        unset($id_pengguna);
    }
}
