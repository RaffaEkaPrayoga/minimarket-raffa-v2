<?php

$id_transaksi = $_GET["id"];
$pdo = Koneksi::connect();
$bayar = Pembayaran::getInstance($pdo);
$get = $bayar->getTransaksi($id_transaksi);

//pengecekan discount member
$cekAnggota = $bayar->getDiscount($get["id_pembeli"]);
$cekDiscount = $cekAnggota['keanggotaan'];
$total_harga = $bayar->hitungTotalHarga($id_transaksi);

switch ($cekDiscount) {
    case 'SILVER':
        $discount = $total_harga * 0.15;
        break;
    case 'GOLD':
        $discount = $total_harga * 0.20;
        break;
    case 'PLATINUM':
        $discount = $total_harga * 0.25;
        break;
    default:
        $discount = 0;
        break;
}
//proses memasukan data ke tabel bayar
if (isset($_POST['bayar'])) {
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $hargaSeluruh = $total_harga - $discount;
    $kembalian = $jumlah_bayar - $hargaSeluruh;

    if ($jumlah_bayar >= $total_harga) {
        $id_bayar = $bayar->simpanPembayaran($id_transaksi, $hargaSeluruh, $jumlah_bayar, $kembalian, $discount);
        echo "<script>window.location.href ='index.php?page=struk&act=total&id_struk=$id_bayar'</script>";
    } else {
        $error = $bayar->getError();
    }
}
?>
<br>
<?php
if (isset($error)) {
    echo "<div class='card-body'> 
            <div class='alert alert-danger alert-dismissible show fade'>
                <div class='alert-body'>
                    <button class='close' data-dismiss='alert'>
                        <span>&times;</span>
                    </button>
                        Uang Yang Dimasukan Tidak Cukup, Pastikan Memiliki Uang Yang Cukup Untuk Membayar
                </div>
            </div>
        </div>";
}
?>
<br>
<div class="row">
    <div class="col-10 col-sm-6 col-md-4 col-lg-4 offset-lg-4">
        <div class="card">
            <h3 class="text-center">Total Harga</h3>
            <h3 class="text-center">Rp.<?= number_format($total_harga) ?></h3>
            <form method="POST">
                <div class="form-group">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Jumlah Uang</label>
                            <input min="1" type="number" name="jumlah_bayar" autofocus required class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" name="bayar">
                                Bayar
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>