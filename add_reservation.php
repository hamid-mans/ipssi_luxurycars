<?php
session_start();

include "components/functions.php";
include "components/db.php";

if(isset($_GET['id']))
{
	$id = htmlspecialchars($_GET['id']);
    $vehicule = getVehiculeById($id);

	$error = "";

	if(isset($_POST['sub_new_reservation']))
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
				$reqNewReservation = $db->prepare("INSERT INTO reservation(date_reservation, date_debut, date_fin, id_vehicule, id_personne) VALUES(NOW(),?,?,?,?)");
				$reqNewReservation->execute(array($datedebut, $datefin, $id, $_SESSION['id']));

				header('location: compte.php');
            }
        }
    }
}

?>

<html>
<head>
    <title>LuxuryCars - Nouvelle réservation pour : <?= $vehicule['marque'] . ' ' . $vehicule['modele'] . ' - ' . $vehicule['matricule']; ?></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
	<?php include "components/header.php"; ?>

	<div class="ui container">
	    <h1>Nouvelle réservation <?= $vehicule['marque'] . ' ' . $vehicule['modele'] . ' - ' . $vehicule['matricule']; ?></h1><br>

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
					<input type="date" name="datedebut" id="datedebut">
				</div>

				<div class="field">
					<label for="datefin">Date de fin</label>
					<input type="date" name="datefin" id="datefin">
				</div>
			</div>

			<div class="field">
				<input type="submit" class="ui teal button" name="sub_new_reservation" value="Ajouter">
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
