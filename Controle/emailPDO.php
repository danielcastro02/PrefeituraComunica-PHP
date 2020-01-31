<?php
    include_once __DIR__.'/../Controle/conexao.php';
    include_once __DIR__.'/../Controle/usuarioPDO.php';
    include_once __DIR__.'/../Modelo/Usuario.php';
    include_once __DIR__.'/../Modelo/Email.php';
    include_once __DIR__.'/../Modelo/Parametros.php';
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



    }
