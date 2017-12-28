 <?php

include("connect.php"); /* connexion à la base de données sql */
include("functions_admin.php");



if(isset($_POST['Fériés']))
 $feries=$_POST['Fériés'];
else      $feries="";

if(isset($_POST['Week_end']))
    $we=$_POST['Week_end'];
else      $we="";

if(isset($_POST['Nuit']))       $nuit=$_POST['Nuit'];
else      $nuit="";

if(isset($_POST['Commissions']))       $commissions=$_POST['Commissions'];
else      $commissions="";

// On vérifie si les champs obligatoires sont vides
if(empty($we) OR empty($commissions) OR empty($feries) OR empty($nuit))
    {
    echo '<font color="red"> Attention, Aucun champ ne peut rester vide !</font>';
    }

    // on écrit la requête sql
     $update1 = $bdd->exec("UPDATE taux_site SET valeur=$nuit WHERE periode='Nuit'");

     $update2 = $bdd->exec("UPDATE taux_site SET valeur=$we WHERE periode='Week-end'");
     $reponse3 = $bdd->exec("UPDATE taux_site SET valeur=$commissions WHERE periode='Commissions'");
     $reponse4 = $bdd->exec("UPDATE taux_site SET valeur=$feries WHERE periode='Fériés'");

    $bdd = '' ;

mail_it($bdd,$Week_end,$Nuit,$Commissions,$Fériés);

header('Location: dash_admin_taux.php');






?>
