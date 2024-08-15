<?php
require_once "../database/koneksi.php";

$pdo = Koneksi::connect();
$user = Auth::getInstance($pdo);

if (isset($_POST["regis"])) {
    // Mendapatkan dan menyaring input
    $username = htmlspecialchars(trim($_POST["username"]));
    $password = htmlspecialchars(trim($_POST["password"]));
    $nama = htmlspecialchars(trim($_POST["nama"]));
    $passConf = htmlspecialchars(trim($_POST["passConf"]));
    $alamat = htmlspecialchars(trim($_POST["alamat"]));

    // Memeriksa apakah ada kolom yang kosong
    if (empty($username) || empty($password) || empty($nama) || empty($passConf) || empty($alamat)) {
        header("Location: index.php?auth=register&alert=err1");
        exit();
    } else if ($password !== $passConf) {
        header("Location: index.php?auth=register&alert=err2");
        exit();
    } else if ($user->cekUsernameDanNama($username, $nama)) {
        header("Location: index.php?auth=register&alert=err3");
    } else if ($user->register($nama, $username, $password, $alamat, $level)) {
        header("Location: index.php?auth=register&alert=success");
        exit();
    } else {
        header("Location: index.php?auth=register&alert=err4");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Register &mdash; Minimarket Raffa</title>

    <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/modules/jquery-selectric/selectric.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/components.css">
    <link rel="shortcut icon" href="../assets/img/Keranjang.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 CDN -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php
            if (isset($_GET['alert'])) {
                switch ($_GET['alert']) {
                    case 'success':
                        echo "Swal.fire({
                            icon: 'success',
                            title: 'Registrasi Berhasil',
                            text: 'Anda telah berhasil terdaftar. Silakan login.'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'index.php?auth=login.php';
                            }
                            });";
                        break;
                    case 'err1':
                        echo "Swal.fire({
                            icon: 'warning',
                            title: 'Mohon mengisi setiap kolom!',
                            showConfirmButton: false,
                            timer: 2500
                        });";
                        break;
                    case 'err2':
                        echo "Swal.fire({
                            icon: 'error',
                            title: 'Konfirmasi password tidak cocok!',
                            text: 'Silakan coba lagi.',
                            showConfirmButton: false,
                            timer: 3000
                        });";
                        break;
                    case 'err3':
                        echo "Swal.fire({
                            icon: 'error',
                            title: 'Username sudah digunakan!',
                            text: 'Silakan pilih username lain.',
                            showConfirmButton: false,
                            timer: 3000
                        });";
                        break;
                    case 'err4':
                        echo "Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan!',
                            text: 'Silakan coba lagi nanti.',
                            showConfirmButton: false,
                            timer: 3000
                        });";
                        break;
                }
            }
            ?>
        });
    </script>
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                        <div class="login-brand">
                            <img src="../assets/img/Keranjang.png" alt="logo" width="100" class="shadow-light rounded-circle">
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Register</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" class="needs-validation" novalidate="">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="nama">Nama</label>
                                            <input id="nama" type="text" class="form-control" name="nama" autofocus placeholder="nama">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="alamat">Alamat</label>
                                            <input id="alamat" type="text" class="form-control" name="alamat" placeholder="alamat">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input id="username" type="text" class="form-control" name="username" placeholder="username">
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="password" class="d-block">Password</label>
                                            <div class="input-group">
                                                <input id="password" type="password" class="form-control pwstrength" name="password" placeholder="password">
                                                <div class="input-group-append">
                                                    <button id="togglePassword1" class="btn btn-outline-secondary" type="button">
                                                        <i id="toggleIcon1" class="fa fa-eye-slash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="password2" class="d-block">Konfirmasi Password</label>
                                            <div class="input-group">
                                                <input id="password2" type="password" class="form-control" name="passConf" placeholder="konfirmasi password">
                                                <div class="input-group-append">
                                                    <button id="togglePassword2" class="btn btn-outline-secondary" type="button">
                                                        <i id="toggleIcon2" class="fa fa-eye-slash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" name="regis">
                                            Register
                                        </button>
                                        <button type="reset" name="reset" class="btn btn-danger btn-lg btn-block">
                                            Reset
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            Kamu sudah memiliki Akun? <a href="index.php?auth=login">Log In</a>
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
        document.getElementById('togglePassword1').addEventListener('click', function(e) {
            // Toggle the type attribute
            const password = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon1');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle the icon
            toggleIcon.classList.toggle('fa-eye-slash');
            toggleIcon.classList.toggle('fa-eye');
        });
        document.getElementById('togglePassword2').addEventListener('click', function(e) {
            // Toggle the type attribute
            const password = document.getElementById('password2');
            const toggleIcon = document.getElementById('toggleIcon2');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle the icon
            toggleIcon.classList.toggle('fa-eye-slash');
            toggleIcon.classList.toggle('fa-eye');
        });
    </script>

    <script src="../assets/modules/jquery.min.js"></script>
    <script src="../assets/modules/popper.js"></script>
    <script src="../assets/modules/tooltip.js"></script>
    <script src="../assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="../assets/modules/moment.min.js"></script>
    <script src="../assets/js/stisla.js"></script>
    <script src="../assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
    <script src="../assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
    <script src="../assets/js/page/auth-register.js"></script>
    <script src="../assets/js/scripts.js"></script>
    <script src="../assets/js/custom.js"></script>
</body>

</html>