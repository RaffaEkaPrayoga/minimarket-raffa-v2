<footer class="main-footer">
    <div class="footer-left">
        Copyright &copy; 2024 <div class="bullet"></div><a href="">Raffa Eka Prayoga</a>
    </div>
    <div class="footer-right">
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php
    if (isset($_GET['alert']) && $_GET['alert'] == "success1") {
    ?>
        Swal.fire({
            icon: 'success',
            title: 'Penambahan Berhasil',
            text: 'Anda telah berhasil menambahkan data'
        });
    <?php } elseif (isset($_GET['alert']) && $_GET['alert'] == "success2") { ?>
        Swal.fire({
            icon: 'success',
            title: 'Update Berhasil',
            text: 'Anda telah berhasil mengupdate data'
        });
    <?php } elseif (isset($_GET['alert']) && $_GET['alert'] == "err1") { ?>
        Swal.fire({
            icon: "warning",
            title: 'Mohon mengisi setiap kolom!',
            showConfirmButton: false,
            timer: 2500
        });
    <?php } elseif (isset($_GET['alert']) && $_GET['alert'] == "err2") { ?>
        Swal.fire({
            icon: "error",
            title: 'Tidak Ada Izin',
            text: 'Anda Tidak Memiliki Izin Untuk Halaman Ini!',
            showConfirmButton: false,
            timer: 3000
        });
    <?php } elseif (isset($_GET['alert']) && $_GET['alert'] == "err3") { ?>
        Swal.fire({
            icon: "error",
            title: 'Password Salah',
            text: 'Password yang Anda Masukkan Salah!',
            showConfirmButton: false,
            timer: 3000
        });
    <?php } elseif (isset($_GET['alert']) && $_GET['alert'] == "hapus") { ?>
        Swal.fire({
            icon: "success",
            title: 'Items telah dihapus!',
            showConfirmButton: false,
            timer: 1500
        });
    <?php } elseif (isset($_GET['alert']) && $_GET['alert'] == "pass") { ?>
        Swal.fire({
            icon: "success",
            title: 'Berhasil Mengganti Password!',
            showConfirmButton: false,
            timer: 1500
        });
    <?php } elseif (isset($_GET['alert']) && $_GET['alert'] == "passConf") { ?>
        Swal.fire({
            icon: "success",
            title: 'Silahkan Mengganti Password!',
            showConfirmButton: false,
            timer: 1500
        });
    <?php } elseif (isset($_GET['alert']) && $_GET['alert'] == "passNCof") { ?>
        Swal.fire({
            icon: 'error',
            title: 'Konfirmasi password tidak cocok!',
            text: 'Silakan coba lagi.',
            showConfirmButton: false,
            timer: 3000
        });
    <?php } elseif (isset($_GET['alert']) && $_GET['alert'] == "userno") { ?>
        Swal.fire({
            icon: 'error',
            title: 'Username Sudah Ada!',
            text: 'Silakan coba lagi.',
            showConfirmButton: false,
            timer: 3000
        });
    <?php } ?>
</script>