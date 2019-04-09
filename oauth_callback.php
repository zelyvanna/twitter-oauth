<?php

//démarrage de la session
session_start();

// On charge la librairie, qui appellera elle-même les différentes classes
require_once "./twitteroauth/autoload.php";
require_once "./config.php";

// Utiliser la classe TwitterOAuth
use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;

function redirectToConnect()
{
    header("location:" . CONNECT_URL);
    die(); //interrompt le script
}

// Si user en train de se connecter
if (isset($_GET['oauth_verifier'],$_SESSION['oauth_token'],$_SESSION['oauth_token_secret'])) {
    $general_token = $_SESSION['oauth_token'];
    $general_token_secret = $_SESSION['oauth_token_secret'];
    $twitterOAuth = new TwitterOAuth(
        CONSUMER_KEY, CONSUMER_SECRET,
        $general_token, $general_token_secret
    );

    try {
        //Obtention des tokens SPECIFIQUES A LUTILISATEUR qui tente de se connecter
        $responseUser = $twitterOAuth->oauth('oauth/access_token', [
            'oauth_verifier' => $_GET['oauth_verifier']
        ]);

        //stocker les infos de l'utilisateur en $_SESSION
        //user_token
        $_SESSION['user_token'] = $responseUser['oauth_token'];
        //user_secret
        $_SESSION['user_secret'] = $responseUser['oauth_token_secret'];
        //ttes les données retournée
        $_SESSION['user'] = $responseUser;

        //redirection vers timeline
        header("location:".APP_URL);

        var_dump($responseUser);
    } catch (TwitterOAuthException $e) {
        //var_dump($e);
        redirectToConnect();
    }

    echo '<h1>Verification</h1>';
    var_dump($_GET['oauth_verifier']);

} else {
    //sil manque quoi que ce soit insérer le lien de redirection vers CONNECT ici
    redirectToConnect();
}