<?php
include("connect.php"); /* connexion à la base de données sql */
include("functions.php");

// On récupère ici les infos que l'utilisateur peut être amené à modifier. Si certains champs étaient restés vides, on récupère la valeur NULL, le cas est traité dans ModificationProfilUtilisateur.php

$req = $bdd->prepare('SELECT user_type, nom, prenom, email, naissance, code_postal, adresse, telephone, tarif, cni, etudes, permis, description, enfants, image, tempsreponse FROM `users` WHERE ID = :utilisateur');

$req->execute(array('utilisateur' => $_SESSION['ID']));

//récupération des champs modifiable dans la base de données
while ($donnees = $req->fetch())
{
    $type_utilisateur = $donnees['user_type'] ;
    $ancien_nom = $donnees['nom'] ;
    $ancien_prenom = $donnees['prenom'] ;
    $ancien_email = $donnees['email'] ;
    //la date de naissance soit être reformatée pour être affichée et modifiée facilement par l'utilisateur
    $ancien_naissance = $donnees['naissance'] ;
    $ancien_jourNaissance = substr($ancien_naissance, 8, 2);
    $ancien_moisNaissance = substr($ancien_naissance, 5, 2);
    $ancien_anneeNaissance = substr($ancien_naissance, 0, 4);
    $ancien_cp = $donnees['code_postal'] ;
    $ancien_adresse = $donnees['adresse'] ;
    $ancien_telephone = $donnees['telephone'] ;
    $ancien_tarif = $donnees['tarif'] ;
    $ancien_cni = $donnees['cni'] ;
    $ancien_etudes = $donnees['etudes'] ;
    $ancien_permis = $donnees['permis'] ;
    $ancien_description = $donnees['description'] ;
    $ancien_enfants = $donnees['enfants'] ;
    $ancien_image = $donnees['image'] ;
    $ancien_temps = $donnees['tempsreponse'] ;

}

$req->closeCursor();

?>
