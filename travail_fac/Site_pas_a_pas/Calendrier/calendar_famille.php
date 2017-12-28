<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include('php/connect.php');
include('classes/class_calendar.php');
include('../functions.php');
autologout();

if(isset($_POST['Ident'])){
if(!isset($_SESSION['ID_etudiant'])) {
$_SESSION['ID_etudiant'] = $_POST['Ident'];
}

else{
	unset($_SESSION['ID_etudiant']);
	$_SESSION['ID_etudiant'] = $_POST['Ident'];
}
}

$calendar = new booking_diary($con);

if(isset($_GET['month'])) $month = $_GET['month']; else $month = date("m");
if(isset($_GET['year'])) $year = $_GET['year']; else $year = date("Y");
if(isset($_GET['day'])) $day = $_GET['day']; else $day = 0;

// Unix Timestamp of the date a user has clicked on
$selected_date = mktime(0, 0, 0, $month, 01, $year);

// Unix Timestamp of the previous month which is used to give the back arrow the correct month and year
$back = strtotime("-1 month", $selected_date);

// Unix Timestamp of the next month which is used to give the forward arrow the correct month and year
$forward = strtotime("+1 month", $selected_date);


// Permet de déterminer si les jours en question correspondent à un week-end, auquel cas on passe la variable $_SESSION[is_week] à 1
$_SESSION['id_week'] = 2;
$dateuh = $year."-".$month."-".$day;
if(date('N', strtotime($dateuh)) >= 6)
	{
		$_SESSION["is_week"] = 1;
	}
else{$_SESSION['is_week'] = 0;} 

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../Style_calendar.css" />
<link rel="stylesheet" href="../style_general.css" />
<link rel="stylesheet" href="../style_general_connect.css" />

<link href="http://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet" type="text/css">

<title>Calendar</title>

</head>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<body>
        <div id = "bloc_page">
            <header>
                    <div id="logo">
                        <img src="../Pictures/logo.png" alt="Logo E-sitting" />
                    </div>
                    <div id="deconnexion">
                        <a href="../logout.php" class="myButtonConnected">Déconnexion</a>
                    </div>
                    <div id="bonjour"><?php
                      if ($_SESSION['type']=='Super' or $_SESSION['type']=='Admin')
                      {
                    echo(  "<a href='../dash_admin.php' class='myButtonConnected'> Dashboard  </a>" );
                  }
                    else
                    {
                        echo("<a href='#' class='myButtonConnected'>Bonjour ". $_SESSION['prenom'] . " ". $_SESSION['nom'] . "  </a>");
                      }?>
                      </div>
            </header>


            <div id = "Menu_Principal">
                    <ul class="fancyNav" id="myTopnav">
                        <li id="home"><a href="../AccueilConnecte.php" class="homeIcon">Accueil</a></li>
                        <li><a href="#">Annonces</a></li>
                        <li><a href="../AccueilConnecte.php#Whoarewe">Qui sommes-nous ?</a></li>
                        <li><a href="../AccueilConnecte.php#Esitter">Rejoignez l'aventure</a></li>
                        <li><a href="../AccueilConnecte.php#Paiements">Tarifs & Paiements</a></li>
                        <li><a href="../ConsultationProfilUtilisateur.php">Profil</a></li>

                        <li class="icon">
                        <a href="javascript:void(0);" style="font-size:15px;" onclick="myFunction()">☰</a> <!-- Initialisation du bouton qui apparait en cas de trop petite image (voir media query) -->
                        </li>
                    </ul>
            </div>
			<section>
				<article>
					<h1 style="  margin-left: 95px;  font-family: arial, 'Trebuchet MS', serif, sans-serif; font-weight: normal; text-transform: uppercase; font-size: 1.0em;"> Emploi du temps de l'étudiant : </h1> </br>

					<script>
						function myFunction() {
							var x = document.getElementById("myTopnav");
							if (x.className === "fancyNav") {
								x.className += " responsive";
							} else {
								x.className = "fancyNav";
							}
						}
					</script>

					<script type="text/javascript">

					var check_array = [];

					$(document).ready(function(){

						$(".fields").click(function(){

							dataval = $(this).data('val');

							// Show the Selected Slots box if someone selects a slot
							if($("#outer_basket").css("display") == 'none') {
								$("#outer_basket").css("display", "block");
							}

							if(jQuery.inArray(dataval, check_array) == -1) {
								check_array.push(dataval);
							} else {
								// Remove clicked value from the array
								check_array.splice($.inArray(dataval, check_array) ,1);
							}

							slots=''; hidden=''; basket = 0;

							cost_per_slot = $("#cost_per_slot").val();
							//cost_per_slot = parseFloat(cost_per_slot).toFixed(2)
						
							//var $bool_weekend = parseInt(<?php echo $_SESSION['is_week']; ?>);
							
							for (i=0; i< check_array.length; i++) {
								slots += check_array[i] + '\r\n';
								
								var $NUIT= <?php echo $_SESSION['Nuit']; ?>;
								var $COM= <?php echo $_SESSION['Commissions']; ?>;
								var $WEK= <?php echo $_SESSION['Weekend']; ?>;
								var $day= <?php echo $day; ?>;

								//document.write($bool_weekend);
								
								// document.write($NUIT, $COM, $WEK);
								//document.write(check_array[i].split(" - ")[0].split(":")[0]);	
								// document.write($day);

							if(parseInt(<?php echo $_SESSION['is_week']; ?>) == 0){

								if(check_array[i].split(" - ")[0].split(":")[0] < 18)
								{
								hidden += check_array[i].substring(0, 8) + '|';
								basket = (basket + parseFloat(cost_per_slot));
								}
								
								if(check_array[i].split(" - ")[0].split(":")[0] >= 18)
								{
								hidden += check_array[i].substring(0, 8) + '|';
								basket = (basket + parseFloat(cost_per_slot*$NUIT));
								}
								
							}

							else if(parseInt(<?php echo $_SESSION['is_week']; ?>) == 1){
							
								if(check_array[i].split(" - ")[0].split(":")[0] < 18)
								{
								hidden += check_array[i].substring(0, 8) + '|';
								basket = (basket + parseFloat(cost_per_slot*$WEK));
								}
								
								if(check_array[i].split(" - ")[0].split(":")[0] >= 18)
								{
								hidden += check_array[i].substring(0, 8) + '|';
								basket = (basket + parseFloat(cost_per_slot*($NUIT+$WEK)));
								}
								
							}
							
							}

							// Populate the Selected Slots section
							$("#selected_slots").html(slots);

							// Update hidden slots_booked form element with booked slots
							$("#slots_booked").val(hidden);

							// Update basket total box
							basket = basket.toFixed(2);
							$("#total").html(basket);

							// Hide the basket section if a user un-checks all the slots
							if(check_array.length == 0)
							$("#outer_basket").css("display", "none");
						
						
						var d = new Date();
					    d.setTime(d.getTime() + (1500));
					    var expires = "expires="+ d.toUTCString();
					    document.cookie = "prix" + "=" + basket + ";path=/";

						});


						$(".classname").click(function(){

							msg = '';

							if($("#login").val() == '')
							msg += 'Merci de renseigner votre login\r\n';

							if($("#password").val() == '')
							msg += 'Merci de renseigner votre mot de passe\r\n';

							if(msg != '') {
								alert(msg);
								return false;
							}

						});

						// Firefox caches the checkbox state.  This resets all checkboxes on each page load
						$('input:checkbox').removeAttr('checked');

					});

					</script>

					</head>
					<body>

					<?php


					// if($_SERVER['REQUEST_METHOD'] == 'POST') {
					    // $calendar->after_post($month, $day, $year);
					// }

					// Call calendar function
					$calendar->make_calendar($selected_date, $back, $forward, $day, $month, $year);

					?>

</body>
</html>
