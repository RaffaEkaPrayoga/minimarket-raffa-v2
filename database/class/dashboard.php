<?php
class DashboardFunctions
{
    private $conn;

    public function __construct()
    {
        $this->conn = Koneksi::connect();
    }

    public function getTotalPelanggan()
    {
        $query = "SELECT COUNT(id_pelanggan) as jumlahpelanggan FROM pelanggan";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['jumlahpelanggan'] ?? 0;
    }

    public function getTotalProductTerjual()
    {
        $query = "SELECT SUM(quantity) as jumlahterjual FROM nota";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['jumlahterjual'] ?? 0;
    }

    public function getHasilDidapat()
    {
        $query = "SELECT * FROM nota t, produk p WHERE p.idproduk=t.idproduk ORDER BY idnota ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $totalharga = 0;
        $totaldiskon = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $totalharga += $row['harga_jual'] * $row['quantity'];
            $totaldiskon += $row['harga_modal'] * $row['quantity'];
        }
        return $totalharga - $totaldiskon;
    }

    public function getTotalPenjualan()
    {
        $query = "SELECT SUM(totalbeli) as jumlahtotal FROM laporan";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['jumlahtotal'] ?? 0;
    }

    public function getPembelianPelanggan()
    {
        $query = "SELECT * FROM laporan l, pelanggan e WHERE e.id_pelanggan=l.id_pelanggan ORDER BY id_laporan ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ribuan($angka)
    {
        return number_format($angka, 0, ',', '.');
    }
}