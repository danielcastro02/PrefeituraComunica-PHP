<?php

if (!isset($_SESSION)) {
    session_start();
}

if (realpath('./index.php')) {
    include_once './Controle/trocasenhaPDO.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/trocasenhaPDO.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/trocasenhaPDO.php';
        }
    }
}

$classe = new trocasenhaPDO();

if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    $classe->$metodo();
}

