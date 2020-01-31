<?php

$pontos = "";
if (realpath("./index.php")) {
    $pontos = './';
} else {
    if (realpath("../index.php")) {
        $pontos = '../';
    } else {
        if (realpath("../../index.php")) {
            $pontos = '../../';
        }
    }
}
if (!isset($_SESSION)) {
    session_start();
}
include_once $pontos . 'Modelo/Usuario.php';
include_once $pontos . 'Modelo/Quarto.php';
if (isset($_SESSION['logado'])) {
    $usuario = new usuario(unserialize($_SESSION['logado']));
    if ($usuario->getAdministrador() == 0) {

            $logado = $usuario;
            header('location: ' . $pontos . "Tela/acessoNegado.php");

    }else{
        $logado = $usuario;
    }
} else{
    header('location: ' . $pontos . "Tela/acessoNegado.php");
}
