<?php
session_start();

include "components/functions.php";
include "components/db.php";

if(isset($_GET['id']))
{
    $id = htmlspecialchars($_GET['id']);
    $vehicule = getVehiculeById($id);

    $reservation = getReservationById($id);

    $error = "";

    if(isset($_POST['sub_edit_reservation']))
    {
        $datedebut = htmlspecialchars($_POST['datedebut']);
        $datefin = htmlspecialchars($_POST['datefin']);

        if (!empty($datedebut) && !empty($datefin))
        {
            $debut = new DateTime($datedebut);
            $fin = new DateTime($datefin);

            if($debut > $fin)
            {
                $error = "La date de fin ne doit pas précéder la date de début";
            }
            else
            {
                $reqNewReservation = $db->prepare("UPDATE reservation SET date_debut = ?, date_fin = ? WHERE id = ?");
                $reqNewReservation->execute(array($datedebut, $datefin, $id));

                header('location: compte.php');
            }
        }
    }
}

?>

<html>
<head>
    <title>LuxuryCars - Modifier la réservation pour : <?= $vehicule['marque'] . ' ' . $vehicule['modele'] . ' - ' . $vehicule['matricule'] . '. Le ' . $reservation['date_debut']; ?></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
<?php include "components/header.php"; ?>

<div class="ui container">
    <h1>Modifier la réservation pour : <?= $vehicule['marque'] . ' ' . $vehicule['modele'] . ' - ' . $vehicule['matricule'] . '. Le ' . $reservation['date_debut']; ?></h1><br>

    <form method="POST" class="ui form">
        <div class="field">
            <select name="vehicule" id="vehicule" disabled>
                <option value=""><?= $vehicule['marque'] . ' ' . $vehicule['modele'] . ' - ' . $vehicule['matricule']; ?></option>
            </select>
        </div>

        <p id="error"></p>
        <?php if(!empty($error)) { ?>
            <div class="ui negative message">
                <?= $error; ?>
            </div>
        <?php } ?>

        <div class="two fields">
            <div class="field">
                <label for="datedebut">Date de début</label>
                <input type="date" name="datedebut" id="datedebut" value="<?= $reservation['date_debut']; ?>">
            </div>

            <div class="field">
                <label for="datefin">Date de fin</label>
                <input type="date" name="datefin" id="datefin" value="<?= $reservation['date_fin']; ?>">
            </div>
        </div>

        <div class="field">
            <input type="submit" class="ui orange button" name="sub_edit_reservation" value="Modifier">
        </div>
    </form>

</div>

<script>
    let datedebut = document.getElementsByName('datedebut')[0];
    let datefin = document.getElementsByName('datefin')[0];
    let error = document.getElementById("error")

    datedebut.addEventListener('blur', () => {
        if (datedebut.value !== "") {
            let debut = new Date(datedebut.value);
            let fin = new Date(datefin.value);

            if (debut.getTime() > fin.getTime()) {
                console.log("La date de début est après la date de fin.");
            }
        }
    });

    datefin.addEventListener('blur', () => {
        if (datedebut.value !== "") {
            let debut = new Date(datedebut.value);
            let fin = new Date(datefin.value);

            if (debut.getTime() > fin.getTime()) {
                datedebut.style.border = "2px solid red"
                datefin.style.border = "2px solid red"
                error.className = "ui negative message"
                error.innerHTML = "La date de fin ne doit pas précéder la date de début"
            }
        }
    });
</script>
</body>
</html>
