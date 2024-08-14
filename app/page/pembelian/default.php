<?php
include "../database/class/pembelian.php";
include "../database/class/page.php";

$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {
    case 'create':
        include('page/pembelian/add.php');
        break;
    case 'edit':
        include('page/pembelian/edit.php');
        break;
    case 'delete':
        include('page/pembelian/hapus.php');
        break;
    default:
        include('page/pembelian/index.php');
}
