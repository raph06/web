


<?php

include("connect.php"); /* connexion à la base de données sql */
include("functions.php");
$old_admin=htmlspecialchars($_POST['admin_to_suppress']);
$nb= $bdd->query("select count(*) from users where email='$old_admin' and user_type='Admin'")->fetchColumn();

if($nb==0) {
    header('Location: dash_admin_nouvel_admin.php?error=no_users');
}
else if ($nb>=1) {
	$suppressing_query = $bdd->query("DELETE FROM users WHERE email='$old_admin'");

  header('Location: dash_admin_nouvel_admin.php');
}

?>
