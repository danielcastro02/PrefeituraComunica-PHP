<?php

include_once __DIR__."/../Modelo/Parametros.php";
class PDOBase
{


    protected function addToast(string $toast){
        $_SESSION['toast'][] = $toast;
    }

    protected function log(string $content , string $file = "./logEmergence"){
        $data = new DateTime();
        file_put_contents($file , "
".$data->format("d/m/Y H/i/s - - -").$content , FILE_APPEND);
    }
}