<?php

if (!isset($_SESSION)) {
    session_start();
}

if (realpath('./index.php')) {
    include_once './Controle/contatoPDO.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/contatoPDO.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/contatoPDO.php';
        }
    }
}

$classe = new contatoPDO();

if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    $classe->$metodo(); 
}

