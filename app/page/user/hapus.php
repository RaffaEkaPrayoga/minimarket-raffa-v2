<?php
$pdo = Koneksi::connect();
$crudUser = user::getInstance($pdo);
$id_user = $_GET['id'];

if ($crudUser->delete($id_user) == true) {
    echo "<script>window.location.href = 'index.php?page=user'</script>";
}
