<?php

include('php/connect.php');

if(isset($_POST['slots_booked'])) $slots_booked = mysqli_real_escape_string($con, $_POST['slots_booked']);
if(isset($_POST['ID'])) $login = mysqli_real_escape_string($con, $_POST['ID']);
if(isset($_POST['password'])) $password= mysqli_real_escape_string($con, $_POST['password']);
if(isset($_POST['booking_date'])) $booking_date = mysqli_real_escape_string($con, $_POST['booking_date']);
if(isset($_POST['cost_per_slot'])) $cost_per_slot = mysqli_real_escape_string($con, $_POST['cost_per_slot']);

$user_in_base = $con->query("SELECT mdp FROM users WHERE ID='$login'");
while ($donnees = $user_in_base->fetch_array())
      {
        $mdpHashe=$donnees['mdp'];
      }
$bool_pwd=password_verify($password,$mdpHashe);

if($bool_pwd and $_POST['login_name'] == $_SESSION['login']){
	
$id = "";
$id = $_SESSION['ID'];
//$login_etudiant = $_SESSION['ID_etudiant'];

	
$booking_array = array(
	"slots_booked" => $slots_booked,	
	"booking_date" => $booking_date,
	"cost_per_slot" => number_format($cost_per_slot, 2),
	"login" => $login,
	"password" => $password,
	"id" =>  $id
);

$explode = explode('|', $slots_booked);

foreach($explode as $slot) {

		// $stmt = $con->query("SELECT start FROM bookings WHERE id ='$login'");  // permet d'éditer l'edt de la famille
		// while( $donnes = $stmt->fetch_array())
		// {
		// print_r($donnes['start']);
		// }

	if(strlen($slot) > 0) {
		$test = $con->query("SELECT id FROM bookings WHERE login = '$id' AND start = '$slot' AND date ='$booking_date'"); // test pour vérifier que le créneau est vide, dans le cas contraire on supprime le contenu
		if(mysqli_num_rows($test) > 0)
		{
			$stmt = $con->prepare("DELETE FROM bookings WHERE login = '$id' AND start = '$slot' AND date ='$booking_date'");
			$stmt->execute();
			// echo("ERASE");
		}
		else // cas où le créneau est vide, alors on le remplit
		{
			// echo("SAVE");
			$sloti = strtotime($slot);
			$slot_end = date("H:i", strtotime('+30 minutes', $sloti));
			$stmt = $con->prepare("INSERT INTO bookings (date, start, login, end) VALUES (?, ?, ?, ?)"); // permet d'éditer l'edt de l'étudiant
			$stmt->bind_param('ssss', $booking_date, $slot, $login, $slot_end);
			$stmt->execute();


		}
		
	} // Close if
	
} // Close foreach

// unset($_SESSION['ID_etudiant']); Si on veut vider les variables session
// unset($_SESSION['prix']); Si on veut vider les variables session

// print_r('<pre>');
// print_r($booking_array);
// print_r('</pre>');

}

else
{
	echo "Il y a eu une erreur de vérification, veuillez recommencer la manipulation !";
	echo "<script>setTimeout(\"location.href = 'calendar_etudiant.php';\",1600);</script>";
	exit();
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Booking Confirmed</title>
<link href="style.css" rel="stylesheet" type="text/css">

<link href="http://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

</head>

<body>

<div class='success'>Les créneaux sélectionnés ont été réservés dans votre emploi du temps.</div>

<p style='font-family:courier; font-size:13px; margin-top:25px'>
Les familles sont désormais capables de :
</p>

<ul style='font-family:courier; font-size:13px'>
	<li>Réserver ces créneaux</li>
	<li>Une fois bookés par une famille, une demande de validation vous est envoyée pour ces créneaux.</li>
	<li>Si le contrat est réalisé par l'étudiant, alors le paiment est réalisé sous un certain délai par E-sitting</li>
</ul>

<form action="../AccueilConnecte.php"> 
    <input type="submit" value="Retour à l'accueil" style="vertical-align: top;"/>
</form> 

</body>

</html>
