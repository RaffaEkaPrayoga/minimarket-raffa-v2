<?php
if ($currentUser['level'] === 3) {
   echo "<script>
       window.location = 'index.php?alert=err2';
    </script>";
   exit;
}

$pdo = Koneksi::connect();

if (isset($_POST["submit"])) {
$nama_pelanggan = htmlspecialchars($_POST['nama_pelanggan']);
$alamat_pelanggan = htmlspecialchars($_POST['alamat_pelanggan']);
$telepon_pelanggan = htmlspecialchars($_POST['telepon_pelanggan']);

$pelanggan = pelanggan::getInstance($pdo);

if (empty($nama_pelanggan) || empty($alamat_pelanggan) || empty($telepon_pelanggan)) {
echo '<script>
   window.location = "index.php?page=pelanggan&act=create&alert=err1"
</script>';
} else if ($pelanggan->tambah($nama_pelanggan, $alamat_pelanggan, $telepon_pelanggan)) {
//untuk mendapatkan id pembeli yang terakhir kali dimasukkan
$id_pelanggan = $pdo->lastInsertId();
echo "<script>
   window.location.href = 'index.php?page=pelanggan&alert=success1'
</script>";
} else {
echo "Gagal menambahkan pelanggan.";
}
}
?>

<div class="main-content" style="padding-left: 0px; padding-right:0;">
   <div class="section">
      <div class="section-header" style="margin-left:0px; margin-right:0px; border-radius: 10px;">
         <h1>Pelanggan</h1>
      </div>

      <div class="row">
         <div class="col-12 col-md-20 col-lg-20">
            <div class="card">
               <form method="post">
                  <div class="card-header">
                     <h4>Tambah Pelanggan</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="form-group col-md-6">
                           <label>Nama</label>
                           <input type="text" autofocus autocomplete="off" class="form-control" name="nama_pelanggan">
                        </div>
                        <div class="form-group col-md-6">
                           <label>Alamat Pelanggan</label>
                           <input type="text" autocomplete="off" class="form-control" name="alamat_pelanggan">
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-6">
                           <label>Nomor Telepon</label>
                           <input type="text" autocomplete="off" class="form-control" name="telepon_pelanggan">
                        </div>
                     </div>
                     <br>
                     <div class="form-group">
                        <button class="btn btn-primary btn-lg btn-block" type="submit" name="submit">Submit</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>