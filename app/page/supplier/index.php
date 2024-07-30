<?php

$pdo = Koneksi::connect();

$supplier = Supplier::getInstance($pdo);
$paging = Page::getInstance($pdo, 'supplier');

if (isset($_POST['cari'])) {
  $key = htmlspecialchars($_POST['keyword']);
}
$suppliers = $paging->getData(@$key, 'nama_supplier');
$pages = $paging->getPageNumber();

if ($currentUser['level'] != 1) {
  echo "<script>
       window.location = 'index.php?alert=err2';
    </script>";
  exit;
} ?>

<!-- Main Content -->
<div class="main-content" style="padding-left: 0px; padding-right:0;">
  <div class="section">
    <div class="section-header" style="margin-left:0px; margin-right:0px; border-radius: 10px;">
      <h1>Suplier</h1>
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Tabel Suplier</h4>
              <a class="btn btn-primary" style="margin-left: 630px;" href="index.php?page=supplier&act=create"><i class="fa fa-plus"></i> Tambah Suplier</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-1">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Nama</th>
                      <th>Telepon</th>
                      <th>Alamat</th>
                      <th style="padding: 10px -30px">Operasi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    foreach ($suppliers as $sup) {
                    ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $sup['nama_supplier']; ?></td>
                        <td><?= $sup['telepon_supplier']; ?></td>
                        <td><?= $sup['alamat_supplier']; ?></td>
                        <td style="padding: 10px -30px;">
                          <a class="btn btn-sm btn-warning" href="index.php?page=supplier&act=edit&id_supplier=<?= $sup['id_supplier']; ?>" name="update">
                            <i class="fa fa-pen"></i> Edit
                          </a>
                          <a onclick="hapus(<?= $sup['id_supplier'] ?>)" class="btn btn-sm btn-danger text-light" name="hapus">
                            <i class="fa fa-trash"></i> Hapus
                          </a>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <div class="card-footer text-right">
                  <nav class="d-inline-block">
                    <ul class="pagination mb-0">
                      <li class="page-item ">
                        <a class="page-link" href="index.php?page=supplier&halaman=<?= $paging->prevPage(); ?>" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                      </li>
                      <?php
                      for ($i = 1; $i <= $pages; $i++) :
                        $halaman = isset($_GET['halaman']) ? $_GET['halaman'] : '';
                        if ($halaman == $i) {
                      ?>
                          <li class="page-item active">
                            <a class="page-link active" href="index.php?page=supplier&halaman=<?= $i; ?>"><?= $i; ?> </a>
                          </li>
                        <?php
                        } else {
                        ?>
                          <li class="page-item">
                            <a class="page-link active" href="index.php?page=supplier&halaman=<?= $i; ?>"><?= $i; ?> </a>
                          </li>
                      <?php
                        }
                      endfor;
                      ?>
                      <li class="page-item">
                        <a class="page-link" href="index.php?page=supplier&halaman=<?= $paging->nextPage(); ?>"><i class="fas fa-chevron-right"></i></a>
                      </li>
                      <?php
                      ?>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </section>
  </div>

  <script>
    function hapus(hapus_id) {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-primary mx-4',
          cancelButton: 'btn btn-danger mx-4'
        },
        buttonsStyling: false
      })

      swalWithBootstrapButtons.fire({
        title: 'Apakah anda yakin?',
        text: "Data kamu nggak bisa kembali lagi!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, menghapus !',
        cancelButtonText: 'Tidak, batal !',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          swalWithBootstrapButtons.fire(
            'Hapus!',
            'File kamu telah dihapus.',
            'success'
          )
          window.location = ("index.php?page=supplier&act=delete&id_supplier=" + hapus_id)
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          swalWithBootstrapButtons.fire(
            'Batal',
            'File kamu masih aman :)',
            'error'
          )
        }
      })
    }
  </script>