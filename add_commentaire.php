<?php
session_start();

include "components/functions.php";
include "components/db.php";

if(isset($_GET['id']))
{
    $id = htmlspecialchars($_GET['id']);
    $reservation = getReservationById($id);
    $commentaires = getCommentairesByReservation($id);

    $error = "";

    if(isset($_POST['sub_add_commentaire']))
    {
        $commentaire = htmlspecialchars($_POST['commentaire']);
        $note = htmlspecialchars($_POST['note']);

        if(!empty($commentaire) && !empty($note))
        {
            $reqAddCommentaire = $db->prepare("INSERT INTO commentaire(commentaire, date_commentaire, note, id_vehicule, id_personne, id_reservation) VALUES(?, NOW(), ?,?,?,?)");
            $reqAddCommentaire->execute([$commentaire, $note, $reservation['id_vehicule'], $reservation['id_personne'], $id]);

            header('location: compte.php');
        }
        else
        {
            $error = "Veuillez saisir tous les champs";
        }
    }
}

?>


<html>
<head>
    <title>LuxuryCars - Nouveau commentaire</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
<?php include "components/header.php"; ?>

<div class="ui container">

    <h2>Nouveau commentaire sur la réservation n°<?= $reservation['id']; ?></h2><br>

    <?php if(!empty($error)) { ?>
        <div class="ui negative message">
            <?= $error; ?>
        </div>
    <?php } ?>

    <form method="POST" class="ui form">

        <div class="field">
            <textarea name="commentaire" id="commentaire" style="width: 100%" placeholder="Laissez une commentaire..."></textarea>
        </div>
        
        <div class="field">
            <label for="note">Note (1 à 5)</label>
            <input type="number" name="note" id="note" min="1" max="5" value="5">
        </div>

        <div class="field">
            <input type="submit" name="sub_add_commentaire" value="Ajouter" class="ui teal button">
        </div>

    </form>

    <br><br>

    <hr>

    <br><br>

    <h2>Commentaires</h2>

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

