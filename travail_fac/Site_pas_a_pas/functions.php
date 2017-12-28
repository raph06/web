<?php
///test autologout
function autologout($from=true)
{
$now = time();

if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    // this session has worn out its welcome; kill it and start a brand new one
    session_unset();
    session_destroy();
    session_start();
    if ($from==true)
		header('location:Accueil.php');
    elseif ($from==false){
      header('location:../Accueil.php');

    }

}}


		function email_exists($email, $bdd)
	{
		$result = $bdd->query("SELECT id FROM users WHERE email='$email'");

		if($result->rowCount() == 1) /* si il y a un résultat alors l'email existe */
		{
			return true; /* l'email existe on renvoie un booléen true */
		}
		else
		{
			return false; /* l'email n'existe pas on renvoie un booléen true */
		}
	}

	function logged_in()
	{
		if(isset($_SESSION['email']) || isset($_COOKIE['email'])) /* si la session a commencé (si l'utilisateur est logged in) */
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_infos($bdd,$login)
	    {
	      $I = $bdd->query("SELECT nom,prenom,ID FROM users WHERE email='$login'");
	      while ($donnees = $I->fetch())
	    {
	      $_SESSION['nom']= $donnees['nom'] ;
	      $_SESSION['prenom']= $donnees['prenom'] ;
				$_SESSION['ID']=$donnees['ID'];
	    }

	    $I->closeCursor();
			$_SESSION['email']=$login;
}

function try_session()
// cette fonction permet de renvoyer un visiteur non connecté vers la page d'acceuil
// si il essaye d'acceder aux pages admins
{
if (!isset($_SESSION['login']) AND !isset($_SESSION['type']))
{
//Le visiteur n'est pas connecté
echo '<body onLoad="alert(\'Accès interdit\')">';
// puis on le redirige vers la page d'accueil
echo '<meta http-equiv="refresh" content="0;URL=Accueil.php">';
exit;


if (($_SESSION['type']!='Admin') and ($_SESSION['type']!='Super'))
// cette fonction permet de renvoyer un visiteur non admin vers la page d'acceuil
// si il essaye d'acceder aux pages admins
{

  // Le visiteur n'est pas un admin
echo '<body onLoad="alert(\'Accès interdit\')">';
// puis on le redirige vers la page d'accueil
echo '<meta http-equiv="refresh" content="0;URL=AccueilConnecte.php">';
exit;

}}
}
?>
