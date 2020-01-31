<?php
if(!isset($_SESSION)){
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
        <title><?php echo $parametros->getNome_empresa(); ?></title> 
        
    <body class="homeimg">
        <?php
        include_once '../Base/iNav.php';
        ?>
        <main>
            <div class="row">
                <div class="col l6 m8 s10 offset-l3 offset-m2 offset-s1 card">
                    <h5>Alguns dados já estão cadastrados no sistema...</h5>
                    <?php
                    switch ($_GET['msg']) {
                        case 'telefone':
                            ?>
                            <p>O numero de celular ja está no nosso sistema! Confira o número de celular inserido ou prossiga para o 
                                <a href="../Tela/login.php">login</a> caso ja tenha um usuário.</p>
                            <div class="row center">
                                <a class="btn waves-effect  corPadrao3" href="<?php echo isset($_GET['update'])?"../Tela/perfil.php":"../Tela/registroUsuario.php" ?>">Voltar</a>
                                <a class="btn waves-effect  corPadrao2" href="../Tela/login.php">Identifique-se</a>
                            </div>
                            <?php
                            break;
                        case 'email':
                            ?>
                            <p>O E-mail ja está no nosso sistema! Confira o E-mail inserido ou prossiga para o 
                                <a href="../Tela/login.php">login</a> caso ja tenha um usuário.</p>
                            <div class="row center">
                                <a class="btn waves-effect  corPadrao3" href="<?php echo  isset($_GET['update'])?"../Tela/perfil.php":"../Tela/registroUsuario.php" ?>">Voltar</a>
                                <a class="btn waves-effect  corPadrao2" href="../Tela/login.php">Identifique-se</a>
                            </div>
                            <?php
                            break;
                        case 'cpf':
                            ?>
                            <p>Este CPF já está no nosso sistema!</p>
                            <div class="row center">
                                <a class="btn waves-effect  corPadrao3" href="<?php echo isset($_GET['update'])?"../Tela/perfil.php":"../Tela/registroUsuario.php" ?>">Voltar</a>
                            </div>
                            <?php
                            break;
                    }
                    ?>
                </div>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>

        <script>
            $("#telefone").mask("(00) 00000-0000");
        </script>
    </body>
</html>

