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
                            <!-- <li><a class="nav-link" href="index.php?page=user&act=create">Tambah User</a></li> -->
                        </ul>
                        </li>
                    <?php } elseif ($currentUser['level'] === 2) {
                    echo "<script>window.location.href = 'index.php </script>";
                } ?>
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
                            <!-- <li><a class="nav-link" href="index.php?page=pelanggan&act=create">Tambah Pelanggan</a></li> -->
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
                                <!-- <li><a class="nav-link" href="index.php?page=produk&act=create">Tambah produk</a></li> -->
                            </ul>

                        <li class="menu-header">Pembelian Barang</li>
                        <?php if ($nav === 'supplier') {
                        ?>
                            <li class="dropdown active ">
                            <?php } else { ?>
                            <li class="dropdown ">
                            <?php } ?>
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i></i><span>Supplier</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="index.php?page=supplier">Supplier</a></li>
                            </ul>
                            <?php if ($nav === 'pembelian') {
                            ?>
                            <li class="dropdown active ">
                            <?php } else { ?>
                            <li class="dropdown ">
                            <?php } ?>
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-shopping-basket"></i><span>Pembelian</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="index.php?page=pembelian">Pembelian</a></li>
                                <!-- <li><a class="nav-link" href="index.php?page=pembelian&act=create">Tambah pembelian</a></li> -->
                            </ul>


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
                                    <!-- <li><a class="nav-link" href="index.php?page=transaksi&act=create">Buat Transaksi</a></li> -->
                                </ul>
        </ul>
    </aside>
</div>