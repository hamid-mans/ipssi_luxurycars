<?php
session_start();

include "../components/functions.php";

$reservations = getReservations();

?>

<html>
<head>
    <title>LuxuryCars - Admin</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css">
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>
<?php include "../components/header.php"; ?>

<div class="ui container">
    <h1>Espace Administrateur</h1><br><br>

    <h3>Gérer les réservations clients</h3>

    <table class="ui celled inverted table">
        <tr class="thead">
            <th>#</th>
            <th>Date réservation</th>
            <th></th>
            <th>Date de début</th>
            <th>Date de fin</th>
            <th>Utilisateur</th>
            <th>Voiture</th>
            <th>Commentaires</th>
            <th>Action</th>
        </tr>

        <?php foreach($reservations as $reservation) {

            $utilisateur = getPersonneById($reservation['id_personne']);
            $vehicule = getVehiculeById($reservation['id_vehicule']);
            $comms = count(getCommentairesByReservation($reservation['id']));

            ?>
            <tr>
                <td><?= $reservation['id']; ?></td>
                <td><?= $reservation['date_reservation']; ?></td>
                <td></td>
                <td><?= $reservation['date_debut']; ?></td>
                <td><?= $reservation['date_fin']; ?></td>
                <td>
                    <?= $utilisateur['civilite'] . " " . $utilisateur['nom'] . " " . $utilisateur['prenom']; ?>
                </td>
                <td>
                    <?= $vehicule['marque'] . ' ' . $vehicule['modele'] . ' - ' . $vehicule['matricule']; ?>
                </td>
                <td><a href="admin/commentaires_reservation.php?id=<?= $reservation['id']; ?>">Voir les <?= $comms; ?> commentaires</a></td>
                <td><a href="delete_reservation.php?id=<?= $reservation['id']; ?>">Supprimer</a></td>
            </tr>
        <?php } ?>
    </table>

</div>
</body>
</html>
