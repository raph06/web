 <?php

include("connect.php"); // connexion à la base de données sql
include("functions.php");

if(logged_in())
    {
    header("location:AccueilConnecte.php"); // permet de rediriger l'utilisateur déja connecté
    exit(); // permet de ne pas exécuter la suite du php
    }

//page etudiant => definition du type d'utilisateur
 $user_type='Etudiant';
 $message='Votre profil a été crée avec succès.\n\nPensez à renseigner votre emploi du temps';
// On récupère les champs
if(isset($_POST['NomEtudiant']))                        $nom=$_POST['NomEtudiant'];
else      $nom="";

if(isset($_POST['PrenomEtudiant']))                     $prenom=$_POST['PrenomEtudiant'];
else      $prenom="";

if(isset($_POST['MailEtudiant']))                       $email=$_POST['MailEtudiant'];
else      $email="";

if(isset($_POST['PasswordEtudiant']))                   $mdp=$_POST['PasswordEtudiant'];
else      $mdp="";

if(isset($_POST['PasswordConfirmationEtudiant']))       $mdp_verification=$_POST['PasswordConfirmationEtudiant'];
else      $mdp_verification="";

if(isset($_POST['JourNaissance']))                      $jourNaissance=$_POST['JourNaissance'];
else      $jourNaissance="";

if(isset($_POST['MoisNaissance']))                      $moisNaissance=$_POST['MoisNaissance'];
else      $moisNaissance="";

if(isset($_POST['AnneeNaissance']))                     $anneeNaissance=$_POST['AnneeNaissance'];
else      $anneeNaissance="";

if(isset($_POST['CodePostal']))                         $codePostal=$_POST['CodePostal'];
else      $codePostal="";

if(isset($_POST['AdresseEtudiant']))                    $adresse=$_POST['AdresseEtudiant'];
else      $adresse="";

if(isset($_POST['TelephoneEtudiant']))                  $telephone=$_POST['TelephoneEtudiant'];
else      $telephone="";

if(isset($_POST['Prix']))                               $Prix=$_POST['Prix'];
else      $Prix="";

if(isset($_POST['tempsReponse']))                       $tempsReponse=$_POST['tempsReponse'];
else      $tempsReponse="";

if(isset($_POST['NumeroCNIEtudiant']))                  $numero_cni=$_POST['NumeroCNIEtudiant'];
else      $numero_cni="";

if(isset($_POST['EtudesEtudiant']))                     $niveau_etude=$_POST['EtudesEtudiant'];
else      $niveau_etude="";

if(isset($_POST['VehiculeEtudiant']))                   $vehicule=$_POST['VehiculeEtudiant'];
else      $vehicule="";

if(isset($_POST['DescriptionEtudiant']))                $description_perso=$_POST['DescriptionEtudiant'];
else      $description_perso="";

if(isset($_POST['conditions']))                         $conditions=$_POST['conditions'];
else      $conditions="";

$image = $_FILES['image']['name'];
$tmp_image = $_FILES['image']['tmp_name']; // temporary name
$imageSize = $_FILES["image"]['size'];
$imageType = $_FILES["image"]['type'];

// On vérifie si les champs obligatoires sont vides
if(empty($nom) OR empty($prenom) OR empty($email) OR empty($mdp) OR empty($mdp_verification) OR empty($jourNaissance) OR empty($moisNaissance) OR empty($anneeNaissance) OR empty($codePostal) OR empty($adresse) OR empty($telephone) OR empty($Prix) OR empty($tempsReponse) OR empty($numero_cni))
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
else if($image == "")
    {
        echo '<font color="red">Merci d\'uploader une image valide</font>';
    }
else if($imageSize > 1048576) /* taille max à remplir en bytes */
    {
        echo '<font color="red">La taille de l\'image ne peut pas dépasser 1 Mo</font>';
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

    $imageExt = explode("/", $imageType); /* explode used to extract extension, ajout d'un point après $image+"." afin d'éviter l'erreur undefined offset : http://stackoverflow.com/questions/1807849/undefined-offset-when-using-php-explode */

    $imageExtension = $imageExt[1];

    $image = rand(0,100000).rand(0,100000).rand(0,100000).time().".".$imageExtension; /* on s'assure que les noms d'image soient toujours les mêmes, à chaque utilisateur sa photo */

    // Mise en forme de la date de naissance
    $dateNaissance = $anneeNaissance . '-' . $moisNaissance . '-' . $jourNaissance ;

    // hashage du mot de passe
    $mdpHashe = password_hash($mdp, PASSWORD_DEFAULT) ;

    // on écrit la requête sql
    $req = $bdd->prepare('INSERT INTO users(user_type, nom, prenom, email, mdp, naissance, code_postal, adresse, telephone, tarif, cni, etudes, permis, description, image, tempsreponse) VALUES(:user_type, :nom, :prenom, :email, :mdp, :dateNaissance, :cp, :adresse, :telephone, :tarif, :numero_cni, :niveau_etude, :vehicule, :description_perso, :image , :tempsreponse)');
    //on l'execute
    $req->execute(array(
        'user_type' => $user_type,
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'mdp' => $mdpHashe,
        'dateNaissance' => $dateNaissance,
        'cp' => $codePostal,
        'adresse' => $adresse,
        'tarif' => $Prix,
        'telephone' => $telephone,
        'numero_cni' => $numero_cni,
        'niveau_etude' => $niveau_etude,
        'vehicule' => $vehicule,
        'description_perso' => $description_perso,
        'image' => $image,
        ':tempsreponse' => $tempsReponse,
        ));
    // on affiche le résultat pour le visiteur
	move_uploaded_file($tmp_image, "images/$image");
    //echo 'Votre inscription a bien été prise en compte <br/>';
    //echo 'Merci de penser à renseigner votre emploi du temps<br/><br/>';
	//echo 'Redirection vers l\'accueil';
  echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
  header("Refresh:0; Accueil.php");

		}

    $bdd = '' ;





?>
