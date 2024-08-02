<?php
$pdo = Koneksi::connect();
$user = Auth::getInstance($pdo);

if (isset($_POST["reset"])) {
    $nama = htmlspecialchars($_POST["nama"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    if (empty($username) || empty($nama) || empty($password)) {
        echo "<script>window.location = 'index.php?auth=forget&alert=err1';</script>";
    } else if ($user->forgotPassword($username, $nama, $password)) {
        echo "<script>window.location = 'index.php?auth=forget&alert=pass';</script>";
    } else {
        echo "<script>window.location = 'index.php?auth=forget&alert=errPass';</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href=".../assets/modules/bootstrap-social/bootstrap-social.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href=".../assets/css/components.css">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div id="app">

        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <img src="../assets/img/Keranjang.png" alt="logo" width="100" class="shadow-light rounded-circle">
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Reset Password</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" class="needs-validation" novalidate="">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input id="nama" type="text" class="form-control" name="nama" tabindex="1" autocomplete="off" autofocus>
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input id="username" type="text" class="form-control" name="username" tabindex="1" autocomplete="off" autofocus>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password Baru</label>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password" tabindex="2">
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" name="reset" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            <a href="index.php?auth=login">Kembali Ke Menu Login</a>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; Raffa Eka Prayoga
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
                    <?php if (isset($_GET['alert'])) { ?>
                        switch ("<?php echo $_GET['alert']; ?>") {
                            case "pass":
                                Swal.fire({
                                    icon: "success",
                                    title: 'Berhasil Mengganti Password!',
                                    text: 'Anda telah berhasil terdaftar. Silakan login.'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'index.php?auth=login.php';
                                    }
                                });
                                break;
                            case "errPass":
                                Swal.fire({
                                    icon: "error",
                                    title: 'Nama dan Username Tidak Sesuai!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                break;
                            case "err1":
                                Swal.fire({
                                    icon: "warning",
                                    title: 'Mohon Mengisi Setiap Kolom!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                break;
                                // Tambahkan case lain di sini jika diperlukan
                        }
                    <?php } ?>
                });
    </script>

    <script src="../assets/modules/jquery.min.js"></script>
    <script src="../assets/modules/popper.js"></script>
    <script src="../assets/modules/tooltip.js"></script>
    <script src="../assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="../assets/modules/moment.min.js"></script>
    <script src="../assets/js/stisla.js"></script>
    <script src="../assets/js/scripts.js"></script>
    <script src="../assets/js/custom.js"></script>
</body>

</html>