<?php
if ($currentUser['level'] != 1) {
    echo "<script>
       window.location = 'index.php?alert=err2';
    </script>";
    exit;
}

$pdo = Koneksi::connect();
$crudUser = user::getInstance($pdo);

$id_user = htmlspecialchars($_GET["id"]);

// Pengecekan session confirm_password dan id_user
if (!isset($_SESSION['confirm_password']) || $_SESSION['confirm_password'] !== true || !isset($_SESSION['id_user']) || $_SESSION['id_user'] != $id_user) {
    echo "<script>
        window.location.href = 'index.php?page=user&act=confirm-Password&id={$id_user}&alert=err2';
    </script>";
    exit();
}

// Proses reset password
if (isset($_POST["reset"])) {
    $password = htmlspecialchars($_POST["password"]);

    if ($crudUser->resetPassword($id_user, $password)) {
        // Hapus session setelah password berubah
        unset($_SESSION['confirm_password']);
        unset($_SESSION['id_user']);
        echo "<script>window.location.href ='index.php?page=user&alert=pass'</script>";
    } else {
        echo "<script>alert('Gak bisa')</script>";
    }
}
?>

<div class="main-content" style="padding-left: 0px; padding-right:0;">
    <div class="section">
        <div class="section-header" style="margin-left:0px; margin-right:0px; margin-bottom:6rem; border-radius: 10px;">
            <h1>Ganti Password</h1>
        </div>
        <div class="row d-flex justify-content-center align-items-center">
            <div class="card">
                <form method="POST">
                    <div class="card-body">

                        <div class="h5 font-weight-bold text-center">
                            <p>
                                Buat Pasword Baru Kamu
                            </p>
                        </div>
                        <div class="col-12 col-md-16 col-lg-18">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" autocomplete="off" placeholder="Confirm Password" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" name="reset">
                                Confirm Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>