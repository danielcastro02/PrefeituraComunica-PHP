<?php
include_once __DIR__."/../Modelo/Parametros.php";
class conexao {

    private static $con;

    public static function getConexao(): PDO {
        $parametros = new parametros();
        try {
            if (is_null(self::$con)) {
                self::$con = new PDO('mysql:host=localhost;dbname='.$parametros->getNomeDb(), $parametros->getNomeDb(), 'gabCd&fnx^t5bKhH', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            }
            return self::$con;
        } catch (Exception $e) {
            echo "<h1>FALHA GERAL CONTATE O SUPORTE contato@markeyvip.com</h1>";
            exit(0);
        }
    }

    public static function getTransactConnetion(): PDO {
        $parametros = new parametros();
        try {
//        return new PDO('mysql:host=localhost;dbname=markey', 'root', '');
            return new PDO('mysql:host=localhost;dbname='.$parametros->getNomeDb(), $parametros->getNomeDb(), 'gabCd&fnx^t5bKhH', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        } catch (Exception $e) {
            echo "<h1>FALHA GERAL CONTATE O SUPORTE contato@markeyvip.com</h1>";
            exit(0);
        }
    }

}
