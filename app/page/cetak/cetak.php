<?php
require_once "../vendor/autoload.php";
include "../database/class/bayar.php";

$id_struk = $_GET["id_struk"];

$pdo = Koneksi::connect();
$bayar = Pembayaran::getInstance($pdo);
$cek = $bayar->getBayar($id_struk);
$get = $bayar->getTransaksi($cek["id_transaksi"]);
$rows = $bayar->getStruk($cek["id_transaksi"]);
$mpdf = new \Mpdf\Mpdf();
?>

<?php
$html = '<!DOCTYPE html>
<html lang="en">
    <head>
        <title>ZKasir</title>
        <link rel="stylesheet" href="../assets/css/custom.css">
    </head>
        <body>
        <div class="cartu">
            <h5 class="zkasir">ZKASIR</h5>
            <hr>
            <h2 class="struk">Struk Transaksi</h2>
            <div class="letakTgl">' . $get["tanggal_transaksi"] . '</div>
            <div>
                <p>ID transaksi : ' . $cek["id_transaksi"] . ' </p>
                <p>ID Pembayaran : ' . $id_struk . ' </p>
            </div>
            <hr>
            <table align="center" cellspacing="0" cellpadding="10">
            <tr>
            <th class="thSize" width="8cm">Nama Product</th>
            <th class="thSize" width="2cm">Jumlah</th>
            <th class="thSize" width="5cm">Harga Satuan</th>
            <th class="thSize" width="4cm">Total</th>
            </tr>';

foreach ($rows as $row) {

    $html .= '
        <tr>
                <td class="tdSize" align="center"> ' . $row["nama_produk"] . '</td>
                <td class="tdSize" align="center">' . $row["qty"] . '</td>
                <td class="tdSize" align="center">Rp. ' . number_format($row["harga_produk"]) . '</td>
                <td class="tdSize" align="center">Rp. ' . number_format($row["qty"] * $row["harga_produk"]) . '</td>
        </tr>';
}

$html .= '
</table>
<hr>
<hr>
<table class="bolder" align="center" cellspacing="0" cellpadding="10">
<tr>
    <th class="thSize" width="10cm">Harga</th>
    <th class="thSize" width="10cm">Rp.' . number_format($cek["total_harga"]  + $cek["discount"]) . '</th>
</tr>
<tr>
    <th class="thSize">Discount</th>
    <th class="thSize">Rp.' . number_format($cek["discount"]) . '</th>
</tr>
<tr>
    <th class="thSize">Total Harga</th>
    <th class="thSize">Rp.' . number_format($cek["total_harga"]) . '</th>
</tr>


<tr>
    <th class="thSize">Uang</th>
    <th class="thSize">Rp.' . number_format($cek["jumlah_bayar"]) . '</th>
</tr>

<tr>
    <th class="thSize">Kembalian</td>
    <th class="thSize">Rp.' . number_format($cek["kembalian"]) . '</th>
</tr>
</table>

        <hr>
        <div>
            <h5 style+"font-style: italic;" align="center">
                Terimakasih Telah Berbelanja Disini
            </h5>

        </div>
    </div>
    </body>
</html>
';

$mpdf->WriteHTML($html);
$mpdf->Output();
