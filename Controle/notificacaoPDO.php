<?php



include_once __DIR__ . '/../Modelo/Notificacao.php';
include_once __DIR__ . '/../Controle/conexao.php';
include_once __DIR__ . '/../Controle/agendamentoPDO.php';
include_once __DIR__ . '/../Controle/usuarioPDO.php';
include_once __DIR__ . '/../Controle/quartoPDO.php';
include_once __DIR__ . '/../Controle/reservavelPDO.php';
include_once __DIR__ . '/../Modelo/Quarto.php';
include_once __DIR__ . '/../Modelo/Usuario.php';
include_once __DIR__ . '/../Modelo/Agendamento.php';
include_once __DIR__.'/../Modelo/Parametros.php';

class notificacaoPDO
{

    function notificaAgendamento(agendamento $agendamento)
    {
        $agendamentoPDO = new agendamentoPDO();
        $agendamento = $agendamentoPDO->selectAgendamentoId_quartoPorOutrosDados($agendamento);
        $agendamento = new agendamento($agendamento->fetch());
        $quartoPDO = new QuartoPDO();
        $parametros = new parametros();
        $usuarioPDO = new UsuarioPDO();
        $stmtQuarto = $quartoPDO->selectQuartoId_usuario($agendamento->getId_reservavel());
        $stmtUsuario = $usuarioPDO->selectUsuarioId_usuario($agendamento->getId_usuario());
        $quarto = new Quarto($stmtQuarto->fetch());
        $usuario = new usuario($stmtUsuario->fetch());

        $notificacao = new Notificacao();
        $notificacao->setDestinatario($quarto->getToken(), $quarto->getIdQuarto());
        $notificacao->setTitle("Hora marcada");
        $notificacao->setBody("O cliente " . $usuario->getNome() . " marcou " . $servico->getNome() . " com você no dia " . $agendamento->getHora_marcadaDateTime()->format("d/m \à\s H:i"));
        if ($parametros->getConfirma_agendamento() == 0) {
            $notificacao->setUrlDestino("/Tela/listagemAgendamento.php");
        } else {
            $notificacao->setUrlDestino("/Tela/confirmaAgendamento.php?id_agendamento=" . $agendamento->getId_agendamento());
            $notificacao->setId_agendamento($agendamento->getId_agendamento());
        }
        $notificacao->send();
    }

    function novoUsuario(usuario $usuario)
    {
        $usuarioPDO = new UsuarioPDO();
        $notificacao = new Notificacao();
        $notificacao->setTitle("Novo usuário!");
        $notificacao->setBody("Novo usuário " . $usuario->getNome());
        $notificacao->setUrlDestino("/Tela/listagemUsuario.php");
        $notificacao->stmt2MulticastArray($usuarioPDO->selectUsuarioAdministrador('1'));
        $notificacao->send();
    }

    function notificaCancelamento(agendamento $agendamento)
    {
        $reservavelPDO = new reservavelPDO();
        $usuarioPDO = new UsuarioPDO();
        $reservavel = new Reservavel($reservavelPDO->selectReservavelIdReservavel($agendamento->getId_reservavel())->fetch());
        $stmtUsuario = $usuarioPDO->selectUsuarioId_usuario($agendamento->getId_usuario());
        $usuario = new usuario($stmtUsuario->fetch());
        $usuarios = $usuarioPDO->selectUsuarioAdministrador(1);
        $notificacao = new Notificacao();
        $notificacao->stmt2MulticastArray($usuarios);
        $notificacao->setTitle("Reserva Cancelada!");
        $notificacao->setBody("O cliente " . $usuario->getNome() . " cancelou a reserva no quarto " . $reservavel->getNome() . " do dia " . $agendamento->getHora_marcadaDateTime()->format("d/m/Y"));
        return $notificacao->send();
    }

    function notificaCancelamentoAdm(agendamento $agendamento)
    {
        $usuarioPDO = new UsuarioPDO();
        $reservavelPDO = new reservavelPDO();

        $stmtReservavel = $reservavelPDO->selectReservavelIdReservavel($agendamento->getId_reservavel());
        $quarto = new Reservavel($stmtReservavel->fetch());
        $stmtUsuario = $usuarioPDO->selectUsuarioId_usuario($agendamento->getId_usuario());
        $usuario = new usuario($stmtUsuario->fetch());
        $notificacao = new Notificacao();
        $notificacao->setDestinatario($usuario->getToken(), $usuario->getId_usuario());
        $notificacao->setTitle("Horario Cancelado!");
        $notificacao->setBody("Infelizmente sua reserva no quarto" . $quarto->getNome() . " do dia " . $agendamento->getHora_marcadaDateTime()->format("d/m \à\s H:i") . " foi cancelado!");
        $notificacao->setUrlDestino("/Tela/minhasReservas.php");
        return $notificacao->send();
    }

    function notificaPersonalizada()
    {
        $notificacao = new Notificacao($_POST);
        if (isset($_POST['destinatarios'])) {

            foreach ($_POST['destinatarios'] as $destinatario) {
                echo $destinatario . "<br>";
                $usuarioPDO = new UsuarioPDO();
                $usuario = $usuarioPDO->selectUsuarioToken($destinatario);
                $notificacao->addToMulticasArray($destinatario, $usuario->getId_usuario());
            }
        }
        $notificacao->send();
        header('location: ../Tela/enviarNotificacao.php');
    }


    function selectNotificacaoUsuario($id_usuario)
    {
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select n.* from notificacao as n left outer join destinatarionotificacao as dn on dn.id_notificacao = n.id_notificacao where dn.id_usuario = :id_usuario or n.mensagemGeral = 1 order by data desc;");
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        return $stmt;
    }

    function notificaAgendamentoProximo(agendamento $agendamento)
    {
        $usuarioPDO = new UsuarioPDO();
        $servicoPDO = new ServicoPDO();
        $stmtUsuario = $usuarioPDO->selectUsuarioId_usuario($agendamento->getId_usuario());
        $stmtServico = $servicoPDO->selecServicoAgendamento($agendamento->getId_agendamento());
        $servico = new servico($stmtServico->fetch());
        $usuario = new usuario($stmtUsuario->fetch());

        $notificacao = new notificacao();
        $notificacao->setDestinatario($usuario->getToken());
        $notificacao->setTitle("Está quase na hora!");
        $notificacao->setBody("Não perca seu horário! " . $servico->getNome() . " as " . $agendamento->getHora_marcadaDateTime()->format("H:i") . "! Estamos te aguardando!");
        $notificacao->send();
    }

    public function notificacaoPromocao(Quarto $servico)
    {
        $notificacao = new notificacao();
        $notificacao->setTitle("Promoção");
        $notificacao->setBody("Se liga nessa... "
            . "O quarto " . $servico->getNome() . " de R$" . $servico->getPreco() . " está por apenas R$" . $servico->getPrecoPromocao() . ", não perca essa chance ;)");
        $notificacao->send();
    }

    function drowNotification(Notificacao $notificacao , $exibido = 0)
    {
        echo "
                <div class='row'>
                <div class='col s10 offset-s1 card'>
                <p class='bold'>" . $notificacao->getTitle() . "</p>
                <span>" . $notificacao->getBody() . "</span>
                <input name='last_notification' hidden class='last_notification' value='" . $notificacao->getId_notificacao() . "'>
                <div class='forToast' exibido = '".$exibido."'><span>" . $notificacao->getTitle() . "
                " . $notificacao->getBody() . "</span></div>
</div>
</div>
            ";
    }

    function getStorageNotifications()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $logado = new usuario(unserialize($_SESSION['logado']));
        session_write_close();
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select * from notificacao as n inner join destinatarionotificacao d on n.id_notificacao = d.id_notificacao where d.id_usuario = :id_usuario order by n.data desc limit 20");
        $stmt->bindValue(":id_usuario", $logado->getId_usuario());
        $stmt->execute();
        while ($linha = $stmt->fetch()) {
            $notificacao = new Notificacao($linha);
            $this->drowNotification($notificacao , 1);
        }
    }

    function getNotification(){
        set_time_limit(100);
        if (!isset($_SESSION)) {
            session_start();
        }
        $logado = new usuario(unserialize($_SESSION['logado']));
        session_write_close();
        $last_notification = $_GET['lastNotification'];
        $pdo = conexao::getConexao();
        $x = 0;
        while($x<60) {
            $stmt = $pdo->prepare("select * from notificacao as n inner join destinatarionotificacao d on n.id_notificacao = d.id_notificacao where d.id_usuario = :id_usuario and n.id_notificacao > :id_notificacao order by n.data desc limit 20");
            $stmt->bindValue(":id_usuario", $logado->getId_usuario());
            $stmt->bindValue(":id_notificacao", $last_notification);
            $stmt->execute();
            if($stmt->rowCount()>0) {
                while ($linha = $stmt->fetch()) {
                    $notificacao = new Notificacao($linha);
                    $this->drowNotification($notificacao);
                }
                break;
            }
            $x++;
            sleep(1);
        }
    }

}
