<?php
    if ($currentUser['level'] != 1) {
        echo "<script>
        window.location = 'index.php?alert=err2';
    </script>";
        exit;
    }
?>

<!-- Main Content -->
<div class="main-content" style="padding-left: 0px; padding-right:0;">
    <div class="section">
        <div class="section-header" style="margin-left:0px; margin-right:0px; border-radius: 10px;">
            <h1>User</h1>
        </div>
        <br>
        <div class="card">
            <form action="" method="post">
                <div class="form-grup">
                    <div class="row">
                        <div class="col-3 mb-md-2">
                            <input type="text" class="form-control" size="5" name="keyword" autocomplete="off" placeholder="Cari Nama Costumer">
                        </div>
                        <button class="btn btn-primary btn-action mr-1" type="submit" style="cursor: pointer;" name="cari"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <div class="card-header">
                <div class="card-header">
                    <h4 class="d-inline">User List</h4>
                </div>
                <div class="text-right">
                    <!-- Button trigger modal -->
                    <a href="index.php?page=user&act=create"><button type="button" class="btn btn-primary">
                            Tambah user
                        </button>
                    </a>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php
                    $pdo = Koneksi::connect();
                    if (isset($_POST['cari'])) {
                        $key = htmlspecialchars($_POST['keyword']);
                    }
                    $paging = Page::getInstance($pdo, 'user');
                    $rows = $paging->getdata(@$key, 'nama');
                    $pages = $paging->getPageNumber();
                    $no = 1;
                    ?>
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Alamat</th>
                                <th>Level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row) {
                                $level = htmlspecialchars($row["level"]);
                                if ($level == '1') {
                                    $levelText = "Super Admin";
                                } elseif ($level == '2') {
                                    $levelText = "Admin";
                                } else {
                                    $levelText = "User";
                                }
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row["nama"]) ?></td>
                                    <td>@<?= htmlspecialchars($row["username"]) ?></td>
                                    <td><?= htmlspecialchars($row["alamat"]) ?></td>
                                    <td><?= $levelText ?></td>
                                    <td>
                                        <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit" href='index.php?page=user&act=edit&id=<?= $row['id'] ?>'><i class="fas fa-pencil-alt"></i></a>
                                        <a class="btn btn-danger btn-action tombol-hapus" data-toggle="tooltip" title="Delete" href='index.php?page=user&act=delete&id=<?= $row['id'] ?>'><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer text-right">
                <nav class="d-inline-block">
                    <ul class="pagination mb-0">
                        <li class="page-item ">
                            <a class="page-link" href="index.php?page=user&halaman=<?= $paging->prevPage() ?>" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <?php
                        for ($i = 1; $i <= $pages; $i++) :
                            $halaman = isset($_GET['halaman']) ? $_GET['halaman'] : '';
                            if ($halaman == $i) {
                        ?>
                                <li class="page-item active">
                                    <a class="page-link active" href="index.php?page=user&halaman=<?= $i; ?>"><?= $i ?> </a>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li class="page-item">
                                    <a class="page-link active" href="index.php?page=user&halaman=<?= $i; ?>"><?= $i ?> </a>
                                </li>
                        <?php
                            }
                        endfor;
                        ?>
                        <li class="page-item">
                            <a class="page-link" href="index.php?page=user&halaman=<?= $paging->nextPage() ?>"><i class="fas fa-chevron-right"></i></a>
                        </li>
                        <?php
                        ?>
                    </ul>
                </nav>
            </div>
        </div>