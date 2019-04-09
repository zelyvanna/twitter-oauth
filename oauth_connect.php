<?php

//Démarrage de la session
session_start();

// On charge la librairie, qui appellera elle-même les différentes classes
require_once "./twitteroauth/autoload.php";
require_once "./config.php";

// Utiliser la classe TwitterOAuthc
use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;


// Si l'utilisateur n'est PAS connecté


// Instantiation d'un client API sans token
$twitterOAuth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

// Obtention d'un token général, avec possibilité de se connecter via une url
$response = $twitterOAuth->oauth(
    'oauth/request_token', [
        'oauth_callback' => CALLBACK_URL
    ]
);

// Stocker la réponse dans une variable de session
$_SESSION['oauth_token'] = $response['oauth_token'];
$_SESSION['oauth_token_secret'] = $response['oauth_token_secret'];

// Création de l'url pour authoriser un vrai utilisateur pour notre session
$url = $twitterOAuth->url('oauth/authorize', [
    'oauth_token' => $response['oauth_token']
]);



// redirection vers la page d'authentification twitter
header("location:".$url);


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Twitter connect</title>
</head>
<body>

</body>
</html>