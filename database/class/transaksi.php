<?php

class Transaksi
{
    private static $instance = null;
    private $pdo;

    private function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public static function getInstance($pdo)
    {
        if (self::$instance === null) {
            self::$instance = new self($pdo);
        }
        return self::$instance;
    }

    public function generateKodeNota()
    {
        // Query untuk mendapatkan nomor nota terbesar
        $query = "SELECT MAX(no_nota) as kodeTerbesar11 FROM laporan";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $datanya = $stmt->fetch(PDO::FETCH_ASSOC);
        $kodenota = $datanya['kodeTerbesar11'];

        // Ambil urutan dari nomor nota
        $urutan = (int) substr($kodenota, 9, 3);
        $urutan++;

        // Format tanggal
        $tgl = date("jnyGi");

        // Inisial huruf untuk nomor nota
        $huruf = "AD";

        // Hasil akhir nomor nota
        $kodeCart = $huruf . $tgl . sprintf("%03s", $urutan);

        return $kodeCart;
    }

    public function insertCart($idproduk, $nonota, $jumlah, $total, $bayar)
    {
        try {
            // SQL untuk menyimpan data ke tabel keranjang
            $sql = "INSERT INTO keranjang (id_produk, no_nota, jumlah, total, bayar) VALUES (:idproduk, :nonota, :jumlah, :total, :bayar)";
            $stmt = $this->pdo->prepare($sql);

            // Bind parameter
            $stmt->bindParam(':idproduk', $idproduk, PDO::PARAM_INT);
            $stmt->bindParam(':nonota', $nonota, PDO::PARAM_STR);
            $stmt->bindParam(':jumlah', $jumlah, PDO::PARAM_INT);
            $stmt->bindParam(':total', $total, PDO::PARAM_STR);
            $stmt->bindParam(':bayar', $bayar, PDO::PARAM_STR);

            // Eksekusi query
            return $stmt->execute();
        } catch (PDOException $e) {
            // Tangani error
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }


    public function getPelangganOptions()
    {
        try {
            $stmt = $this->pdo->query("SELECT nama_pelanggan FROM pelanggan");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Menangani kesalahan database
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getProdukKeranjang()
    {
        $sql = "SELECT * FROM keranjang c JOIN produk p ON p.idproduk = c.idproduk ORDER BY c.idcart ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function saveTransaction($nonota, $idpell, $totalbeli, $pembayaran, $kembalian, $catatan)
    {
        try {
            // Memulai transaksi
            $this->pdo->beginTransaction();

            // Memperbarui keranjang dengan nomor nota
            $stmt = $this->pdo->prepare("UPDATE keranjang SET no_nota = :no_nota");
            $stmt->bindParam(':no_nota', $nonota, PDO::PARAM_STR);
            $stmt->execute();

            // Menyimpan detail nota
            $stmt = $this->pdo->prepare("INSERT INTO nota (no_nota, idproduk, quantity) SELECT :no_nota, idproduk, quantity FROM keranjang");
            $stmt->bindParam(':no_nota', $nonota, PDO::PARAM_STR);
            $stmt->execute();

            // Menyimpan laporan transaksi
            $stmt = $this->pdo->prepare("INSERT INTO laporan (no_nota, id_pelanggan, catatan, totalbeli, pembayaran, kembalian) VALUES (:no_nota, :id_pelanggan, :catatan, :totalbeli, :pembayaran, :kembalian)");
            $stmt->bindParam(':no_nota', $nonota, PDO::PARAM_STR);
            $stmt->bindParam(':id_pelanggan', $idpell, PDO::PARAM_INT);
            $stmt->bindParam(':catatan', $catatan, PDO::PARAM_STR);
            $stmt->bindParam(':totalbeli', $totalbeli, PDO::PARAM_INT);
            $stmt->bindParam(':pembayaran', $pembayaran, PDO::PARAM_INT);
            $stmt->bindParam(':kembalian', $kembalian, PDO::PARAM_INT);
            $stmt->execute();

            // Menghapus data dari keranjang
            $stmt = $this->pdo->prepare("DELETE FROM keranjang");
            $stmt->execute();

            // Commit transaksi
            $this->pdo->commit();

            // Redirect setelah menyimpan
            echo '<script>window.location="index.php?page=laporan&act=detail&alert=success1&invoice=' . $nonota . '"</script>';
        } catch (PDOException $e) {
            // Rollback jika terjadi kesalahan
            $this->pdo->rollBack();
            echo '<script>alert("Terjadi kesalahan: ' . $e->getMessage() . '");history.go(-1);</script>';
        }
    }

    public function getAllPelanggan()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM pelanggan");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // handle exception
            return [];
        }
    }

    // Menambahkan metode getAllProduk
    public function getAllProduk()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM produk");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getKeranjang()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM keranjang");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}
function ribuan($angka)
{
    return number_format($angka, 0, ',', '.');
}
