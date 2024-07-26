<?php
include '../database/class/bayar.php';

$act = isset($_GET["act"]) ? $_GET["act"] : null;
switch ($act) {
    case 'pembayaran':
        include('pembayaran.php');
        break;

    case 'total':
        include('index.php');
        break;

    default:
        include('index.php');
}
