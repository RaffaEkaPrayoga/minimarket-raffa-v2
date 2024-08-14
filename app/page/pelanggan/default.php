<?php
include "../database/class/pelanggan.php";
include "../database/class/page.php";

$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {
    case 'create':
        include('page/pelanggan/add.php');
        break;
    case 'edit':
        include('page/pelanggan/edit.php');
        break;
    case 'delete':
        include('page/pelanggan/hapus.php');
        break;
    default:
        include('page/pelanggan/index.php');
}
