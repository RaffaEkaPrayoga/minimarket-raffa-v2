<?php
if ($currentUser['level'] == 3) {
    echo "<script>window.location = 'index.php?alert=err2';</script>";
    exit;
}

$pdo = Koneksi::connect();
$laporan = Laporan::getInstance($pdo);

$nota = $_GET['invoice'];
if (!isset($_GET['invoice'])) {
    echo '<script>alert("Data Tidak Di Temukan");history.go(-1);</script>';
}

$detail_laporan = $laporan->getDetailLaporan($nota);
$data_produk = $laporan->getProdukByNota($nota);
?>

<div class="main-content" style="padding-left: 0px; padding-right:0;">
    <div class="section">
        <div class="section-header" style="margin-left:0px; margin-right:0px; border-radius: 10px;">
            <h1>Detail Laporan</h1>
        </div>
        <div class="card">
            <div class="card-body">
                <a href="index.php?page=laporan" class="btn btn-light btn-xs mt-3" style="font-weight:500; margin-left: 50rem;">
                    <i class="fa fa-chevron-left fa-xs"></i> Kembali
                </a>
                <a href="index.php?cetak=struk&invoice=<?= $nota ?>" target="_BLANK" class="btn btn-xs btn-info" style="font-weight:500; margin-left: 51rem; margin-top: 1rem;">
                    PDF
                </a>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="mb-4" style="margin-top: -5rem;">Invoice : <?= $nota ?></h5>
                        <br><br>
                        <p class="small mb-0">Kasir : <?= $currentUser['nama'] ?></p>
                        <p class="small mb-0">Tanggal : <?= $detail_laporan['tgl_sub'] ?></p>
                    </div>
                    <div class="col-sm-6 mb-4">
                        <p class="small mb-0">Nama : <?= $detail_laporan['nama_pelanggan'] ?></p>
                        <p class="small mb-0">Telepon : <?= $detail_laporan['telepon_pelanggan'] ?></p>
                        <p class="small mb-0">Alamat : <?= $detail_laporan['alamat_pelanggan'] ?></p>
                    </div>
                </div>
                <table class="table table-sm" id="cart" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data_produk as $d) {
                            $total = $d['quantity'] * $d['harga_jual'];
                        ?>
                            <tr>
                                <td style="border: 1px solid #dee2e6;"><?= $no++ ?></td>
                                <td style="border: 1px solid #dee2e6;"><?= $d['nama_produk'] ?></td>
                                <td style="border: 1px solid #dee2e6;"><?= $d['quantity'] ?></td>
                                <td style="border: 1px solid #dee2e6;">Rp.<?= ribuan($d['harga_jual']) ?></td>
                                <td style="border: 1px solid #dee2e6;">Rp.<?= ribuan($total) ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="container">
                    <div class="row justify-content-end">
                        <div class="col-lg-4 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-group list-group-flush" style="margin-right: 20px;">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">Total</div>
                                                <div class="col">Rp. <?= ribuan($detail_laporan['totalbeli']) ?></div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">Pembayaran</div>
                                                <div class="col">Rp. <?= ribuan($detail_laporan['pembayaran']) ?></div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">Kembalian</div>
                                                <div class="col">Rp. <?= ribuan($detail_laporan['kembalian']) ?></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>