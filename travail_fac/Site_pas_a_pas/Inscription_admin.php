 <?php

include("connect.php"); /* connexion à la base de données sql */
include("functions.php");


 //page admin => definition du type d'utilisateur
 $user_type='Admin';

if(isset($_POST['mail_new_admin']))                       $email=$_POST['mail_new_admin'];
else      $email="";

if(isset($_POST['Password']))                   $mdp=$_POST['Password'];
else      $mdp="";

if(isset($_POST['Password_again']))       $mdp_verification=$_POST['Password_again'];
else      $mdp_verification="";


// On vérifie si les champs obligatoires sont vides
if(empty($email) OR empty($mdp) OR empty($mdp_verification))
    {
    echo '<font color="red"> Attention, les champs suivis d\'une étoiles ne peuvent pas rester vides !</font>';
    }

else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        echo '<font color="red">Merci d\'entrer une adresse e-mail valide</font>';
    }
//else if(email_exists($email, $con)) /* On utilise la fct email_exists pour éviter des doublons */   <====== IMPORTANT
//    {
//        $error = "Cette addresse est déja associée à un compte utilisateur.";
//    }
//On vérifie si les mots de passes sont identiques

else if(strlen($mdp) < 8)
    {
        echo '<font color="red">Le mot de passe doit contenir au moins 8 caractères</font>';
    }
else if ($mdp != $mdp_verification)
    {
        echo '<font color="red">Attention, les mots de passes ne sont pas identiques !</font>';
    }

// les champs sont bons, on peut enregistrer dans la table
else
    {
    // hashage du mot de passe
    $mdpHashe = password_hash($mdp, PASSWORD_DEFAULT) ;

    // on écrit la requête sql
    $req = $bdd->prepare('INSERT INTO users(user_type, email, mdp) VALUES(:user_type, :email, :mdp)');
    //on l'execute
    $req->execute(array(
        'user_type' => $user_type,
        'email' => $email,
        'mdp' => $mdpHashe,
        ));
    // on affiche le résultat pour le visiteur

    $bdd = '' ;
    header('Location: dash_admin_nouvel_admin.php');


    }



?>
