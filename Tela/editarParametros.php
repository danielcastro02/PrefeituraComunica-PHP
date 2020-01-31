<?php
include_once '../Base/requerAdm.php';
include_once '../Modelo/Parametros.php';
$parametros = new parametros();
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $parametros->getNomeEmpresa(); ?></title>
        <?php
        include_once '../Base/header.php';
        ?>
    </head>
    <body>
        <?php
        include_once '../Base/iNav.php';
        ?>
        <main>
            <form action="../Controle/parametrosControle.php?function=update" method="POST">

                <div class="row">
                    <div class="col s12 m10 offset-m1 l10 offset-l1 container center">
                        <div class="row">
                            <h5>Configurações do Site</h5>
                            <div class="col s12 l4">
                                <div class="col s12 l10 offset-l1 card">
                                    <h5>Identificação do seu negócio</h5>
                                    <p>Este é o nome que vai aparecer na tela inicial e na barra de navegação.</p>
                                    <div class="row">
                                        <div class="col s12 input-field">
                                            <input id="nome_empresa" type="text" value="<?php echo $parametros->getNomeEmpresa(); ?>" name="nome_empresa"/>
                                            <label for="nome_empresa">Nome do seu negócio</label>
                                        </div>
                                        <div class="col s12">
                                            <?php
                                            if ($parametros->getIsFoto() == 1) {
                                                ?>
                                                <a class="btn waves-effect  corPadrao2" id="removeLogo" href="../Controle/parametrosControle.php?function=removeLogo">Remover logo</a>
                                                <?php
                                            } else {
                                                ?>
                                                <a class="btn waves-effect  corPadrao2" href="./definirLogomarca.php">Definir uma logo</a>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col s12 l4 ">
                                <div class="col s12 l10 offset-l1 card">
                                    <h5>Seu contato</h5>
                                    <div class="col s12  input-field">
                                        <input id="emailContato" type="email" required value="<?php echo $parametros->getEmailContato(); ?>" name="emailContato"/>
                                        <label for="emailContato">E-mail de contato</label>
                                    </div>
                                    <div class="col s12  input-field">
                                        <input id="telefones" type="text" value="<?php echo $parametros->getTelefones(); ?>" name="telefones"/>
                                        <label for="telefones">Telefones de contato</label>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <div class="col s12 l4">
                                <div class="col s12 l10 offset-l1 card">
                                    <h5>Onde você está?</h5>
                                    <div class="col s12  input-field">
                                        <input id="ruaNumero" type="text" value="<?php echo $parametros->getRuaNumero(); ?>" name="ruaNumero"/>
                                        <label for="telefones">Rua e Número</label>
                                    </div>
                                    <div class="col s12  input-field">
                                        <input id="cidade" type="text" value="<?php echo $parametros->getCidade(); ?>" name="cidade"/>
                                        <label for="cidade">Cidade</label>
                                    </div>
                                    <div class="col s12  input-field">
                                        <input id="estado" type="text" value="<?php echo $parametros->getEstado(); ?>" name="estado"/>
                                        <label for="estado">Estado (Pode ser Sigla)</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row center">
                            <a class="btn waves-effect  corPadrao3" href='../index.php'>Cancelar</a>
                            <button type="submit" class="btn waves-effect corPadrao2 initLoader">Confirmar</button>
                        </div>
                        </form>
                    </div>
                </div>
        </main>
        <script>
            $("#horasCancelamento").mask('00:00:00');
            $("#removeLogo").click(function () {
                return confirm("Tem certeza que deseja remover sua logo?");
            });
            $("#removeDestaque").click(function () {
                return confirm("Tem certeza que deseja remover Imagem de destaque da tela inicial?");
            });
            $(".timepicker").timepicker();
            $("select").formSelect();
            $('.timepicker').timepicker({
                i18n: {
                    container: 'body',
                    cancel: 'Volta',
                    clear: 'Limpar',
                    done: 'Ok'
                },
                twelveHour: false,
                autoClose: true,
                vibrate: true
            });
        </script>
        <?php
        include_once '../Base/footer.php';
        ?>
    </body>
</html>