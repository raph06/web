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
      <li><a class="selected" href="#">Modifier les taux de E-sitting</a></li>
      <?php if ($bool_user) // si super -user seulement
      {echo ("<li><a href='dash_admin_nouvel_admin.php'>Modifications administrateurs</a></li>");}?>
    </ul>

  </div>
<form method="post" action="modification_taux.php">
  <div class="content">
   <?php // on récupère les anciens taux
list($Nuit, $Fériés, $Week_end, $Commissions) = get_taux($bdd);
?>
    <h1>Modification des taux</h1>
    <div id="box">
     <div class="box-top">Taux spécifiques</div>
     <div class="box-panel">
    <form method="post" action="modification_taux.php">

    <label>Taux jours fériés</label> <input type="number" step="0.01"  min="0" name="Fériés" Value="<?php echo $Fériés  ?>" /> <br/><br/>
    <label>Taux Week end </label><input type="number" step="0.01" min="0" name="Week_end" Value="<?php echo $Week_end  ?>"  /> <br/><br/>
    <label>Taux Nuits </label><input type="number" step="0.01" min="0" name="Nuit" Value="<?php echo $Nuit  ?>" /> <br/><br/>


     </div>
    </div>

   <div id="box">
     <div class="box-top">Taux commissions</div>
     <div class="box-panel">
     <label>Taux Commissions </label><input type="number" step="0.01" min="0" name="Commissions" Value="<?php echo $Commissions  ?>"  /> <br/><br/>

     </div>
    </div>
<input type="submit" name="submit" onclick="return(confirm('Etes-vous sûr de vouloir modifier les taux?'));"/> <br/><br/>
                </form>


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
