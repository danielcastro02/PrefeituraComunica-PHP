<?php

class parametros
{

    private $id_parametro = 0;
    private $tempo_cancelamento = "P0DT00H00M01S";
    private $nome_empresa = "Hotel";
    private $is_foto = 0;
    private $tema = "default";
    private $emailContato = "contato@markeyvip.com";
    private $hasAdm = 1;
    private $telefones = "(55) 99959-8414";
    private $logo = "";
    private $ruaNumero = "";
    private $cidade = "";
    private $sms = 0;
    private $estado = "";
    private $imagem_destaque = "";
    private $destaque_personalizado = "";
    private $mp_token = "APP_USR-3350858051691068-091000-e5bb8aa8f4fc71b7e9003204396963c3-468060725";
    private $ativa_pagamento = 0;
    private $app_token = "AAAAW9yWcpU:APA91bGu9PcQ6iBvtNR0YUSOmLW2V6l0aYb-_uDyA36sgILxOrx0IOiGTzm2bE-KjzREdzu46vWbrMml5dlBBsbOylDxDdNqZo4glUn88_6HFdXbuXfeF7_Zto-32TcpfzdgTLGEy9up";
    private $envia_notificacao = 0;
    private $server;
    private $confirma_agendamento = 0;
    private $checkin = 0;
    private $face_app_id = "923573528013985";
    private $face_app_secret = "7e74dd0ff62cb33ac67ce15cebd47438";
    private $antecedencia_notifica_agendamento = 15;
    private $link_app = "https://play.google.com/store/apps/details?id=markey.hotel";
    private $qr_app = "";
    private $active_chat = 0;
    private $vira_diaria = "13:00:00";
    private $confirma_email = 0;
    private $firebase_topic = "dispositivos";
    private $nome_db = "hotel";

    public function __construct()
    {
        try {
            error_reporting(0);
            $atributos = json_decode(file_get_contents(__DIR__ . "/parametros.json"));
            foreach ($atributos as $atributo => $valor) {
                if (isset($valor)) {
                    $this->$atributo = $valor;
                }
            }
            error_reporting(E_ALL);
        }catch (Exception $e){
            $this->save();
        }
        if ($_SERVER["HTTP_HOST"] == 'localhost') {
            $this->server = "https://" . gethostbyname(gethostbyaddr($_SERVER['REMOTE_ADDR']));
            $requestURI = $_SERVER['REQUEST_URI'];
            $arrRequest = explode("/", $requestURI);
            $this->server = $this->server . "/".strtolower($arrRequest[1]);
        } else {
            $this->server = "https://" . $_SERVER["HTTP_HOST"];
        }

    }

    public function getFirebaseTopic(): string
    {
        return $this->firebase_topic;
    }

    public function setFirebaseTopic(string $firebase_topic)
    {
        $this->firebase_topic = $firebase_topic;
    }

    public function getAntecedenciaNotificaAgendamento()
    {
        return $this->antecedencia_notifica_agendamento;
    }

    public function getNomeDb()
    {
        return $this->nome_db;
    }

    public function setNomeDb($nome_db)
    {
        $this->nome_db = $nome_db;
    }

    public function getLinkApp()
    {
        return $this->link_app;
    }

    public function getConfirmaEmail()
    {
        return $this->confirma_email;
    }

    public function setConfirmaEmail($confirma_email)
    {
        $this->confirma_email = $confirma_email;
    }


    public function getViraDiaria()
    {
        return $this->vira_diaria;
    }

    public function save()
    {
        file_put_contents(__DIR__ . '/parametros.json', json_encode(get_object_vars($this)));
        file_put_contents(__DIR__ . '/../../adm.markeyvip.com/Parametros/'.$_SERVER["HTTP_HOST"].".json", json_encode(get_object_vars($this)));
    }

    public function setViraDiaria($vira_diaria)
    {
        $this->vira_diaria = $vira_diaria;
    }


    public function setLinkApp($link_app)
    {
        $this->link_app = $link_app;
    }

    public function getActiveChat()
    {
        return $this->active_chat;
    }

    public function setActiveChat($active_chat)
    {
        $this->active_chat = $active_chat;
    }

    public function getQrApp()
    {
        return $this->qr_app;
    }

    public function setQrApp($qr_app)
    {
        $this->qr_app = $qr_app;
    }

    public function setAntecedenciaNotificaAgendamento($antecedencia_notifica_agendamento)
    {
        $this->antecedencia_notifica_agendamento = $antecedencia_notifica_agendamento;
    }


    function getAtiva_pagamento()
    {
        return $this->ativa_pagamento;
    }

    function getEnvia_notificacao()
    {
        return $this->envia_notificacao;
    }

    function getFace_app_id()
    {
        return $this->face_app_id;
    }

    function getFace_app_secret()
    {
        return $this->face_app_secret;
    }

    function setFace_app_id($face_app_id)
    {
        $this->face_app_id = $face_app_id;
    }

    function setFace_app_secret($face_app_secret)
    {
        $this->face_app_secret = $face_app_secret;
    }


    function setAtiva_pagamento($ativa_pagamento)
    {
        $this->ativa_pagamento = $ativa_pagamento;
    }

    function setEnvia_notificacao($envia_notificacao)
    {
        $this->envia_notificacao = $envia_notificacao;
    }

    function getConfirma_agendamento()
    {
        return $this->confirma_agendamento;
    }

    function setConfirma_agendamento($confirma_agendamento)
    {
        $this->confirma_agendamento = $confirma_agendamento;
    }


    function getAppToken()
    {
        return $this->app_token;
    }

    function getEnviarNotificacao()
    {
        return $this->envia_notificacao;
    }

    function setEnviarNotificacao($enviarNotificacao)
    {
        $this->envia_notificacao = $enviarNotificacao;
    }


    function setAppToken($appToken)
    {
        $this->app_token = $appToken;
    }

    function getDestaque_personalizado()
    {
        return $this->destaque_personalizado;
    }

    function getMp_token()
    {
        return $this->mp_token;
    }

    function getApp_token()
    {
        return $this->app_token;
    }

    function getServer()
    {
        return $this->server;
    }

    function setMp_token($mp_token)
    {
        $this->mp_token = $mp_token;
    }

    function setApp_token($app_token)
    {
        $this->app_token = $app_token;
    }

    function setServer($server)
    {
        $this->server = $server;
    }

    function setDestaque_personalizado($destaque_personalizado)
    {
        $this->destaque_personalizado = $destaque_personalizado;
    }

    function atualizar($vetor)
    {
        foreach ($vetor as $atributo => $valor) {
            if (isset($valor)) {
                $this->$atributo = $valor;
            }
        }
    }

    function getRuaNumero()
    {
        return $this->ruaNumero;
    }

    function getImagem_destaque()
    {
        return $this->imagem_destaque;
    }

    function getMpToken()
    {
        return $this->mp_token;
    }

    function setMpToken($mpToken)
    {
        $this->mp_token = $mpToken;
    }

    function setImagem_destaque($imagem_destaque)
    {
        $this->imagem_destaque = $imagem_destaque;
    }

    function getCidade()
    {
        return $this->cidade;
    }

    function getSms()
    {
        return $this->sms;
    }

    function setSms($sms)
    {
        $this->sms = $sms;
    }

    function getEstado()
    {
        return $this->estado;
    }

    function setRuaNumero($ruaNumero)
    {
        $this->ruaNumero = $ruaNumero;
    }

    function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    function setEstado($estado)
    {
        $this->estado = $estado;
    }

    function getEmailContato()
    {
        return $this->emailContato;
    }

    function getLogo()
    {
        return $this->logo;
    }

    function setLogo($logo)
    {
        $this->logo = $logo;
    }

    function setEmailContato($emailContato)
    {
        $this->emailContato = $emailContato;
    }

    function getTelefones()
    {
        return $this->telefones;
    }

    function setTelefones($telefones)
    {
        $this->telefones = $telefones;
    }

    public function getId_parametro()
    {
        return $this->id_parametro;
    }

    function setId_parametro($id_parametro)
    {
        $this->id_parametro = $id_parametro;
    }

    public function getTempo_cancelamento()
    {
        return $this->tempo_cancelamento;
    }

    function setTempo_cancelamento($tempo_cancelamento)
    {
        $this->tempo_cancelamento = $tempo_cancelamento;
    }

    public function getNome_empresa()
    {
        return $this->nome_empresa;
    }

    function setNome_empresa($nome_empresa)
    {
        $this->nome_empresa = $nome_empresa;
    }

    public function getIs_foto()
    {
        return $this->is_foto;
    }

    function setIs_foto($is_foto)
    {
        $this->is_foto = $is_foto;
    }

    public function getTema()
    {
        return $this->tema;
    }

    function setTema($tema)
    {
        $this->tema = $tema;
    }

    public function getHasAdm()
    {
        return $this->hasAdm;
    }

    public function getViraDiariaTime()
    {
        $hora = $this->getViraDiaria();
        $arrHora = explode(':', explode(".", $hora)[0]);
        $data = new DateTime();
        $data->setTime($arrHora[0], $arrHora[1], $arrHora[2]);
        return $data;
    }

    function setHasAdm($hasAdm)
    {
        $this->hasAdm = $hasAdm;
    }

    public function getCheckin()
    {
        return $this->checkin;
    }

    public function setCheckin($checkin)
    {
        $this->checkin = $checkin;
    }

}
