<?php
class Pembayaran
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
            self::$instance = new Pembayaran($pdo);
        }

        return self::$instance;
    }


    // hitung total total harga produk peritem 
    public function hitungTotalHarga($id_transaksi)
    {
        $stmt = $this->db->prepare("SELECT SUM(detail_transaksi.qty * product.harga_produk) as total_harga 
                                    FROM detail_transaksi 
                                    JOIN product ON detail_transaksi.id_produk = product.id_produk 
                                    WHERE detail_transaksi.id_transaksi = :id_transaksi");
        $stmt->bindParam(":id_transaksi", $id_transaksi);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['total_harga'] : 0;
    }

    //menyimpan pembayaran / input pembayaran ke database
    public function simpanPembayaran($id_transaksi, $total_harga, $jumlah_bayar, $kembalian, $discount)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO bayar (id_transaksi, total_harga, jumlah_bayar, kembalian, discount) VALUES (:id_transaksi, :total_harga, :jumlah_bayar, :kembalian, :discount)");
            $stmt->bindParam(":id_transaksi", $id_transaksi);
            $stmt->bindParam(":total_harga", $total_harga);
            $stmt->bindParam(":jumlah_bayar", $jumlah_bayar);
            $stmt->bindParam(":kembalian", $kembalian);
            $stmt->bindParam(":discount", $discount);
            $this->statusUpdate($id_transaksi);
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // merubah status pendign ke selesai ketika sudah melakukan pembayaran
    public function statusUpdate($id_transaksi)
    {
        try {

            $stmt = $this->db->prepare("UPDATE transaksi SET status = 'SELESAI' WHERE id_transaksi = :id_transaksi ");
            $stmt->bindParam(":id_transaksi", $id_transaksi);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    // menmapilkan data bayar / mendapatkan data bayar pada table bayar
    public function getBayar($id_bayar)
    {
        $stmt = $this->db->prepare("SELECT * FROM bayar WHERE id_bayar = :id_bayar");
        $stmt->bindParam(":id_bayar", $id_bayar);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // menampilkan data untuk struk
    public function getStruk($id_transaksi)
    {
        $stmt = $this->db->prepare("SELECT detail_transaksi.qty, product.nama_produk, product.harga_produk 
                        FROM detail_transaksi 
                        JOIN product ON detail_transaksi.id_produk = product.id_produk 
                        WHERE detail_transaksi.id_transaksi = :id_transaksi");
        $stmt->bindParam(":id_transaksi", $id_transaksi);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    //menampilan data transaksi dari table transaksi
    public function getTransaksi($id_transaksi)
    {
        $stmt = $this->db->prepare("SELECT * FROM transaksi WHERE id_transaksi = :id_transaksi");
        $stmt->bindParam(":id_transaksi", $id_transaksi);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //pengecekan discount sesuai member
    public function getDiscount($id_pembeli)
    {
        $stmt = $this->db->prepare("SELECT pembeli.* , member.* FROM pembeli JOIN member ON pembeli.id_member = member.id_member WHERE id_pembeli = :id_pembeli");
        $stmt->bindParam(":id_pembeli", $id_pembeli);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //pesan error
    public function getError()
    {
        return true;
    }
}
