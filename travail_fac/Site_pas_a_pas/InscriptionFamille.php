 <?php

include("connect.php"); // connexion à la base de données sql
include("functions.php");

if(logged_in())
    {
    header("location:AccueilConnecte.php"); // permet de rediriger l'utilisateur déja connecté
    exit(); // permet de ne pas exécuter la suite du php
    }

//page etudiant => definition du type d'utilisateur
 $user_type='Famille';
// On récupère les champs
$message='Votre profil a été crée avec succès.\n\nConnectez-Vous et consultez de nombreuses offres.';
if(isset($_POST['NomFamille']))                        $nom=$_POST['NomFamille'];
else      $nom="";

if(isset($_POST['MailFamille']))                     $email=$_POST['MailFamille'];
else      $email="";

if(isset($_POST['PasswordFamille']))                   $mdp=$_POST['PasswordFamille'];
else      $mdp="";

if(isset($_POST['PasswordConfirmationFamille']))       $mdp_verification=$_POST['PasswordConfirmationFamille'];
else      $mdp_verification="";

if(isset($_POST['CodePostal']))                    $codePostal=$_POST['CodePostal'];
else      $codePostal="";

if(isset($_POST['AdresseFamille']))                    $adresse=$_POST['AdresseFamille'];
else      $adresse="";

if(isset($_POST['TelephoneFamille']))                  $telephone=$_POST['TelephoneFamille'];
else      $telephone="";

if(isset($_POST['NombreEnfantsFamille']))                  $nombre_enfants=$_POST['NombreEnfantsFamille'];
else      $nombre_enfants="";

if(isset($_POST['DescriptionFamille']))                $description_perso=$_POST['DescriptionFamille'];
else      $description_perso="";

if(isset($_POST['conditions']))                         $conditions=$_POST['conditions'];
else      $conditions="";


//gestion de l'image
$image = $_FILES['image']['name'];

if($image !='')
{
    $tmp_image = $_FILES['image']['tmp_name']; // temporary name
    $imageSize = $_FILES["image"]['size'];
    $imageType = $_FILES["image"]['type'];

    if($imageSize > 1048576) // taille max à remplir en bytes
    {
        echo '<font color="red">La taille de l\'image ne peut pas dépasser 1 Mo</font>';
    }
    else
    {
        $imageExt = explode("/", $imageType); // explode used to extract extension, ajout d'un point après $image+"." afin d'éviter l'erreur undefined offset : http://stackoverflow.com/questions/1807849/undefined-offset-when-using-php-explode
        $imageExtension = $imageExt[1];
        $image = rand(0,100000).rand(0,100000).rand(0,100000).time().".".$imageExtension; // on s'assure que les noms d'image soient toujours les mêmes, à chaque utilisateur sa photo
        move_uploaded_file($tmp_image, "images/$image");

    }

}
// l'image est optionelle pour la famille
else
{
    $image = 'user.png';
}



// On vérifie si les champs sont vides
if(empty($nom) OR empty($email) OR empty($mdp) OR empty($mdp_verification) OR empty($codePostal) OR empty($adresse) OR empty($telephone))
    {
    echo '<font color="red">Attention, les champs suivis d\'une étoiles ne peuvent pas rester vides !</font>';
    }

else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        echo '<font color="red">Merci d\'entrer une adresse e-mail valide</font>';
    }
else if(email_exists($email, $bdd)) /* On utilise la fct email_exists pour éviter des doublons */
    {
        echo '<font color="red">Cette adresse est déja utilisée par une autre personne.</font>';
    }
//On vérifie si les mots de passes sont identiques

else if(strlen($mdp) < 8)
    {
        echo '<font color="red">Le mot de passe doit contenir au moins 8 caractères</font>';
    }
else if ($mdp != $mdp_verification)
    {
        echo '<font color="red">Attention, les mots de passes ne sont pas identiques !</font>';
    }

else if(!$conditions)
    {
        echo '<font color="red">Il faut accepter les conditions d\'utilisateur avant de s\'enregistrer !</font>';
    }
else if(is_numeric($codePostal)==false)
    {
         echo '<font color="red">Veuillez rentrer un code postal en chiffres seulement !</font>';
    }

// les champs sont bons, on peut enregistrer dans la table
else
    {
    //Si le champ de description n'a pas été touché, on ne veut pas garder le message par défaut
    if($description_perso == 'Description personnelle')
    {
    $description_perso = '';
    }

    // hashage du mot de passe
    $mdpHashe = password_hash($mdp, PASSWORD_DEFAULT) ;

    // on écrit la requête sql
    $req = $bdd->prepare('INSERT INTO users(user_type, nom, email, mdp,code_postal, adresse, telephone, enfants, description, image) VALUES(:user_type, :nom, :email, :mdp,:cp, :adresse, :telephone, :nombre_enfants, :description_perso, :image)');
    //on l'execute
    $req->execute(array(
        'user_type' => $user_type,
        'nom' => $nom,
        'email' => $email,
        'mdp' => $mdpHashe,
        'cp' => $codePostal,
        'adresse' => $adresse,
        'telephone' => $telephone,
        'nombre_enfants' => $nombre_enfants,
        'description_perso' => $description_perso,
        'image' => $image,
        ));
  echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
  header("Refresh:0; Accueil.php");
    }

    $bdd = '' ;






?>
