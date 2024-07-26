<?php
class Kategori
{
    private $db;
    private static $instance = null;

    // Konstruktor kelas untuk menginisialisasi koneksi database
    private function __construct($db_conn)
    {
        $this->db = $db_conn;
    }

    // Mengambil instance dari kelas Kategori (Singleton Pattern)
    public static function getInstance($pdo)
    {
        if (self::$instance === null) {
            self::$instance = new self($pdo);
        }
        return self::$instance;
    }

    // Menambahkan kategori baru
    public function tambahKategori($namaKategori)
    {
        $sql = "INSERT INTO kategori (nama_kategori) VALUES (:nama_kategori)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nama_kategori', htmlspecialchars($namaKategori), PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount(); // Mengembalikan jumlah baris yang terpengaruh
    }

    // Mengupdate kategori yang sudah ada
    public function updateKategori($idKategori, $namaKategori)
    {
        $sql = "UPDATE kategori SET nama_kategori = :nama_kategori WHERE idkategori = :idkategori";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nama_kategori', htmlspecialchars($namaKategori), PDO::PARAM_STR);
        $stmt->bindValue(':idkategori', (int)$idKategori, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount(); // Mengembalikan jumlah baris yang terpengaruh
    }

    // Menghapus kategori berdasarkan ID
    public function hapusKategori($idKategori)
    {
        $sql = "DELETE FROM kategori WHERE idkategori = :idkategori";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idkategori', (int)$idKategori, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount(); // Mengembalikan jumlah baris yang terpengaruh
    }

    // Membaca semua kategori
    public function bacaKategori()
    {
        $sql = "SELECT * FROM kategori ORDER BY idkategori ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan hasil dalam bentuk array asosiatif
    }

    // Membaca kategori berdasarkan ID
    public function bacaKategoriById($idKategori)
    {
        $sql = "SELECT * FROM kategori WHERE idkategori = :idkategori";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idkategori', (int)$idKategori, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Mengembalikan hasil dalam bentuk array asosiatif
    }

    // Menghitung jumlah produk dalam kategori tertentu
    public function countProdukByKategori($idKategori)
    {
        $sql = "SELECT COUNT(idproduk) AS count FROM produk WHERE idkategori = :idkategori";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idkategori', (int)$idKategori, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['count']; // Mengembalikan jumlah produk
    }
}

function ribuan($angka)
{
    return number_format($angka, 0, ',', '.'); // Format angka dengan pemisah ribuan
}
