<?php
    include_once __DIR__.'/../Controle/conexao.php';
    include_once __DIR__.'/../Controle/usuarioPDO.php';
    include_once __DIR__.'/../Controle/cancelamentoPDO.php';
    include_once __DIR__.'/../Controle/agendamentoPDO.php';
    include_once __DIR__.'/../Modelo/Usuario.php';
    include_once __DIR__.'/../Modelo/Email.php';
    include_once __DIR__.'/../Modelo/Agendamento.php';
    include_once __DIR__.'/../Modelo/Parametros.php';
    include_once __DIR__.'/../Modelo/Cancelamento.php';
    require_once __DIR__.'/../vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class emailPDO
    {

        private $parametros;

        public function __construct()
        {
            $this->parametros = new parametros();
        }

        public function enviaEmail($destino, $resposta, $assunto, $conteudoHTML, $conteudonaoHTML, $paginaDestino)
        {
            $mail = new PHPMailer(true);
            try {
                //Server settings
                //TODO adicionar credenciais servidor e remetente nas consfigurações abaixo
                $mail->isSMTP();                                            // Set mailer to use SMTP
                $mail->Host = '';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                $mail->Username = '';                     // SMTP username
                $mail->Password = '';                               // SMTP password
                $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;                                    // TCP port to connect to
                //Recipients
                $mail->setFrom('', '');
                $mail->addAddress($destino);               // Name is optional
                $mail->addReplyTo($resposta, 'MarkeyHotel');
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $assunto;
                $mail->Body = $conteudoHTML;
                $mail->AltBody = $conteudonaoHTML;
                $mail->send();
                header('location: ../Tela/'.$paginaDestino);
            } catch (Exception $e) {
                file_put_contents("../Logs/mailLog.txt", $e->getMessage(), FILE_APPEND);
                header("location: ../Tela/erroInterno.php");
            }
        }

        function notificaCancelamento($id_agendamento)
        {
            $agendamentoPDO = new AgendamentoPDO();
            $stmtAg = $agendamentoPDO->selectAgendamentoId_agendamento($id_agendamento);
            $agendamento = new agendamento($stmtAg->fetch());
            $usuarioPDO = new UsuarioPDO();
            $cancelamentoPDO = new CancelamentoPDO();
            $cancela = $cancelamentoPDO->selectCancelamentoId_agendamento($id_agendamento);
            $cancelamento = new cancelamento($cancela->fetch());
            $usuario = $usuarioPDO->selectUsuarioId_usuario($agendamento->getId_usuario());
            $usuario = new usuario($usuario->fetch());
            $hora_marcada = $agendamento->getHora_marcadaDateTime();
            $email = new Email();
            $email->setAssunto("Reserva cancelada!");
            $parametros = new parametros();
            $adms = $usuarioPDO->selectUsuarioAdministrador(1);
            while($linha = $adms->fetch()){
                $adm = new usuario($linha);
                $email->addDestinatario($adm->getEmail());
            }
            $email->setEmailResposta($usuario->getEmail());
            $email->setTituloModeP("Olá");
            $email->setMensagemModeP("<h5>O cliente cancelou a reserva!</h5>"
                ."<p>O cliente ".$usuario->getNome().", cancelou a reserva do dia ".$hora_marcada->format('d/m/Y')."</p>"
                ."O cliente deixou a seguinte mensagem <br>".$cancelamento->getMotivo());
            $email->enviar(true, true);
            header("Loacation: ../Tela/minhasReservas.php");
        }

        function notificaCancelamantoAdm(agendamento $agendamento)
        {
            $agendamentoPDO = new AgendamentoPDO();
            $usuarioPDO = new UsuarioPDO();
            $reservavelPDO = new reservavelPDO();
            $stmtAg = $agendamentoPDO->selectAgendamentoId_agendamento($agendamento->getId_agendamento());
            $agendamento = new agendamento($stmtAg->fetch());
            $usuario = $usuarioPDO->selectUsuarioId_usuario($agendamento->getId_usuario());
            $usuario = new usuario($usuario->fetch());
            $quarto = new Reservavel($reservavelPDO->selectReservavelIdReservavel($agendamento->getId_reservavel())->fetch());
            $cancelamentoPDO = new CancelamentoPDO();
            $cancela = $cancelamentoPDO->selectCancelamentoId_agendamento($agendamento->getId_agendamento());
            $cancelamento = new cancelamento($cancela->fetch());
            $hora_marcada = $agendamento->getHora_marcadaDateTime();
            $email = new Email();
            $email->setAssunto("Reserva Cancelada");
            $email->addDestinatario($usuario->getEmail());
            $email->setMensagemHTML('<h4>Sua reserva foi cancelada</h4>'.
            '<p>Infelizmente um de nossos administradores canelalou sua reserva do quarto '.$quarto->getNome().' do dia '.$hora_marcada->format('d/m/Y').'</p><br>'.
            '<p>Deixando a seguinte mensagem: </p><br>'.$cancelamento->getMotivo());
            $email->enviar(true);
        }

        function notificaCancelamentoQuarto($id_agendamento)
        {
//        $id_agendamento = $_GET['id_agendamento'];
            $agendamentoPDO = new AgendamentoPDO();
            $stmtAg = $agendamentoPDO->selectAgendamentoId_agendamento($id_agendamento);
            $agendamento = new agendamento($stmtAg->fetch());
            $usuarioPDO = new UsuarioPDO();
            $cancelamentoPDO = new CancelamentoPDO();
            $cancela = $cancelamentoPDO->selectCancelamentoId_agendamento($id_agendamento);
            $cancelamento = new cancelamento($cancela->fetch());
            $usuario = $usuarioPDO->selectUsuarioId_usuario($agendamento->getId_usuario());
            $prestado = $usuarioPDO->selectUsuarioId_usuario($agendamento->getId_reservavel());
            $usuario = new usuario($usuario->fetch());
            $quarto = new usuario($prestado->fetch());
            $hora_marcada = $agendamento->getHora_marcadaDateTime();
            $email = new Email();
            $email->setAssunto("Horário cancelado!");
            $email->addDestinatario($usuario->getEmail(), $usuario->getNome());
            $email->setEmailResposta($quarto->getEmail());
            $email->setMensagemHTML("<h5>O quarto cancelou o horário!</h5>"
                ."<p>O quarto ".$quarto->getNome().", cancelou a hora marcada no dia ".$hora_marcada->format('d/m/Y \a\s H:i')." horas.</p>"
                ."O quarto deixou a seguinte mensagem <br>".$cancelamento->getMotivo());
            $email->enviar(true);
            header("Loacation: ../Tela/listagemAgendamento.php");
        }

        function emailAgendamento(agendamento $agendamento)
        {
            $usuarioPDO = new UsuarioPDO();
            $usuario = $usuarioPDO->selectUsuarioId_usuario($agendamento->getId_usuario());
            $quarto = $usuarioPDO->selectUsuarioId_usuario($agendamento->getId_reservavel());
            $usuario = new usuario($usuario->fetch());
            $quarto = new usuario($quarto->fetch());
            $servicoPDO = new ServicoPDO();
            $servico = $servicoPDO->selecServicoAgendamento($agendamento->getId_agendamento());
            $servico = new servico($servico->fetch());
            $hora_marcada = $agendamento->getHora_marcadaDateTime();
            $email = new Email();
            $email->setAssunto('Agendamento');
            $email->setEmailResposta($quarto->getEmail(), $quarto->getNome());
            $email->addDestinatario($usuario->getEmail(), $usuario->getNome());
            $email->setMensagemHTML("<h5>Olá!</h5>"
                ."<p>Seu horário com ".$quarto->getNome().", para ".$servico->getNome().", está confirmado para o dia: "
                .$hora_marcada->format('d/m')." às ".$hora_marcada->format('H:i')." horas.</p>");
            $email->enviar(true);
            $email = new Email();
            $email->setAssunto('Agendamento');
            $email->addDestinatario($quarto->getEmail(), $quarto->getNome());
            $email->setEmailResposta($usuario->getEmail(), $usuario->getNome());
            $email->setMensagemHTML("<h5>Olá!</h5>"
                ."<p>O cliente ".$usuario->getNome().",agendou ".$servico->getNome().", Com você no dia: "
                .$hora_marcada->format('d/m')." às ".$hora_marcada->format('H:i')." horas.</p>");
            $email->enviar(true);
        }

        function usuarioDeletado()
        {
            $usuarioPDO = new UsuarioPDO();
            $remetente = $_POST['remetente'];
            $mensagem = $_POST['mensagem'];
            $id_usuario = $_POST['id_usuario'];
            $stmtUs = $usuarioPDO->selectUsuarioId_usuario($id_usuario);
            $userDeletado = new usuario($stmtUs->fetch());
            $conteudoHTML = "<p>O usuário ".$userDeletado->getNome().", CPF: ".$userDeletado->getCpfPontuado()." Telefone: ".$userDeletado->getTelefoneMascarado()." entrou em contato sobre seu usuário estar deletado, com a segunte mensagem:</p>"
                ."<p>".$mensagem."</p>";
            $email = new Email();
            $stmtUsusario = $usuarioPDO->selectUsuarioAdministrador('1');
            while ($linha = $stmtUsusario->fetch()) {
                $usuario = new usuario($linha);
                if ($usuario->getEmail() != "") {
                    $email->addDestinatario($usuario->getEmail());
                }
            }
            $email->setAssunto("Usuário deletado!");
            $email->setMensagemHTML($conteudoHTML);
            $email->setEmailResposta($remetente);
            $email->enviar(true);
            $_SESSION['toast'][] = "Sua mensagem foi enviada, o administrador entrara em contato em breve!";
            header('location: ../index.php?msg=enviado');
        }

        function confirmaEmail($destinatario, $codigo = null, $id_usuario = null)
        {
            if (is_null($codigo)) {
                $codigo = mt_rand(1000, 99999);
                $pdo = conexao::getConexao();
                $stmt = $pdo->prepare("insert into codigoconfirmacao values (default, :id_usuario , :codigo, 'email');");
                $stmt->bindValue(':id_usuario', $id_usuario);
                $stmt->bindValue(':codigo', $codigo);
                $stmt->execute();
            }
            $email = new Email();
            $server = $_SERVER['HTTP_HOST'];
            $server == 'localhost' ? $server = $server.'/MarkeyHotel' : $server = $server;
            $conteudoHTML = htmlentities("Link de verificação:")."<a href='http://".$server."/Controle/usuarioControle.php?function=confirmaEmail&codigo=".$codigo."'>CLIQUE AQUI!</a>";
            $conteudonaoHTML = "Link de verificação: http://".$server."/Controle/usuarioControle.php?function=confirmaEmail&codigo=".$codigo;
            $email->setAssunto(("Confirmação de Email"));
            $email->setTituloModeP(htmlentities("Seu código de confirmação!"));
            $email->setMensagemModeP($conteudoHTML);
            $email->setMensagemNaoHTML($conteudonaoHTML);
            $email->setEmailResposta($this->parametros->getEmailContato());
            $email->addDestinatario($destinatario);
            return $email->enviar(true, true);
        }

        public function responderEmail()
        {
            $id_quarto = $_POST['id_quarto'];
            $id_usuario = $_POST['id_usuario'];
            $mensagem = $_POST['motivo'];
            $quartoPDO = new QuartoPDO();
            $usuarioPDO = new UsuarioPDO();
            $quarto = new Quarto($quartoPDO->selectQuartoId_usuario($id_quarto)->fetch());
            $usuario = new usuario($usuarioPDO->selectUsuarioId_usuario($id_usuario)->fetch());
            $email = new Email();
            $email->setAssunto("Resposta cancelamento");
            $email->addDestinatario($usuario->getEmail());
            $email->setEmailResposta($quarto->getEmail());
            $conteudoHTML = "<p>O quarto ".$quarto->getNome().", respondeu seu email de cancelamento com a seguinte mensagem: </p>"
                ."<p>".$mensagem."</p>";
            $email->setMensagemHTML($conteudoHTML);
            $email->enviar(false);
            $_SESSION['toast'][] = "Email enviado com sucesso!";
            header("Location: ../Tela/verCancelamentos.php");
        }

    }
