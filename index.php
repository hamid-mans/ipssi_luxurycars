<?php
session_start();

?>

<html>
    <head>
        <title>Devoir à rendre : Agence de location</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css">
        <link rel="stylesheet" href="styles/main.css">
    </head>
    <body>
        <?php include "components/header.php"; ?>

        <div class="ui container">
	        <h1>Bienvenue <?= $_SESSION['login'] ?? 'visiteur'; ?>,</h1><br>

	        <p class="introduction">LuxuryCars est une application qui vous permet de louer des voitures simplement et rapidement. Gardez un oeil rapide sur vos réservations, vous pourrez les modifier 24h avant votre réservation !<br><br>LuxuryCars l'expert de votre gestion automobile.</p>
	        <br>

            <?php if(!isset($_SESSION['login'])) { ?>
	            <a href="register.php" class="ui teal button">Commencer</a>
            <?php } else { ?>
		        <a href="#" class="ui teal button">Mon compte</a>
            <?php } ?>



        </div>
    </body>
</html>
