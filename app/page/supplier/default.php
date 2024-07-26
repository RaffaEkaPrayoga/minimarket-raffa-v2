<?php
include "../database/class/supplier.php";
include "../database/class/page.php";

$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {
    case 'create':
        include('page/supplier/add.php');
        break;
    case 'edit':
        include('page/supplier/edit.php');
        break;
    case 'delete':
        include('page/supplier/hapus.php');
        break;
    default:
        include('index.php');
}
