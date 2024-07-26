<?php
$pdo = Koneksi::connect();
$supplier = Supplier::getInstance($pdo);

$id_supplier = isset($_GET['id_supplier']) ? $_GET['id_supplier'] : null;

if (isset($_POST["edit"])) {
  $nama_supplier = htmlspecialchars($_POST['nama_supplier']);
  $alamat_supplier = htmlspecialchars($_POST['alamat_supplier']);
  $telepon_supplier = htmlspecialchars($_POST['telepon_supplier']);

  if (empty($nama_supplier) || empty($alamat_supplier) || empty($telepon_supplier)) {
    echo '<script>window.location="index.php?page=supplier&act=edit&alert=err1&id_supplier=' . $id_supplier . '"</script>';
  } else if ($supplier->update($id_supplier, $nama_supplier, $alamat_supplier, $telepon_supplier)) {
    echo "<script>window.location.href = 'index.php?page=supplier&alert=success2'</script>";
  } else {
    echo "Gagal mengubah supplier.";
  }
}

$sup = $supplier->getID($id_supplier);
?>

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Supplier</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="index.php?page=supplier">Supplier</a></div>
        <div class="breadcrumb-item">Edit Supplier</a></div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-4 col-md-8 col-lg-12">
          <div class="card">
            <form method="post">
              <div class="card-header">
                <h4>Edit Data Supplier</h4>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama_supplier" class="form-control" value="<?= $sup['nama_supplier']; ?>">
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea name="alamat_supplier" class="form-control"><?= $sup['alamat_supplier']; ?></textarea>
                </div>
                <div class="form-group">
                  <label>Telepon</label>
                  <input type="tel" name="telepon_supplier" class="form-control" value="<?= $sup['telepon_supplier']; ?>">
                </div>
                <div class="card-footer text-right">
                  <button class="btn btn-primary mr-1" type="submit" name="edit">Edit</button>
                  <button class="btn btn-secondary" type="reset">Reset</button>
                </div>
            </form>
          </div>
        </div>
      </div>
  </section>
</div>