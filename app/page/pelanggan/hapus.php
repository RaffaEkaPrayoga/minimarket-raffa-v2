<?php
$pdo = Koneksi::connect();
$pelanggan = Pelanggan::getInstance($pdo);

$id_pelanggan = $_GET['id_pelanggan'];

if ($pelanggan->delete($id_pelanggan)) {
        echo "<script>window.location.href = 'index.php?page=pelanggan&alert=hapus'</script>";
}
