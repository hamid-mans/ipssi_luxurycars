<?php
session_start();

include "../components/functions.php";

$personnes = getAllPersonnes();

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

    <h3>Gérer les utilisateurs</h3>

    <table class="ui celled inverted table">
        <tr class="thead">
            <th>#</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Pseudo</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Rôle</th>
            <th>Date Création</th>
            <th>Action</th>
        </tr>

        <?php foreach($personnes as $personne) { ?>
            <tr>
                <td><?= $personne['id']; ?></td>
                <td><?= $personne['prenom']; ?></td>
                <td><?= $personne['nom']; ?></td>
                <td><?= $personne['login']; ?></td>
                <td><?= $personne['email']; ?></td>
                <td><?= $personne['telephone']; ?></td>
                <td><?= $personne['role']; ?></td>
                <td><?= $personne['date_inscription']; ?></td>
                <td><a href="admin/edit_utilisateur.php?id=<?= $personne['id']; ?>">Modifier</a> | <a
			                href="admin/delete_utilisateur.php?id=<?= $personne['id']; ?>">Supprimer</a></td>
            </tr>
        <?php } ?>
    </table>

</div>
</body>
</html>
