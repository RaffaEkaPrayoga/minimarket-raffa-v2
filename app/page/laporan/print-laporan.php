<?php
// require_once __DIR__ . '/../vendor/autoload.php';
require '../vendor/autoload.php';
include '../database/class/Koneksi.php';
include '../database/class/Laporan.php';

// Pastikan ekstensi gd sudah diaktifkan
if (!extension_loaded('gd')) {
    die('Ekstensi GD tidak ditemukan.');
}

$pdo = Koneksi::connect();
$laporan = Laporan::getInstance($pdo);

$nota = $_GET['invoice'];
if (!isset($nota)) {
    echo '<script>alert("Data Tidak Ditemukan");history.go(-1);</script>';
    exit();
}

$detail_laporan = $laporan->getDetailLaporan($nota);
$data_produk = $laporan->getProdukByNota($nota);

$toko = 'Minimarket Raffa';
$alamat = 'Jalan Pattimura No.115 Kec. Sail Kota. Pekanbaru - Riau';
$telp = '08127723443';

$content = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .main-content {
            padding: 20px;
        }
        .section-header {
            text-align: center;
            margin-top: -20px   ;
        }
        .card {
            border: 1px solid #dee2e6;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #dee2e6;
        }
        th {
            background-color: #f8f9fa;
            color: #495057;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .bg-light {
            background-color: #f8f9fa;
        }
        hr {
            border: 0;
            border-top: 1px solid #dee2e6;
            margin: 20px 0;
        }
        .flex-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .flex-item {
            flex: 1;
            margin-right: 20px;
        }
        .flex-item:last-child {
            margin-right: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="main-content">
            <div class="section">
                <div class="section-header">
                    <h1>' . $toko . '</h1>
                    <p>' . $alamat . '</p>
                    <p>Telepon : ' . $telp . '</p>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="flex-container">
                            <div class="flex-item">
                                <h3>Invoice : ' . $nota . '</h3>
                                <p>Kasir : ' . $_SESSION['ssUser'] . '</p>
                                <p>Tanggal : ' . $detail_laporan['tgl_sub'] . '</p>
                            </div>
                            <div class="flex-item">
                                <p>Nama : ' . $detail_laporan['nama_pelanggan'] . '</p>
                                <p>Telepon : ' . $detail_laporan['telepon_pelanggan'] . '</p>
                                <p>Alamat : ' . $detail_laporan['alamat_pelanggan'] . '</p>
                            </div>
                        </div>
                        <hr>
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>';

$no = 1;
foreach ($data_produk as $d) {
    $total = $d['quantity'] * $d['harga_jual'];
    $content .= '
        <tr>
            <td>' . $no++ . '</td>
            <td>' . $d['nama_produk'] . '</td>
            <td>' . $d['quantity'] . '</td>
            <td>Rp. ' . ribuan($d['harga_jual']) . '</td>
            <td>Rp. ' . ribuan($total) . '</td>
        </tr>';
}

$content .= '
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" style="text-align: right; font-weight: bold;">Total :</th>
                                    <th style="font-weight: bold;">Rp. ' . ribuan($detail_laporan['totalbeli']) . '</th>
                                </tr>
                                <tr>
                                    <th colspan="4" style="text-align: right; font-weight: bold;">Bayar :</th>
                                    <th style="font-weight: bold;">Rp. ' . ribuan($detail_laporan['pembayaran']) . '</th>
                                </tr>
                                <tr>
                                    <th colspan="4" style="text-align: right; font-weight: bold;">Kembali :</th>
                                    <th style="font-weight: bold;">Rp. ' . ribuan($detail_laporan['kembalian']) . '</th>
                                </tr>
                            </tfoot>
                        </table>
                        <hr>
                        <p style="font-weight: bold;">Catatan : ' . $detail_laporan['catatan'] . '</p>
                    </div>
                </div>
            </div>
            <h3 align="center">* Terima Kasih Telah Berbelanja Di Toko Kami *</h3>
        </div>
    </div>
</body>
</html>
';




$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($content);
$mpdf->Output();