<?php
$pdo = Koneksi::connect();
$pembelian = Pembelian::getInstance($pdo);

$id_pembelian = isset($_GET['id_pembelian']) ? intval($_GET['id_pembelian']) : null;

if (isset($_POST["edit"])) {
    $supplier = htmlspecialchars($_POST['supplier']);
    $produk = htmlspecialchars($_POST['produk']);
    $jumlah = htmlspecialchars($_POST['jumlah']);

    if (empty($supplier) || empty($produk) || empty($jumlah)) {
        echo '<script>window.location="index.php?page=pembelian&act=edit&alert=err1&id_pembelian=' . $id_pembelian . '"</script>';
    } else {
        if ($pembelian->updatePembelian($id_pembelian, $supplier, $produk, $jumlah)) {
            echo "<script>window.location.href = 'index.php?page=pembelian&alert=success2'</script>";
        } else {
            echo "Gagal mengedit pembelian.";
        }
    }
}

if ($id_pembelian) {
    $data = $pembelian->getID($id_pembelian);
    if ($data) {
        extract($data);
    } else {
        echo "Data pembelian tidak ditemukan.";
        echo "<script>window.location.href = 'index.php?page=pembelian'</script>";
    }
} else {
    echo "ID pembelian tidak valid.";
    echo "<script>window.location.href = 'index.php?page=pembelian'</script>";
}
?>

<div class="main-content" style="padding-left: 0px; padding-right:0;">
    <div class="section">
        <div class="section-header" style="margin-left:0px; margin-right:0px; border-radius: 10px;">
            <h1>Pembelian</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="index.php?page=pembelian">Pembelian</a></div>
                <div class="breadcrumb-item">Update Pembelian</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-4 col-md-8 col-lg-12">
                    <div class="card">
                        <form method="post">
                            <div class="card-header">
                                <h4>Update Data Pembelian</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="supplier">Supplier:</label>
                                    <select class="form-control" id="supplier" name="supplier">
                                        <option value="" selected>-- Pilih Supplier --</option>
                                        <?php
                                        $suppliers = $pembelian->getSupplier();
                                        foreach ($suppliers as $supplier) {
                                            $selected = ($data['id_supplier'] == $supplier['id_supplier']) ? "selected" : "";
                                            echo "<option value='" . htmlspecialchars($supplier['id_supplier']) . "' $selected>" . htmlspecialchars($supplier['nama_supplier']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="produk">Produk:</label>
                                    <select class="form-control" id="produk" name="produk">
                                        <option value="" selected>-- Pilih Produk --</option>
                                        <?php
                                        $products = $pembelian->getProduk();
                                        foreach ($products as $product) {
                                            $selected = ($data['idproduk'] == $product['idproduk']) ? "selected" : "";
                                            echo "<option value='" . htmlspecialchars($product['idproduk']) . "' $selected>" . htmlspecialchars($product['nama_produk']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah Pembelian:</label>
                                    <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?= htmlspecialchars($data['jumlah_pembelian']); ?>" required>
                                </div>
                                <button type="submit" name="edit" class="btn btn-primary">Edit Pembelian</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </div>