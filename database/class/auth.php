<?php

class Auth
{
    private $db;
    private $error;
    private static $instance = null;

    private function __construct($db_conn)
    {
        $this->db = $db_conn;
        @session_start();
    }

    public static function getInstance($pdo)
    {
        if (self::$instance == null) {
            self::$instance = new Auth($pdo);
        }
        return self::$instance;
    }

    // Fungsi untuk registrasi user
    public function register($nama, $username, $password, $passConf, $alamat, $level)
    {
        if (empty($nama) || empty($username) || empty($password) || empty($passConf) || empty($alamat)) {
            header("Location: index.php?auth=register&alert=err1");
            exit();
        }
        if ($password !== $passConf) {
            header("Location: index.php?auth=register&alert=err2");
            exit();
        }

        try {
            $this->cekUsername($username);

            // Enkripsi password
            $hashPasswd = password_hash($password, PASSWORD_DEFAULT);

            // Masukkan user baru ke database
            $stmt = $this->db->prepare("INSERT INTO user (nama, username, password, alamat, level) 
                                    VALUES (:nama, :username, :pass, :alamat, :level)");
            $stmt->bindParam(":nama", $nama);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":pass", $hashPasswd);
            $stmt->bindParam(":alamat", $alamat);
            $stmt->bindParam(":level", $level);
            $stmt->execute();

            // Redirect setelah berhasil
            header("Location: index.php?auth=register&alert=success");
            exit();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] == 23000) {
                header("Location: index.php?auth=register&alert=err3");
            } else {
                header("Location: index.php?auth=register&alert=err4");
            }
            exit();
        }
    }


    // Fungsi untuk login user
    public function login($username, $password)
    {
        if (empty($username) || empty($password)) {
            $this->error = 'Username dan password tidak boleh kosong';
            return false;
        }

        try {
            $stmt = $this->db->prepare("SELECT id, password FROM user WHERE username = :username");
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($fetch && password_verify($password, $fetch['password'])) {
                $_SESSION['ssLogin'] = $fetch['id'];
                $_SESSION["ssUser"] = $username;
                return true;
            } else {
                $this->error = 'Username atau Password salah';
                return false;
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    // Cek apakah user sudah login
    public function isLoggedIn()
    {
        return isset($_SESSION['ssLogin']);
    }

    // Mendapatkan data user yang login saat ini
    public function getUser()
    {
        if (!$this->isLoggedIn()) {
            return false;
        }
        try {
            $stmt = $this->db->prepare("SELECT * FROM user WHERE id = :id");
            $stmt->bindParam(":id", $_SESSION['ssLogin']);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    // Logout user
    public function logout()
    {
        unset($_SESSION['ssLogin']);
        unset($_SESSION['ssUser']);
        session_destroy();
        return true;
    }

    // Cek apakah username sudah ada
    private function cekUsername($username)
    {
        try {
            $stmt = $this->db->prepare("SELECT id FROM user WHERE username = :username");
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                throw new Exception("Username sudah digunakan!");
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    // Mendapatkan pesan error
    public function getError()
    {
        return $this->error;
    }
}
