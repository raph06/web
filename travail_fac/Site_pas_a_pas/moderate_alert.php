<?php
include('connect.php');
include('functions_admin.php');
/*Chech post variables*/
if (isset($_POST['id']))
$id=$_POST['id'];
else $id='';
if (isset($_POST['date']))
$date=$_POST['date'];
else $date="";
if (isset($_POST['set']))
$fate=$_POST['set'];
else $fate='';

/*Decide fate of slot*/
if ($fate==0)/*eraseslot*/
{
$update1 = $bdd->exec("UPDATE bookings SET status=0 WHERE bookings.login='$id'and bookings.status=3 and bookings.date='$date'");
header('location:dash_admin.php');

}
elseif ($fate==1)/*Validate*/
{

$update2 = $bdd->exec("UPDATE bookings SET status=1 WHERE bookings.login='$id'and bookings.status=3 and bookings.date='$date'");
 header('location:dash_admin.php');

}


 ?>
