<!-- Main Content -->
<div class="section-header">
    <h1>User</h1>
</div>

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
<br>
<div class="card">

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
        <ul class="list-unstyled list-unstyled-border">
            <?php
            $pdo = Koneksi::connect();
            if (isset($_POST['cari'])) {
                $key = htmlspecialchars($_POST['keyword']);
            }
            $paging = Page::getInstance($pdo, 'user');
            $rows = $paging->getdata(@$key, 'nama');
            $pages = $paging->getPageNumber();
            foreach ($rows as $row) {
            ?>
                <li class="media">
                    <img class="mr-3 rounded-circle" width="50" src="../../assets/img/avatar/avatar-4.png" alt="avatar">
                    <div class="media-body">
                        <h6 class="media-title"> <span style="cursor:default" data-toggle="tooltip" title="Nama"> <?php echo $row["nama"] ?> </span> </h6>
                        <div class="text-small text-muted"><span style="cursor:default" data-toggle="tooltip" title="Username">@<?php echo $row["username"] ?> </span>
                            <div class=" bullet"></div> <span style="cursor:default" data-toggle="tooltip" title="level" class="text-primary"><?php echo $row["level"] ?></span>
                        </div>
                    </div>
                    <td>
                        <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit" href='index.php?page=user&act=edit&id=<?php echo $row['id'] ?>'><i class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-danger btn-action tombol-hapus" data-toggle="tooltip" title="Delete" href='index.php?page=user&act=delete&id=<?php echo $row['id'] ?>'><i class="fas fa-trash"></i></a>
                    </td>
                </li>
            <?php
            }
            ?>
        </ul>
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