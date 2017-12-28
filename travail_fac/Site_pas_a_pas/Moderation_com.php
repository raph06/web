<?php include ("connect.php");
$com = $bdd->prepare('SELECT * FROM commentaire WHERE destinataire = ? ORDER BY ID DESC ');
$com->execute(array($_POST['destin']));      //permet de récupérer toutes les informations des commentaires grâce à ID transmis par $SESSION

$nbcom=0;
while($comment =$com -> fetch())//les données des commentaires sont représentées par $comment
{
    if (isset($_POST[$comment['ID']])) //Modifie le statut de modération de chaque commentaire sélectionné précédement
    {
    	$sign = $bdd->prepare('UPDATE commentaire SET moderation = 1 WHERE ID = ? ');
		$sign->execute(array($comment['ID']));
		$sign ->closeCursor();
		$nbcom=$nbcom+1;
    }
}
$com -> closecursor();
if ($nbcom > 1) //permet d'afficher un message de confirmation à l'utilisateur
{
	$aff=(string)$nbcom." commentaires ont été signalé aux administrateurs." ;
}
elseif ($nbcom == 1)
{
	$aff=(string)$nbcom." commentaire a été signalé aux administrateurs." ;

}
else
{
	$aff="aucun commentaires n'a été sélectionné.";
}
echo "<p>".$aff."</p>";

if($_POST['retour']==0)
{
	header("Refresh:2; ConsultationProfilUtilisateur.php");
	exit;
}
elseif($_POST['retour']==1) //Retourne automatique sur la page précédente après 2secondes.
{
	$_SESSION['prof_visit']=$_POST['destin'];
	header("Refresh:2; ConsultationProfilUtilisateurTiers.php");
	exit;
}
?>
