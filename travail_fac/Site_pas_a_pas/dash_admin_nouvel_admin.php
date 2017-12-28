<?php
include("connect.php"); /* connexion à la base de données sql */
include("functions_admin.php"); //inclure les fonctions relatives aux pages admins
try_session($_SESSION);// teste la manière dont un utilisateur accède à cette page
$bool_user=which_admin();// définit le type d'admin (admin-super)
if ($bool_user!=1) // redirige en cas de mauvais type d'admin
header('location: dash_admin.php');
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
  <div id="bdd">
  <a href="update.php" class="myButton">Màj BDD</a>
  </div>
</div>

<a class="mobile">MENU</a>


<div id="container">

  <div class="sidebar">
    <ul id="nav">
      <li><a href="dash_admin.php">Tableau de bord</a></li>
      <li><a href="dash_admin_moderation.php">Modération des commentaires</a></li>
      <li><a href="dash_admin_profils_etu.php">Modération profils Etudiant</a></li>
      <li><a href="dash_admin_profils_fam.php">Modération profils Famille</a></li>
      <li><a  href="dash_admin_taux.php">Modifier les taux de E-sitting</a>
      </li>

      <li><a class="selected" href="#">Modifications administrateurs</a></li>

    </ul>

  </div>
  <div class="content">
    <h1>Modification des administrateurs</h1>

    <div id="box">
     <div class="box-top">Ajouter un administrateur</div>
     <div class="box-panel">
<form method="POST" action="Inscription_admin.php">

      <label>Adresse e-mail: </label> <input type="text" name="mail_new_admin" placeholder="Entrez une adresse mail valide" /> <br/><br/>
      <label>Mot de passe:  </label><input type="password" name="Password" placeholder="Entrez un mot de passe robuste"  /> <br/><br/>
     <label>Répeter le mot de passe:  </label><input type="password" name="Password_again" placeholder="Retapez le mot de passe"  />


     </div>
    </div>
 <!--on ajoute un admin via email + mdp => inscription_admin.php -->

<input type="submit" name="submit" /> <br/><br/>
</form>


<div id="box">
     <div class="box-top">Supprimer un administrateur</div>
     <div class="box-panel">

<form method="post" action="suppression_admin.php">

    <label>Adresse e-mail:</label><input type="text" name="admin_to_suppress" placeholder="Entrez une adresse mail " /><br/>
      </div>
    </div>
<!--on supprime un admin via email  => suppression_admin.php-->


<input type="submit" value="Supprimer" /> <br/>
</form>
<!-- gestion d'erreur email inconnu-->
<?php
if (isset($_GET['error']) && $_GET['error']=='no_users')
echo ("Cet utilisateur n'est pas référencé comme administrateur") ?>




<div id="box">
     <div class="box-top">Administrateurs enregistrés</div>
     <div class="box-panel">


<!-- on récupère un echo des admins via la fonction get_admin-->
<?php
get_admin($bdd); // on récupère les admins du site
?>


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
