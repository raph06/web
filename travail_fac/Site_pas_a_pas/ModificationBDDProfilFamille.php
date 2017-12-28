 <?php

include("connect.php"); // connexion à la base de données sql
include("functions.php");

/* Impossible de garder ça ici, car la redirection se fait avant l'execution de la modification de la base de donnée
Je le laisse en commentaire un moment pour qu'on y pense. Attention également, la page profile.php n'existe pas
if(logged_in())
    {
    header("location:profile.php"); // permet de rediriger l'utilisateur déja connecté
    exit(); // permet de ne pas exécuter la suite du php
    }
*/
?>
<DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style_inscription.css" />
        <link rel="stylesheet" href="style_general.css" />
        <link rel="stylesheet" href="style_general_connect.css" />
        <title>E-Sitting - Le babysitting sans bouger de chez vous</title>
    </head>
    <body>

        <div id = "bloc_page">
            <header>
                <div id="titre_principal">
                    <div id="logo">
                        <img src="Pictures/logo.png" alt="Logo E-sitting" />
                    </div>
                    <div id="deconnexion">
                        <a href="logout.php" class="myButtonConnected">Déconnexion</a>
                    </div>
                    <div id="bonjour"><?php
                      if ($_SESSION['type']=='Super' or $_SESSION['type']=='Admin')
                      {
                    echo(  "<a href='dash_admin.php' class='myButtonConnected'>Dashboard".  "</a>" );
                  }
                    else
                    {
                        echo("<a href='#' class='myButtonConnected'>Bonjour ". $_SESSION['prenom'] . " ". $_SESSION['nom'] . "  </a>");
                      }?></div>
                </div>
            </header>
            <div id = "Menu_Principal">
                    <ul class="fancyNav" id="myTopnav">
                        <li id="home"><a href="AccueilConnecte.php" class="homeIcon">Accueil</a></li>
                        <li><a href="#">Annonces</a></li>
                        <li><a href="AccueilConnecte.php#Whoarewe">Qui sommes-nous ?</a></li>
                        <li><a href="AccueilConnecte.php#Esitter">Rejoignez l'aventure</a></li>
                        <li><a href="AccueilConnecte.php#Paiements">Tarifs & Paiements</a></li>
                        <li><a href="ConsultationProfilUtilisateur.php">Profil</a></li>
                        <li class="icon">
                        <a href="javascript:void(0);" style="font-size:15px;" onclick="myFunction()">☰</a> <!-- Initialisation du bouton qui apparait en cas de trop petite image (voir media query) -->
                        </li>
                    </ul>
            </div>
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
            <section>
                    <!--<article>-->
                    <?php
                    $utilisateur=$_SESSION['ID'];

                    // On récupère les champs
                    // Si des champs obligatoires sont laissés vides, on réutilise les anciennes infos

                    if(isset($_POST['NomFamille']))                        $nom=$_POST['NomFamille'];
                    else      $nom=$ancien_nom;

                    if(isset($_POST['MailFamille']))                     $email=$_POST['MailFamille'];
                    else      $email=$ancien_email;

                    if(isset($_POST['PasswordFamille']))                   $mdp=$_POST['PasswordFamille'];
                    else      $mdp="";

                    if(isset($_POST['PasswordConfirmationFamille']))       $mdp_verification=$_POST['PasswordConfirmationFamille'];
                    else      $mdp_verification="";

                    if(isset($_POST['AdresseFamille']))                    $adresse=$_POST['AdresseFamille'];
                    else      $adresse=$ancien_adresse;

                    if(isset($_POST['CodePostal']))                    $codePostal=$_POST['CodePostal'];
                    else      $codePostal=$ancien_cp;

                    if(isset($_POST['TelephoneFamille']))                  $telephone=$_POST['TelephoneFamille'];
                    else      $telephone=$ancien_telephone;

                    if(isset($_POST['NombreEnfantsFamille']))                  $nombre_enfants=$_POST['NombreEnfantsFamille'];
                    else      $nombre_enfants='';

                    if(isset($_POST['DescriptionFamille']))                $description_perso=$_POST['DescriptionFamille'];
                    else      $description_perso="";

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
                    else
                    {
                        $image = $_POST['oldImage'] ;
                    }

                    if(empty($nom) OR empty($email) OR empty($codePostal) OR empty($adresse) OR empty($telephone))
                        {
                        echo '<font color="red">Attention, les champs suivis d\'une étoiles ne peuvent pas rester vides !</font>';
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

                    else if($mdp!="" and strlen($mdp) < 8)
                        {
                            echo '<font color="red">Le mot de passe doit contenir au moins 8 caractères</font>';
                        }
                    else if ($mdp != $mdp_verification)
                        {
                            echo '<font color="red">Attention, les mots de passes ne sont pas identiques !</font>';
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

                        if($mdp != "")
                        {
                            // hashage du mot de passe
                            $mdpHashe = password_hash($mdp, PASSWORD_DEFAULT) ;

                            // on écrit la requête sql
                            $req = $bdd->prepare('UPDATE users SET nom = :nom, email = :email, mdp = :mdp, code_postal = :codePostal, adresse = :adresse, telephone = :telephone, enfants = :nb_enfants, description = :description_perso, image = :image, moderation = :moderation WHERE ID = :utilisateur');
                            //on l'execute
                            $req->execute(array(
                            'nom' => $nom,
                            'email' => $email,
                            'mdp' => $mdpHashe,
                            'codePostal' => $codePostal,
                            'adresse' => $adresse,
                            'telephone' => $telephone,
                            'nb_enfants' => $nombre_enfants,
                            'description_perso' => $description_perso,
                            'image' => $image,
                            'moderation' => 1,
                            'utilisateur' => $utilisateur
                            ));

                        }

                        else
                        {
                            // on écrit la requête sql
                            $req = $bdd->prepare('UPDATE users SET nom = :nom, email = :email, code_postal = :codePostal, adresse = :adresse, telephone = :telephone, enfants = :nb_enfants, description = :description_perso, image = :image, moderation = :moderation WHERE ID = :utilisateur');
                            //on l'execute
                            $req->execute(array(
                            'nom' => $nom,
                            'email' => $email,
                            'codePostal' => $codePostal,
                            'adresse' => $adresse,
                            'telephone' => $telephone,
                            'nb_enfants' => $nombre_enfants,
                            'description_perso' => $description_perso,
                            'image' => $image,
                            'moderation' => 1,
                            'utilisateur' => $utilisateur
                            ));

                        }

                        $bdd = '' ;
                        $message='Votre profil a été modifié avec succès';

                        echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                        header("Refresh:0; AccueilConnecte.php");

                        if ($nom != $_SESSION['nom'])            $_SESSION['nom'] = $nom;
                    }
                    ?>
                    <!--</article>-->
                </section>
            </div>
        </body>
    </html>

