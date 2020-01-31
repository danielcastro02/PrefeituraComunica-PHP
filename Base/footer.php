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
include_once $pontos . 'Modelo/Parametros.php';
include_once $pontos . 'Base/toast.php';
$parametros = new parametros();
?>


<div class="divider grey lighten-1" style="height: 2px;"></div>
<div class="center white preFooter" style="width: 100%;">
    <div class="row">
        <div class="">
            <br>
            <div class="row">
                <div class="col s3 mostr" style="display: none;"></div>
                <div class="esc">
                    <div class="col s5 l3 offset-l3">
                        <a href="<?php echo $parametros->getLinkApp() ?>" target="_blank">
                            <img class="responsive-img" src="<?php echo $pontos ?>Img/playStore.png"
                                 style="max-height: 50px; max-width: 130px; height:auto; width: auto; margin-top: 30px">
                        </a>
                    </div>
                </div>

                <div class="col s7 l3">
                    <?php if ($parametros->getIs_foto() == 1) { ?>
                        <img class="responsive-img "
                             src="<?php echo $pontos . $parametros->getLogo() . '?' . $numeruzinho; ?>"
                             style="max-height: 100px; max-width: 200px; height:auto; width: auto;">
                        <?php
                    } else {
                        ?>
                        <h5><?php echo $parametros->getNome_empresa(); ?></h5>
                    <?php } ?>
                </div>
            </div>
            <div class="col s3 mostr" style="display: none;"></div>
            <div class="col s5 l3 offset-l3 esc">
                <img class="responsive-img" src="<?php echo $pontos . $parametros->getQrApp() ?>"
                     style="max-height: 100px; max-width: 130px; height:auto; width: auto;">
            </div>
            <div class="col s7 l3">
                <h5 class="black-text " style="font-size: 110%;"><?php echo $parametros->getTelefones(); ?></h5>
                <h class="black-text "><?php echo $parametros->getRuaNumero(); ?></h>
                <br>
                <h class="black-text "><?php echo $parametros->getCidade() . " | " . $parametros->getEstado(); ?></h>
                <br>
                <h class="black-text "><?php echo $parametros->getEmailContato(); ?></h>
            </div>
            <div class="hide-on-large-only"><br></div>
        </div>
    </div>
</div>
<div class="divider grey lighten-3" style="height: 2px;"></div>

<footer class="center grey lighten-4">
    <div class="footer-copyright black-text"><a target="_blank" href="http://markeyvip.com"
                                                class="center col l10 s12 offset-l1 black-text">
           Desenvolvido pela comunidade</a>
    </div>
</footer>


<!--Codigo que realiza os loaders-->
<div id="preLoader"
     style="z-index: 214748364; position: fixed; height: 100vh; width: 100vw; background-color: white; opacity: 0.7; ; top: 0; left: 0; display: none;">
    <div style="display: block; position: fixed; left: calc(50% - 32px); top:calc(50% - 32px); opacity: 1;">
        <div class="preloader-wrapper big active">
            <div class="spinner-layer spinner-blue-only">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.onbeforeunload = function () {
        $("#preLoader").show();
    };
    $(".formLoader").submit(function () {
        var x = true;
        $(this).find('input[required=true]').each(function () {
            if (!$(this).val()) {
                x = false;
            }
        });
        if (x == true) {
            $("#preLoader").show();
        }
    });
    $(".initLoader").click(function () {
        $("#preLoader").show();
    });
    if (interfaceAndroid != undefined) {
        $(".esc").hide();
        $(".mostr").show();
    }

</script>
<input id="malditosPontos" value="<?php echo $pontos ?>" hidden/>
<?php
if (isset($_SESSION)) {
    if (isset($_SESSION['logado'])) {
        if ($parametros->getActiveChat() == 1) {
            include_once __DIR__ . "/chat2.php";
        }
    }
}
?>

<div id="testeDeNotifcacao" style="display: none"></div>

<script src="<?php echo $pontos; ?>js/notificationService.js">


</script>

