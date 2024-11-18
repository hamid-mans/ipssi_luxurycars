<?php
session_start();
    include 'components/db.php';

    $error = "";

    if(isset($_POST['sub_register']))
    {
        $civilite = $_POST['civilite'];
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $pseudo = $_POST['login'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $motdepasse = sha1($_POST['motdepasse']);

        if(!empty($civilite) && !empty($prenom) && !empty($nom) && !empty($pseudo) && !empty($email) && !empty($telephone) && !empty($motdepasse))
        {
            if($civilite == "no")
            {
                $error = "Veuillez renseigner une civilité.";
            }
            else
            {
                if(strpos($pseudo, ' ') !== false)
                {
                    $error = "Aucun espace n'est autorisé pour le pseudonyme et le mot de passe";
                }
                else
                {
                    if(strlen($telephone) == 10)
                    {
                        if(preg_match("/^\d+$/", $telephone))
                        {
                            if(strpos($motdepasse, ' ') !== false)
                            {
                                $error = "Aucun espace n'est autorisé pour le pseudonyme et le mot de passe";
                            }
                            else
                            {
                                // REUSSI

                                $reqNewUser = $db->prepare("INSERT INTO personne(civilite, prenom, nom, login, email, role, date_inscription, telephone, motdepasse) VALUES (?,?,?,?,?,?,now(),?,?)");
                                $reqNewUser->execute([$civilite, $prenom, $nom, $pseudo, $email, 'CLIENT', $telephone, $motdepasse]);
                                $_SESSION['login'] = $pseudo;
                                header('location: index.php');
                            }
                        }
                        else
                        {
                            $error = "Votre numéro de téléphone est incorrect";
                        }
                    }
                    else
                    {
                        $error = "Votre numéro de téléphone doit contenir 10 caractères.";
                    }
                }
            }
        }
        else
        {
            $error = "Tous les champs doivent être renseignés.";
        }
    }

?>

<html>
    <head>
        <title>LuxyCars - Créer mon compte</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css">
        <link rel="stylesheet" href="styles/main.css">
    </head>
    <body>
        <?php include "components/header.php"; ?>

        <div class="ui container">
            <h1>Créer un nouveau compte</h1><br>

            <?php if(!empty($error)) { ?>
            <div class="ui negative message">
                <?= $error; ?>
            </div>
            <?php } ?>

            <br>

            <form method="POST" class="ui form">

                <div class="three fields">
                    <div class="field">
                        <label for="civilte">Civilité</label>
                        <select name="civilite" id="civilite">
                            <option value="no">-- Veuillez choisir une civilité --</option>
                            <option value="Mr">Mr</option>
                            <option value="Mme">Mme</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="prenom">Prénom</label>
                        <input type="text" name="prenom" id="prenom" placeholder="Prénom">
                    </div>

                    <div class="field">
                        <label for="nom">Nom de famille</label>
                        <input type="text" name="nom" id="nom" placeholder="Nom de famille">
                    </div>
                </div>

                <div class="two fields">
                    <div class="field">
                        <label for="login">Pseudo</label>
                        <input type="text" name="login" id="login" placeholder="Pseudonyme">
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Adresse de messagerie">
                    </div>
                </div>
                
                <div class="two fields">
                    <div class="field">
                        <label for="telephone">Numéro de téléphone</label>
                        <input type="text" name="telephone" id="telephone" placeholder="Numéro de téléphone">
                    </div>
                    <div class="field">
                        <label for="motdepasse">Mot de passe</label>
                        <input type="password" name="motdepasse" id="motdepasse" placeholder="Mot de passe">
                    </div>
                </div>
                <br>

                <div class="field">
                    <input type="submit" name="sub_register" value="Commencer" class="ui teal button">
                </div>

            </form>

        </div>
    </body>
</html>
