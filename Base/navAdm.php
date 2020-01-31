<?php
$pontos = "";
if (realpath("./index.php")) {
    $pontos = './';
} else {
    if (realpath("../index.php")) {
        $pontos = '../';
    } else {
        if (realpath("../../index.php")) {
            $pontos = '../../';
        }
    }
}
if (!isset($_SESSION)) {
    session_start();
}
include_once $pontos . 'Modelo/Usuario.php';
include_once $pontos . 'Modelo/Parametros.php';
include_once $pontos . 'Modelo/Agendamento.php';
include_once $pontos . 'Controle/agendamentoPDO.php';
$parametros = new parametros();
$logado = new usuario(unserialize($_SESSION['logado']));
?>

<div class="navbar-fixed" style="max-width: 100%">
    <nav class="nav-extended white " >

        <div class="nav-wrapper" style="width: 100%; margin-left: auto; margin-right: auto;">
            <a href="#" data-target="slide-out" class="sidenav-trigger">
                <i class="material-icons black-text">menu</i>
            </a>
            <?php if ($parametros->getIs_foto() == 1) { ?>
                <a  href="<?php echo $pontos; ?>./index.php" class="brand-logo initLoader">
                    <img class="responsive-img hide-on-small-only" src="<?php echo $pontos . $parametros->getLogo() . '?' . $numeruzinho; ?>" style="max-height: 60px; height:auto; width: auto; margin-left: 5px;">
                    <img class="responsive-img hide-on-med-and-up" src="<?php echo $pontos . $parametros->getLogo() . '?' . $numeruzinho; ?>" style="max-height: 55px; height:auto; width: auto; margin-left: 5px;">
                </a>
            <?php } else {
                ?>
                <a  href="<?php echo $pontos; ?>index.php" class="brand-logo black-text initLoader">
                    <?php echo $parametros->getNome_empresa(); ?>
                </a> 
            <?php }
            ?>
<!--<a href="<?php // echo $pontos;                          ?>./index.php" class="brand-logo black-text">MarkeyVip</a>-->
            <ul class="right hide-on-med-and-down">
                <li>
                    <a href="#!" class="dropdown-trigger black-text" data-target='dropPessoal'> 
                        <div class="chip detalheSuave">
                            <div class="left-align" style="background-image: url('<?php echo ($logado->getIs_foto_url()==1?"":$pontos) . $logado->getFoto(); ?>');
                                 float: left;
                                 margin: 0 8px 0 -12px;
                                 border-radius: 50%;
                                 height: 32px; width: 32px;
                                 background-position: center;
                                 background-size: cover;
                                 background-position: center;
                                 background-repeat: no-repeat;
                                 object-fit: cover;
                                 object-position: center;
                                 ">
                            </div>
                            <?php echo $logado->getNome() ?>
                        </div>
                    </a>                


                    <ul id='dropPessoal' class='dropdown-content'>
                        <li><a href="<?php echo $pontos ?>Tela/perfil.php" id="linkquarto" class="black-text modal-trigger initLoader">Meu Perfil</a></li>
                        <?php if (isset($_SESSION['quarto'])) {
                            ?>
                            <li><a href="<?php echo $pontos; ?>Tela/listagemAgendamento.php" class="black-text initLoader">Minha Agenda</a></li>

                            <?php
                            if ($parametros->getConfirma_agendamento() == 1) {
                                $agendamentoPDO = new AgendamentoPDO();
                                echo '<li><a href = "' . $pontos . 'Tela/agendamentosPendentes.php " class = "black-text initLoader">Agendamentos Pendentes<span class="new badge" style="background-color: #E25211" data-badge-caption="">' . $agendamentoPDO->agendamentosPendentesN($logado->getId_usuario()) . '</span></a></li>';
                            }
                            ?>

                        <?php }
                        ?>
                    </ul>
                </li>
                <!--Botão de Inicio-->
                <li>
                    <a class="initLoader" href="<?php echo $pontos; ?>./index.php"> 
                        <div class="chip detalheSuave">
                            <img style="height: 20px; width: 20px; margin-top: 12%" class="" src="<?php echo $pontos ?>Img/Icones/iconeInicio.svg">
                            Início
                        </div>
                    </a>  
                </li>

                <li>
                    <a class='dropdown-trigger black-text' href="#!" data-target='dropAdministracao' >
                        <div class="chip detalheSuave">
                            Administração
                        </div>
                    </a>
                    <ul id='dropAdministracao' class='dropdown-content'>
                        <li>
                            <a href="<?php echo $pontos ?>Tela/listagemUsuario.php" class="black-text initLoader">
                                Clientes
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $pontos ?>Tela/cadastroUsuarioAdm.php" class="black-text initLoader">
                                Cadastrar Clientes
                            </a>
                        </li>
                        <li><a href="<?php echo $pontos ?>Tela/editarParametros.php" class="black-text initLoader">
                                Configurações do Site
                            </a>
                        </li>
                        <?php
                        if ($logado->getAdministrador() == 2) {
                            ?>
                            <li><a href="<?php echo $pontos ?>Tela/configuracoesAvancadas.php" class="black-text initLoader">
                                    GOD MODE
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>

                <li>
                    <a class='dropdown-trigger black-text' href="#!" data-target='dropfuncionarios' >
                        <div class="chip detalheSuave">
                            Quartos
                        </div>
                    </a>
                    <ul id='dropfuncionarios' class='dropdown-content'>
                        <li><a href="<?php echo $pontos; ?>Tela/registroQuarto.php" id="linkquarto" class="black-text modal-trigger initLoader">Cadastrar</a></li>
                        <li><a href="<?php echo $pontos; ?>Tela/listagemQuarto.php" class="black-text initLoader">Ver Quartos Agrupados</a></li>
                        <li><a href="<?php echo $pontos; ?>Tela/listagemReservaveis.php" class="black-text initLoader">Ver Quartos Individuais</a></li>
                    </ul>
                </li>

                <li><a class="btSair black-text initLoader" href="<?php echo $pontos; ?>Controle/usuarioControle.php?function=logout&url=<?php echo $_SERVER["REQUEST_URI"]; ?>" class="black-text">
                        <div class="chip detalheSuave " >
                            Sair
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<!--Teste de SidNavBar-->

<ul id="slide-out" class="sidenav">
    <li><div class="user-view">
            <div class="background">
                <img src="<?php echo $pontos; ?>Img/backSide.jpg" style="height: 250px">
            </div>
            <!--<a href="#user"><img class="circle" src="<?php // echo $pontos . $logado->getFoto();                                ?>"></a>-->
            <a href="#user"><div class="fotoPerfil left-align" style="background-image: url('<?php echo $pontos . $logado->getFoto(); ?>');background-size: cover;
                                 background-position: center;
                                 background-repeat: no-repeat;
                                 max-height: 20vh; max-width: 20vh;"></div></a>
            <a href="#name"><span class="black-text name"><?php echo $logado->getNome(); ?></span></a>
            <a href="#email"><span class="black-text email"><?php echo $logado->getEmail(); ?></span></a>
        </div></li>
    <ul class="collapsible">
        <a href="<?php echo $pontos; ?>./index.php" class="black-text initLoader">
            <li>
                <div class="headerMeu" style="margin-left: 16px">
                    Início
                </div>
            </li>
        </a>
        <li>
            <div class="collapsible-header anime" x="0">Meu Perfil<i class="large material-icons right animi">arrow_drop_down</i></div>
            <div class="collapsible-body">
                <ul class="grey lighten-2">
                    <li><a href="<?php echo $pontos ?>Tela/perfil.php" id="linkquarto" class="black-text modal-trigger initLoader">Ver Meu Perfil</a></li>
                    <?php if (isset($_SESSION['quarto'])) {
                        ?>
                        <li><a href="<?php echo $pontos; ?>Tela/listagemAgendamento.php" class="black-text initLoader">Minha Agenda</a></li>

                        <?php
                        if ($parametros->getConfirma_agendamento() == 1) {
                            $agendamentoPDO = new AgendamentoPDO();
                            echo '<li><a href = "' . $pontos . 'Tela/agendamentosPendentes.php " class = "black-text initLoader">Agendamentos Pendentes<span class="new badge" style="background-color: #E25211" data-badge-caption="">' . $agendamentoPDO->agendamentosPendentesN($logado->getId_usuario()) . '</span></a></li>';
                        }
                        ?>

                    <?php }
                    ?>
                </ul>
            </div>
        </li>
        <li>
            <div class="collapsible-header anime" x="0">Administração<i class="large material-icons right animi">arrow_drop_down</i></div>
            <div class="collapsible-body">
                <ul class="grey lighten-2">
                    <li>
                        <a href="<?php echo $pontos ?>Tela/listagemUsuario.php" class="black-text initLoader">
                            Ver Clientes
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $pontos ?>Tela/cadastroUsuarioAdm.php" class="black-text initLoader">
                            Cadastrar Clientes
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $pontos ?>Tela/listaTodosQuartoes.php" class="black-text initLoader">
                            Próximos horários
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $pontos ?>Tela/editarParametros.php" class="black-text initLoader">
                            Configurações do Site
                        </a>
                    </li>
                    <?php
                    if ($logado->getAdministrador() == 2) {
                        ?>
                        <li>
                            <a href="<?php echo $pontos ?>Tela/configuracoesAvancadas.php" class="black-text initLoader">
                                GOD MODE
                            </a>
                        </li> 
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </li>
        <li>
            <div class="collapsible-header anime" x="0">Quartos<i class="large material-icons right animi">arrow_drop_down</i></div>
            <div class="collapsible-body">
                <ul class="grey lighten-2">
                    <li><a href="<?php echo $pontos; ?>Tela/registroQuarto.php" id="linkquarto" class="black-text modal-trigger initLoader">Cadastrar</a></li>
                    <li><a href="<?php echo $pontos; ?>Tela/listagemQuarto.php" class="black-text initLoader">Ver Quartos Agrupados</a></li>
                    <li><a href="<?php echo $pontos; ?>Tela/listagemReservaveis.php" class="black-text initLoader">Ver Quartos Individuais</a></li>
                </ul>
            </div>
        </li>
        <a class="modal-trigger black-text" href="#modalSair">
            <li>
                <div class="headerMeu black-text" style="margin-left: 16px">
                    Sair
                </div>
            </li>
        </a>

        <?php
        if ($logado->getAdministrador() == 2) {
            ?>
            <a class="toatsURI" href="#!" class="black-text">
                <li>
                    <div class="headerMeu black-text" style="margin-left: 16px">
                        Toast URI
                    </div>
                </li>
            </a>
            <a href="#!" onclick="location.reload();" class="black-text">
                <li>
                    <div class="headerMeu black-text" style="margin-left: 16px">
                        Reload
                    </div>
                </li>
            </a>
        <?php } ?>
    </ul>
</ul>

<div id="modalSair" class="modal">
    <div class="modal-content">
        <h4>Atenção</h4>
        <p>Você realmente deseja sair? Se sair não receberá nenhuma notificação do app...</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn corPadrao2">Cancelar</a>
        <a href="<?php echo $pontos; ?>Controle/usuarioControle.php?function=logout&url=<?php echo $_SERVER["REQUEST_URI"]; ?>" class="modal-close waves-effect waves-green btn red darken-2 initLoader btSair">Sair</a>
    </div>
</div>


<script>
    $('.sidenav').sidenav();
    $('.collapsible').collapsible();
    $('.modal').modal();

    $('.dropdown-trigger').dropdown({
        coverTrigger: false
    });

//      $(".anime").each(function (){
//        if ($(this).attr("x") == 1) {
//            $(this).children($(".animi")).attr("style", "transform: rotate(180deg);");
//        }
//        
//    });

    $(".anime").click(function () {
        if ($(this).attr("x") == 0) {
            $(".anime").attr("x", "0");
            $(".animi").attr("style", "transform: rotate(0deg);");
            $(this).children($(".animi")).attr("style", "transform: rotate(180deg);");
            $(this).attr("x", "1");
        } else {
            $(this).children($(".animi")).attr("style", "transform: rotate(0deg);");
            $(this).attr("x", "0");
        }
    });
    if (interfaceAndroid != undefined) {
        $('.btSair').click(function () {
            $.ajax({url: '<?php echo $pontos ?>Controle/usuarioControle.php?function=eliminaToken'});
            interfaceAndroid.logOut();
        });
        $(".toatsURI").click(function () {
            alert('<?php echo $_SERVER['REQUEST_URI'] ?>');
        });
    }

</script>