<?php
include_once '../Base/requerGodMode.php';
include_once '../Modelo/Parametros.php';
$parametros = new parametros();
?>
<!DOCTYPE html>
<html>
<head>
    <?php
    include_once '../Base/header.php';
    ?>
    <title><?php echo $parametros->getNomeEmpresa(); ?></title>

</head>
<body>
<?php
include_once '../Base/iNav.php';
?>
<main>
    <div class="row">
        <div class="col s12 m10 offset-m1 l10 offset-l1 container center">
            <div class="row">
                <h5>Configurações do Site</h5>
            </div>
            <div class="row">
                <div class="col s12 l4">
                    <div class="col s12 l10 offset-l1 card">
                        <div class="row center">
                            <h5>Chat</h5>
                        </div>

                        <form action="../Controle/parametrosControle.php?function=updateChat" method="post">
                            <div class="row">
                                <div class="col s12 input-field">
                                    <div class="switch">
                                        <span class="left teal-text">Ativar chat:</span>
                                        <label class="right">
                                            Off
                                            <input type="checkbox"
                                                   name="active_chat" <?php echo $parametros->getActiveChat() == 1 ? 'checked' : ''; ?>
                                                   value="1">
                                            <span class="lever"></span>
                                            On
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <button class="btn corPadrao2" type="submit">Confirmar</button>
                            </div>
                        </form>


                    </div>
                </div>
                <div class="col s12 l4">
                    <div class="col s12 l10 offset-l1 card">
                        <h5>Configurações de Notificação</h5>
                        <form action="../Controle/parametrosControle.php?function=updateNotificacao" method="POST">
                            <div class="col s12 input-field">

                                <div class="switch">
                                    <span class="left teal-text">Envio de Notificações:</span>
                                    <label class="right">
                                        Off
                                        <input type="checkbox"
                                               name="envia_notificacao" value="1" <?php echo $parametros->getEnviaNotificacao() == 1 ? 'checked' : ''; ?>>
                                        <span class="lever"></span>
                                        On
                                    </label>
                                </div>

                            </div>
                            <div class="col s12 input-field">
                                <input name="app_token" value="<?php echo $parametros->getAppToken() ?>" type="password"
                                       id="appToken"/>
                                <label for="appToken">Token do aplicativo:</label>
                            </div>
                            <div class="row">
                                <button type="submit" class="btn waves-effect  corPadrao2">Confirmar</button>
                            </div>
                        </form>
                    </div>
                </div>


                <form action="../Controle/parametrosControle.php?function=updateQrLink" method="post"
                      enctype="multipart/form-data">
                    <div class="col s12 l4">
                        <div class="col s12 l10 offset-l1 card">
                            <h5>Link aplicativo</h5>
                            <div class="col  s12 input-field">
                                <input name="link_app" value="<?php echo $parametros->getLinkApp() ?>" type="text"
                                       id="linkApp"/>
                                <label for="linkApp">Dias de antecedencia para cancelar:</label>
                            </div>
                            <div class="col  s12 input-field">
                                <input name="qr_app" type="file" hidden id="qr_app"/>
                                <img class="prev-img" style="

                             height: auto;
                              width: 80%;
                              ">
                                <a href="#!" id="linkFotoQr" class="btn corPadrao2">Adicionar QR Code</a>
                                <script>
                                    $("#linkFotoQr").click(function () {
                                        $("#qr_app").click();
                                        console.log('aaaa');
                                    });
                                    $('#qr_app').change(function () {
                                        const file = $(this)[0].files[0];
                                        console.log(file);
                                        const fileReader = new FileReader();
                                        console.log("entrou aqui");
                                        fileReader.onload = function () {
                                            console.log("Aaaaaaaaaaaa");
                                            $('.prev-img').attr('src', fileReader.result);
                                        };
                                        fileReader.readAsDataURL(file);
                                    });
                                </script>
                            </div>
                            <div class="row">
                                <button type="submit" class="btn corPadrao2">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <form action="../Controle/parametrosControle.php?function=updateGeral" method="POST">
                    <div class="col s12 l4">
                        <div class="col s12 l10 offset-l1 card">
                            <h5>Configurações gerais</h5>
                            <div class="col s12 input-field">
                                <div class="switch">
                                    <span class="left teal-text">Envio de SMS:</span>
                                    <label class="right">
                                        Off
                                        <input type="checkbox"
                                               name="sms" value="1"<?php echo $parametros->getSms() == 1 ? 'checked' : ''; ?>>
                                        <span class="lever"></span>
                                        On
                                    </label>
                                </div>
                            </div>
                            <div class="col s12 input-field">
                                <div class="switch">
                                    <span class="left teal-text">Confirmação de E-mail:</span>
                                    <label class="right">
                                        Off
                                        <input type="checkbox"
                                               name="confirma_email" value="1"<?php echo $parametros->getConfirmaEmail() == 1 ? 'checked' : ''; ?>>
                                        <span class="lever"></span>
                                        On
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <button type="submit" class="btn waves-effect white-text corPadrao2">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col s12 l4">
                    <div class="col s12 l10 offset-l1 card">
                        <div class="row center">
                            <h5>Utilitários</h5>
                        </div>
                        <div class="row">
                            <a class="btn corPadrao2" href="./enviarNotificacao.php">Enviar notificação</a>
                        </div>
                        <div class="row">
                            <a class="btn corPadrao2" href="./todosAgendamentos.php">Ver todos agendamentos</a>
                        </div>
                        <div class="row">
                            <a class="btn red darken-4" id="botaodocapeta" href="../Controle/parametrosControle.php?function=recuperaParametros">Recuperar Parametros</a>
                        </div>
                    </div>
                </div>
                <div class="col s12 l4">
                    <form action="../Controle/parametrosControle.php?function=update" method="post">
                        <div class="col s12 l10 offset-l1 card">
                            <div class="row center">
                                <h5>Firebase</h5>
                            </div>
                            <div class="row">
                                <div class="col s12 input-field">
                                    <input type="text" name="firebase_topic" id="firebase_topic" value="<?php echo $parametros->getFirebaseTopic() ?>">
                                    <label for="firebase_topic">Firebase Topic</label>
                                </div>
                                <div class="col s12 input-field">
                                    <input type="text" name="nome_db" id="nome_db" value="<?php echo $parametros->getNomeDb() ?>">
                                    <label for="nome_db">Nome DB</label>
                                </div>
                            </div>
                            <div class="row">
                                <button class="btn corPadrao2">Confirmar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">

            </div>

        </div>
    </div>
</main>
<script>
    $("#removeLogo").click(function () {
        return confirm("Tem certeza que deseja remover sua logo?");
    });
    $("#removeDestaque").click(function () {
        return confirm("Tem certeza que deseja remover Imagem de destaque da tela inicial?");
    });
    $("select").formSelect();
    $("#botaodocapeta").click(function () {
        if(confirm("Isso vai recupar os parametros do banco e pode dar muito problema, você realmente quer fazer isso?")){
            if(confirm("Tem certeza?????")){
                if(confirm("Absoluta???")){
                    if(confirm("LUUUCAAAS?????????")){
                        return true;
                    }else{
                        return false;

                    }
                }else{
                    return false
                }
            }else{
                return false;
            }
        }else {
            return false
        }
    });
</script>
<?php
include_once '../Base/footer.php';
?>
</body>
</html>