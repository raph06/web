<?php
include('connect.php'); /* connexion à la base de données sql */
include('functions_admin.php'); //inclure les fonctions relatives aux pages admins
try_session($_SESSION); // teste la manière dont un utilisateur accède à cette page
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
      <li><a class="selected" href="#">Modération des commentaires</a></li>
      <li><a href="dash_admin_profils_etu.php">Modération profils Etudiant</a></li>
      <li><a href="dash_admin_profils_fam.php">Modération profils Famille</a></li>
      <li><a href="dash_admin_taux.php">Modifier les taux de E-sitting</a></li>
      <?php if ($bool_user) //si super_admin seulement
      {echo ("<li><a href='dash_admin_nouvel_admin.php'>Modifications administrateurs</a></li>");}?>
    </ul>

  </div>
  <div class="content">

    <h1>Commentaires signalés</h1>
    <div id="box">
     <div class="box-top">Commentaires</div>
     <div class="box-panel">
  <?php
{
  get_comments($bdd);

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
