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

    public function getAllProduk()
    {
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

    public function hapusProduk($id)
    {
        $stmt = $this->db->prepare("DELETE FROM produk WHERE idproduk = :idproduk");
        $stmt->bindParam(':idproduk', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function tambahProduk($data)
    {
        $stmt = $this->db->prepare("INSERT INTO produk (kode_produk, nama_produk, idkategori, stock, harga_modal, harga_jual, gambar, tgl_input) VALUES (:kode_produk, :nama_produk, :idkategori, :stock, :harga_modal, :harga_jual, :gambar, NOW())");
        $stmt->bindParam(':kode_produk', $data['kode_produk']);
        $stmt->bindParam(':nama_produk', $data['nama_produk']);
        $stmt->bindParam(':idkategori', $data['idkategori']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':harga_modal', $data['harga_modal']);
        $stmt->bindParam(':harga_jual', $data['harga_jual']);
        $stmt->bindParam(':gambar', $data['gambar']);
        return $stmt->execute();
    }

    public function updateProduk($data)
    {
        $stmt = $this->db->prepare("UPDATE produk SET nama_produk = :nama_produk, idkategori = :idkategori, stock = :stock, harga_modal = :harga_modal, harga_jual = :harga_jual, gambar = :gambar WHERE idproduk = :idproduk");
        $stmt->bindParam(':idproduk', $data['idproduk']);
        $stmt->bindParam(':nama_produk', $data['nama_produk']);
        $stmt->bindParam(':idkategori', $data['idkategori']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':harga_modal', $data['harga_modal']);
        $stmt->bindParam(':harga_jual', $data['harga_jual']);
        $stmt->bindParam(':gambar', $data['gambar']);
        return $stmt->execute();
    }

    public function uploadimg($url)
    {
        $namafile = $_FILES['gambar']['name'];
        $ukuran   = $_FILES['gambar']['size'];
        $error    = $_FILES['gambar']['error'];
        $tmp      = $_FILES['gambar']['tmp_name'];

        // Cek file yang diupload
        $validExtension = ['jpg', 'jpeg', 'png'];
        $fileExtension = explode('.', $namafile);
        $fileExtension = strtolower(end($fileExtension));

        if (!in_array($fileExtension, $validExtension)) {
            header("location:" . $url . '?msg=notimage');
            die;
        }

        // Cek ukuran gambar
        if ($ukuran > 1000000) {
            header("location:" . $url . '?msg=oversize');
            die;
        }

        // Tentukan nama file baru
        $namafilebaru = uniqid() . '.' . $fileExtension;

        // Upload gambar
        if (move_uploaded_file($tmp, "page/produk/img/" . $namafilebaru)) {
            return $namafilebaru;
        } else {
            header("location:" . $url . '?msg=uploadfailed');
            die;
        }
    }
}


function ribuan($angka)
{
    return number_format($angka, 0, ',', '.');
}