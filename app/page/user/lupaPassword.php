<?php
$pdo = Koneksi::connect();
$user = user::getInstance($pdo);

if (isset($_POST["reset"])) {
    $nama = htmlspecialchars($_POST["nama"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    if (empty($username) || empty($nama) || empty($password)) {
        echo "<script>window.location = 'index.php?page=user&act=lupa-Password&alert=err1';</script>";
    } else if ($user->forgotPassword($username, $nama, $password)) {
        echo "<script>window.location = 'index.php?page=user&act=lupa-Password&alert=pass';</script>";
    } else {
        echo "<script>window.location = 'index.php?page=user&act=lupa-Password&alert=errPass';</script>";
    }
}
?>
<div class="main-content" style="padding-left: 0px; padding-right:0;">
    <div class="section">
        <div class="section-header" style="margin-left:0px; margin-right:0px; border-radius: 10px;">
            <h1>Lupa Password</h1>
        </div>
        <section class="section">
            <div class="container" style="margin-top: 5rem;">
                <div class="row">
                    <div class="col-12 col-md-20 col-lg-20">
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
                                        <button type="submit" name="reset" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Reset Password
                                        </button>
                                    </div>
                                </form>
                            </div>
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