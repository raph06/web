<?php include ("connect.php");


    /// ON FIXE à VALIDATION = 1 TOUS LES VIEUX CONTRATS
	
	$date = date('Y/m/d h:i:s a', time());

    $accepte_query = $bdd->exec("UPDATE bookings SET Validation='1' WHERE date < '$date' ");
	
	
	/// A PARTIR D ICI : ON SUPPRIME TOUS LES VIEUX CONTRATS VALIDES 

	//$date = new DateTime('now');
	
	
	$date = date("Y-m-d",time());
	$date = date("Y-m-d",strtotime($date)-86400);
	$hour = date("H:i:s",time());
	
	// print_r($date);
	// print_r($hour);
	$var = 'Check';
	
	$contrat = $bdd->query("SELECT Status FROM bookings WHERE Validation = '1'  AND Status != '5' AND date =  '$date' AND start < '$hour' ");


      while ($donnees = $contrat->fetch())
    {
		$var = 'veille';
	}

	if($var = 'veille'){
	    $accepte_query = $bdd->exec("DELETE FROM bookings WHERE Validation = '1' AND Status != '5' AND date = '$date' AND start < '$hour' ");
	
	}
	
	$contrat = $bdd->query("SELECT Status FROM bookings WHERE Validation = '1'  AND Status != '5' AND date <  '$date'");


      while ($donnees = $contrat->fetch())
    {
		$var = 'sup48h';
	}

	if($var = 'sup48h'){
	    $accepte_query = $bdd->exec("DELETE FROM bookings WHERE Validation = '1' AND Status != '5' AND date < '$date'");
	
	}
	
	
	header("location:javascript://history.go(-1)");

	?>
		
		
