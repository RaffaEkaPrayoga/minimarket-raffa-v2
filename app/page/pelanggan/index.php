<?php
$pdo = Koneksi::connect();

$pelanggan = Pelanggan::getInstance($pdo);
$paging = Page::getInstance($pdo, 'pelanggan');

if (isset($_POST['cari'])) {
    $key = htmlspecialchars($_POST['keyword']);
}
$rows = $paging->getData(@$key, 'nama_pelanggan');
$pages = $paging->getPageNumber();

?>
<div class="main-content" style="padding-left: 0px; padding-right:0;">
    <div class="section">
        <div class="section-header" style="margin-left:0px; margin-right:0px; border-radius: 10px;">
            <h1>Pelanggan</h1>
        </div>
        <div class="col-18 col-md-16 mb-md-2 col-lg-12">
            <form action="" method="post">
                <div class="form-grup">
                    <div class="row">
                        <div class="col-3">
                            <input type="text" class="form-control" size="5" name="keyword" autocomplete="off" placeholder="Cari Nama Customer">
                        </div>
                        <button class="btn btn-primary btn-action mr-1" type="submit" style="cursor: pointer;" name="cari"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-18 col-md-16 col-lg-12">
            <div class="card">

                <div class="card-header">
                    <div class="card-header">
                        <h4 class="d-inline">Pelanggan List</h4>
                    </div>
                    <div class="text-right">
                        <!-- Button trigger modal -->
                         <?php if ($currentUser['level'] != 3) { ?>
                        <a href="index.php?page=pelanggan&act=create"> <button type="button" class="btn btn-primary">
                                Tambah Pelanggan
                            </button>
                        </a>
                        <?php
                         }
                        ?>
                    </div>
                </div>

                <div class="card-body p-0" style="text-align : center;">
                    <div class="table-responsive">
                        <table class="table table-striped table-md table-1">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">No Hp</th>
                                <?php if ($currentUser['level'] != 3) { ?>
                                    <th scope="col">Action</th>
                                <?php } ?>
                            </tr>
                            <?php
                            $i = 1;
                            foreach ($rows as $row) {
                            ?>
                                <tr>
                                    <td class="align-middle"><?php echo $i++; ?></td>
                                    <td class="align-middle"><?php echo $row["nama_pelanggan"]; ?></td>
                                    <td class="align-middle"><?php echo $row["alamat_pelanggan"]; ?></td>
                                    <td class="align-middle"><?php echo $row["telepon_pelanggan"]; ?></td>
                                    <?php if ($currentUser['level'] != 3) { ?>
                                        <td class="align-middle">
                                            <a class="btn btn-primary btn-action mr-1 tombol-edit" data-toggle="tooltip" title="Edit" href='index.php?page=pelanggan&act=edit&id_pelanggan=<?php echo $row['id_pelanggan']; ?>'><i class="fas fa-pencil-alt"></i></a>
                                            <a class="btn btn-danger btn-action tombol-hapus" data-toggle="tooltip" title="Delete" href='index.php?page=pelanggan&act=delete&id_pelanggan=<?php echo $row['id_pelanggan']; ?>' id="delete"><i class="fas fa-trash"></i></a>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </table>
                        <div class="card-footer text-right">
                            <nav class="d-inline-block">
                                <ul class="pagination mb-0">
                                    <li class="page-item ">
                                        <a class="page-link" href="index.php?page=pelanggan&halaman=<?= $paging->prevPage(); ?>" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                                    </li>
                                    <?php
                                    for ($i = 1; $i <= $pages; $i++) :
                                        $halaman = isset($_GET['halaman']) ? $_GET['halaman'] : '';
                                        if ($halaman == $i) {
                                    ?>
                                            <li class="page-item active">
                                                <a class="page-link active" href="index.php?page=pelanggan&halaman=<?= $i; ?>"><?= $i; ?> </a>
                                            </li>
                                        <?php
                                        } else {
                                        ?>
                                            <li class="page-item">
                                                <a class="page-link active" href="index.php?page=pelanggan&halaman=<?= $i; ?>"><?= $i; ?> </a>
                                            </li>
                                    <?php
                                        }
                                    endfor;
                                    ?>
                                    <li class="page-item">
                                        <a class="page-link" href="index.php?page=pelanggan&halaman=<?= $paging->nextPage(); ?>"><i class="fas fa-chevron-right"></i></a>
                                    </li>
                                    <?php
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>