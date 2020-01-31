<?php

include_once __DIR__ . '/../Controle/conexao.php';
include_once __DIR__ . '/../Controle/PDOBase.php';
include_once __DIR__ . '/../Modelo/Parametros.php';

class ParametrosPDO extends PDOBase
{

    public function update()
    {
        $parametros = new parametros();
        $parametros->atualizar($_POST);
        $parametros->save();
        echo "<script>javascript:history.go(-1);</script>";

    }


    function updateNotificacao()
    {
        $parametros = new parametros();
        $parametros->atualizar($_POST);
        if (isset($_POST['envia_notificacao'])) {
            $parametros->setEnviaNotificacao(1);
        } else {
            $parametros->setEnviaNotificacao(0);
        }
        $parametros->save();
        echo "<script>javascript:history.go(-1);</script>";
    }

    function updateChat()
    {
        $parametros = new parametros();
        $parametros->atualizar($_POST);
        if (isset($_POST['active_chat'])) {
            $parametros->setActiveChat(1);
        } else {
            $parametros->setActiveChat(0);
        }
        $parametros->save();
        echo "<script>javascript:history.go(-1);</script>";
    }

    function updateGeral()
    {
        $parametros = new parametros();
        $parametros->atualizar($_POST);
        $con = new conexao();
        $horas = explode(":", $_POST['horasCancelamento']);
        $parametros->setConfirmaEmail(isset($_POST['confirma_email']) ? 1 : 0);
        $parametros->setSms((isset($_POST['sms']) ? 1 : 0));
        $parametros->save();
        header('location: ../Tela/configuracoesAvancadas.php?msg=parametrosAtualizados');
    }

    public function alteraLogo()
    {
        if (filesize($_FILES['imagem']['tmp_name']) > 15000000) {
            $_SESSION['toast'][] = "O tamanho máximo de arquivo é de 15MB";
            header("location: ../Tela/editarParametros.php");
        } else {
            $parametros = new parametros();
            $SendCadImg = filter_input(INPUT_POST, 'SendCadImg', FILTER_SANITIZE_STRING);
            //Receber os dados do formulÃ¡rio
            $antiga = $parametros->getLogo();
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $nome_imagem = hash_file('md5', $_FILES['imagem']['tmp_name']);
            //Inserir no BD
            $ext = explode('.', $_FILES['imagem']['name']);
            $extensao = "." . $ext[(count($ext) - 1)];
            $parametros->setIsFoto(1);
            $parametros->setLogo('Img/' . $nome_imagem . ($extensao == '.svg' ? ".svg" : ".webp"));
            $parametros->save();
            switch ($extensao) {
                case '.jpeg':
                case '.jfif':
                case '.jpg':
                    imagewebp(imagecreatefromjpeg($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/' . $nome_imagem . '.webp', 35);
                    break;
                case '.svg':
                    move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/../Img/' . $nome_imagem . '.svg');
                    break;
                case '.png':
                    $img = imagecreatefrompng($_FILES['imagem']['tmp_name']);
                    imagepalettetotruecolor($img);
                    imagewebp($img, __DIR__ . '/../Img/' . $nome_imagem . '.webp', 35);
                    break;
                case '.webp':
                    imagewebp(imagecreatefromwebp($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/' . $nome_imagem . '.webp', 35);
                    break;
                case '.bmp':
                    imagewebp(imagecreatefromwbmp($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/' . $nome_imagem . '.webp', 35);
                    break;
            }
            //Verificar se os dados foram inseridos com sucesso
            if (realpath("../" . $antiga) && $antiga != $nome_imagem . ".webp") ;
            header('Location: ../Tela/editarParametros.php');
        }
    }

    public
    function alteraDestaque()
    {
        if (filesize($_FILES['imagem']['tmp_name']) > 15000000) {
            $_SESSION['toast'][] = "O tamanho máximo de arquivo é de 15MB";
            header("location: ../Tela/editarParametros.php");
        } else {
            $parametros = new parametros();
            $SendCadImg = filter_input(INPUT_POST, 'SendCadImg', FILTER_SANITIZE_STRING);
            //Receber os dados do formulÃ¡rio
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $nome_imagem = hash_file('md5', $_FILES['imagem']['tmp_name']);
            //Inserir no BD
            $ext = explode('.', $_FILES['imagem']['name']);
            $extensao = "." . $ext[(count($ext) - 1)];
            $extensao = strtolower($extensao);
            $conexao = new conexao();
            $pdo = $conexao->getConexao();
            $stmt = $pdo->prepare("update parametros set  imagem_destaque = :imagem where id_parametro = :id");
            $stmt->bindValue(':id', $parametros->getIdParametro());
            $stmt->bindValue(':imagem', 'Img/' . $nome_imagem . ($extensao == '.svg' ? ".svg" : ".webp"));

            //Verificar se os dados foram inseridos com sucesso
            if ($stmt->execute()) {
                //DiretÃ³rio onde o arquivo vai ser salvo
                $diretorio = '../Img/' . $nome_imagem . '.webp';
                try {
                    switch ($extensao) {
                        case '.jpeg':
                        case '.jfif':
                        case '.jpg':
                            imagewebp(imagecreatefromjpeg($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/' . $nome_imagem . '.webp', 65);
                            break;
                        case '.svg':
                            move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/../Img/' . $nome_imagem . '.svg');
                            break;
                        case '.png':
                            $img = imagecreatefrompng($_FILES['imagem']['tmp_name']);
                            imagepalettetotruecolor($img);
                            imagewebp($img, __DIR__ . '/../Img/' . $nome_imagem . '.webp', 65);
                            break;
                        case '.webp':
                            imagewebp(imagecreatefromwebp($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/' . $nome_imagem . '.webp', 65);
                            break;
                        case '.bmp':
                            imagewebp(imagecreatefromwbmp($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/' . $nome_imagem . '.webp', 65);
                            break;
                    }
                    header('Location: ../Tela/editarParametros.php');
                } catch (Exception $e) {
                    header('Location: ../Tela/editaParametros.php?msg=erroImagem');
                }
            } else {
                header('Location: ../Tela/Sistema/editaParametros.php?msg=erro1');
            }
        }
    }

    public function removeLogo()
    {
        $parametros = new parametros();
        unlink('../' . $parametros->getLogo());
        $parametros->setLogo("");
        $parametros->setIsFoto(0);
        $parametros->save();
        header('Location: ../Tela/editarParametros.php');
    }

    function recuperaParametros()
    {
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select * from parametros");
        $stmt->execute();
        $linha = $stmt->fetch();
        file_put_contents("../Modelo/parametros.json", json_encode($linha));
        header("location: ../Tela/configuracoesAvancadas.php");
    }

}
