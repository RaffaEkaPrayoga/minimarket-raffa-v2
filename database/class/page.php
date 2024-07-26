<?php

class Page
{

    private static $instance = null;

    private $db, $table, $total_records, $id, $limit = 5;

    public function __construct($db_conn, $table)
    {
        $this->db = $db_conn;
        $this->table = $table;
        $this->setTotalData($this->id);
    }

    public static function getInstance($pdo, $table)
    {
        if (self::$instance == null) {
            self::$instance = new Page($pdo, $table);
        }

        return self::$instance;
    }


    public function setTotalData($id)
    {
        $stmt = $this->db->prepare("SELECT :id FROM $this->table");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $this->total_records = $stmt->rowCount();
    }

    public function HalamanSaatIni()
    {
        return isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
    }


    public function getData($keyword, $record)
    {
        $start = 0;
        if ($this->HalamanSaatIni() > 1) {
            $start = ($this->HalamanSaatIni() * $this->limit) - $this->limit;
        }
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE $record like '%$keyword%' LIMIT $start, $this->limit");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPageNumber()
    {
        return ceil($this->total_records / $this->limit);
    }

    public function prevPage()
    {
        return ($this->HalamanSaatIni() > 1) ? $this->HalamanSaatIni() - 1 : 1;
    }

    public function nextPage()
    {
        return ($this->HalamanSaatIni() < $this->getPageNumber()) ? $this->HalamanSaatIni() + 1 : $this->getPageNumber();
    }
}
