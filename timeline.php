<?php

//démarrage de la session
session_start();

// On charge la librairie, qui appellera elle-même les différentes classes
require_once "./twitteroauth/autoload.php";
require_once "./config.php";


// Utiliser la classe TwitterOAuth
use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;


$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['user_token'], $_SESSION['user_secret']);
$content = $connection->get("account/verify_credentials");
$statuses = $connection->get("statuses/home_timeline", ["count" => 25, "exclude_replies" => true]);
echo '<pre>';
print_r($statuses);
echo '</pre>';
