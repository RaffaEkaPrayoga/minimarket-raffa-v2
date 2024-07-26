<?php
$pdo = Koneksi::connect();
$user = Auth::getInstance($pdo);
if ($user->logout()) {
    echo "<script>window.location.href='index.php'</script>";
}
