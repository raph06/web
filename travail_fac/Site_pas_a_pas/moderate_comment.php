<?php
include("connect.php"); /* connexion à la base de données sql */
include("functions_admin.php");


if(isset($_POST['Ignorer']))
 $id_ignore=$_POST['Ignorer'];
else      $id_ignore="";

if(isset($_POST['Supprimer']))
    $id_suppress=$_POST['Supprimer'];
else      $id_suppress="";

// on consulte le choix de l'admin
if(empty($id_ignore))
    {
    $suppressing_query = $bdd->query("DELETE FROM commentaire WHERE ID='$id_suppress'");
    }
    else
    {
   	$modif_query = $bdd->exec("UPDATE commentaire SET moderation=0 WHERE ID='$id_ignore'");

    $bdd = '' ;
    }

header("Location: dash_admin_moderation.php");
?>
