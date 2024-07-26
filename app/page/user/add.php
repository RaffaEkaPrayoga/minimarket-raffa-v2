<?php
$crudUser = user::getInstance($pdo);

if (isset($_POST["tambah"])) {
    $nama = htmlspecialchars($_POST["nama"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $not_tlp = htmlspecialchars($_POST["not_tlp"]);
    $role = $_POST["role"];

    if ($crudUser->tambah($nama, $username, $email, $password, $alamat, $not_tlp, $role)) {
        echo "<script>window.location.href='index.php?page=user'</script>";
    } else {
        echo "pesan";
    }
}
?>

<div class="section-header">
    <h1>Tambah User</h1>

</div>

<div class="row">
    <div class="col-12 col-md-20 col-lg-20">
        <div class="card">
            <form method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nama">Name</label>
                            <input id="nama" type="text" class="form-control" autocomplete="off" name="nama" autofocus required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="username">Username</label>
                            <input id="username" type="text" class="form-control" autocomplete="off" name="username" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="alamat">Alamat</label>
                            <input id="alamat" type="text" class="form-control" autocomplete="off" name="alamat" required>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Role</label>
                            <select class="form-control selectric" name="role" required>
                                <option value="2">admin</option>
                                <option value="3">user</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="password" class="d-block">Password</label>
                            <input id="password" type="password" autocomplete="off" class="form-control pwstrength" data-indicator="pwindicator" name="password" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="passconf" class="d-block">Password Konfirmasi</label>
                            <input id="passconf" type="password" autocomplete="off" class="form-control pwstrength" data-indicator="pwindicator" name="password" required>
                        </div>
                    </div>

                    <br>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" name="tambah">
                            Tambah
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>