<?php
if ($currentUser['level'] != 1) {
  echo "<script>window.location = 'index.php?alert=err2';</script>";
  exit;
}

$pdo = Koneksi::connect();

if (isset($_POST["submit"])) {
  $nama_supplier = htmlspecialchars($_POST['nama_supplier']);
  $alamat_supplier = htmlspecialchars($_POST['alamat_supplier']);
  $telepon_supplier = htmlspecialchars($_POST['telepon_supplier']);

  $supplier = Supplier::getInstance($pdo);

  if (empty($nama_supplier) || empty($alamat_supplier) || empty($telepon_supplier)) {
    echo '<script>window.location="index.php?page=supplier&act=create&alert=err1"</script>';
  } else if ($supplier->tambah($nama_supplier, $alamat_supplier, $telepon_supplier)) {
    echo "<script>window.location.href = 'index.php?page=supplier&alert=success1'</script>";
  } else {
    echo "Gagal menambahkan supplier.";
  }
}
?>

<div class="main-content" style="padding-left: 0px; padding-right:0;">
  <div class="section">
    <div class="section-header" style="margin-left:0px; margin-right:0px; border-radius: 10px;">
      <h1>Supplier</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="index.php?page=supplier">Supplier</a></div>
        <div class="breadcrumb-item">Tambah Supplier</a></div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-4 col-md-8 col-lg-12">
          <div class="card">
            <form method="post">
              <div class="card-header">
                <h4>Tambah Data Supplier</h4>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama_supplier" class="form-control">
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea name="alamat_supplier" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <label>Telepon</label>
                  <input type="tel" name="telepon_supplier" class="form-control">
                </div>
                <div class="card-footer text-right">
                  <button class="btn btn-primary mr-1" type="submit" name="submit">Submit</button>
                  <button class="btn btn-secondary" type="reset">Reset</button>
                </div>
            </form>
          </div>
        </div>
      </div>
      </section>
    </div>