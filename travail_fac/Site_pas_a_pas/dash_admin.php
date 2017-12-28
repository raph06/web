<?php
include('connect.php'); /* connexion à la base de données sql */
include('functions_admin.php'); //inclure les fonctions relatives aux pages admins
try_session($_SESSION); // teste la manière dont un utilisateur accède à cette page
$bool_user=which_admin();// définit le type d'admin (admin-super)
//print_r($_SESSION);
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
    <a href="AccueilConnecte.php">E<span>Sitting</span></a> <!-- option visite connecté pour l'admin-->
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
      <li><a class="selected" href="#">Tableau de bord</a></li>
      <li><a href="dash_admin_moderation.php">Modération des commentaires</a></li>
      <li><a href="dash_admin_profils_etu.php">Modération profils Etudiant</a></li>
      <li><a href="dash_admin_profils_fam.php">Modération profils Famille</a></li>
      <li><a href="dash_admin_taux.php">Modifier les taux de E-sitting</a></li>
      <?php if ($bool_user) // si l'utilisateur est le super admin uniquement.
      {echo ("<li><a href='dash_admin_nouvel_admin.php'>Modifications administrateurs</a></li>");}?>
    </ul>

  </div>

  <div class="content">


    <h1>Tableau de bord</h1>

    <div id="box">
     <div class="box-top">Notifications</div>
     <div class="box-panel">
       <?php
$profils=get_number_of_flagged_profils($bdd);//récupère le nombre de profils à moderer
  get_number_of_flagged_coments($bdd); //idem commentaires
   echo(' Commentaire(s) abusif(s) a/ont été signalé(s) sur un/des profil(s).<br/>');
echo($profils. ' Profil(s) modifié(s) ou initialisé(s)');?>
  </div>
    </div>
<?php
list($Nuit, $Fériés, $Week_end, $Commissions) = get_taux($bdd);
//récupère les taux en vigueurs
?>
   <div id="box">
     <div class="box-top">Notifications</div>
     <div class="box-panel">Les taux d'intérets en vigueur sont:
     <p>Travail de nuit: <?php echo $Nuit ?> </p>
     <p>Travail les Week end: <?php echo $Week_end ?> </p>
     <p>Travail les jours fériés: <?php echo $Fériés ?> </p>
     <p>Commissions: <?php echo $Commissions ?> </p></div>
    </div>


<div id="box">
     <div class="box-top">Alertes</div>
     <div class="box-panel">La(es) prestation(s) suivante(s) à(ont) été signalé(es):
<p>

<?php
// on récupère les prestations signalés
{
    $alerts = $bdd->query("SELECT users.nom, users.prenom, users.ID, bookings.tarif_horaire,bookings.date FROM `bookings`, `users`WHERE bookings.login=users.ID and bookings.status='3'");
    while ($donnees = $alerts->fetch())
  {
    $id=$donnees['ID'] ;
    $prenom= $donnees['prenom'] ;
    $nom= $donnees['nom'] ;
    $date= $donnees['date'] ;
    $tarif=$donnees['tarif_horaire'];

    echo( '<p>'. $nom . ' '. $prenom . ' ' . '</p>');
     echo( '<p>'. 'Prix de la demande : ' .$tarif.'€ par demie heure</p>') ;

echo("<form action='moderate_alert.php' method='POST'>
<button type='submit' name='set' value=1 class='btn-link'>Ignorer</button>
<button type='submit' name='set' value=0 class='btn-link'>Supprimer</button>
<input type='hidden' value='$id' name='id'>
<input type='hidden' value='$date' name='date'></form>".'</br>');
  }
  $alerts->closeCursor();

}

?>
</p>

</div>
</div>

<div id="box">
     <div class="box-top">Conflits</div>
     <div class="box-panel">La(es) prestation(s) suivante(s) à(ont) été signalé(es):
<p>

<?php
// on récupère les prestations signalés
{
    $conflits = $bdd->query("SELECT users.nom, users.prenom, users.ID, bookings.tarif_horaire,bookings.date,bookings.commentaire FROM `bookings`, `users`WHERE bookings.login=users.ID and bookings.status='5'");
    while ($donnees = $conflits->fetch())
  {
    $id=$donnees['ID'] ;
    $prenom= $donnees['prenom'] ;
    $nom= $donnees['nom'] ;
    $date= $donnees['date'] ;
    $tarif=$donnees['tarif_horaire'];
    $commentaire=$donnees['commentaire'];

    echo( '<p>'. $nom . ' '. $prenom . ' ' . '</p>');
     echo( '<p>'. 'Prix de la demande : ' .$tarif.'€ par demie heure</p>') ;
     echo('<p>'. 'Sujet du litige : ' . $commentaire. '</p>');

echo("<form action='moderate_conflits.php' method='POST'>
<button type='submit' name='set' value=1 class='btn-link'>Ignorer</button>
<button type='submit' name='set' value=0 class='btn-link'>Rembourser</button>
<input type='hidden' value='$id' name='id'>
<input type='hidden' value='$date' name='date'></form>".'</br>');
  }
  $conflits->closeCursor();

}

?>
</p>

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
