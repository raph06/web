 <?php

include("connect.php"); /* connexion à la base de données sql */
include("functions.php");

/* Impossible de garder ça ici, car la redirection se fait avant l'execution de la modification de la base de donnée
Je le laisse en commentaire un moment pour qu'on y pense. Attention également, la page profile.php n'existe pas
if(logged_in())
    {
    header("location:profile.php"); // permet de rediriger l'utilisateur déja connecté
    exit(); // permet de ne pas exécuter la suite du php
    } */
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
                        if(isset($_POST['NomEtudiant']))                        $nom=$_POST['NomEtudiant'];
                        else      $nom=$ancien_nom;

                        if(isset($_POST['PrenomEtudiant']))                     $prenom=$_POST['PrenomEtudiant'];
                        else      $prenom=$ancien_prenom;

                        if(isset($_POST['MailEtudiant']))                       $email=$_POST['MailEtudiant'];
                        else      $email=$ancien_email;

                        if(isset($_POST['PasswordEtudiant']))                   $mdp=$_POST['PasswordEtudiant'];
                        else      $mdp="";

                        if(isset($_POST['PasswordConfirmationEtudiant']))       $mdp_verification=$_POST['PasswordConfirmationEtudiant'];
                        else      $mdp_verification="";

                        if(isset($_POST['JourNaissance']))                      $jourNaissance=$_POST['JourNaissance'];
                        else      $jourNaissance=$ancien_jourNaissance;

                        if(isset($_POST['MoisNaissance']))                      $moisNaissance=$_POST['MoisNaissance'];
                        else      $moisNaissance=$ancien_moisNaissance;

                        if(isset($_POST['AnneeNaissance']))                     $anneeNaissance=$_POST['AnneeNaissance'];
                        else      $anneeNaissance=$ancien_anneeNaissance;

                        if(isset($_POST['CodePostal']))                         $codePostal=$_POST['CodePostal'];
                        else      $codePostal=$ancien_cp;

                        if(isset($_POST['AdresseEtudiant']))                    $adresse=$_POST['AdresseEtudiant'];
                        else      $adresse=$ancien_adresse;

                        if(isset($_POST['TelephoneEtudiant']))                  $telephone=$_POST['TelephoneEtudiant'];
                        else      $telephone=$ancien_telephone;

                        if(isset($_POST['Prix']))                              $prix=$_POST['Prix'];
                        else      $prix=$ancien_tarif;

                        if(isset($_POST['tempsReponse']))                       $tempsReponse=$_POST['tempsReponse'];
                        else      $tempsReponse="";

                        if(isset($_POST['NumeroCNIEtudiant']))                  $numero_cni=$_POST['NumeroCNIEtudiant'];
                        else      $numero_cni=$ancien_cni;

                        if(isset($_POST['EtudesEtudiant']))                     $niveau_etude=$_POST['EtudesEtudiant'];
                        else      $niveau_etude="";

                        if(isset($_POST['VehiculeEtudiant']))                   $vehicule=$_POST['VehiculeEtudiant'];
                        else      $vehicule="";

                        if(isset($_POST['DescriptionEtudiant']))                $description_perso=$_POST['DescriptionEtudiant'];
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
                        if(empty($nom) OR empty($prenom) OR empty($email) OR empty($jourNaissance) OR empty($moisNaissance) OR empty($anneeNaissance) OR empty($codePostal) OR empty($adresse) OR empty($telephone) OR empty($prix) OR empty($tempsReponse) OR empty($numero_cni))
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
                        // les champs sont bons, on peut enregistrer dans la table
                        else
                        {
                            //Si le champ de description n'a pas été touché, on ne veut pas garder le message par défaut
                            if($description_perso == 'Description personnelle')
                            {
                            $description_perso = '';
                            }

                            // Mise en forme de la date de naissance
                            $dateNaissance = $anneeNaissance . '-' . $moisNaissance . '-' . $jourNaissance ;

                            if($mdp != "")
                            {
                                // hashage du mot de passe
                                $mdpHashe = password_hash($mdp, PASSWORD_DEFAULT) ;

                                // on écrit la requête sql
                                $req = $bdd->prepare('UPDATE users SET nom = :nom, prenom = :prenom, email = :email, mdp = :mdp, naissance = :dateNaissance, code_postal = :code_postal, adresse = :adresse, telephone = :telephone, tarif = :prix, cni = :numero_cni, etudes = :niveau_etude, permis = :vehicule, description = :description_perso, image = :image, tempsreponse = :tempsreponse, moderation = :moderation WHERE ID = :utilisateur');
                                //on l'execute
                                $req->execute(array(
                                'nom' => $nom,
                                'prenom' => $prenom,
                                'email' => $email,
                                'mdp' => $mdpHashe,
                                'dateNaissance' => $dateNaissance,
                                'code_postal' => $codePostal,
                                'adresse' => $adresse,
                                'telephone' => $telephone,
                                'prix' => $prix,
                                'numero_cni' => $numero_cni,
                                'niveau_etude' => $niveau_etude,
                                'vehicule' => $vehicule,
                                'description_perso' => $description_perso,
                                'image' => $image,
                                'tempsreponse' => $tempsReponse,
                                'moderation' => 1,
                                'utilisateur' => $utilisateur
                                ));

                            }

                            else
                            {
                                // on écrit la requête sql
                                $req = $bdd->prepare('UPDATE users SET nom = :nom, prenom = :prenom, email = :email, naissance = :dateNaissance, code_postal = :code_postal, adresse = :adresse, telephone = :telephone, tarif = :prix, cni = :numero_cni, etudes = :niveau_etude, permis = :vehicule, description = :description_perso, image = :image, tempsreponse = :tempsreponse, moderation = :moderation WHERE ID = :utilisateur');
                                //on l'execute
                                $req->execute(array(
                                'nom' => $nom,
                                'prenom' => $prenom,
                                'email' => $email,
                                'dateNaissance' => $dateNaissance,
                                'code_postal' => $codePostal,
                                'adresse' => $adresse,
                                'telephone' => $telephone,
                                'prix' => $prix,
                                'numero_cni' => $numero_cni,
                                'niveau_etude' => $niveau_etude,
                                'vehicule' => $vehicule,
                                'description_perso' => $description_perso,
                                'image' => $image,
                                'tempsreponse' => $tempsReponse,
                                'moderation' => 1,
                                'utilisateur' => $utilisateur
                                ));

                            }

                            $bdd = '' ;
                            $message='Votre profil a été modifié avec succès';

                            echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                            header("Refresh:0; AccueilConnecte.php");

                            if ($nom != $_SESSION['nom'])               $_SESSION['nom'] = $nom;

                            if ($prenom != $_SESSION['prenom'])         $_SESSION['prenom'] = $nom;
                        }
                        ?>
                    <!--</article>-->
                </section>
            </div>
        </body>
    </html>

