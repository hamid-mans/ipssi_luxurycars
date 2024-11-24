<?php
session_start();

include "../components/functions.php";

if(isset($_GET['id']))
{
    $id = htmlspecialchars($_GET["id"]);
    $vehicule = getVehiculeById($id);

    if(isset($_POST['sub_edit_vehicule']))
    {
        $marque = htmlspecialchars($_POST['marque']);
        $modele = htmlspecialchars($_POST['modele']);
        $type = htmlspecialchars($_POST['type']);
        $matricule = htmlspecialchars($_POST['matricule']);
        $prix = htmlspecialchars($_POST['prix']);
        $photo = $_FILES['photo'];
		$dispo = ($_POST['dispo']) ? 1 : 0;

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
                $reqAddVehicule = $db->prepare("UPDATE vehicule SET marque = ?, modele = ?, matricule = ?, type_vehicule = ?, prix_journalier = ?, statut_dispo = ?, photo =? WHERE id = ?");
                $reqAddVehicule->execute([$marque, $modele, $matricule, $type, $prix, $dispo, $photo_final ?? $vehicule['photo'], $id]);

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
}


?>

<html>
<head>
    <title>LuxuryCars - Modifier la voiture : <?= $vehicule['marque'] . ' ' . $vehicule['modele'] . ' - ' . $vehicule['matricule']; ?></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css">
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>
<?php include "../components/header.php"; ?>

<div class="ui container">
    <h1>Espace Administrateur</h1><br><br>

    <h3>Modifier le véhicule :  <?= $vehicule['marque'] . ' ' . $vehicule['modele'] . ' - ' . $vehicule['matricule']; ?></h3>
    <br>
    <?php if(!empty($error)) { ?>
        <div class="ui negative message">
            <?= $error; ?>
        </div>
    <?php } ?>

    <br>


    <form method="POST" enctype="multipart/form-data" class="ui celled form">
        <div class="three fields">
            <div class="field">
                <label for="marque">Marque</label>
                <input type="text" name="marque" id="marque" placeholder="Marque" value="<?= $vehicule['marque']; ?>">
            </div>
            <div class="field">
                <label for="modele">Modèle</label>
                <input type="text" name="modele" id="modele" placeholder="Modèle" value="<?= $vehicule['modele']; ?>">
            </div>
            <div class="field">
                <label for="type">Type de véhicule</label>
                <select name="type" id="type">
                    <option value="Voiture" <?= ($vehicule['type_vehicule'] == 'Voiture') ? 'selected' : '' ?>>Voiture</option>
                    <option value="Camion" <?= ($vehicule['type_vehicule'] == 'Camion') ? 'selected' : '' ?>>Camion</option>
                    <option value="Moto" <?= ($vehicule['type_vehicule'] == 'Moto') ? 'selected' : '' ?>>Moto</option>
                </select>
            </div>
        </div>


        <div class="two fields">
            <div class="field">
                <label for="matricule">Matricule</label>
                <input type="text" name="matricule" id="matricule" placeholder="Matricule" value="<?= $vehicule['matricule']; ?>">
            </div>
            <div class="field">
                <label for="prix">Prix journalier</label>
                <input type="number" name="prix" id="prix" placeholder="Prix journalier" value="<?= $vehicule['prix_journalier']; ?>">
            </div>
        </div>

        <div class="field">
            <label for="photo">Photo principale</label>
            <input type="file" name="photo" id="photo">
        </div>

	    <div class="inline field">
		    <div class="ui checkbox">
			    <input type="checkbox" name="dispo" id="dispo" <?= ($vehicule['statut_dispo']) ? 'checked' : '' ?>>
			    <label for="dispo">Disponible</label>
		    </div>
	    </div>

        <div class="field">
            <input type="submit" value="Modifier" name="sub_edit_vehicule" class="ui teal button">
        </div>
    </form>


</div>
</body>
</html>

