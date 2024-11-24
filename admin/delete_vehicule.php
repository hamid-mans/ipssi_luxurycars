<?php
session_start();

include "../components/db.php";
include "../components/functions.php";

$id = htmlspecialchars($_GET["id"]);

$reqDeleteVehicule = $db->prepare("DELETE FROM vehicule WHERE id = ?");
$reqDeleteVehicule->execute([$id]);

header('location: ../vehicules.php');
