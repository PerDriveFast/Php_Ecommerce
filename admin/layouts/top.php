<?php include '../config/config.php';
include 'layouts/header.php';

$cur_page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);

if ($cur_page != 'login.php'):
    include 'layouts/nav.php';
    include 'layouts/sidebar.php';
endif;
