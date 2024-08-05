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

if (isset($_POST["confirm"])) {
    $password = htmlspecialchars($_POST["password"]);

    if (empty($password)) {
        // Jika password kosong, arahkan dengan parameter alert=err1
        echo "<script>
            window.location.href = 'index.php?page=user&act=confirm-Password&id=" . htmlspecialchars($id_user) . "&alert=err1';
        </script>";
    } else if ($crudUser->confirmPassword($id_user, $password)) {
        // Jika password benar, set session dan arahkan ke halaman perubahan password
        $_SESSION['confirm_password'] = true;
        $_SESSION['id_user'] = $id_user;
        echo "<script>
            window.location.href = 'index.php?page=user&act=change-Password&alert=passConf&id=" . htmlspecialchars($id_user) . "';
        </script>";
    } else {
        // Jika password salah, arahkan dengan parameter alert=err3
        echo "<script>
            window.location.href = 'index.php?page=user&act=confirm-Password&id=" . htmlspecialchars($id_user) . "&alert=err3';
        </script>";
    }
}
?>


<div class="main-content" style="padding-left: 0px; padding-right:0;">
    <div class="section">
        <div class="section-header" style="margin-left:0px; margin-right:0px; margin-bottom:6rem; border-radius: 10px;">
            <h1>Ganti Password</h1>
        </div>

        <?php
        if (isset($error)) {
            echo "";
        }

        ?>

        <div class="row d-flex justify-content-center align-items-center">
            <div class="card">
                <form method="POST">
                    <div class="card-body">
                        <div class="h5 font-weight-bold text-center">
                            <p>
                                Konfirmasi Password Lama Kamu, Sebelum Mengganti Password Baru
                            </p>
                        </div>
                        <div class="col-20 col-md-16 col-lg-18">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" autocomplete="off" placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" name="confirm">
                                Confirm Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>