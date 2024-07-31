<?php
include '../database/class/laporan.php';

$act = isset($_GET["act"]) ? $_GET["act"] : null;
switch ($act) {
    case 'laporan':
        include('laporan.php');
        break;

    case 'detail':
        include('detail.php');
        break;

    default:
        include('laporan.php');
}
