<?php
session_start();
include "components/db.php";
include "components/functions.php";

    $error = "";

    if(isset($_POST["sub_login"]))
    {
        $email = $_POST["email"];
        $motdepasse = $_POST["motdepasse"];

        if(!empty($email) && !empty($motdepasse))
        {
            $personne = getPersonneByEmail($email);

            if(!$personne)
            {
                $error = "Adresse email ou mot de passe incorrect";
            }
            else
            {
                if($personne['motdepasse'] == sha1($motdepasse))
                {
                    // REUSSI

                    $_SESSION['login'] = $personne['login'];
					$_SESSION['id'] = $personne['id'];
					if($personne['role'] == 'ADMIN')
                    {
						$_SESSION['admin'] = true;
                    }

					header('location: compte.php');
                }
                else
                {
                    $error = "Adresse email ou mot de passe incorrect";
                }
            }
        }
        else
        {
            $error = "Veuillez renseigner tous les champs";
        }
    }

?>

<html>
<head>
    <title>LuxuryCars - Connexion</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
<?php include "components/header.php"; ?>

<div class="ui container">
    <h1>Connectez-vous</h1><br>

    <?php if(!empty($error)) { ?>
        <div class="ui negative message">
            <?= $error; ?>
        </div>
    <?php } ?>

    <br>

    <form method="POST" class="ui form">


        <div class="two fields">
            <div class="field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Adresse de messagerie">
            </div>

            <div class="field">
                <label for="motdepasse">Mot de passe</label>
                <input type="password" name="motdepasse" id="motdepasse" placeholder="Mot de passe">
            </div>
        </div>

        <div class="field">
            <input type="submit" name="sub_login" value="Se connecter" class="ui teal button">
        </div>

    </form>

</div>
</body>
</html>

