<?php
if ($currentUser['level'] != 1) {
    echo "<script>
       window.location = 'index.php?alert=err2';
    </script>";
    exit;
}
$pdo = Koneksi::connect();
$crudUser = user::getInstance($pdo);

$id_user = $_GET['id'];

if ($crudUser->delete($id_user) == true) {
    echo "<script>window.location.href = 'index.php?page=user&alert=hapus'</script>";
}
