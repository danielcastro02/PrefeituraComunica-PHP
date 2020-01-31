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
        <title><?php echo $parametros->getNomeEmpresa(); ?></title>
        
    <body class="homeimg">
        <?php
        include_once '../Base/navBar.php';
        ?>
        <main>
            <div class="row" style="margin-top: 10vh;">
                <form action="../Controle/contatoControle.php?function=inserirContato" class="card col l8 offset-l2 m10 offset-m1 s10 offset-s1" method="post">
                    <div class="row center">
                        <h4 class="textoCorPadrao2">Cadastrar Contato</h4>
                        <div class="input-field col s6">
                            <input type="text" name="id_usuario">
                            <label>id_usuario</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="motivo">
                            <label>motivo</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="mensagem">
                            <label>mensagem</label>
                        </div>
                    <div class="row center">
                        <a href="../index.php" class="corPadrao3 btn waves-effect ">Voltar</a>
                        <input type="submit" class="btn waves-effect  corPadrao2" value="Cadastrar">
                    </div>
                </form>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
    </body>
</html>

