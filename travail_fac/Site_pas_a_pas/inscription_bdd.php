 <?php
 //page etudiant => definition du type d'utilisateur
 $user_type='Etudiant';
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

if(isset($_POST['AdresseEtudiant']))                    $adresse=$_POST['AdresseEtudiant'];
else      $adresse="";

if(isset($_POST['TelephoneEtudiant']))                  $telephone=$_POST['TelephoneEtudiant'];
else      $telephone="";

if(isset($_POST['NumeroCNIEtudiant']))                  $numero_cni=$_POST['NumeroCNIEtudiant'];
else      $numero_cni="";

if(isset($_POST['EtudesEtudiant']))                     $niveau_etude=$_POST['EtudesEtudiant'];
else      $niveau_etude="";

if(isset($_POST['VehiculeEtudiant']))                   $vehicule=$_POST['VehiculeEtudiant'];
else      $vehicule="";

if(isset($_POST['DescriptionEtudiant']))                $description_perso=$_POST['DescriptionEtudiant'];
else      $description_perso="";

// On vérifie si les champs sont vides
if(empty($nom) OR empty($prenom) OR empty($email) OR empty($mdp) OR empty($mdp_verification) OR empty($jourNaissance) OR empty($moisNaissance) OR empty($anneeNaissance) OR empty($adresse) OR empty($telephone) OR empty($numero_cni))
    {
    echo '<font color="red">Attention, les champs suivis d\'une étoiles ne peuvent pas rester vides !</font>';
    //debug
    echo $nom . ' ' . $prenom . ' ' . $email . ' ' . $mdp . ' ' . $mdp_verification . ' ' . $jourNaissance . ' ' . $moisNaissance . ' ' . $anneeNaissance . ' ' . $adresse . ' ' . $telephone . ' ' . $numero_cni ;
    }
//On vérifie si les mots de passes sont identiques
elseif ($mdp != $mdp_verification)
    {
    echo '<font color="red">Attention, les mots de passes ne sont pas identiques !</font>';
    }

// les champs sont bons, on peut enregistrer dans la table
else    
    {
    
    include("connect.php"); // connexion à la base
    
    }
    
    // Mise en forme de la date de naissance
    $dateNaissance = $anneeNaissance . '-' . $moisNaissance . '-' . $jourNaissance ;
    // hashage du mot de passe
    $mdpHashe = password_hash($mdp, PASSWORD_DEFAULT) ;
    // on écrit la requête sql
    $req = $bdd->prepare('INSERT INTO users(user_type, nom, prenom, email, mdp, naissance, adresse, telephone, cni, etudes, permis, description) VALUES(:user_type, :nom, :prenom, :email, :mdp, :dateNaissance, :adresse, :telephone, :numero_cni, :niveau_etude, :vehicule, :description_perso)');
    //on l'execute
    $req->execute(array(
        'user_type' => $user_type,
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'mdp' => $mdpHashe,
        'dateNaissance' => $dateNaissance,
        'adresse' => $adresse,
        'telephone' => $telephone,
        'numero_cni' => $numero_cni,
        'niveau_etude' => $niveau_etude,
        'vehicule' => $vehicule,
        'description_perso' => $description_perso,
        ));
    // on affiche le résultat pour le visiteur
    echo 'Votre inscription a bien été prise en compte';
    }
?>


