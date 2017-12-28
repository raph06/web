<?php

include("functions.php"); /* Accède au fichier regroupant les fonctions */


/* Toutes ces fonctions ont des fonctionnement très simillaires. Elles ont pour but de récupèrer les informations
dans la base de données pour les afficher dans les différents cadres de la page ConsultationProfilUtilisateur.php
Chaque fonction sera appelé dans un cadre différent. Ceci afin de rendre plus clair le script.
Il y a différents cas : user_type=Etudiant ou famille. On prendra selon l'un ou l'autre l'ID de l'user "opposé".
Ces données servent à récupérer le nom des users impliqués dans les contrats
On récupère dans tout les cas la date du contrat et l'heure.
*/


function recup_data_contrat_unlock_etudiant($bdd) // Fonction pour les contrat démandé non validé
																									// On recupère l'ID, la date, l'heure de début.

{
  // on récupère les info des contrats selon les cas 0:9
	  $id_etud = $_SESSION['ID'];
      $contrat = $bdd->query("SELECT id_famille,date,start FROM bookings WHERE login = '$id_etud' AND Status = '1' ");
	  $id_famille = 0;

      while ($donnees = $contrat->fetch())
    {
		$id_famille = $donnees['id_famille'];
		$user_in_base = $bdd->query("SELECT nom,email FROM users WHERE ID='$id_famille'");
		while ($donnees_bis = $user_in_base->fetch())
			  {
				$donnees['famille']=$donnees_bis['nom'];
				$donnees['email_famille']= $donnees_bis['email'];
			  }
		$a[] = $donnees;

    }

	if(isset($a)){
	return($a); }
	else{return 0;}

  $contrat->closeCursor();
  }

function recup_data_contrat_unlock_famille($bdd) // Contrat démandé par la famille en attente de confirmation

{

	  $id_famille = $_SESSION['ID'];
      $contrat = $bdd->query("SELECT login,date,start FROM bookings WHERE id_famille = '$id_famille' AND Status = '1' ");
	  $id_famille = 0;

      while ($donnees = $contrat->fetch())
    {
		$id_famille = $donnees['login'];
		$user_in_base = $bdd->query("SELECT nom,email FROM users WHERE ID='$id_famille'");
		while ($donnees_bis = $user_in_base->fetch())
			  {
				$donnees['famille']=$donnees_bis['nom'];
				$donnees['email_etudiant']= $donnees_bis['email'];
			  }

		$a[] = $donnees;

    }

	if(isset($a)){
	return($a); }
	else{return 0;}

  $contrat->closeCursor();
  }

function recup_data_contrat_lock_etudiant($bdd)

{
  // on récupère les info des contrats selon les cas 0:9
	  $id_etud = $_SESSION['ID'];
      $contrat = $bdd->query("SELECT id_famille,date,start FROM bookings WHERE login = '$id_etud' AND Status = '2' AND validation != '1' ");
	  $id_famille = 0;

      while ($donnees = $contrat->fetch())
    {
		$id_famille = $donnees['id_famille'];

		$user_in_base = $bdd->query("SELECT nom,email FROM users WHERE ID='$id_famille'");
		while ($donnees_bis = $user_in_base->fetch())
			  {
				$donnees['famille']=$donnees_bis['nom'];
				$donnees['email_famille']= $donnees_bis['email'];
			  }
		$a[] = $donnees;

    }
	if(isset($a)){
	return($a); }
	else{return 0;}
  $contrat->closeCursor();
  }

function recup_data_contrat_lock_famille($bdd)

{
  // on récupère les info des contrats selon les cas 0:9
	  $id_famille = $_SESSION['ID'];
      $contrat = $bdd->query("SELECT login,date,start FROM bookings WHERE id_famille = '$id_famille' AND Status = '2' AND validation != '1' ");
	  $id_famille = 0;

      while ($donnees = $contrat->fetch())
    {
		$id_famille = $donnees['login'];

		$user_in_base = $bdd->query("SELECT nom,email FROM users WHERE ID='$id_famille'");
		while ($donnees_bis = $user_in_base->fetch())
			  {
				$donnees['famille']=$donnees_bis['nom'];
				$donnees['email_etudiant']= $donnees_bis['email'];
			  }

		$a[] = $donnees;

    }
	if(isset($a)){
	return($a); }
	else{return 0;}

  $contrat->closeCursor();
  }

 function recup_contrat_passes_famille($bdd)

{
  // on récupère les info des contrats selon les cas 0:9
	  $id_famille = $_SESSION['ID'];

	$contrat = $bdd->query("SELECT id,login,date,start,Note FROM bookings WHERE Validation = '1'  AND id_famille = '$id_famille' AND Status != '5' ");
	$var = "";

      while ($donnees = $contrat->fetch())
    {
		$id_famille = $donnees['login'];

		$user_in_base = $bdd->query("SELECT nom FROM users WHERE ID='$id_famille'");
		while ($donnees_bis = $user_in_base->fetch())
			  {
				$donnees['famille']=$donnees_bis['nom'];
			  }

		$a[] = $donnees;
	}

	if(isset($a)){
	return($a); }
	else{return 0;}

  $contrat->closeCursor();
  }

  function recup_contrat_passes_etudiant($bdd)

{
  // on récupère les info des contrats selon les cas 0:9
	  $id = $_SESSION['ID'];

	$contrat = $bdd->query("SELECT id,login,id_famille,date,start,Note FROM bookings WHERE Validation = '1'  AND login = '$id' AND Status != '5' ");
	$var = "";

      while ($donnees = $contrat->fetch())
    {
		$id_famille = $donnees['id_famille'];

		$user_in_base = $bdd->query("SELECT nom FROM users WHERE ID='$id_famille'");
		while ($donnees_bis = $user_in_base->fetch())
			  {
				$donnees['famille']=$donnees_bis['nom'];
			  }

		$a[] = $donnees;
	}

	if(isset($a)){
	return($a); }
	else{return 0;}

  $contrat->closeCursor();
  }


function get_number_of_accepted_mission($bdd)
// cette fonction permet d'accéder au nombre de missions répertoriés comme étant acceptées
// elle prend en entrée les informations sur la base de donnée et renvoie des echos contenant
// le nombre de mission accepté
{
    $acc = $bdd->query("SELECT count(*) AS accepted FROM booking WHERE statut='1'");
      while ($donnees = $acc->fetch())
      {
        $Count= $donnees['accepted'] ;
      }
      $acc->closeCursor();

      echo($Count);
    }


function get_number_of_refused_mission($bdd)
// cette fonction permet d'accéder au nombre de missions répertoriés comme étant refusées
// elle prend en entrée les informations sur la base de donnée et renvoie des echos contenant
// le nombre de mission refusé
{
    $ref = $bdd->query("SELECT count(*) AS refused FROM booking WHERE statut='2'");
      while ($donnees = $ref->fetch())
      {
        $Count= $donnees['refused'] ;
      }
      $ref->closeCursor();

      echo($Count);
    }

function get_number_of_Inprogress_mission($bdd)
// cette fonction permet d'accéder au nombre de missions répertoriés comme étant refusées
// elle prend en entrée les informations sur la base de donnée et renvoie des echos contenant
// le nombre de mission refusé
{
    $inpro = $bdd->query("SELECT count(*) AS inprogress FROM booking WHERE statut='0'");
      while ($donnees = $inpro->fetch())
      {
        $Count= $donnees['inprogress'] ;
      }
      $inpro->closeCursor();

      echo($Count);
    }
?>
