<?php
include_once '../Base/requerAdm.php';
include_once '../Modelo/Usuario.php';
include_once '../Controle/usuarioPDO.php';

$usuarioPDO = new UsuarioPDO();
$stmt = $usuarioPDO->pesquisaListagem($_GET['pesquisa']);

if ($stmt) {
    while ($linha = $stmt->fetch()) {
        $usuario = new usuario($linha);
        if ($usuario->getDeletado() != 1) {
            ?>
            <li>
                <div class="collapsible-header">
                    <div class="left-align" style="background-image: url('<?php echo $usuario->getIs_foto_url()==1? $usuario->getFoto() : $pontos . $usuario->getFoto(); ?>'); 
                         float: left;
                         margin: 0 8px 0 -5px;
                         border-radius: 50%;
                         height: 25px; width: 25px;
                         background-position: center;
                         background-size: cover;
                         background-position: center;
                         background-repeat: no-repeat;
                         object-fit: cover;
                         object-position: center;
                         ">
                    </div>
                    <?php echo $usuario->getNome(); ?>
                </div>
                <div class="collapsible-body grey lighten-4">
                    <span class="bold">CPF: </span> 
                    <span><?php
                        if ($usuario->getCpf() != "") {
                            $vetCPF = explode(".", $usuario->getCpfPontuado());
                            echo $vetCPF[0] . ".***.***-**";
                        } else {
                            echo '***.***.***-**';
                        }
                        ?>
                    </span>
                    <p>
                        <span class="bold">Email: </span>
                        <span><?php echo $usuario->getEmail() ?></span>
                    </p>
                    <p>
                        <span class="bold">Telefone: </span>
                        <span class="telefone"><?php echo $usuario->getTelefone() ?></span>
                    </p>

                    <p class="center-align">
                        <a class='btn waves-effect  corPadrao2' href='../Tela/agendaTerceiro.php?id_usuario=<?php echo $usuario->getId_usuario() ?>'>Agendar</a>
                        <a class="btn waves-effect  red darken-3 hide-on-large-only hide-on-small-and-down" href="#!" onclick="excluir(<?= $usuario->getId_usuario() ?>)">Excluir</a>

                    </p>
                    <p class="center hide-on-med-and-up">
                        <a class="btn waves-effect  red darken-3" href="#!" onclick="excluir(<?= $usuario->getId_usuario() ?>)">Excluir</a>
                    </p>
                </div>
            </li>
            <?php
        }
    }
}
?>

<script>
    $(".telefone").mask("(00) 00000-0000");
</script>
