<?php

class parametros
{
//Os parametros não comentados não são fundamentais
    private $id_parametro = 0;
    private $nome_empresa = "Prefeitura Comunica";
    private $is_foto = 0;
    private $emailContato = "contato@markeyvip.com";
    private $hasAdm = 1;
    private $telefones = "";
    private $logo = "";
    private $ruaNumero = "";
    private $cidade = "";
    private $sms = 0;
    private $estado = "";
    //Token do firebase para o aplicativo
    private $app_token = "";
    private $envia_notificacao = 0;
    private $server;
    //Id do aplicativo do facebook para login
    private $face_app_id = "";
    //Senha do aplicativo do facebook
    private $face_app_secret = "";
    private $link_app = "";
    private $qr_app = "";
    private $active_chat = 0;
    private $confirma_email = 0;
    private $firebase_topic = "dispositivos";
    //Nome do banco mysql
    private $nome_db = "";
    //Chave do recapcha
    private $capKey = "";
    //Usuario do facilitamovel para envio de sms
    private $smsUser = "";
    //Senha do facilitamovel
    private $smsPass = "";

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

    public function save()
    {
        file_put_contents(__DIR__ . '/parametros.json', json_encode(get_object_vars($this)));
        file_put_contents(__DIR__ . '/../../adm.markeyvip.com/Parametros/'.$_SERVER["HTTP_HOST"].".json", json_encode(get_object_vars($this)));
    }

    function atualizar($vetor)
    {
        foreach ($vetor as $atributo => $valor) {
            if (isset($valor)) {
                $this->$atributo = $valor;
            }
        }
    }

    public function getIdParametro(): int
    {
        return $this->id_parametro;
    }

    public function setIdParametro(int $id_parametro)
    {
        $this->id_parametro = $id_parametro;
    }

    public function getNomeEmpresa(): string
    {
        return $this->nome_empresa;
    }

    public function setNomeEmpresa(string $nome_empresa)
    {
        $this->nome_empresa = $nome_empresa;
    }

    public function getIsFoto(): int
    {
        return $this->is_foto;
    }

    public function setIsFoto(int $is_foto)
    {
        $this->is_foto = $is_foto;
    }

    public function getEmailContato(): string
    {
        return $this->emailContato;
    }

    public function setEmailContato(string $emailContato)
    {
        $this->emailContato = $emailContato;
    }

    public function getHasAdm(): int
    {
        return $this->hasAdm;
    }

    public function setHasAdm(int $hasAdm)
    {
        $this->hasAdm = $hasAdm;
    }

    public function getTelefones(): string
    {
        return $this->telefones;
    }

    public function setTelefones(string $telefones)
    {
        $this->telefones = $telefones;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    public function setLogo(string $logo)
    {
        $this->logo = $logo;
    }

    public function getRuaNumero(): string
    {
        return $this->ruaNumero;
    }

    public function setRuaNumero(string $ruaNumero)
    {
        $this->ruaNumero = $ruaNumero;
    }

    public function getCidade(): string
    {
        return $this->cidade;
    }

    public function setCidade(string $cidade)
    {
        $this->cidade = $cidade;
    }

    public function getSms(): int
    {
        return $this->sms;
    }

    public function setSms(int $sms)
    {
        $this->sms = $sms;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado)
    {
        $this->estado = $estado;
    }

    public function getAppToken(): string
    {
        return $this->app_token;
    }

    public function setAppToken(string $app_token)
    {
        $this->app_token = $app_token;
    }

    public function getEnviaNotificacao(): int
    {
        return $this->envia_notificacao;
    }

    public function setEnviaNotificacao(int $envia_notificacao)
    {
        $this->envia_notificacao = $envia_notificacao;
    }

    public function getServer(): string
    {
        return $this->server;
    }

    public function setServer(string $server)
    {
        $this->server = $server;
    }

    public function getFaceAppId(): string
    {
        return $this->face_app_id;
    }

    public function setFaceAppId(string $face_app_id)
    {
        $this->face_app_id = $face_app_id;
    }

    public function getFaceAppSecret(): string
    {
        return $this->face_app_secret;
    }

    public function setFaceAppSecret(string $face_app_secret)
    {
        $this->face_app_secret = $face_app_secret;
    }

    public function getLinkApp(): string
    {
        return $this->link_app;
    }

    public function setLinkApp(string $link_app)
    {
        $this->link_app = $link_app;
    }

    public function getQrApp(): string
    {
        return $this->qr_app;
    }

    public function setQrApp(string $qr_app)
    {
        $this->qr_app = $qr_app;
    }

    public function getActiveChat(): int
    {
        return $this->active_chat;
    }

    public function setActiveChat(int $active_chat)
    {
        $this->active_chat = $active_chat;
    }

    public function getConfirmaEmail(): int
    {
        return $this->confirma_email;
    }

    public function setConfirmaEmail(int $confirma_email)
    {
        $this->confirma_email = $confirma_email;
    }

    public function getFirebaseTopic(): string
    {
        return $this->firebase_topic;
    }

    public function setFirebaseTopic(string $firebase_topic)
    {
        $this->firebase_topic = $firebase_topic;
    }

    public function getNomeDb(): string
    {
        return $this->nome_db;
    }

    public function setNomeDb(string $nome_db)
    {
        $this->nome_db = $nome_db;
    }

    public function getCapKey(): string
    {
        return $this->capKey;
    }

    public function setCapKey(string $capKey)
    {
        $this->capKey = $capKey;
    }

    public function getSmsUser(): string
    {
        return $this->smsUser;
    }

    public function setSmsUser(string $smsUser)
    {
        $this->smsUser = $smsUser;
    }

    public function getSmsPass(): string
    {
        return $this->smsPass;
    }

    public function setSmsPass(string $smsPass)
    {
        $this->smsPass = $smsPass;
    }

}
