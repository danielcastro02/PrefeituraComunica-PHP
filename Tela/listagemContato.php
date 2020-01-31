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
            include_once '../Controle/contatoPDO.php';
            include_once '../Modelo/Contato.php';
            include_once '../Modelo/Parametros.php';
            $parametros = new parametros();
            $contatoPDO = new contatoPDO();
        ?>
        <title><?php echo $parametros->getNomeEmpresa(); ?></title>
        
        <body class="homeimg">
        <?php
        include_once '../Base/navBar.php';
        ?>
        <main>
            <div class="row " style="margin-top: 5vh;">
                <table class=" card col s10 offset-s1 center">
                <h4 class='center'>Listagem Contato</h4>
                    <tr class="center">

                        <td class='center'>Id_contato</td>
                        <td class='center'>Id_usuario</td>
                        <td class='center'>Motivo</td>
                        <td class='center'>Mensagem</td>
                        <td class='center'>Editar</td>
                        <td class='center'>Excluir</td>
                    </tr>
                    <?php
                    $stmt = $contatoPDO->selectContato();
                        
                    if ($stmt) {
                        while ($linha = $stmt->fetch()) {
                            $contato = new contato($linha);
                            ?>
                        <tr>
                            <td class="center"><?php echo $contato->getId_contato()?></td>
                            <td class="center"><?php echo $contato->getId_usuario()?></td>
                            <td class="center"><?php echo $contato->getMotivo()?></td>
                            <td class="center"><?php echo $contato->getMensagem()?></td>
                            <td class = 'center'><a href="./editarContato.php?id=<?php echo $contato->getid_contato()?>">Editar</a></td>
                            <td class="center"><a href="../Controle/contatoControle.php?function=deletar&id=<?php echo $contato->getid_contato()?>">Excluir</a></td>
                        </tr>
                                <?php
                        }
                    }
                    ?>
                    </table>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
    </body>
</html>

