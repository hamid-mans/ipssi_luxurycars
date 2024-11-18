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