<?php
require_once "../database/koneksi.php";

$pdo = Koneksi::connect();
$user = Auth::getInstance($pdo);
if (isset($_POST["login"])) {
  // Mendapatkan dan menyaring input
  $username = htmlspecialchars(trim($_POST["username"]));
  $password = htmlspecialchars(trim($_POST["password"]));

  // Memeriksa apakah username atau password kosong
  if (empty($username) || empty($password)) {
    header("Location: index.php?auth=login&alert=err1");
    exit();
  }

  // Memeriksa kredensial login
  if ($user->login($username, $password)) {
    header("Location: index.php?alert=success");
    exit();
  } else {
    header("Location: index.php?auth=login&alert=err2");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; Minimarket Raffa</title>
  <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="../assets/modules/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/components.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 CDN -->
</head>

<body>
  <div id="app">
    <section class="section">
      <?php if (isset($_GET['alert'])) : ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
          document.addEventListener("DOMContentLoaded", function() {
            <?php
            if ($_GET['alert'] == "success") {
            ?>
              Swal.fire({
                icon: 'success',
                title: 'Login Berhasil',
                showConfirmButton: false,
                timer: 2500
              });
            <?php
            } else if ($_GET['alert'] == "successLogout") {
            ?>
              Swal.fire({
                icon: 'success',
                title: 'Logout Berhasil',
                showConfirmButton: false,
                timer: 2500
              });
            <?php
            } else if ($_GET['alert'] == "err1") {
            ?>
              Swal.fire({
                icon: 'warning',
                title: 'Mohon mengisi setiap kolom!',
                showConfirmButton: false,
                timer: 2500
              });
            <?php
            } else if ($_GET['alert'] == "err2") {
            ?>
              Swal.fire({
                icon: 'error',
                title: 'Username atau Password salah',
                showConfirmButton: false,
                timer: 2500
              });
            <?php
            }
            ?>
          });
        </script>
      <?php endif; ?>
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="../assets/img/Keranjang.png" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>

              <div class="card-body">
                <form method="POST" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" class="form-control" name="username" tabindex="1" autocomplete="off" autofocus>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a href="index.php?auth=forget" class="text-small">
                          Lupa Password?
                        </a>
                      </div>
                    </div>
                    <div class="input-group">
                      <input id="password" type="password" class="form-control" name="password" tabindex="2">
                      <div class="input-group-append">
                        <button id="togglePassword" class="btn btn-outline-secondary" type="button">
                          <i id="toggleIcon" class="fa fa-eye-slash"></i>
                        </button>
                      </div>
                    </div>
                  </div>


                  <div class="form-group">
                    <button type="submit" name="login" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
              <div class="mb-3 text-muted text-center">
                Belum Punya Akun? <a href="index.php?auth=register">Klik disini !!</a>
              </div>
            </div>
          </div>
        </div>
        <div class="simple-footer">
          Copyright &copy; Raffa Eka Prayoga
        </div>
      </div>
    </section>
  </div>

  <script>
    document.getElementById('togglePassword').addEventListener('click', function(e) {
      // Toggle the type attribute
      const password = document.getElementById('password');
      const toggleIcon = document.getElementById('toggleIcon');
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
  <script src="../assets/js/scripts.js"></script>
  <script src="../assets/js/custom.js"></script>
</body>

</html>