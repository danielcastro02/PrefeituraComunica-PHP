<?php

if (!isset($_SESSION)) {
    session_start();
}

if (realpath('./index.php')) {
    include_once './Controle/emailPDO.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/emailPDO.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/emailPDO.php';
        }
    }
}

$classe = new emailPDO();

if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    $classe->$metodo();
}

