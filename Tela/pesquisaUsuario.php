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
            <tr class="hide-on-small-only">
                <td class="center" data-title="Nome"><?php echo $usuario->getNome() ?></td>
                <td class="center cpf" data-title="CPF"><?php echo $usuario->getCpf(); ?></td>
                <td class="center" data-title="Email"><?php echo $usuario->getEmail() ?></td>
                <td class="center telefone" data-title="Telefone"><?php echo $usuario->getTelefoneMascarado() ?></td>
                <td class='center'>
                    <a class='btn waves-effect  corPadrao2' href='../Tela/agendaTerceiro.php?id_usuario=<?php echo $usuario->getId_usuario() ?>'>Agendar</a>
                </td>
                <td class="center" data-title="Excluir"><a class="btn waves-effect  red darken-3" href="#!" onclick="excluir(<?= $usuario->getId_usuario() ?>)">Excluir</a></td>
            </tr>
            
            
            <?php
        }
    }
}
?>