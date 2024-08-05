<!--sideBard-->
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.php">Minimarket Raffa</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.php"><span>MR</span></i></a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <?php
            @$nav = isset($_GET['page']) ? $_GET['page'] : '';
            if ($nav === 'dashboard' || $nav === '') {
            ?>
                <li class="dropdown active ">
                <?php } else { ?>
                <li class="dropdown ">
                <?php } ?>
                <a href="index.php?page=dashboard"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                </li>

                <?php
                if ($currentUser['level'] === 1) {
                ?>
                    <li class="menu-header">User</li>
                    <?php if ($nav === 'user') {
                    ?>
                        <li class="dropdown active ">
                        <?php } else { ?>
                        <li class="dropdown ">
                        <?php } ?>
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-user"></i><span>User Management</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="index.php?page=user">User</a></li>
                            <li><a class="nav-link" href="index.php?page=user&act=create">Tambah User</a></li>
                        </ul>
                        </li>
                    <?php } elseif ($currentUser['level'] != 1) {
                    echo "<script>window.location.href = 'index.php </script>";
                } ?>

                    <?php
                    if ($currentUser['level'] != 3) {
                    ?>
                        <li class="menu-header">Transaksi</li>
                        <?php if ($nav === 'transaksi') {
                        ?>
                            <li class="dropdown active ">
                            <?php } else { ?>
                            <li class="dropdown ">
                            <?php } ?>
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-shopping-cart"></i><span>Transaksi</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="index.php?page=transaksi">Transaksi</a></li>
                            </ul>

                            <li class="menu-header">Laporan</li>
                            <?php if ($nav === 'laporan') {
                            ?>
                                <li class="dropdown active ">
                                <?php } else { ?>
                                <li class="dropdown ">
                                <?php } ?>
                                <a href="#" class="nav-link has-dropdown"><i class="fas fa-file-alt"></i><span>Laporan</span></a>
                                <ul class="dropdown-menu">
                                    <li><a class="nav-link" href="index.php?page=laporan">Laporan</a></li>
                                </ul>
                            <?php } ?>

                                <li class="menu-header">Pelanggan</li>
                                <?php if ($nav === 'pelanggan') {
                                ?>
                                    <li class="dropdown active ">
                                    <?php } else { ?>
                                    <li class="dropdown ">
                                    <?php } ?>
                                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-user"></i><span>Pelanggan</span></a>
                                    <ul class="dropdown-menu">
                                        <li><a class="nav-link" href="index.php?page=pelanggan">Pelanggan</a></li>
                                    </ul>


                                    <li class="menu-header">Barang</li>
                                    <?php if ($nav === 'kategori') {
                                    ?>
                                        <li class="dropdown active ">
                                        <?php } else { ?>
                                        <li class="dropdown ">
                                        <?php } ?>
                                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i></i><span>Kategori</span></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="nav-link" href="index.php?page=kategori">Kategori</a></li>
                                        </ul>
                                        <?php if ($nav === 'produk') {
                                        ?>
                                        <li class="dropdown active ">
                                        <?php } else { ?>
                                        <li class="dropdown ">
                                        <?php } ?>
                                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-shopping-basket"></i><span>Produk</span></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="nav-link" href="index.php?page=produk">Produk</a></li>
                                        </ul>

                                        <?php
                    if ($currentUser['level'] === 1) {
                    ?>
                                        <li class="menu-header">Pembelian Barang</li>
                                        <?php if ($nav === 'supplier') {
                                        ?>
                                            <li class="dropdown active ">
                                            <?php } else { ?>
                                            <li class="dropdown ">
                                            <?php } ?>
                                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-columns"></i></i><span>Supplier</span></a>
                                            <ul class="dropdown-menu">
                                                <li><a class="nav-link" href="index.php?page=supplier">Supplier</a></li>
                                            </ul>
                                            <?php if ($nav === 'pembelian') {
                                            ?>
                                            <li class="dropdown active ">
                                            <?php } else { ?>
                                            <li class="dropdown ">
                                            <?php } ?>
                                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-square"></i><span>Pembelian</span></a>
                                            <ul class="dropdown-menu">
                                                <li><a class="nav-link" href="index.php?page=pembelian">Pembelian</a></li>
                                            </ul>
                                            <?php
                    }
                    ?>
        </ul>
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://instagram.com/raffaekaprayoga" target="_blank" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-instagram"></i> Instagram Toko
            </a>
        </div>
    </aside>
</div>