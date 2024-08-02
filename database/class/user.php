<?php

class user
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
            self::$instance = new user($pdo);
        }
        return self::$instance;
    }


    public function tambah($nama, $username, $password, $alamat,  $level)
    {
        try {

            if ($this->cekUsername($username)) {
                return false;
            }

            // enkripsi
            $hashPasswd = password_hash($password, PASSWORD_DEFAULT);
            //Masukkan user baru ke database
            $stmt = $this->db->prepare("INSERT INTO user(id ,nama, username, password, alamat,  level) VALUES(NULL,:nama, :username , :pass, :alamat, :level)");
            $stmt->bindParam(":nama", $nama);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":pass", $hashPasswd);
            $stmt->bindParam(":alamat", $alamat);
            $stmt->bindParam(":level", $level);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getID($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->execute(array(":id" => $id));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }


    public function update($id, $nama, $username, $alamat, $level)
    {
        try {

            $stmt = $this->db->prepare("UPDATE user SET nama = :nama, username = :username, alamat =:alamat, level = :level WHERE id =:id ");
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":nama", $nama);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":alamat", $alamat);
            $stmt->bindParam(":level", $level);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM user WHERE id =:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return true;
    }

    //pengecekan sebelum ganti passsoerd apakah password yang lama sesuai dengan milik user
    public function confirmPassword($id, $oldPassword)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM user WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $data = $stmt->fetch();

            if ($stmt->rowCount() == 1) {
                if (password_verify($oldPassword, $data["password"])) {
                    return true;
                } else {
                    return false;
                }
            }

            // return true;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function resetPassword($id, $password)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM user WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                $this->updatePassword($id, $password);
                return true;
            } else {
                echo "Username yang dimasukkan tidak sesuai";
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updatePassword($id, $password)
    {
        try {

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE user SET password = :password WHERE id = :id");
            $stmt->bindParam(":password", $hash);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // apakah username dan email sudah pernah digunakan
    public function cekUsername($username)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM user WHERE username = :username");
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getError()
    {
        return true;
    }
}
