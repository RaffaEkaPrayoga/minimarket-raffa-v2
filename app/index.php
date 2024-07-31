<?php
include("../database/koneksi.php");
include "../database/class/auth.php";

$pdo = Koneksi::connect();
$user = Auth::getInstance($pdo);
$currentUser = $user->getUser();

// Cek user apakah sudah login atau belum
if (!$user->isLoggedIn() && $user->isLoggedIn() == false) {
    $login = isset($_GET['auth']) ? $_GET['auth'] : 'auth';
    switch ($login) {
        case 'login':
            include 'auth/login.php';
            break;
        case 'register':
            include 'auth/register.php';
            break;
        default:
            include 'auth/login.php';
            break;
    }
} else {
    $cetak = isset($_GET['cetak']) ? $_GET['cetak'] : 'cetak';
    switch ($cetak) {
        case 'struk':
            include 'page/laporan/print-laporan.php';
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>Minimarket Raffa</title>
        <?php
        include 'layout/stylecss.php';
        ?>
        <style>
            .section {
                margin-top: -2.5rem;
            }

            .section-header .section-body {
                border-radius: 100px;
            }
        </style>
    </head>

    <body>
        <div id="app">
            <?php
            include("layout/header.php");
            include("layout/sidebar.php");
            ?>
            <div class="main-content">
                <section class="section">

                    <?php
                    $page = isset($_GET["page"]) ? $_GET["page"] : '';
                    switch ($page) {
                        case 'user':
                            include('page/user/default.php');
                            break;

                        case 'pelanggan':
                            include('page/pelanggan/default.php');
                            break;

                        case 'kategori':
                            include('page/kategori/kategori.php');
                            break;

                        case 'produk':
                            include('page/produk/produk.php');
                            break;

                        case 'supplier':
                            include('page/supplier/default.php');
                            break;
                            
                        case 'pembelian':
                            include('page/pembelian/default.php');
                            break;

                        case 'transaksi':
                            include('page/transaksi/transaksi.php');
                            break;

                        case 'laporan':
                            include('page/laporan/default.php');
                            break;

                        case 'dashboard':
                            include('page/dashboard/index.php');
                            break;
                            
                        default:
                            include('page/dashboard/index.php');
                    }
                    ?>
                </section>
            </div>

        </div>
        <!-- General JS Scripts -->
        <?php
        include 'layout/footer.php';
        include("layout/stylejs.php");
        ?>
    </body>

    </html>

<?php
}
?>