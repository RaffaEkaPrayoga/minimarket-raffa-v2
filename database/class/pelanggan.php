<?php

class Pelanggan
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
            self::$instance = new Pelanggan($pdo);
        }

        return self::$instance;
    }


    public function tambah($nama_pelanggan, $alamat_pelanggan, $telepon_pelanggan)
    {
        try {

            // Masukkan pelanggan baru ke database
            $stmt = $this->db->prepare("INSERT INTO pelanggan(id_pelanggan, nama_pelanggan, alamat_pelanggan, telepon_pelanggan) VALUES(NULL, :nama_pelanggan, :alamat_pelanggan, :telepon_pelanggan)");
            $stmt->bindParam(":nama_pelanggan", $nama_pelanggan);
            $stmt->bindParam(":alamat_pelanggan", $alamat_pelanggan);
            $stmt->bindParam(":telepon_pelanggan", $telepon_pelanggan);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getID($id_pelanggan)
    {
        $stmt = $this->db->prepare("SELECT * FROM pelanggan WHERE id_pelanggan = :id_pelanggan");
        $stmt->execute(array(":id_pelanggan" => $id_pelanggan));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function update($id_pelanggan, $nama_pelanggan, $alamat_pelanggan, $telepon_pelanggan)
    {
        try {
            $stmt = $this->db->prepare("UPDATE pelanggan SET nama_pelanggan = :nama_pelanggan, alamat_pelanggan = :alamat_pelanggan, telepon_pelanggan = :telepon_pelanggan WHERE id_pelanggan = :id_pelanggan");
            $stmt->bindParam(":id_pelanggan", $id_pelanggan);
            $stmt->bindParam(":nama_pelanggan", $nama_pelanggan);
            $stmt->bindParam(":alamat_pelanggan", $alamat_pelanggan);
            $stmt->bindParam(":telepon_pelanggan", $telepon_pelanggan);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function delete($id_pelanggan)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM pelanggan WHERE id_pelanggan = :id_pelanggan");
            $stmt->bindParam(":id_pelanggan", $id_pelanggan);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
