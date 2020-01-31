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
if(!isset($_SESSION)){
    session_start();
}
include_once $pontos . 'Modelo/Usuario.php';
include_once $pontos . 'Modelo/Quarto.php';
if (!isset($_SESSION['logado'])) {
    include_once $pontos . 'Base/navDeslogado.php';
} else {
    $usuario = new usuario(unserialize($_SESSION['logado']));

    if ($usuario->getAdministrador() == 0) {
        if (isset($_SESSION['quarto'])) {
            $quarto = new Quarto(unserialize($_SESSION['quarto']));
            if($quarto->getAtivo_quarto() == 1){
                include_once $pontos . "Base/navQuarto.php";
            }else{
                unset($_SESSION['quarto']);
                include_once $pontos."Base/navLogado.php";
            }
        } else {
            include_once $pontos . "Base/navLogado.php";
        }
    } else {
        include_once $pontos . "Base/navAdm.php";
    }
}