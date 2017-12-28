<?php

	$con = mysqli_connect("localhost","root","","projetesi"); /* fonction used to connect with database on host (specify name if not localhost) */

	if(mysqli_connect_errno())
	{
		echo "Error occured while connecting with the database".mysqli_connect_errno();
	}

    session_start(); /* on ouvre la session ici, il faudra inclure connect.php dans chaque page de notre site qui en auront besoin */

?>
