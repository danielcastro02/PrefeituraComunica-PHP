<?php

session_start();
require_once '../vendor/autoload.php';
include_once '../Modelo/Parametros.php';
$parametros = new parametros();
echo $parametros->getServer();
$fb = new Facebook\Facebook([
    'app_id' => $parametros->getFace_app_id(),
    'app_secret' => $parametros->getFace_app_secret(),
    'default_graph_version' => 'v2.10',
        ]);

$helper = $fb->getRedirectLoginHelper();

try {
    $accessToken = $helper->getAccessToken($parametros->getServer()."/Controle/facebookRest.php");
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo $e->getMessage();
    exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo $e->getMessage();
    // When validation fails or other local issues
    exit;
}

if (!isset($accessToken)) {
    if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
    } else {
        header('HTTP/1.0 400 Bad Request');
    }
    exit;
}

// Logged in

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId($parametros->getFace_app_id());

// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (!$accessToken->isLongLived()) {
    // Exchanges a short-lived access token for a long-lived one
    try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo $e->getMessage();
        exit;
    }

    echo '<h3>Long-lived</h3>';
}

$usuario = $fb->get('/me?fields=id,name,email,picture{url}', $accessToken);
$us = $usuario->getGraphUser();
$_SESSION['fb_access_token'] = (string) $accessToken;

include_once './usuarioPDO.php';
$usuarioPDO = new UsuarioPDO();
$usuarioPDO->insertFacebook($us);
