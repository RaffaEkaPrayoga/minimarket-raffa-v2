<?php
include "../database/class/produk.php";
include "../database/class/page.php";

$pdo = Koneksi::connect();
$produk = Produk::getInstance($pdo);

$paging = Page::getInstance($pdo, 'produk');
$key = isset($_POST['cari']) ? htmlspecialchars($_POST['keyword']) : '';
$rows = $paging->getData($key, 'nama_produk');
$pages = $paging->getPageNumber();

$kodeProduk = $produk->generateKodeProduk();

// Proses penghapusan produk
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($produk->hapusProduk($id)) {
        echo '<script>window.location="index.php?page=produk&alert=hapus"</script>';
        exit;
    } else {
        echo "Gagal menghapus produk.";
    }
}

?>
<div class="main-content" style="padding-left: 0px; padding-right:0;">
    <?php
    if (isset($_POST['tambahProduk'])) {
        // Validasi input
        if (empty($_POST['nama_produk']) || empty($_POST['idkategori']) || empty($_POST['stock']) || empty($_POST['harga_modal']) || empty($_POST['harga_jual'])) {
            echo '<script>window.location="index.php?page=produk&alert=err1"</script>';
        } else {
            $produk->tambahProduk($_POST);
            echo '<script>window.location="index.php?page=produk&alert=success1"</script>';
        }
    }

    if (isset($_POST['updateProduk'])) {
        // Validasi input
        if (empty($_POST['nama_produk']) || empty($_POST['idkategori']) || empty($_POST['stock']) || empty($_POST['harga_modal']) || empty($_POST['harga_jual'])) {
            echo '<script>window.location="index.php?page=produk&alert=err1"</script>';
        } else {
            $produk->updateProduk($_POST);
            echo '<script>window.location="index.php?page=produk&alert=success2"</script>';
        }
    }
    ?>
    <div class="section" style="padding-left:0px; padding-right:0px;">
        <div class="section-header" style="margin-left:0px; margin-right: 0px; border-radius: 10px;">
            <h1><i class="fa fa-table me-2"></i> Data Produk </h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Produk</h4>
                            <?php if ($currentUser['level'] != 3) { ?>
                                <button type="button" class="btn btn-primary btn-xs p-2" style="margin-left: 70%; margin-top: 20px;" data-toggle="modal" data-target="#addproduk">
                                    <i class="fa fa-plus fa-xs mr-1"></i> Tambah Produk
                                </button>
                            <?php } ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Kategori</th>
                                            <th>Stock</th>
                                            <th>Harga Modal</th>
                                            <th>Harga Jual</th>
                                            <?php if ($currentUser['level'] != 3) { ?>
                                                <th>Tanggal Input</th>
                                                <th>Opsi</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $produkData = $produk->getAllProduk();
                                        $no = 1;
                                        foreach ($produkData as $d) {
                                            $idproduk = htmlspecialchars($d['idproduk']);
                                            $kode_produk = htmlspecialchars($d['kode_produk']);
                                            $nama_produk = htmlspecialchars($d['nama_produk']);
                                            $nama_kategori = htmlspecialchars($d['nama_kategori']);
                                            $stock = htmlspecialchars($d['stock']);
                                            $harga_modal = htmlspecialchars($d['harga_modal']);
                                            $harga_jual = htmlspecialchars($d['harga_jual']);
                                            $tgl_input = htmlspecialchars($d['tgl_input']);
                                        ?>
                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?php echo $kode_produk ?></td>
                                                <td><?php echo $nama_produk ?></td>
                                                <td><?php echo $nama_kategori ?></td>
                                                <td><span class="badge badge-light"><?php echo $stock ?></span></td>
                                                <td>Rp.<?php echo ribuan($harga_modal) ?></td>
                                                <td>Rp.<?php echo ribuan($harga_jual) ?></td>
                                                <?php if ($currentUser['level'] != 3) { ?>
                                                    <td><span class="text-small font-weight-bold text-center"><?php echo $tgl_input ?></span></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#editP<?php echo $idproduk ?>">
                                                            <i class="fa fa-pen"></i>
                                                        </button>
                                                        <a class="btn btn-danger btn-sm text-light mt-1" onclick="hapus_produk(<?php echo $idproduk ?>)">
                                                            <i class="fa fa-trash"></i>
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
</div>
</div>

<?php if ($currentUser['level'] != 3) { ?>
    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="addproduk" tabindex="-1" role="dialog" aria-labelledby="ModalTittle" aria-hidden="true" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalTittle"><i class="fa fa-shopping-bag mr-1 text-muted"></i> Tambah Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label>Kode Produk :</label>
                            <input type="text" name="kode_produk" class="form-control" value="<?php echo htmlspecialchars($kodeProduk); ?>" readonly>
                        </div>
                        <div class="form-group mb-2">
                            <label>Nama Produk :</label>
                            <input type="text" name="nama_produk" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Kategori Produk :</label>
                            <select name="idkategori" class="form-control" required>
                                <option value="" selected>-- Pilih Kategori --</option>
                                <?php
                                $dataK = $produk->getKategori();
                                foreach ($dataK as $dk) {
                                ?>
                                    <option value="<?php echo htmlspecialchars($dk['idkategori']) ?>"><?php echo htmlspecialchars($dk['nama_kategori']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Stock :</label>
                            <input type="number" name="stock" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Harga Modal :</label>
                            <input type="number" name="harga_modal" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Harga Jual :</label>
                            <input type="number" name="harga_jual" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="tambahProduk" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Produk -->
    <?php foreach ($produkData as $d) { ?>
        <div class="modal fade" id="editP<?php echo htmlspecialchars($d['idproduk']) ?>" tabindex="-1" role="dialog" aria-labelledby="ModalTittle" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post">
                        <input type="hidden" name="idproduk" value="<?php echo htmlspecialchars($d['idproduk']) ?>">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalTittle"><i class="fa fa-edit mr-1 text-muted"></i> Edit Produk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-2">
                                <label>Kode Produk :</label>
                                <input type="text" name="kode_produk" class="form-control" value="<?php echo htmlspecialchars($d['kode_produk']) ?>" readonly>
                            </div>
                            <div class="form-group mb-2">
                                <label>Nama Produk :</label>
                                <input type="text" name="nama_produk" class="form-control" value="<?php echo htmlspecialchars($d['nama_produk']) ?>" required>
                            </div>
                            <div class="form-group mb-2">
                                <label>Kategori Produk :</label>
                                <select name="idkategori" class="form-control" required>
                                    <option value="" selected>-- Pilih Kategori --</option>
                                    <?php
                                    $dataK = $produk->getKategori();
                                    foreach ($dataK as $dk) {
                                    ?>
                                        <option value="<?php echo htmlspecialchars($dk['idkategori']) ?>" <?php echo ($dk['idkategori'] == $d['idkategori']) ? 'selected' : '' ?>><?php echo htmlspecialchars($dk['nama_kategori']) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Stock :</label>
                                <input type="number" name="stock" class="form-control" value="<?php echo htmlspecialchars($d['stock']) ?>" required>
                            </div>
                            <div class="form-group mb-2">
                                <label>Harga Modal :</label>
                                <input type="number" name="harga_modal" class="form-control" value="<?php echo htmlspecialchars($d['harga_modal']) ?>" required>
                            </div>
                            <div class="form-group mb-2">
                                <label>Harga Jual :</label>
                                <input type="number" name="harga_jual" class="form-control" value="<?php echo htmlspecialchars($d['harga_jual']) ?>" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="updateProduk" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>


    <script>
        function hapus_produk(id) {
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
                    window.location.href = 'index.php?page=produk&id=' + id;
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

<?php
}
?>