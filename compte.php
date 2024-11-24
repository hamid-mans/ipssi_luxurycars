<?php
session_start();

    include "components/db.php";
    include "components/functions.php";

    $personne = getPersonneById($_SESSION['id']);
	$reservations = getReservationsByUser($_SESSION['id']);

    $error = "";

    if(isset($_POST['sub_edit_compte']))
    {

        $civilite = $_POST['civilite'];
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $pseudo = $_POST['login'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $motdepasse = $_POST['motdepasse'];

        if(!empty($civilite) && !empty($prenom) && !empty($nom) && !empty($pseudo) && !empty($email) && !empty($telephone))
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

                            $reqEditCompte = $db->prepare("UPDATE personne SET civilite = ?, prenom = ?, nom = ?, login = ?, email = ?, telephone = ?, motdepasse = ? WHERE id = ?");
                            $reqEditCompte->execute([$civilite, $prenom, $nom, $pseudo, $email, $telephone, (sha1($motdepasse) ?? $personne['motdepasse']), $personne['id']]);

                            header('location: compte.php');

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
        else
        {
            $error = "Tous les champs doivent être renseignés.";
        }
    }

?>

<html>
    <head>
        <title>LuxuryCars - Mon Compte</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css">
        <link rel="stylesheet" href="styles/main.css">
    </head>
    <body>
        <?php include "components/header.php"; ?>

        <div class="ui container">
            <h1>Bonjour <?= $_SESSION['login'] ?? 'visiteur'; ?>,</h1><br>

            <p class="introduction">Modifier les informations personnelles de votre compte
            <br><br>

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
                            <option value="Mr" <?= $personne['civilite'] == 'Mr' ?'selected' : '' ?>>Mr</option>
                            <option value="Mme" <?= $personne['civilite'] == 'Mme' ?'selected' : '' ?>>Mme</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="prenom">Prénom</label>
                        <input type="text" name="prenom" id="prenom" placeholder="Prénom" value="<?= $personne['prenom']; ?>">
                    </div>

                    <div class="field">
                        <label for="nom">Nom de famille</label>
                        <input type="text" name="nom" id="nom" placeholder="Nom de famille" value="<?= $personne['nom']; ?>">
                    </div>
                </div>

                <div class="two fields">
                    <div class="field">
                        <label for="login">Pseudo</label>
                        <input type="text" name="login" id="login" placeholder="Pseudonyme" value="<?= $personne['login']; ?>">
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Adresse de messagerie" value="<?= $personne['email']; ?>">
                    </div>
                </div>

                <div class="two fields">
                    <div class="field">
                        <label for="telephone">Numéro de téléphone</label>
                        <input type="text" name="telephone" id="telephone" placeholder="Numéro de téléphone" value="<?= $personne['telephone']; ?>">
                    </div>
                    <div class="field">
                        <label for="motdepasse">Mot de passe</label>
                        <input type="password" name="motdepasse" id="motdepasse" placeholder="Mot de passe">
                    </div>
                </div>
                <br>

                <div class="field">
                    <input type="submit" name="sub_edit_compte" value="Modifier" class="ui orange button">
                </div>

            </form>
	        <br><br>

	        <hr>

	        <br><br>

	        <h2>Mes réservations</h2><br>

	        <p class="introduction">
		        Réservez un nouveau véhicul depuis la <a href="vehicules.php">liste des véhicules</a>
	        </p><br>

			<table class="ui celled inverted table">
				<tr>
					<th>Date de réservation</th>
					<th></th>
					<th>Date de début</th>
					<th>Date de fin</th>
					<th>Voiture</th>
					<th>Gérer</th>
				</tr>
				<?php foreach($reservations as $reservation) {

					$car = getVehiculeById($reservation['id_vehicule']);

					?>
					<tr>
						<td><?= $reservation['date_reservation']; ?></td>
						<td></td>
						<td><?= $reservation['date_debut']; ?></td>
						<td><?= $reservation['date_fin']; ?></td>
						<td><?= $car['marque'] . ' ' . $car['modele'] . ' - ' . $car['matricule']; ?></td>
						<td><a href="edit_reservation.php?id=<?= $reservation['id']; ?>">Modifier</a> | <a
									href="delete_reservation.php?id=<?= $reservation['id']; ?>">Supprimer</a> | <a
									href="add_commentaire.php?id=<?= $reservation['id']; ?>">Laisser un commentaire</a></td>
					</tr>
				<?php } ?>
			</table>

        </div>
    </body>
</html>
