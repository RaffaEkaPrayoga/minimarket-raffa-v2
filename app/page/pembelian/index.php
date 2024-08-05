<?php
if ($currentUser['level'] != 1) {
    echo "<script>window.location = 'index.php?alert=err2';</script>";
    exit;
}

$pdo = Koneksi::connect();

$pembelian = Pembelian::getInstance($pdo);
$paging = Page::getInstance($pdo, 'pembelian');

if ($currentUser['level'] != 1) {
    echo "<script>window.location = 'index.php?alert=err2';</script>";
    exit;
}

$key = isset($_POST['cari']) ? htmlspecialchars($_POST['keyword']) : null;
$rows = $paging->getData($key, 'id_supplier');
$pages = $paging->getPageNumber();

?>

<div class="main-content" style="padding-left: 0px; padding-right:0;">
    <div class="section">
        <div class="section-header" style="margin-left:0px; margin-right:0px; border-radius: 10px;">
            <h1>Data Pembelian</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel pembelian</h4>
                            <a href="index.php?page=pembelian&act=create" class="btn btn-primary btn-xs p-2 float-right" style="margin-left: 70%;">
                                <i class="fa fa-plus fa-xs mr-1"></i> Tambah Data</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Supplier</th>
                                            <th>Produk</th>
                                            <th>Jumlah Pembelian</th>
                                            <th>Tanggal Pembelian</th>
                                            <?php if ($currentUser['level'] != 3) { ?>
                                                <th>Aksi</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $rowPembelian = $pembelian->getAllPembelian();
                                        $no = 1;
                                        foreach ($rowPembelian as $row) {
                                            $supplier = htmlspecialchars($row['nama_supplier']);
                                            $nama_produk = htmlspecialchars($row['nama_produk']);
                                            $jumlah = htmlspecialchars($row['jumlah_pembelian']);
                                            $tgl = htmlspecialchars($row['tgl_pembelian']);
                                        ?>
                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?= $supplier ?></td>
                                                <td><?= $nama_produk ?></td>
                                                <td><?= $jumlah ?></td>
                                                <td><?= $tgl ?></td>
                                                <?php if ($currentUser['level'] != 3) { ?>
                                                    <td>
                                                        <a href='index.php?page=pembelian&act=edit&id_pembelian=<?= $row["id_pembelian"] ?>' class='btn btn-primary btn-xs'>
                                                            <i class='fa fa-pen fa-xs mr-1'></i>Edit
                                                        </a>
                                                        <a class='btn btn-danger btn-xs text-light' onclick='hapus_pembelian(<?= $row["id_pembelian"] ?>)'>
                                                            <i class='fa fa-trash fa-xs mr-1'></i>Hapus</a>
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
</div>

<script>
    function hapus_pembelian(hapus_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary mx-4',
                cancelButton: 'btn btn-danger mx-4'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Hapus Data Pembelian',
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
                window.location = ("index.php?page=pembelian&act=delete&id_pembelian=" + hapus_id)
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
