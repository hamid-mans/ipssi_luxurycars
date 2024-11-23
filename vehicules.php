<?php
session_start();

include "components/functions.php";

$voitures = getVoitures();

?>

<html>
<head>
    <title>LuxuryCars - Voitures</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
<?php include "components/header.php"; ?>

<div class="ui container">

    <h3>Liste des véhicules (<?= count($voitures); ?>)</h3><br>

	<?php if(isset($_SESSION['admin'])) {
		if($_SESSION['admin']) { ?>
	<a href="admin/add_vehicule.php" class="ui teal button">
		Nouveau
	</a><br><br>
	<?php } } ?>

    <table class="ui celled table">
        <tr class="thead">
            <th>Marque</th>
            <th>Modèle</th>
            <th>Matricule</th>
            <th>Type de véhicule</th>
            <th>Prix journalier</th>
            <th>Disponible</th>
            <th>Photo</th>
        </tr>

        <?php foreach($voitures as $voiture) { ?>
            <tr>
                <td><?= $voiture['marque']; ?></td>
                <td><?= $voiture['modele']; ?></td>
                <td><?= $voiture['matricule']; ?></td>
                <td><?= $voiture['type_vehicule']; ?></td>
                <td><?= $voiture['prix_journalier'] . ' €' ?></td>
                <td><?= ($voiture['statut_dispo']) ? 'Disponible' : 'Pas dispo' ?></td>
                <td><?= $voiture['photo'] ?></td>
            </tr>
        <?php } ?>
    </table>

</div>
</body>
</html>
