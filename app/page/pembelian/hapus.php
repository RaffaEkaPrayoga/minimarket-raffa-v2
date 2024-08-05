<?php
if ($currentUser['level'] != 1) {
    echo "<script>window.location = 'index.php?alert=err2';</script>";
    exit;
}

$pdo = Koneksi::connect();
$pembelian = Pembelian::getInstance($pdo);

$id_pembelian = isset($_GET['id_pembelian']) ? $_GET['id_pembelian'] : null;

if ($id_pembelian && $pembelian->hapusPembelian($id_pembelian)) {
    echo "<script>window.location.href = 'index.php?page=pembelian&alert=hapus'</script>";
} else {
    echo "Gagal menghapus pembelian.";
}