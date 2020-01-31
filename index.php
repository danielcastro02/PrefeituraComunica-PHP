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
</main>

<script>
    $('.modal').modal();
</script>

<?php
include_once './Base/footer.php';
?>
</body>
</html>

