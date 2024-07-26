<?php

class Transaksi
{

    private static $instance = null;

    private $db;

    public function __construct($db_conn)
    {
        $this->db = $db_conn;
    }


    public static function getInstance($pdo)
    {
        if (self::$instance == null) {
            self::$instance = new Transaksi($pdo);
        }
        return self::$instance;
    }



    //untuk menggambil data dari tabel transaksi yang berelasi dengan pembeli
    public function getTransaksi($tanggal = null)
    {
        try {
            $start = 0;
            $limit = 5;
            if ($this->halamanSaatIni() > 1) {
                $start = ($this->halamanSaatIni() * $limit) - $limit;
            }

            //jika tanggal dimasukan
            if ($tanggal) {
                $stmt = $this->db->prepare("SELECT transaksi.*, pembeli.id_pembeli , pembeli.nama ,pembeli.alamat , pembeli.no_tlp           
            FROM transaksi 
            JOIN pembeli 
            ON pembeli.id_pembeli = transaksi.id_pembeli WHERE tanggal_transaksi LIKE :tanggal LIMIT :start, :limit");
                $stmt->bindValue(":tanggal", "%$tanggal%");
            }
            // jika tanggal tidak dimasukan
            else {
                $stmt = $this->db->prepare("SELECT transaksi.*, pembeli.id_pembeli , pembeli.nama ,pembeli.alamat , pembeli.no_tlp           
            FROM transaksi 
            JOIN pembeli 
            ON pembeli.id_pembeli = transaksi.id_pembeli LIMIT :start, :limit");
            }

            $stmt->bindValue(":start", $start, PDO::PARAM_INT);
            $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function halamanSaatIni()
    {
        return isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
    }

    //untuk mengambil data pembeli agar bisa diinput ke transaksi
    public function getCustomer()
    {
        try {
            $stmt =  $this->db->prepare("SELECT * FROM pembeli");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //menambahkan transaksi / menginput data transaksi
    public function tambahTransaksi($id_pembeli, $tanggal)
    {
        try {

            $stmt = $this->db->prepare("INSERT INTO transaksi (id_pembeli, tanggal_transaksi) VALUE ( :id_pembeli , :tanggal )");
            $stmt->bindParam(":id_pembeli", $id_pembeli);
            $stmt->bindParam(":tanggal", $tanggal);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    /*


Bagian Detail Transaksi



*/


    //mengambil data produk
    public function getProduk($que, $id_transaksi)
    {
        try {
            $que = "SELECT * FROM product WHERE id_produk NOT IN (SELECT id_produk FROM detail_transaksi WHERE id_transaksi = :id_transaksi)";
            $stmt =  $this->db->prepare($que);
            $stmt->bindParam(':id_transaksi', $id_transaksi);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function cekJumlahProduk($id_produk, $qty)
    {
        try {
            $stmt = $this->db->prepare("SELECT jumlah_produk FROM product WHERE id_produk = :id_produk");
            $stmt->bindParam(":id_produk", $id_produk);
            $stmt->execute();
            $stok = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stok && $stok['jumlah_produk'] >= $qty) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    //menambahkan detail transaksi
    public function tambahDetail($id_transaksi, $id_produk, $qty,)
    {
        try {

            if (!$this->cekJumlahProduk($id_produk, $qty)) {
                echo 'Stok Tidak Cukup';
                return false;
            }

            $stmt = $this->db->prepare("INSERT INTO detail_transaksi (id_transaksi, id_produk, qty) VALUE ( :id_transaksi , :id_produk, :qty )");
            $stmt->bindParam(":id_transaksi", $id_transaksi);
            $stmt->bindParam(":id_produk", $id_produk);
            $stmt->bindParam(":qty", $qty);
            $stmt->execute();

            $this->KurangiStok($id_produk, $qty);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    //Kurangi stock ketika dimasukkan kedalam detail transaksi
    public function KurangiStok($id_produk, $qty)
    {
        try {
            $stmt = $this->db->prepare("UPDATE product SET jumlah_produk = jumlah_produk - :qty WHERE id_produk = :id_produk");
            $stmt->bindParam(":id_produk", $id_produk);
            $stmt->bindParam(":qty", $qty);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function getDetailTransaksi($id_transaksi)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM detail_transaksi, product WHERE detail_transaksi.id_produk = product.id_produk AND id_transaksi = :idTrk");
            $stmt->bindParam(":idTrk", $id_transaksi);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function totalHarga($id_transaksi)
    {
        try {

            $stmt = $this->db->prepare("SELECT SUM(detail_transaksi.qty * product.harga_produk) as total_harga FROM detail_transaksi JOIN product ON detail_transaksi.id_produk = product.id_produk WHERE id_transaksi = :id_transaksi");
            $stmt->bindParam("id_transaksi", $id_transaksi);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function hapusDetail($id_produk, $id_transaksi)
    {

        try {

            $cek = $this->cekQtyInput($id_transaksi, $id_produk);

            //jika detail tidak ditemukan tidak ditenukan
            if ($cek === false) {
                echo "Data Yang ingin Dihapus Tidak Ada";
                return false;
            }
            $qty = $cek['qty'];

            //hapus data 
            $stmt = $this->db->prepare("DELETE FROM detail_transaksi WHERE id_produk = :id_produk AND id_transaksi = :id_transaksi");
            $stmt->bindParam(":id_produk", $id_produk);
            $stmt->bindParam(":id_transaksi", $id_transaksi);
            $stmt->execute();

            $this->kembalikanStok($id_produk, $qty);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function kembalikanStok($id_produk, $qty)
    {
        try {
            //kembalikan stok seperti semula
            $stmt = $this->db->prepare("UPDATE product SET jumlah_produk = jumlah_produk + :qty WHERE id_produk = :id_produk");
            $stmt->bindParam(':qty', $qty);
            $stmt->bindParam(':id_produk', $id_produk);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    //cek jumlah qty  yang diinputkan apakah melebihi jumlah stok
    public function cekQtyInput($id_transaksi, $id_produk)
    {
        //cek jumlah qty 
        $stmt = $this->db->prepare("SELECT qty FROM detail_transaksi WHERE id_transaksi = :id_transaksi AND id_produk = :id_produk");
        $stmt->bindParam(':id_transaksi', $id_transaksi);
        $stmt->bindParam(':id_produk', $id_produk);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function hapusTransaksi($id_transaksi)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM transaksi WHERE id_transaksi = :id");
            $stmt->bindParam(":id", $id_transaksi);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function jumlahTransaski($id_transaksi)
    {
        $stmt = $this->db->prepare("SELECT COUNT(id_transaksi)FROM detail_transaksi WHERE id_transaksi = :id_transaksi");
        $stmt->bindParam(":id_transaksi", $id_transaksi);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }


    public function getIdBayar($id_transaksi)
    {
        $stmt = $this->db->prepare("SELECT * FROM bayar WHERE id_transaksi = :id_transaksi");
        $stmt->bindParam(":id_transaksi", $id_transaksi);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    /*
    @
    @
    Bagian Report
    @
    @
    */


    //Menghitung Pendapatan berdasarkan tanggal
    public function countPendapatan($tanggal)
    {
        try {
            if ($tanggal) {
                $stmt = $this->db->prepare("SELECT SUM(total_harga)
                FROM bayar 
                JOIN transaksi 
                ON bayar.id_transaksi = transaksi.id_transaksi 
                WHERE tanggal_transaksi LIKE :tanggal");
            } else {
                $stmt = $this->db->prepare("SELECT SUM(total_harga) 
                FROM bayar 
                JOIN transaksi 
                ON bayar.id_transaksi = transaksi.id_transaksi 
                WHERE tanggal_transaksi NOT LIKE :tanggal");
            }

            $stmt->bindParam(":tanggal", $tanggal);
            $stmt->execute();
            return  $stmt->fetch(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
