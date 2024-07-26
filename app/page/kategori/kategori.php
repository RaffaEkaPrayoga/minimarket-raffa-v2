<?php
ob_start();
include "../database/class/kategori.php";
include "../database/class/page.php";

$pdo = Koneksi::connect();
$kategori = Kategori::getInstance($pdo);

$paging = Page::getInstance($pdo, 'kategori');
if (isset($_POST['cari'])) {
    $key = htmlspecialchars($_POST['keyword']);
}
$rows = $paging->getData(@$key, 'nama_kategori');
$pages = $paging->getPageNumber();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addkategori'])) {
        $namaKategori = htmlspecialchars($_POST['nama_kategori']);
        if (empty($namaKategori)) {
            echo '<script>window.location="index.php?page=kategori&alert=err1"</script>';
        } else {
            $kategori->tambahKategori($namaKategori);
            echo "<script>window.location = 'index.php?page=kategori&alert=success1';</script>";
        }
        exit();
    } elseif (isset($_POST['update'])) {
        $idKategori = htmlspecialchars($_POST['idkategori']);
        $namaKategori = htmlspecialchars($_POST['nama_kategori']);
        if (empty($idKategori) || empty($namaKategori)) {
            echo '<script>window.location="index.php?page=kategori&alert=err1"</script>';
        } else {
            $kategori->updateKategori($idKategori, $namaKategori);
            echo "<script>window.location = 'index.php?page=kategori&alert=success2';</script>";
        }
        exit();
    }
}

if (isset($_GET['hapus'])) {
    $idKategori = htmlspecialchars($_GET['hapus']);
    $kategori->hapusKategori($idKategori);
    echo "<script>window.location = 'index.php?page=kategori&alert=success3';</script>";
    exit();
}

$kategoriData = $kategori->bacaKategori();

ob_end_flush();
?>

<div class="main-content" style="padding-left:0px; padding-right:0;">
    <div class="section" style="padding-left:30px; margin-right:25px;">
        <div class="section-header" style="border-radius: 10px;">
            <h1>Data Kategori</h1>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Kategori</h4>
                        <div style="margin-left: 50%;">
                            <?php if ($currentUser['level'] != 3) { ?>
                                <?php if (!empty($_GET['edit'])) { ?>
                                    <?php
                                    $idKategori = $_GET['edit'];
                                    $editData = $kategori->bacaKategoriById($idKategori);
                                    ?>
                                    <form method="POST" class="float-right">
                                        <div class="input-group">
                                            <input type="hidden" name="idkategori" value="<?php echo $editData['idkategori'] ?>">
                                            <input type="text" name="nama_kategori" class="form-control form-control-sm bg-white" style="border-radius:0.428rem 0px 0px 0.428rem; margin-top: 2px;" placeholder="Masukan Kategori" value="<?php echo htmlspecialchars($editData['nama_kategori']) ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-success" name="update" style="border-radius: 0px 0.428rem 0.428rem 0px; margin-bottom: 10px;" type="submit">
                                                    <i class="fas fa-check"></i><span class="d-none d-sm-inline-block d-md-inline-block ml-1">Update</span>
                                                </button>
                                                <a href="index.php?page=kategori" class="btn btn-danger btn-xs py-1 px-2 ml-1" style="margin-bottom: 10px;">
                                                    <i class="fas fa-times"></i><span class="d-none d-sm-inline-block d-md-inline-block ml-1">Batal</span>
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                <?php } else { ?>
                                    <form method="POST" class="float-right">
                                        <div class="input-group">
                                            <input type="text" name="nama_kategori" class="form-control form-control-sm bg-white" style="border-radius:0.428rem 0px 0px 0.428rem; margin-top: 2px;" placeholder="Masukan Kategori">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary btn-xl" name="addkategori" style="border-radius: 0px 0.428rem 0.428rem 0px;" type="submit">
                                                    <i class="fa fa-plus"></i><span class="d-none d-sm-inline-block d-md-inline-block ml-1">Tambah</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Kategori</th>
                                        <th>Qty</th>
                                        <th>Tanggal</th>
                                        <?php if ($currentUser['level'] != 3) { ?>
                                            <th>Opsi</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($kategoriData as $d) {
                                        $idKategori = $d['idkategori'];
                                    ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo htmlspecialchars($d['nama_kategori']) ?></td>
                                            <td><?php echo ribuan($kategori->countProdukByKategori($idKategori)); ?></td>
                                            <td><?php echo htmlspecialchars($d['tgl_dibuat']) ?></td>
                                            <?php if ($currentUser['level'] != 3) { ?>
                                                <td>
                                                    <a href="index.php?page=kategori&edit=<?php echo $idKategori ?>" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-pen fa-xs mr-1"></i>Edit
                                                    </a>
                                                    <a class="btn btn-danger btn-xs text-light" onclick="hapus_kategori(<?php echo $idKategori ?>)">
                                                        <i class="fa fa-trash fa-xs mr-1"></i>Hapus
                                                    </a>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function hapus_kategori(hapus_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary mx-4',
                cancelButton: 'btn btn-danger mx-4'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Hapus Data Kategori',
            text: "Data kamu nggak bisa kembali lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, menghapus !',
            cancelButtonText: 'Tidak, batal !',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                swalWithBootstrapButtons.fire(
                    'Hapus!',
                    'File kamu telah dihapus.',
                    'success'
                )
                window.location = "index.php?page=kategori&hapus=" + hapus_id;
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Batal',
                    'File kamu masih aman :)',
                    'error'
                )
            }
        })
    }
</script>