<?php
include("connect.php"); /* connexion à la base de données sql */
 include('functions_admin.php');//inclure les fonctions relatives aux pages admins
try_session($_SESSION);// teste la manière dont un utilisateur accède à cette page
$bool_user=which_admin();// définit le type d'admin (admin-super)


?>
<!DOCTYPE html>
<html>
<head>
<title>Admin dashboard</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style_admin.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,600,400italic,600italic,700' rel='stylesheet' type='text/css'>
</head>
<body>

<div id="header">
  <div class="logo">
    <a href="AccueilConnecte.php">E<span>Sitting</span></a>

  </div>
  <div id="déconnexion">
                        <a href="logout.php" class="myButton">Déconnexion</a>
                    </div>

</div>


<a class="mobile">MENU</a>


<div id="container">

  <div class="sidebar">
    <ul id="nav">
      <li><a href="dash_admin.php">Tableau de bord</a></li>
      <li><a href="dash_admin_moderation.php">Modération des commentaires</a></li>
      <li><a href="dash_admin_profils_etu.php">Modération profils Etudiant</a></li>
      <li><a class='selected' href="dash_admin_profils_fam.php">Modération profils Famille</a></li>
      <li><a href="dash_admin_taux.php">Modifier les taux de E-sitting</a></li>
      <?php if ($bool_user)// si super_admin uniquement
      {echo ("<li><a href='dash_admin_nouvel_admin.php'>Modifications administrateurs</a></li>");}?>

    </ul>

  </div>
  <div class="content">

    <h1>Modération profils</h1>
    <div id="box">
     <div class="box-top">Profils famille</div>
     <div class="box-panel">


  <?php
  //Variables permettant la transition affichage_seul->modification_champs
 // pour chacuns des profils
 if(isset($_GET['open'])) //si demande de modification
     $switch=$_GET['open']; // paramètrage
 else      $switch=0;      // affichage seul par default
 if(isset($_GET['id']))
     $flag=$_GET['id'];   // selectionne le profil en question
 else      $flag="";

  $status="famille";


  {
// récupèration des données
        $profils = $bdd->query("SELECT * FROM `users`WHERE user_type='Famille' AND moderation='1'");
        while ($donnees = $profils->fetch())
      {
        $id_profile=$donnees['ID'];
        $user_type=$donnees['user_type'];
        $nom= $donnees['nom'] ;
        $enfants=$donnees['enfants'];
        $date_enfants=$donnees['date_enfants'];if (empty($date_enfants)) {$date_enfants='NC';}
        $postal=$donnees['code_postal'];
        $adresse=$donnees['adresse'];
        $tel=$donnees['telephone'];
        $description=$donnees['description'];
        $image=$donnees['image'];
        echo('Profil: '.$id_profile);

        if ($switch=='1' and $flag==$id_profile)// si besoin de modifications
        {
        echo("
        <form action='moderate_profile.php' method='post'>
        <br/><img src=images/$image alt='image' height='225'width='225'/>
        <label>Image data</label> <input type='text' name='image' Value=$image READONLY/>
        <label>User ID</label> <input type='text' name='ID_fam' Value=$id_profile READONLY/>
        <label>User type</label> <input type='text' name='user' Value=$user_type READONLY/><br/>
        <label>Nom</label> <input type='text' name='nom' Value=$nom size='30' maxlength='20' />
      <label>Enfants </label><input type='number'  name='enfants' Value=$enfants min='0' />
      <label>Age_enfants </label><input type=''date('yyyy-mm-dd')''  name='date' Value= $date_enfants /><br/><br/>
       <label> CP </label><input type='text'  name='CP' Value= $postal size='30' minlength='5' maxlength='5' />
       <label>Téléphone </label><input type='number'  name='tel' Value= $tel max='9999999999' /><br/><br/>
        <label>Adresse </label><input type='text' name=adresse Value=$adresse size='30' maxlength='50' /><br/>
       <label>Mini-bio <textarea name= minibio> $description </textarea></br>");

  echo("<input type='submit' name='Modifié' value='Valider'><input type='submit' name='Modifié' value='Annuler'>  </form>".'</br></br>');
  $switch=0;
      }
// affichage par defaut lecture seule
      else {
           echo("<br/><img src=images/$image alt='image' height='225'width='225'/>");
             echo( '<p>'. 'Identité: '.$nom .'</p>');
             echo( '<p>'. 'Coordonnées : ' .$postal.', '.$adresse.', Tel: '.$tel.'</p>') ;
          echo('<p>Autres informations:'. 'Enfants: '. $enfants.', Age des enfants: '.$date_enfants.'</p>');
          echo('<p>Mini-bio: '. $description . '</p>');

    echo("<form action='moderate_profile.php' method='post'>
    <input type='hidden' value='$status' name='user_type'>
    <input type='hidden' value='$id_profile' name='user_id'>
      <button type='submit' name='Modérer' value='$id_profile,' class='btn-link'>Modérer</button>
     <button type='submit' name='Ignorer' value='$id_profile' class='btn-link'>Ignorer</button>
      <button type='submit' name='Supprimer' value='$id_profile' class='btn-link'>Supprimer</button>

    </form>".'</br>');
      }

    }
    $profils->closeCursor();
   // $bdd='';
  }

?>
     </div>
    </div>


  </div>


</div><!-- #container -->

<script type="text/javascript">

	$(document).ready(function(){
     $("a.mobile").click(function(){
      $(".sidebar").slideToggle('fast');
     });

    window.onresize = function(event) {
      if($(window).width() > 480){
      	$(".sidebar").show();
      }
    };


	});

</script>

</body>
</html>
