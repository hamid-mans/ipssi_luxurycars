<?php
session_start();

include "components/db.php";
include "components/functions.php";

$id = htmlspecialchars($_GET["id"]);

$reqDeleteReservation = $db->prepare("DELETE FROM reservation WHERE id = ?");
$reqDeleteReservation->execute([$id]);

header('location: compte.php');
