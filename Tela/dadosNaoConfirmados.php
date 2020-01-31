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
        include_once '../Base/header.php';
        include_once '../Modelo/Parametros.php';
        $parametros = new parametros();
        ?>
        <title><?php echo $parametros->getNomeEmpresa(); ?></title>
        
    <body class="homeimg">
        <?php
        include_once '../Base/iNav.php';
        ?>
        <main>
            <div class="row center">
                <h5>Oops!</h5>

            </div>

            <?php
            if (isset($_GET['email'])) {
                if ($_GET['email'] == 0) {
                    ?>
                    <div class="row center">
                        <div class="col l6 m8 s10 offset-l3 offset-m2 offset-s1 card">

                            <p>Seu e-mail ainda não foi confirmado! Não esqueça de verificar sua caixa de spam!</p>
                            <form action="../Controle/usuarioControle.php?function=reenviaEmail" method="POST" id="">
                                <div class="input-field container">
                                    <button class="btn waves-effect  corPadrao2" type="submit">Reenviar E-mail</button>
                                    <a class="btn waves-effect  corPadrao3" href="./confirmaCadastro.php">Alterar E-mail</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php
                }
            }
            if (isset($_GET['telefone'])) {
                if ($_GET['telefone'] == 0) {
                    ?><div class="row center">
                        <div class="col l6 m8 s10 offset-l3 offset-m2 offset-s1 card">
                            <p>Seu telefone ainda não foi confirmado!</p>
                            <form action="../Controle/usuarioControle.php?function=reenviaSMS" method="POST" id="">
                                <div class="input-field container">
                                    <button class="btn waves-effect  corPadrao2" type="submit">Reenviar SMS</button>
                                    <a class="btn waves-effect  corPadrao3" href="./alterarTelefone.php">Alterar Celular</a>
                                </div>
                            </form>
                        </div>
                    </div><?php
                }
            }
            ?>
        </main>
        <?php

        include_once '../Base/footer.php';
        ?>

        <script>

        </script>
    </body>
</html>

