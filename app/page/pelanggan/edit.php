<?php
$pdo = Koneksi::connect();
$pelanggan = pelanggan::getInstance($pdo);

$id_pelanggan = isset($_GET['id_pelanggan']) ? $_GET['id_pelanggan'] : null;

if (isset($_POST["edit"])) {
   $nama_pelanggan = htmlspecialchars($_POST['nama_pelanggan']);
   $alamat_pelanggan = htmlspecialchars($_POST['alamat_pelanggan']);
   $telepon_pelanggan = htmlspecialchars($_POST['telepon_pelanggan']);

   if (empty($nama_pelanggan) || empty($alamat_pelanggan) || empty($telepon_pelanggan)) {
      echo '<script>window.location="index.php?page=pelanggan&act=edit&alert=err1&id_pelanggan=' . $id_pelanggan . '"</script>';
   } else if ($pelanggan->update($id_pelanggan, $nama_pelanggan, $alamat_pelanggan, $telepon_pelanggan)) {
      echo "<script>window.location.href = 'index.php?page=pelanggan&alert=success2'</script>";
   } else {
      echo "Gagal mengedit pelanggan.";
   }
}

if ($id_pelanggan) {
   $data = $pelanggan->getID($id_pelanggan);
   if ($data) {
      extract($data);
   } else {
      echo "Data pelanggan tidak ditemukan.";
      // Optionally, redirect or show a message
      echo "<script>window.location.href = 'index.php?page=pelanggan'</script>";
   }
} else {
   echo "ID pelanggan tidak valid.";
}
?>

<div class="main-content" style="padding-left: 0px; padding-right:0;">
   <div class="section">
      <div class="section-header" style="margin-left:0px; margin-right:0px; border-radius: 10px;">
         <h1>Pelanggan</h1>
      </div>

      <div class="row">
         <div class="col-12 col-md-6 col-lg-8">
            <div class="card">
               <form method="post">
                  <div class="card-header">
                     <h4>Edit Pelanggan</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="form-group col-md-6">
                           <label>Nama</label>
                           <input type="text" autocomplete="off" class="form-control" name="nama_pelanggan" value="<?php echo isset($nama_pelanggan) ? $nama_pelanggan : ''; ?>">
                        </div>
                        <div class="form-group col-md-6">
                           <label>Alamat Pelanggan</label>
                           <input type="text" autocomplete="off" class="form-control" name="alamat_pelanggan" value="<?php echo isset($alamat_pelanggan) ? $alamat_pelanggan : ''; ?>">
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-6">
                           <label>Nomor Telepon</label>
                           <input type="text" autocomplete="off" class="form-control" name="telepon_pelanggan" value="<?php echo isset($telepon_pelanggan) ? $telepon_pelanggan : ''; ?>">
                        </div>
                     </div>
                     <div class="form-group">
                        <button class="btn btn-primary btn-lg btn-block" type="submit" name="edit">Edit</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>