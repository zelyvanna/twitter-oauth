<?php

//démarrage de la session
session_start();

// On charge la librairie, qui appellera elle-même les différentes classes
require_once "./twitteroauth/autoload.php";
require_once "./config.php";


// Utiliser la classe TwitterOAuth
use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;

if (!isset($_SESSION['user_token'], $_SESSION['user_secret'])) {
    //demande de connection
    //redirectToConnect();
    header("location:" . CONNECT_URL);
    die(); //interrompt le script
}

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['user_token'], $_SESSION['user_secret']);

//$statuses = $connection->get("statuses/home_timeline", ["count" => 25, "exclude_replies" => true]);

//Reception du formulaire
if (isset($_POST['tweet_text'])) {

    //Envoi du nouveau tweet à l'api
    $status = $connection->post('statuses/update', ["status" => $_POST['tweet_text']]);
}


$content = $connection->get("account/verify_credentials");
$statuses = $connection->get("statuses/home_timeline", ["count" => 25, "exclude_replies" => true]);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Status</title>
    <style>
        body {
            background-color: blueviolet;
        }

        h1 {
            color: white;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>CREA - TWEET oAuth</h1>
        <!-- Formulaire -->
        <form action="timeline.php" method="post">
            <textarea class="form-control" name="tweet_text" placeholder="Votre tweet" rows="8"></textarea>
            <br>
            <button class="btn btn-primary btn-block" type="submit"> Tweeter</button>
        </form>


        <?php
        //Affichage status (tweets timeline)
        foreach ($statuses as $tweet) {
            ?>
            <hr>
            <div class="card">
                <div class="card-body">
                    <img src="<?php echo $tweet->user->profile_image_url ?>" class="rounded float-right">
                    <p class="card-text">
                        <?php
                        echo $tweet->text;
                        ?>
                    </p>
                </div>
                <div class="card-footer">
                    <b>
                        <?php echo $tweet->user->name ?>
                    </b>
                    <?php echo "@" . $tweet->user->screen_name ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>

