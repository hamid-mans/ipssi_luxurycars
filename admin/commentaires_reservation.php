<?php
session_start();

include "../components/functions.php";

if(isset($_GET['id']))
{
    $id = htmlspecialchars($_GET['id']);
    $commentaires = getCommentairesByReservation($id);
}

?>

<html>
<head>
    <title>LuxuryCars - Commentaires</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css">
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>
<?php include "../components/header.php"; ?>

<div class="ui container">
    <h1>Espace Administrateur</h1><br><br>

    <h3>Commentaires de la réservation n° <?= $id; ?></h3>

    <table class="ui inverted celled table">
        <tr>
            <th>Commentaire</th>
            <th>Note</th>
            <th>Date du commentaire</th>
        </tr>
        <?php foreach($commentaires as $commentaire) { ?>
            <tr>
                <td><?= $commentaire['commentaire']; ?></td>
                <td><?= $commentaire['note']; ?></td>
                <td><?= $commentaire['date_commentaire']; ?></td>
            </tr>
        <?php } ?>
    </table>

</div>
</body>
</html>
