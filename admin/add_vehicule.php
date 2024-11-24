<?php
session_start();

include "../components/functions.php";
include "../components/db.php";

if(isset($_POST['sub_new_vehicule']))
{
	$marque = htmlspecialchars($_POST['marque']);
	$modele = htmlspecialchars($_POST['modele']);
	$type = htmlspecialchars($_POST['type']);
	$matricule = htmlspecialchars($_POST['matricule']);
	$prix = htmlspecialchars($_POST['prix']);
	$photo = $_FILES['photo'];

	$error = "";

	$photo_name = explode('.', $photo['name']);
	$photo_tmp = $_FILES['photo']['tmp_name'];

	if(!empty($photo['name']))
    {
		$photo_final = sha1($photo_name[0]) . '.' . $photo_name[1];
    }

	if(!empty($marque) && !empty($modele) && !empty($type) && !empty($matricule) && !empty($prix) && !empty($photo))
    {
		if($prix >= 100 && $prix <= 350)
        {
			$reqAddVehicule = $db->prepare("INSERT INTO vehicule(marque, modele, matricule, prix_journalier, type_vehicule, statut_dispo, photo) VALUES(?,?,?,?,?,?,?)");
			$reqAddVehicule->execute([$marque, $modele, $matricule, $prix, $type, 1, $photo_final ?? null]);

            move_uploaded_file($photo_tmp, "../images/vehicules/" . $photo_final);

            header('location: ../vehicules.php');
        }
		else
        {
			$error = "Le prix doit être en 100€ et 350€";
        }
    }
	else
    {
		$error = "Tous les champs doivent être renseignés. La photo est optionnelle.";
    }
}

?>

<html>
<head>
    <title>LuxuryCars - Nouvelle voiture</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css">
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>
<?php include "../components/header.php"; ?>

<div class="ui container">

    <h3>Nouvelle voiture</h3><br>

    <?php if(!empty($error)) { ?>
		<div class="ui negative message">
            <?= $error; ?>
		</div>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data" class="ui celled form">
        <div class="three fields">
            <div class="field">
                <label for="marque">Marque</label>
                <input type="text" name="marque" id="marque" placeholder="Marque">
            </div>
            <div class="field">
                <label for="modele">Modèle</label>
                <input type="text" name="modele" id="modele" placeholder="Modèle">
            </div>
            <div class="field">
                <label for="type">Type de véhicule</label>
                <select name="type" id="type">
                    <option value="Voiture">Voiture</option>
                    <option value="Camion">Camion</option>
                    <option value="Moto">Moto</option>
                </select>
            </div>
        </div>


        <div class="two fields">
            <div class="field">
                <label for="matricule">Matricule</label>
                <input type="text" name="matricule" id="matricule" placeholder="Matricule">
            </div>
            <div class="field">
                <label for="prix">Prix journalier</label>
                <input type="number" name="prix" id="prix" placeholder="Prix journalier">
            </div>
        </div>

	    <div class="field">
		    <label for="photo">Photo principale</label>
		    <input type="file" name="photo" id="photo">
	    </div>

	    <div class="field">
		    <input type="submit" value="Ajouter" name="sub_new_vehicule" class="ui teal button">
	    </div>
    </form>

</div>
</body>
</html>
