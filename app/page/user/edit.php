<?php
$pdo = Koneksi::connect();
$crudUser = user::getInstance($pdo);

$id_user = $_GET['id'];

if (isset($_POST["edit"])) {
    $nama = htmlspecialchars($_POST["nama"]);
    $username = htmlspecialchars($_POST["username"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $not_tlp = htmlspecialchars($_POST["not_tlp"]);
    $role = $_POST["role"];
    if ($crudUser->update($id_user, $nama, $username, $email, $alamat, $not_tlp, $role)) {

        echo "<script>window.location.href = 'index.php?page=user'</script>";
    }
}

if (isset($id_user)) {
    extract($crudUser->getID($id_user));
}

?>

<div class="section-header">
    <h1>Edit User</h1>
</div>
<div class="row">
    <div class="col-12 col-md-6 col-lg-10">
        <div class="card">
            <form method="POST">
                <div class="card-body">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nama">Name</label>
                            <input id="nama" type="text" class="form-control" name="nama" value="<?php echo $nama; ?>" autofocus required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="username">Username</label>
                            <input id="username" type="text" class="form-control" name="username" value="<?php echo $username; ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="alamat">Alamat</label>
                            <input id="alamat" type="text" class="form-control" name="alamat" value="<?php echo $alamat; ?>" required>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="not_tlp">Nomor Telpon</label>
                            <input id="not_tlp" type="text" class="form-control" name="not_tlp" value="<?php echo $not_tlp; ?>" required>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Role</label>
                            <select class="form-control selectric" name="role" value="<?php echo $role; ?>" required>
                                <option value="admin">admin</option>
                                <option value="superAdmin">superAdmin</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" name="edit">
                            Edit
                        </button>
                        <br>
                        <div class="text-center">
                            <a href="index.php?page=user&act=confirm-Password&id=<?= $id_user ?>">Change Password</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>