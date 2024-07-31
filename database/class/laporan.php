<?php
class Laporan
{
    private static $instance;
    private $pdo;

    private function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public static function getInstance($pdo)
    {
        if (self::$instance == null) {
            self::$instance = new Laporan($pdo);
        }
        return self::$instance;
    }

    public function getAllLaporan()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM laporan l, pelanggan e WHERE e.id_pelanggan = l.id_pelanggan ORDER BY id_laporan ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetailLaporan($nota)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pelanggan e, laporan c WHERE no_nota = :nota and e.id_pelanggan = c.id_pelanggan");
        $stmt->execute([':nota' => $nota]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProdukByNota($nota)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM nota t, produk p WHERE no_nota = :nota and t.idproduk = p.idproduk ORDER BY t.idproduk ASC");
        $stmt->execute([':nota' => $nota]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
function ribuan($angka)
    {
        return number_format($angka, 0, ',', '.');
    }