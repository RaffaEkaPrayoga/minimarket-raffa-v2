<?php
if ($currentUser['level'] != 1) {
    echo "<script>
       window.location = 'index.php?alert=err2';
    </script>";
    exit;
}
$pdo = Koneksi::connect();
$crudUser = user::getInstance($pdo);

$id_user = $_GET['id'];

if (isset($_POST["edit"])) {
    $nama = htmlspecialchars($_POST["nama"]);
    $username = htmlspecialchars($_POST["username"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $level = $_POST["level"];

    // Ambil username saat ini dari database untuk user dengan id_user ini
    $currentUser = $crudUser->getId($id_user);
    $currentUsername = $currentUser['username'];

    if (empty($id_user) || empty($nama) || empty($username) || empty($alamat) || empty($level)) {
        echo "<script>
            window.location.href = 'index.php?page=user&alert=err1&act=edit&id=$id_user';
        </script>";
    } else if ($username !== $currentUsername && $crudUser->cekUsernameDanNama($username, $nama)) {
        echo "<script>
            window.location.href = 'index.php?page=user&alert=userno&act=edit&id=$id_user';
        </script>";
    } else {
        if ($crudUser->update($id_user, $nama, $username, $alamat, $level)) {
            echo "<script>window.location.href = 'index.php?page=user&alert=success2'</script>";
        } else {
            echo "<script>window.location.href = 'index.php?page=user&alert=err2&act=edit&id=$id_user';</script>";
        }
    }
}

if (isset($id_user)) {
extract($crudUser->getID($id_user));
}

?>

<div class="main-content" style="padding-left: 0px; padding-right:0;">
    <div class="section">
        <div class="section-header" style="margin-left:0px; margin-right:0px; border-radius: 10px;">
            <h1>Edit User</h1>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <form method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nama">Name</label>
                                    <input id="nama" type="text" class="form-control" name="nama" value="<?php echo $nama; ?>" autofocus>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="username">Username</label>
                                    <input id="username" type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="alamat">Alamat</label>
                                    <input id="alamat" type="text" class="form-control" name="alamat" value="<?php echo $alamat; ?>">
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>level</label>
                                    <select class="form-control selectric" name="level" required>
                                        <option value="" selected>-- Pilih Level --</option>
                                        <option value="1" <?php echo ($level == 1) ? 'selected' : '' ?>>SuperAdmin</option>
                                        <option value="2" <?php echo ($level == 2) ? 'selected' : '' ?>>Admin</option>
                                        <option value="3" <?php echo ($level == 3) ? 'selected' : '' ?>>User</option>
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