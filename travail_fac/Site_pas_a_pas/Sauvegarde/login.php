<?php
// On définit un login et un mot de passe de base interroger la base de donnée afin de savoir si le visiteur qui se connecte est bien membre de votre site


// On détruit notre session
//session_destroy ();
include('connect.php');
include('functions.php');
// on teste si nos variables sont définies
if (((isset($_POST['Login']) && isset($_POST['pw']))==0) or ((empty($_POST['pw']) OR empty($_POST['Login']))==1))

  {
    // Le visiteur n'a pas remplit le formulaire
  echo '<body onLoad="alert(\'Les variables du formulaire ne sont pas déclarées.\')">';
  // puis on le redirige vers la page d'accueil
  echo '<meta http-equiv="refresh" content="0;URL=Connexion.html">';

  }

  else {
// on attribue les variables transmises
$login=$_POST['Login'];
$mdp=$_POST['pw'];

// on va chercher dans la base de donnée
      $user_in_base = $bdd->query("SELECT user_type,mdp FROM users WHERE email='$login'");


      while ($donnees = $user_in_base->fetch())
      {
        $user=$donnees['user_type'];
        $mdpHashe=$donnees['mdp'];

      }

      $user_in_base->closeCursor();

      if (isset($user))
      {
        $bool_pwd=password_verify($mdp,$mdpHashe);
      }
      else   {
                // Le visiteur n'a pas été reconnu comme étant membre de notre site. On utilise alors un petit javascript lui signalant ce fait
              echo '<body onLoad="alert(\'Membre non reconnu...\')">';
              // puis on le redirige vers la page d'accueil
              echo '<meta http-equiv="refresh" content="0;URL=Connexion.html">';
              exit;
           }

      if ($bool_pwd)
      {


		// on enregistre les paramètres de notre visiteur comme variables de session ($login et $pwd) (notez bien que l'on utilise pas le $ pour enregistrer ces variables)
		$_SESSION['login'] = $login;
		$_SESSION['pwd'] = $mdpHashe;
    switch ($user)
    {
        case 'Admin';
        $_SESSION['type'] = "Admin";
        get_infos($bdd,$login);
        header ('location: dash_admin.php');
        break;
        case 'Super';
      	// on redirige notre visiteur vers une page de notre section admin
        $_SESSION['type'] = "Super";
        get_infos($bdd,$login);
        //echo (password_verify($mdp,$mdpHashe));
        header ('location: dash_admin.php');
        break;
        case 'Etudiant';
        $_SESSION['type'] = "Etudiant";
        get_infos($bdd,$login);
        header ('location: AccueilConnecte.php');
        break;
        case 'Famille';
        $_SESSION['type'] = "Famille";
        get_infos($bdd,$login);
        header ('location: AccueilConnecte.php');
        break;
    }}

  else
  {
          // Le visiteur n'a pas été reconnu comme étant membre de notre site. On utilise alors un petit javascript lui signalant ce fait
        echo '<body onLoad="alert(\'Mot de passe incorrect\')">';
        // puis on le redirige vers la page d'accueil
        echo '<meta http-equiv="refresh" content="0;URL=Connexion.html">';
     }
}

?>
