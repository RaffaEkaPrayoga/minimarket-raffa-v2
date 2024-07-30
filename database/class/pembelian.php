<?php
class Pembelian
{
    private $db;
    private static $instance = null;

    private function __construct($db_conn)
    {
        $this->db = $db_conn;
    }

    public static function getInstance($pdo)
    {
        if (self::$instance === null) {
            self::$instance = new Pembelian($pdo);
        }
        return self::$instance;
    }

    public function getID($id_pembelian)
    {
        $stmt = $this->db->prepare("SELECT * FROM pembelian WHERE id_pembelian = :id_pembelian");
        $stmt->execute([':id_pembelian' => $id_pembelian]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllPembelian()
    {
        $stmt = $this->db->prepare("SELECT pembelian.*, supplier.nama_supplier, produk.nama_produk FROM pembelian
                                    JOIN supplier ON pembelian.id_supplier = supplier.id_supplier
                                    JOIN produk ON pembelian.idproduk = produk.idproduk");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProduk()
    {
        $stmt = $this->db->prepare("SELECT * FROM produk");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSupplier()
    {
        $stmt = $this->db->prepare("SELECT * FROM supplier");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambahPembelian($supplier, $produk, $jumlah)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO pembelian (id_supplier, idproduk, jumlah_pembelian) VALUES (:id_supplier, :idproduk, :jumlah_pembelian)");
            $stmt->bindParam(':id_supplier', $supplier, PDO::PARAM_INT);
            $stmt->bindParam(':idproduk', $produk, PDO::PARAM_INT);
            $stmt->bindParam(':jumlah_pembelian', $jumlah, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Tangani kesalahan
            return false;
        }
    }

    public function updatePembelian($id, $supplier, $produk, $jumlah)
    {
        try {
            $stmt = $this->db->prepare("UPDATE pembelian SET id_supplier = :supplier, idproduk = :produk, jumlah_pembelian = :jumlah WHERE id_pembelian = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':supplier', $supplier, PDO::PARAM_INT);
            $stmt->bindParam(':produk', $produk, PDO::PARAM_INT);
            $stmt->bindParam(':jumlah', $jumlah, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Tangani kesalahan
            return false;
        }
    }

    public function hapusPembelian($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM pembelian WHERE id_pembelian = :id_pembelian");
            $stmt->bindParam(':id_pembelian', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Tangani kesalahan
            return false;
        }
    }
}