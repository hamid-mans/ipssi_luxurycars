<?php

include 'db.php';


function getPersonneById($id)
{
    global $db;
    $req = $db->prepare("SELECT * FROM personne WHERE id = ?");
    $req->execute([$id]);

    return $req->fetch();
}

function getPersonneByEmail($email)
{
    global $db;
    $req = $db->prepare("SELECT * FROM personne WHERE email = ?");
    $req->execute([$email]);

    return $req->fetch();
}

function existTelephone($telephone)
{
    global $db;
    $req = $db->prepare("SELECT * FROM personne WHERE telephone = ?");
    $req->execute([$telephone]);

    return $req->rowCount();
}

function existPseudo($pseudo)
{
    global $db;
    $req = $db->prepare("SELECT * FROM personne WHERE login = ?");
    $req->execute([$pseudo]);

    return $req->rowCount();
}

function getAllPersonnes()
{
    global $db;
    $req = $db->prepare("SELECT * FROM personne");
    $req->execute();

    return $req->fetchAll();
}

function getVoitures()
{
    global $db;
    $req = $db->prepare("SELECT * FROM vehicule");
    $req->execute();

    return $req->fetchAll();
}

function getVehiculeById($id)
{
    global $db;
    $req = $db->prepare("SELECT * FROM vehicule WHERE id = ?");
    $req->execute([$id]);

    return $req->fetch();
}

function getReservations()
{
    global $db;
    $req = $db->prepare("SELECT * FROM reservation");
    $req->execute();

    return $req->fetchAll();
}

function getReservationById($id)
{
    global $db;
    $req = $db->prepare("SELECT * FROM reservation WHERE id = ?");
    $req->execute([$id]);

    return $req->fetch();
}

function getReservationsByUser($userId)
{
    global $db;
    $req = $db->prepare("SELECT * FROM reservation WHERE id_personne = ?");
    $req->execute([$userId]);

    return $req->fetchAll();
}

function getCommentairesByReservation($id)
{
    global $db;
    $req = $db->prepare("SELECT * FROM commentaire WHERE id_reservation = ?");
    $req->execute([$id]);

    return $req->fetchAll();
}