<?php
session_start();

include "../components/functions.php";



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
                    <option value="Moto">Camion</option>
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
