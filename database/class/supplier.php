<?php
class Supplier
{
    private $db;
    private static $instance = null;

    private function __construct($db_conn)
    {
        $this->db = $db_conn;
    }

    public static function getInstance($pdo)
    {
        if (self::$instance == null) {
            self::$instance = new Supplier($pdo);
        }
        return self::$instance;
    }

    public function getAllSupplier()
    {
        $stmt = $this->db->prepare("SELECT * FROM supplier");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambah($nama_supplier, $alamat_supplier, $telepon_supplier)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO supplier (nama_supplier, alamat_supplier, telepon_supplier) VALUES (:nama_supplier, :alamat_supplier, :telepon_supplier)");
            $stmt->bindParam(":nama_supplier", $nama_supplier);
            $stmt->bindParam(":alamat_supplier", $alamat_supplier);
            $stmt->bindParam(":telepon_supplier", $telepon_supplier);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getID($id_supplier)
    {
        $stmt = $this->db->prepare("SELECT * FROM supplier WHERE id_supplier = :id_supplier");
        $stmt->bindParam(":id_supplier", $id_supplier);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id_supplier, $nama_supplier, $alamat_supplier, $telepon_supplier)
    {
        try {
            $stmt = $this->db->prepare("UPDATE supplier SET nama_supplier = :nama_supplier, alamat_supplier = :alamat_supplier, telepon_supplier = :telepon_supplier WHERE id_supplier = :id_supplier");
            $stmt->bindParam(":id_supplier", $id_supplier);
            $stmt->bindParam(":nama_supplier", $nama_supplier);
            $stmt->bindParam(":alamat_supplier", $alamat_supplier);
            $stmt->bindParam(":telepon_supplier", $telepon_supplier);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function delete($id_supplier)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM supplier WHERE id_supplier = :id_supplier");
            $stmt->bindParam(":id_supplier", $id_supplier);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
