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

    <table class="ui celled inverted table">
        <tr class="thead">
	        <th>Photo</th>
	        <th>Marque</th>
            <th>Modèle</th>
            <th>Matricule</th>
            <th>Type de véhicule</th>
            <th>Prix journalier</th>
            <th>Disponible</th>
	        <th>Reservation</th>
	        <?php if(isset($_SESSION['admin'])) { ?>
                <?php if($_SESSION['admin']) { ?> <th>Administration</th> <?php } ?>
	        <?php } ?>
        </tr>

        <?php foreach($voitures as $voiture) { ?>
            <tr>
	            <td><?php if(!empty($voiture['photo'])) { ?> <img width="200" src="./images/vehicules/<?= $voiture['photo'] ?>" alt="Photo"> <?php } else echo 'Pas d\'image' ?></td>
	            <td><?= $voiture['marque']; ?></td>
                <td><?= $voiture['modele']; ?></td>
                <td><?= $voiture['matricule']; ?></td>
                <td><?= $voiture['type_vehicule']; ?></td>
                <td><?= $voiture['prix_journalier'] . ' €' ?></td>
                <td style="font-weight:bold; color: <?= ($voiture['statut_dispo']) ? 'green' : 'red' ?>"><?= ($voiture['statut_dispo']) ? 'Disponible' : 'Pas dispo' ?></td>
                <?php if($voiture['statut_dispo']) { ?> <td><a class="ui teal button" href="add_reservation.php?id=<?= $voiture['id']; ?>">Réserver</a></td> <?php } else { ?> <td style="font-weight: bold;color:red;">Pas dispo</td> <?php } ?>

	            <?php if(isset($_SESSION['admin'])) { ?>
                    <?php if($_SESSION['admin']) { ?> <td><a href="admin/edit_vehicule.php?id=<?= $voiture['id']; ?>">Modifier</a> | <a href="admin/delete_vehicule.php?id=<?= $voiture['id']; ?>">Supprimer</a></td> <?php } ?>
	            <?php } ?>
            </tr>
        <?php } ?>
    </table>

</div>
</body>
</html>
