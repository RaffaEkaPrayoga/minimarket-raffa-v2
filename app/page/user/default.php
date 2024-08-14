<?php
include "../database/class/user.php";
include "../database/class/page.php";
$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {

    case 'create':
        include('add.php');
        break;
    case 'read':
        include('page/user/index.php');
        break;
    case 'edit':
        include('edit.php');
        break;
    case 'delete':
        include('hapus.php');
        break;
    case 'logout':
        include('userLogout.php');
        break;
    case 'change-Password':
        include('changePassword.php');
        break;
    case 'confirm-Password':
        include('confirmPassword.php');
        break;
    case 'lupa-Password':
        include('lupaPassword.php');
        break;
    default:
        include('page/user/index.php');
}
