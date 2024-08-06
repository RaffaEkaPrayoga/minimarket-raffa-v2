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
if ($currentUser['level'] != 3){
// Proses penghapusan produk
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']); // Tidak perlu htmlspecialchars dan ENT_QUOTES di sini
        if ($produk->hapusProduk($id)) {
            echo '<script>window.location="index.php?page=produk&alert=hapus"</script>';
            exit;
        } else {
            echo "Gagal menghapus produk.";
        }
    }
}
?>

<div class="main-content" style="padding-left: 0px; padding-right:0;">
    <?php
    // Untuk menambah produk
    if ($currentUser['level'] != 3) {
    if (isset($_POST['tambahProduk'])) {
        // Validasi input
        if (empty($_POST['nama_produk']) || empty($_POST['idkategori']) || empty($_POST['stock']) || empty($_POST['harga_modal']) || empty($_POST['harga_jual'])) {
            echo '<script>window.location="index.php?page=produk&alert=err1"</script>';
        } else {
            // Menyimpan gambar
            $gambar = 'produk.png'; // Nama default jika tidak ada upload
            if ($_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
                $gambar = $produk->uploadimg('index.php?page=produk');
            }

            // Membersihkan input
            $data = [
                'kode_produk' => htmlspecialchars($_POST['kode_produk'], ENT_QUOTES, 'UTF-8'),
                'nama_produk' => htmlspecialchars($_POST['nama_produk'], ENT_QUOTES, 'UTF-8'),
                'idkategori' => htmlspecialchars($_POST['idkategori'], ENT_QUOTES, 'UTF-8'),
                'stock' => htmlspecialchars($_POST['stock'], ENT_QUOTES, 'UTF-8'),
                'harga_modal' => htmlspecialchars($_POST['harga_modal'], ENT_QUOTES, 'UTF-8'),
                'harga_jual' => htmlspecialchars($_POST['harga_jual'], ENT_QUOTES, 'UTF-8'),
                'gambar' => $gambar
            ];

            $produk->tambahProduk($data);
            echo '<script>window.location="index.php?page=produk&alert=success1"</script>';
        }
    }

// Untuk memperbarui produk
    if (isset($_POST['updateProduk'])) {
        // Validasi input
        if (empty($_POST['nama_produk']) || empty($_POST['idkategori']) || empty($_POST['stock']) || empty($_POST['harga_modal']) || empty($_POST['harga_jual'])) {
            echo '<script>window.location="index.php?page=produk&alert=err1"</script>';
        } else {
            // Cek apakah ada file gambar baru yang diupload
            $gambar = $_POST['current_gambar']; // Gunakan gambar lama jika tidak ada file baru
            if ($_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
                // Jika ada file baru, upload dan update nama gambar
                $gambar = $produk->uploadimg('index.php?page=produk');
            }

            // Membersihkan input
            $data = [
                'idproduk' => htmlspecialchars($_POST['idproduk'], ENT_QUOTES, 'UTF-8'),
                'nama_produk' => htmlspecialchars($_POST['nama_produk'], ENT_QUOTES, 'UTF-8'),
                'idkategori' => htmlspecialchars($_POST['idkategori'], ENT_QUOTES, 'UTF-8'),
                'stock' => htmlspecialchars($_POST['stock'], ENT_QUOTES, 'UTF-8'),
                'harga_modal' => htmlspecialchars($_POST['harga_modal'], ENT_QUOTES, 'UTF-8'),
                'harga_jual' => htmlspecialchars($_POST['harga_jual'], ENT_QUOTES, 'UTF-8'),
                'gambar' => $gambar
            ];

            // Panggil metode updateProduk untuk memperbarui produk
            $produk->updateProduk($data);

            // Redirect dengan status sukses
            echo '<script>window.location="index.php?page=produk&alert=success2"</script>';
        }
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
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Gambar Produk</th>
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
                                            $gambar_produk = htmlspecialchars($d['gambar']);
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
                                                <td><img src="page/produk/img/<?php echo $gambar_produk ?>" alt="Gambar Produk" width="80"></td>
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

<!-- Modal Tambah Produk -->
<?php if ($currentUser['level'] != 3) { ?>
    <div class="modal fade" id="addproduk" tabindex="-1" role="dialog" aria-labelledby="ModalTittle" aria-hidden="true" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalTittle"><i class="fa fa-shopping-bag mr-1 text-muted"></i> Tambah Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="kode_produk">Kode Produk</label>
                                    <input type="text" class="form-control" id="kode_produk" name="kode_produk" value="<?php echo $kodeProduk ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nama_produk">Nama Produk</label>
                                    <input type="text" class="form-control" id="nama_produk" name="nama_produk">
                                </div>
                                <div class="form-group">
                                    <label for="idkategori">Kategori</label>
                                    <select class="form-control" id="idkategori" name="idkategori">
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php foreach ($produk->getKategori() as $kategori) { ?>
                                            <option value="<?php echo $kategori['idkategori'] ?>"><?php echo $kategori['nama_kategori'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="stock">Stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock">
                                </div>
                                <div class="form-group">
                                    <label for="harga_modal">Harga Modal</label>
                                    <input type="text" class="form-control" id="harga_modal" name="harga_modal">
                                </div>
                                <div class="form-group">
                                    <label for="harga_jual">Harga Jual</label>
                                    <input type="text" class="form-control" id="harga_jual" name="harga_jual">
                                </div>
                                <div class="form-group">
                                    <label for="gambar">Gambar Produk</label>
                                    <input type="file" class="form-control" id="gambar" name="gambar">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" name="tambahProduk">Tambah Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Produk -->
    <?php foreach ($produkData as $d) { ?>
        <div class="modal fade" id="editP<?php echo $d['idproduk'] ?>" tabindex="-1" role="dialog" aria-labelledby="ModalEditTittle" aria-hidden="true" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalEditTittle"><i class="fa fa-edit mr-1 text-muted"></i> Edit Produk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="idproduk" value="<?php echo $d['idproduk'] ?>">
                            <input type="hidden" name="current_gambar" value="<?php echo $d['gambar'] ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nama_produk">Nama Produk</label>
                                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?php echo htmlspecialchars($d['nama_produk']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="idkategori">Kategori</label>
                                        <select class="form-control" id="idkategori" name="idkategori">
                                            <option value="">-- Pilih Kategori --</option>
                                            <?php foreach ($produk->getKategori() as $kategori) { ?>
                                                <option value="<?php echo $kategori['idkategori'] ?>" <?php echo ($kategori['idkategori'] == $d['idkategori']) ? 'selected' : '' ?>>
                                                    <?php echo $kategori['nama_kategori'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="stock">Stock</label>
                                        <input type="number" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($d['stock']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="harga_modal">Harga Modal</label>
                                        <input type="text" class="form-control" id="harga_modal" name="harga_modal" value="<?php echo htmlspecialchars($d['harga_modal']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="harga_jual">Harga Jual</label>
                                        <input type="text" class="form-control" id="harga_jual" name="harga_jual" value="<?php echo htmlspecialchars($d['harga_jual']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="gambar">Gambar Produk</label>
                                        <input type="file" class="form-control" id="gambar" name="gambar">
                                        <img src="page/produk/img/<?php echo htmlspecialchars($d['gambar']) ?>" alt="Gambar Produk" width="100" style="margin-top: 10px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" name="updateProduk">Update Produk</button>
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

<?php } ?>