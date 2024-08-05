<?php
if ($currentUser['level'] != 1) {
  echo "<script>window.location = 'index.php?alert=err2';</script>";
  exit;
}

$pdo = Koneksi::connect();
$pembelian = Pembelian::getInstance($pdo);

if (isset($_POST["tambah"])) {
  $supplier = htmlspecialchars($_POST['id_supplier']);
  $produk = htmlspecialchars($_POST['id_produk']);
  $jumlah = htmlspecialchars($_POST['jumlah_pembelian']);

  if (empty($supplier) || empty($produk) || empty($jumlah)) {
    echo '<script>window.location="index.php?page=pembelian&act=create&alert=err1"</script>';
  } else {
    if ($pembelian->tambahPembelian($supplier, $produk, $jumlah)) {
      echo "<script>window.location.href = 'index.php?page=pembelian&alert=success1'</script>";
    } else {
      echo "Gagal menambahkan pembelian.";
    }
  }
}
?>

<div class="main-content" style="padding-left: 0px; padding-right:0;">
  <div class="section">
    <div class="section-header" style="margin-left:0px; margin-right:0px; border-radius: 10px;">
      <h1>Pembelian</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="index.php?page=pembelian">Pembelian</a></div>
        <div class="breadcrumb-item">Tambah Pembelian</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-4 col-md-8 col-lg-12">
          <div class="card">
            <form method="post">
              <div class="card-header">
                <h4>Tambah Data Pembelian</h4>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="supplier">Supplier:</label>
                  <select class="form-control" id="supplier" name="id_supplier">
                    <option value="" selected>-- Pilih Supplier --</option>
                    <?php
                    $suppliers = $pembelian->getSupplier();
                    foreach ($suppliers as $supplier) {
                      echo "<option value='" . htmlspecialchars($supplier['id_supplier']) . "'>" . htmlspecialchars($supplier['nama_supplier']) . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="produk">Produk:</label>
                  <select class="form-control" id="produk" name="id_produk">
                    <option value="" selected>-- Pilih Produk --</option>
                    <?php
                    $products = $pembelian->getProduk();
                    foreach ($products as $product) {
                      echo "<option value='" . htmlspecialchars($product['idproduk']) . "'>" . htmlspecialchars($product['nama_produk']) . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="jumlah">Jumlah Pembelian:</label>
                  <input type="text" class="form-control" id="jumlah" name="jumlah_pembelian" required>
                </div>
                <button type="submit" name="tambah" class="btn btn-primary">Tambah Pembelian</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    </section>
  </div>