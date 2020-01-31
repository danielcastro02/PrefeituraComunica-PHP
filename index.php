<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>


<html>
<head>
    <meta charset="UTF-8">

    <?php
    include_once './Base/header.php';
    ?>
    <title><?php echo $parametros->getNomeEmpresa(); ?></title>
<body class="homeimg">
<?php
include_once './Base/iNav.php';
?>
<main>
    <?php
    if(isset($_SESSION['logado'])) {
        if ($logado->getAdministrador() > 0) {
            ?>
            <div class="row center">
                <a class="btn corPadrao2" href="./Tela/enviarNotificacao.php">Enviar Aviso!</a>
            </div>
            <?php
        }
    }
    ?>
</main>

<script>
    $('.modal').modal();
</script>

<?php
include_once './Base/footer.php';
?>
</body>
</html>

