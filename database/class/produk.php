<?php
class Produk
{
    private $db;
    private static $instance = null;

    public function __construct($db_conn)
    {
        $this->db = $db_conn;
    }

    public static function getInstance($pdo)
    {
        if (self::$instance == null) {
            self::$instance = new Produk($pdo);
        }
        return self::$instance;
    }

    public function getAllProduk() {
        $stmt = $this->db->prepare("SELECT p.*, k.nama_kategori FROM produk p JOIN kategori k ON p.idkategori = k.idkategori");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getKategori()
    {
        $stmt = $this->db->prepare("SELECT * FROM kategori");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function generateKodeProduk()
    {
        $stmt = $this->db->prepare("SELECT MAX(kode_produk) as kodeTerbesar FROM produk");
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $kodeBarang = $data['kodeTerbesar'];
        $urutan = (int) substr($kodeBarang, 3, 3);
        $urutan++;
        $huruf = "BRG";
        return $huruf . sprintf("%03s", $urutan);
    }

    public function hapusProduk($id) {
        $stmt = $this->db->prepare("DELETE FROM produk WHERE idproduk = :idproduk");
        $stmt->bindParam(':idproduk', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function tambahProduk($data)
    {
        $stmt = $this->db->prepare("INSERT INTO produk (kode_produk, nama_produk, idkategori, stock, harga_modal, harga_jual, tgl_input) VALUES (:kode_produk, :nama_produk, :idkategori, :stock, :harga_modal, :harga_jual, NOW())");
        $stmt->bindParam(':kode_produk', $data['kode_produk']);
        $stmt->bindParam(':nama_produk', $data['nama_produk']);
        $stmt->bindParam(':idkategori', $data['idkategori']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':harga_modal', $data['harga_modal']);
        $stmt->bindParam(':harga_jual', $data['harga_jual']);
        return $stmt->execute();
    }

    public function updateProduk($data)
    {
        $stmt = $this->db->prepare("UPDATE produk SET nama_produk = :nama_produk, idkategori = :idkategori, stock = :stock, harga_modal = :harga_modal, harga_jual = :harga_jual WHERE idproduk = :idproduk");
        $stmt->bindParam(':idproduk', $data['idproduk']);
        $stmt->bindParam(':nama_produk', $data['nama_produk']);
        $stmt->bindParam(':idkategori', $data['idkategori']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':harga_modal', $data['harga_modal']);
        $stmt->bindParam(':harga_jual', $data['harga_jual']);
        return $stmt->execute();
    }
}

function ribuan($angka)
{
    return number_format($angka, 0, ',', '.');
}