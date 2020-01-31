<?php
//Define em que nivel de pasta estamos para fazer include de qualquer lugar
$pontos = "";
if(!isset($_SESSION)){
    session_start();
}
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
include_once __DIR__."/../Modelo/Parametros.php";
$parametros = new parametros();

//numeruzinho da versão pra att o cache
$numeruzinho = 3;
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<link rel="stylesheet" href="<?php echo $pontos; ?>css/materialize.css?v=<?php echo $numeruzinho; ?>">
<link rel="stylesheet" href="<?php echo $pontos; ?>css/custom.css?v=<?php echo $numeruzinho; ?>">
<link rel="stylesheet" href="<?php echo $pontos; ?>css/tabela-responsiva.css?v=<?php echo $numeruzinho; ?>">
<link rel="shortcut icon" href="<?php echo $pontos; ?>/<?php echo $parametros->getLogo() ?>?v=<?php echo $numeruzinho; ?>">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script type="text/javascript" src="<?php echo $pontos; ?>js/jquery-3.3.1.min.js?v=<?php echo $numeruzinho; ?>"></script>
<script type="text/javascript" src="<?php echo $pontos; ?>js/materialize.js?v=<?php echo $numeruzinho; ?>"></script>
<script type="text/javascript" src="<?php echo $pontos; ?>js/chart.bundle.min.js?v=<?php echo $numeruzinho; ?>" ></script>
<script type="text/javascript" src="<?php echo $pontos; ?>js/mascaras.js?v=<?php echo $numeruzinho; ?>" ></script>
<script type="text/javascript" src="<?php echo $pontos; ?>js/helpers.js?v=<?php echo $numeruzinho; ?>" ></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>