<?php
$pdo = Koneksi::connect();
$supplier = Supplier::getInstance($pdo);

if (isset($_GET['id_supplier'])) {
    $id_supplier = $_GET['id_supplier'];
    if ($supplier->delete($id_supplier)) {
        echo "<script>window.location.href = 'index.php?page=supplier&alert=success2'</script>";
    } else {
        echo "Gagal menghapus supplier.";
    }
}
