<?php
include("case_contrats.php");
include("connect.php");

if(isset($_POST['Accepter'])){ // On vérifie que la variable Accepter existe si oui on passe id_accepte a set
$id_accepte='set';}
else{$id_accepte="unsset";}

if(isset($_POST['Refuser'])){
$id_refuse=TRUE;}
else{$id_refuse="unsset";}

if(isset($_POST['Cancel'])){
$id_cancel='set';}
else{$id_cancel="unsset";}

if(isset($_POST['Litige'])){
$id_litige='set';}
else{$id_litige="unsset";}

$id_etud = $_SESSION['ID']; // on récupère l'ID de l'utilisateur
$id_user = $_SESSION['type']; // On récupère le type d'utilisateur dont il s'agit

$a = recup_data_contrat_unlock_etudiant($bdd);
$numero = $_POST['numero'];
$ladate=$a[$numero]['date'];
$start = $a[$numero]['start'];
$email_famille=$a[$numero]['email_famille'];

if ($id_user=='Famille'){ // Sert au cas où la famille annule

$b = recup_data_contrat_lock_famille($bdd);
$numero_fam = $_POST['numero'];

$ladate_fam=$b[$numero]['date'];

$start_fam = $b[$numero]['start'];

$email_etu=$b[$numero]['email_etudiant'];
}


if($id_accepte == 'set') // Si le contrat est accepté, dans la table bookings passe le statut à 2
    {
    $accepte_query = $bdd->exec("UPDATE bookings SET Status='2' WHERE login='$id_etud' AND date='$ladate' AND start = '$start' ");
	$accepte_query = $bdd->exec("UPDATE users SET contrats_acceptes = contrats_acceptes + 1 WHERE ID='$id_etud' ");
  // Query 1 On passe le status à 2 " contrat accepté "
  // Query 2 On indente l'attribut contrats_acceptes dans la table user

  $subject="Validation contrat"; // Objet du mail
$msg="L'étudiant a accepté le contrat. Vous pouvez l'annuler. Si l'annulation intervient dans les 48h avant la mission, l'étudiant sera tout de même payer"; // Contenu du mail
//mail($email_famille, $subject, $msg); // Fonction envoie de mail
$alerte="Un e-mail de confirmation a été envoyé à la famille"; // msg contenu dans la box alerte qui s'affiche
echo '<script type="text/javascript">window.alert("'.$alerte.'");</script>';

    }

else if($id_cancel == 'set' ) // Cas où un contrat accepté est annulé par l'étudiant
	{
		if ($id_user=='Etudiant') // Double verification l'user doit etre un étudiant
		{
      $c = recup_data_contrat_lock_etudiant($bdd);
      			$numero = $_POST['numero'];
      			$idfam = $_POST['fam'];
      			$ladate=$c[$numero]['date'];
      			$start = $c[$numero]['start'];
      			$refuse_query = $bdd->exec("UPDATE bookings SET Status='0', id_famille = '0', tarif_horaire='0' WHERE login='$id_etud' AND id_famille = '$idfam' AND date='$ladate' AND start = '$start' ");
      			$refuse_query = $bdd->exec("UPDATE users SET contrats_annules = contrats_annules + 1 WHERE ID='$id_etud' ");



            $email_famille=$c[$numero]['email_famille'];
            $subject="Annulation contrat"; // Objet du mail
            $msg="L'étudiant a annulé le contrat."; // Contenu du mail
            //mail($email_famille, $subject, $msg); // Fonction envoie de mail
            $alerte="Un e-mail informant votre annulation a été envoyé à la famille"; // msg contenu dans la box alerte qui s'affiche
            echo '<script type="text/javascript">window.alert("'.$alerte.'");</script>';
      // Query 1 -> On remet le creneau libre
      // Query 2 -> Indentation de contrat annulé
      // contrats_acceptes + contrats_annules -> serviront à calculer le ratio " Taux annulation " de l'étudiant
      }
	}

else if($id_litige == 'set' ) // Cas où un contrat accepté est annulé par l'étudiant
	{
		if ($id_user=='Famille') // Double verification l'user doit etre un étudiant
		{
      $d = recup_contrat_passes_famille($bdd);
print_r($d);
      			$numero = $_POST['numero'];
      			$idetud = $_POST['etu'];
      			$ladate=$d[$numero]['date'];
      			$start = $d[$numero]['start'];
      			$refuse_query = $bdd->exec("UPDATE bookings SET Status='5' WHERE login='$idetud' AND id_famille = '$id_etud' AND date='$ladate' AND start = '$start' ");
      // Query 1 -> On remet le creneau libre
      // Query 2 -> Indentation de contrat annulé
      // contrats_acceptes + contrats_annules -> serviront à calculer le ratio " Taux annulation " de l'étudiant
      }
	}


else
    {
      if ($id_user=='Famille') // Cas de l'annulation sous les 48h

      {
        $id_etudiant = $_POST['etu'];

		$bool = 'yolo';
		$date = $b[$numero_fam]['date'];
		$time = $b[$numero_fam]['start'];

		$timestamp = strtotime($date." ".$time); //1373673600

		if($timestamp - time() < 172800) { // Si la date du contrat est dans une période < 48h
		  $bool = 'yes';}
		 else {
		  $bool = 'no';  //outputs no
		}

		if($bool=='no'){ // Si on est > 48h, et qu'il y a annulation ou refus -> le créneau de l'étudiant est libéré. Il est de nouveau bookable

	$refuse_query = $bdd->exec("UPDATE bookings SET Status='0', id_famille = '0', tarif_horaire='0' WHERE login='$id_etudiant' AND date='$ladate_fam' AND start = '$start_fam' ");

	  $subject="Annulation contrat"; // Objet du mail
    $msg="La famille a annulé le contrat. Cette annulation étant intervenu au dessus des 48h, vous ne serez pas payer. Vous êtes à nouveau réservable pour le(s) créneau(x) renseigné(s)"; // Contenu du mail
    //mail($email_etu, $subject, $msg); // Fonction envoie de mail
    $alerte="Un e-mail d'annulation a été envoyé à l'étudiant"; // msg contenu dans la box alerte qui s'affiche
    echo '<script type="text/javascript">window.alert("'.$alerte.'");</script>';

		}

		else{ // Cas < 48h -> On passe a Status = 4 -> L'étudiant doit tout de meme etre rémunéré

		$refuse_query = $bdd->exec("UPDATE bookings SET Status = '4' WHERE login='$id_etudiant' AND date='$ladate_fam' AND start = '$start_fam' ");

	    $subject="Annulation contrat sous 48h"; // Objet du mail
    $msg="La famille a annulé le contrat. La mission ayant du avoir lieu dans moins de 48h, vous serez payer."; // Contenu du mail
    //mail($email_etu, $subject, $msg); // Fonction envoie de mail
    $alerte="Cette annulation a eu lieu 48h avant la mission, l'étudiant sera rémunéré et a été prévenu par mail."; // msg contenu dans la box alerte qui s'affiche
    echo '<script type="text/javascript">window.alert("'.$alerte.'");</script>';

		}


    }

  if ($id_user=='Etudiant') // Si c'est létudiant qui annule -> son créneau se libère, pas de conséquence.
  {
    $refuse_query = $bdd->exec("UPDATE bookings SET Status='0', id_famille = '0', tarif_horaire='0' WHERE login='$id_etud' AND date='$ladate' AND start = '$start' ");
	$subject="Refus de mission"; // Objet du mail
    $msg="L'étudiant a refusé la mission."; // Contenu du mail
    //mail($email_famille, $subject, $msg); // Fonction envoie de mail
    $alerte="Un e-mail informant votre refus a été envoyé à la famille"; // msg contenu dans la box alerte qui s'affiche
    echo '<script type="text/javascript">window.alert("'.$alerte.'");</script>';
  }
}

header("Refresh:0;ConsultationProfilUtilisateur.php");
?>
