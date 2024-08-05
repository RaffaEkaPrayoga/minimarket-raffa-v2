<?php
if ($currentUser['level'] != 1) {
    echo "<script>
       window.location = 'index.php?alert=err2';
    </script>";
    exit;
}

$pdo = Koneksi::connect();
$crudUser = user::getInstance($pdo);

if (isset($_POST["tambah"])) {
    $nama = htmlspecialchars($_POST["nama"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $passConf = htmlspecialchars($_POST["passconf"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $level = $_POST["level"];

    if (empty($nama) || empty($username) || empty($password) || empty($passConf) || empty($alamat) || empty($level)) {
        echo "<script>window.location.href='index.php?page=user&act=create&alert=err1';</script>";
    } else if ($password != $passConf) {
        echo "<script>window.location.href='index.php?page=user&act=create&alert=passNCof';</script>";
    } else if ($crudUser->cekUsername($username)) {
        echo "<script>window.location.href='index.php?page=user&act=create&alert=userno';</script>";
    } else {
        if ($crudUser->tambah($nama, $username, $password, $alamat, $level)) {
            echo "<script>window.location.href='index.php?page=user&alert=success1';</script>";
        } else {
            echo "<script>window.location.href='index.php?page=user&alert=err2';</script>";
        }
    }
}
?>


<div class="main-content" style="padding-left: 0px; padding-right:0;">
    <div class="section">
        <div class="section-header" style="margin-left:0px; margin-right:0px; border-radius: 10px;">
            <h1>Tambah User</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-20 col-lg-20">
                <div class="card">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nama">Nama</label>
                                    <input id="nama" type="text" class="form-control" autocomplete="off" name="nama" autofocus>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="username">Username</label>
                                    <input id="username" type="text" class="form-control" autocomplete="off" name="username">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="alamat">Alamat</label>
                                    <input id="alamat" type="text" class="form-control" autocomplete="off" name="alamat">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Level</label>
                                    <select class="form-control selectric" name="level">
                                        <option value="1">SuperAdmin</option>
                                        <option value="2">Admin</option>
                                        <option value="3">User</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="password" class="d-block">Password</label>
                                    <input id="password" type="password" autocomplete="off" class="form-control pwstrength" data-indicator="pwindicator" name="password">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="passconf" class="d-block">Password Konfirmasi</label>
                                    <input id="passconf" type="password" autocomplete="off" class="form-control pwstrength" data-indicator="pwindicator" name="passconf">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" name="tambah">Tambah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>