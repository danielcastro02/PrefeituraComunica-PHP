<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>


<html>
<head>
    <meta charset="UTF-8">

    <?php
    include_once './Base/header.php';
    include_once './Modelo/Quarto.php';
    include_once './Controle/quartoPDO.php';
    include_once './Controle/fotoquartoPDO.php';
    $quartoPDO = new QuartoPDO();
    $parametros = new parametros();

    ?>
    <title><?php echo $parametros->getNome_empresa(); ?></title>
<body class="homeimg">
<?php
include_once './Base/iNav.php';
if ($parametros->getImagem_destaque() != null && $parametros->getImagem_destaque() != '') {
    $destaque = './' . $parametros->getImagem_destaque();
} else {
    $destaque = './Img/bg1_1.jpg';
}
?>
<main>
    <div class="slider sliderDoInicio">
        <ul class="slides">
            <li>
                <img class="responsive-img" style="background-attachment: fixed; background-position: bottom" src="<?php $pontos ?>Img/ImgSlides/1.webp"> <!-- random image -->
                <div class="caption center-align">
                    <h3>Hotel Cavalo Branco</h3>
<!--                    <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>-->
                </div>
            </li>
            <li>
                <img class="responsive-img" style="background-attachment: fixed; background-position: bottom" src="<?php $pontos ?>Img/ImgSlides/2.webp"> <!-- random image -->
                <div class="caption center-align">
                    <h3>Café da manhã</h3>
<!--                    <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>-->
                </div>
            </li>
            <li>
                <img class="responsive-img" style="background-attachment: fixed; background-position: bottom" src="<?php $pontos ?>Img/ImgSlides/4.webp"> <!-- random image -->
                <div class="caption center-align">
<!--                    <h3>Café da manhã</h3>-->
                    <!--                    <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>-->
                </div>
            </li>
            <li>
                <img class="responsive-img" style="background-attachment: fixed; background-position: bottom" src="<?php $pontos ?>Img/ImgSlides/5.webp"> <!-- random image -->
                <div class="caption center-align">
                    <!--                    <h3>Café da manhã</h3>-->
                    <!--                    <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>-->
                </div>
            </li>
            <li>
                <img class="responsive-img" style="background-attachment: fixed; background-position: bottom" src="<?php $pontos ?>Img/ImgSlides/3.webp"> <!-- random image -->
                <div class="caption center-align">
                    <!--                    <h3>Café da manhã</h3>-->
                    <!--                    <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>-->
                </div>
            </li>
        </ul>
    </div>



    <div class="center">
        <h3 id="aqui" class="title center" style="text-shadow: black 0.1em 0.1em 0.2em">Faça sua Busca</h3>
        <div class="row">
            <div class="col s12 l6 offset-l3">
                <div class="row">
                    <form action="#!" method="post" id="buscaQuarto">
                        <div class="col s12 l6 input-field">
                            <input type="text" name="data" id="data" class="datepicker">
                            <label for="data">Chegada</label>
                        </div>
                        <div class="col s12 l6 input-field">
                            <input type="text" id="saida" name="saida" class="datepicker">
                            <label for="saida">Saída</label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="imagens" class="col s12 m10 offset-m1 l10 offset-l1 center">
            <ul class="center">
                <div id="caixaBusca">
                </div>
            </ul>
        </div>

    </div>

    <div class="modal" id="modalReserva">
        <div class="modal-content" id="loadReserva">

        </div>
        <div class="modal-footer">
            <a class="modal-close corPadrao3 btn" href="#!">Voltar</a>
        </div>
    </div>
    <div id="avisoPerdeu" class="modal">
        <div class="modal-content">
            <h4>Ah não!</h4>
            <p>Parece que alguem fez uma reserva enquanto você decidia, por favor reserve outro quarto!</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Ok</a>
        </div>
    </div>
</main>

<script>

    $('.slider').slider({
        indicators: false,
        height: 250
    });




    $('.parallax').parallax({});


    $('#aqui').scrollSpy({
        scrollOffset: 100
    });

    $('.modal').modal();
    <?php
    if(isset($_GET['msg'])){
        if($_GET['msg'] == "perdeu"){
    ?>
    var instance = M.Modal.getInstance($("#avisoPerdeu"));
    instance.open();

    <?php
        }
    }
    ?>

    var gambi = false;
    function resetGambi(){
        gambi = false;
    }

    function buscaQuarto() {
        if(gambi == true){
            gambi = false;
            return 0;
        }else{
            gambi = true;
        }
        alert("executou");
        var data = $("#data").val();
        var saida = $("#saida").val();
        var arrData = data.split("/");
        var data2 = arrData[2] + "-" + arrData[1] + "-" + arrData[0];
        var arrSaida = saida.split("/");
        var saida2 = arrSaida[2] + "-" + arrSaida[1] + "-" + arrSaida[0];
        var dataObject = new Date(data2);
        var saidaObject = new Date(saida2);
        if (dataObject >= saidaObject) {
            saidaObject = adicionarDiasData(dataObject, 2);
        }
        if(saidaObject.getMonth()<9){
            var auxMes = "0";
        }else{
            var auxMes = "";
        }
        if(saidaObject.getDate()<10){
            var auxdia = "0";
        }else{
            var auxdia = "";
        }
        $("#saida").datepicker({
            defaultDate: saidaObject,
            setDefaultDate: true,
            format: 'dd/mm/yyyy',
            minDate: saidaObject,
            i18n: {
                cancel: 'Cancelar',
                clear: 'Limpar',
                done: 'Ok',
                months: [
                    'Janeiro',
                    'Fevereiro',
                    'Março',
                    'Abril',
                    'Maio',
                    'Junho',
                    'Julho',
                    'Agosto',
                    'Setembro',
                    'Outubro',
                    'Novembro',
                    'Dezembro'
                ],
                weekdays: [
                    'Domingo',
                    'Segunda-Feira',
                    'Terça-Feira',
                    'Quarta-Feira',
                    'Quinta-Feira',
                    'Sexta-Feira',
                    'Sábado'
                ],
                monthsShort: [
                    'Janeiro',
                    'Fevereiro',
                    'Março',
                    'Abril',
                    'Maio',
                    'Junho',
                    'Julho',
                    'Agosto',
                    'Setembro',
                    'Outubro',
                    'Novembro',
                    'Dezembro'
                ],
                weekdaysShort: [
                    'Dom',
                    'Seg',
                    'Ter',
                    'Qua',
                    'Qui',
                    'Sex',
                    'Sáb'
                ],
                weekdaysAbbrev: ['Do', 'Se', 'Te', 'Qa', 'Qi', 'Se', 'Sa']
            }
        });
        var dados = $("#buscaQuarto").serialize();
        $("#preLoader").show();
        function adicionarDiasData(data, dias){
            var dataVenc    = new Date(data.getTime() + (dias * 24 * 60 * 60 * 1000));
            return dataVenc;
        }
        $.ajax({
            url: "./Controle/agendamentoControle.php?function=consultaQuarto&pontos=<?php echo $pontos?>",
            data: dados,
            type: "post",
            success: function (data) {
                $("#preLoader").hide();
                $("#caixaBusca").html(data);
                $('.slider').slider({
                    indicators: false,
                    height: 250
                });
                $('.sliderDoInicio').slider({
                    indicators: false,
                    height: 350
                });

                $(".openModalReserva").click(function () {
                    var id_quarto = $(this).attr("id_quarto");
                    var dados = $("#buscaQuarto").serialize();
                    $("#preLoader").show();
                    $.ajax({
                        url: "./Tela/modalReservaContent.php?id_quarto=" + id_quarto + "&pontos=<?php echo $pontos?>",
                        data: dados,
                        type: 'post',
                        success: function (data) {
                            $("#modalReserva").html(data);
                            var modalReserva = M.Modal.getInstance(document.getElementById("modalReserva"));
                            modalReserva.open();
                            $("#preLoader").hide();
                            $('.sliderEspecial').slider({
                                height: 290
                            });
                        }

                    }) ;

                });
                $('#abrirDatas').click(function () {
                    $('#data').click();
                });
            }
        });
    }

    $('.datepicker').datepicker({
        defaultDate: new Date(),
        setDefaultDate: true,
        format: 'dd/mm/yyyy',
        minDate: new Date(),
        i18n: {
            cancel: 'Cancelar',
            clear: 'Limpar',
            done: 'Ok',
            months: [
                'Janeiro',
                'Fevereiro',
                'Março',
                'Abril',
                'Maio',
                'Junho',
                'Julho',
                'Agosto',
                'Setembro',
                'Outubro',
                'Novembro',
                'Dezembro'
            ],
            weekdays: [
                'Domingo',
                'Segunda-Feira',
                'Terça-Feira',
                'Quarta-Feira',
                'Quinta-Feira',
                'Sexta-Feira',
                'Sábado'
            ],
            monthsShort: [
                'Janeiro',
                'Fevereiro',
                'Março',
                'Abril',
                'Maio',
                'Junho',
                'Julho',
                'Agosto',
                'Setembro',
                'Outubro',
                'Novembro',
                'Dezembro'
            ],
            weekdaysShort: [
                'Dom',
                'Seg',
                'Ter',
                'Qua',
                'Qui',
                'Sex',
                'Sáb'
            ],
            weekdaysAbbrev: ['Do', 'Se', 'Te', 'Qa', 'Qi', 'Se', 'Sa']
        }
    });
    <?php
    if(isset($_SESSION['pesquisa'])){
    ?>
    var pesquisaCache = 'pesquisaCache=<?php echo $_SESSION['pesquisa'] ?>';
    $.ajax({
        url: "./Tela/modalReservaContent.php?pontos=<?php echo $pontos?>",
        data: pesquisaCache,
        type: 'post',
        success: function (data) {
            $("#modalReserva").html(data);
            var modalReserva = M.Modal.getInstance(document.getElementById("modalReserva"));
            modalReserva.open();
            $("#preLoader").hide();
            $('.sliderEspecial').slider({
                height: 290
            });
        }
    })
    <?php
    }
    ?>
    buscaQuarto();
    $("#data").change(buscaQuarto);
    $("#data").click(resetGambi);
    $("#saida").change(buscaQuarto);
    $("#saida").click(resetGambi);


</script>

<?php
include_once './Base/footer.php';
?>
</body>
</html>

