<?php

include('php/connect.php');

if(isset($_POST['slots_booked'])) $slots_booked = mysqli_real_escape_string($con, $_POST['slots_booked']);
if(isset($_POST['ID_famille'])) $login = mysqli_real_escape_string($con, $_POST['ID_famille']);
if(isset($_POST['password'])) $password= mysqli_real_escape_string($con, $_POST['password']);
if(isset($_POST['booking_date'])) $booking_date = mysqli_real_escape_string($con, $_POST['booking_date']);
if(isset($_POST['cost_per_slot'])) $cost_per_slot = mysqli_real_escape_string($con, $_POST['cost_per_slot']);
if(isset($_POST['ID_etudiant'])) $login_etudiant = mysqli_real_escape_string($con, $_POST['ID_etudiant']);

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
	"loginetud" => $login_etudiant,
	"password" => $password,
	"id" =>  $id
);

$explode = explode('|', $slots_booked);
	
foreach($explode as $slot) {

	if(strlen($slot) > 0) {

		//print_r($login);
		if(	$_COOKIE["prix"] < 150){ // <<<  MODIFIER ICI SI ON VEUT CHANGER LE PRIX MINIMUM DE CONTACT ADMIN
		$status = "book_unlock";
		$stmt = $con->prepare("UPDATE bookings SET id_famille = '$login', Status = '1', tarif_horaire = '$cost_per_slot' WHERE login = '$login_etudiant' AND date = ' $booking_date' AND start = '$slot'");  // permet d'éditer l'edt de la famille
		$stmt->execute();
		}
		else{
		$status = "book_admin";
		$stmt = $con->prepare("UPDATE bookings SET id_famille = '$login', Status = '3', tarif_horaire = '$cost_per_slot' WHERE login = '$login_etudiant' AND date = ' $booking_date' AND start = '$slot'");  // permet d'éditer l'edt de la famille
		$stmt->execute();	
			
		}
	
		// $stmt = $con->prepare("INSERT INTO bookings (date, start, login) VALUES (?, ?, ?)");  // permet d'éditer l'edt de la famille
		// $stmt->bind_param('sss', $booking_date, $slot, $login);
		// $stmt->execute();
		
		//$stmt = $con->prepare("INSERT INTO bookings (date, start, login) VALUES (?, ?, ?)"); // permet d'éditer l'edt de l'étudiant
		//$stmt->bind_param('sss', $booking_date, $slot, $login_etudiant);
		//$stmt->execute();
		
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
	echo "<script>setTimeout(\"location.href = 'calendar_famille.php';\",1600);</script>";
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

<div class='success'>Les créneaux ont été bookés chez l'étudiant.</div>

<p style='font-family:courier; font-size:13px; margin-top:25px'>
Le contrat a été proposé à l'étudiant si il le valide vous serez informés par mail.<br> <br>
</p>

<p style='font-family:courier; font-size:13px; margin-top:25px'>
L'étudiant est donc désormais capable de :
</p>

<ul style='font-family:courier; font-size:13px'>
	<li>Valider ou Refuser le contrat</li>
	<li>Une fois validé par l'étudiant, un mail vous est envoyé.</li>
	<li>Si le contrat est réalisé par l'étudiant, alors le paiment est réalisé sous un certain délai par E-sitting.<br>
		   Si un problème survient, vous pouvez sous un délai de 24h déclarer un litige et votre situation sera étudiée par un administrateur.
	</li>
</ul>

<img src="../Pictures/transaction.png" alt="transaction" style="width:500px;height:300px;"> </br> </br> </br>

<form action="../AccueilConnecte.php"> 
    <input type="submit" value="Retour à l'accueil" style="vertical-align: top;"/>
</form> 


</body>

</html>
