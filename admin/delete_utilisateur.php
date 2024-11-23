<?php
session_start();

include "../components/db.php";
include "../components/functions.php";

$id = htmlspecialchars($_GET["id"]);

$personne = getPersonneById($id);

$reqDeletePersonne = $db->prepare("DELETE FROM personne WHERE id = ?");
$reqDeletePersonne->execute([$id]);

header('location: utilisateurs.php');
