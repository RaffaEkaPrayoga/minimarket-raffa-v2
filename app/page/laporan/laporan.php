<?php
if ($currentUser['level'] === 3) {
    echo "<script>window.location = 'index.php?alert=err2';</script>";
    exit;
}

$pdo = Koneksi::connect();
$laporan = Laporan::getInstance($pdo);

$data_laporan = $laporan->getAllLaporan();
?>

<div class="main-content" style="padding-left: 0px; padding-right:0;">
    <div class="section">
        <div class="section-header" style="margin-left:0px; margin-right:0px; border-radius: 10px;">
            <h1>Data Laporan</h1>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fa fa-table me-2"></i> Data Laporan
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-sm table-bordered dt-responsive nowrap" id="table" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. Nota</th>
                            <th>Pelanggan</th>
                            <th>Qty</th>
                            <th>Catatan</th>
                            <th>SubTotal</th>
                            <th>Pembayaran</th>
                            <th>Kembalian</th>
                            <th>Tanggal</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data_laporan as $d) {
                            $nota = $d['no_nota'];
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $d['no_nota'] ?></td>
                                <td><?php echo $d['nama_pelanggan'] ?></td>
                                <td>
                                    <?php
                                    $itungtrans = $laporan->getProdukByNota($nota);
                                    $total_qty = 0;
                                    foreach ($itungtrans as $item) {
                                        $total_qty += $item['quantity'];
                                    }
                                    echo $total_qty;
                                    ?>
                                </td>
                                <td class="catatan"><?php echo $d['catatan'] ?></td>
                                <td>Rp.<?php echo ribuan($d['totalbeli']) ?></td>
                                <td>Rp.<?php echo ribuan($d['pembayaran']) ?></td>
                                <td>Rp.<?php echo ribuan($d['kembalian']) ?></td>
                                <td><?php echo $d['tgl_sub'] ?></td>
                                <td>
                                    <a class="btn btn-info btn-xs" href="index.php?page=laporan&act=detail&invoice=<?php echo $nota ?>">
                                        <i class="fa fa-eye fa-xs"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>