 <!-- On récupère les anciennes données enregistrées dans la base de données correspondantes à l'utilisateur -->
<?php include("BDProfilUtilisateur.php");
autologout();
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
                <article>



                    <!-- On gère deux cas différents en fonction du type d'utilisateur car les infos ne sont pas les mêmes -->
                    <?php
                    if($type_utilisateur=='Etudiant')
                    { ?>

                    <h1>Modification de profil étudiant</h1>
                    <a class="EmploiDuTemps" href="Calendrier/calendar_etudiant.php">Mon emploi du temps</a>


                        <div id="formDiv">
                            <form method="post" action="ModificationBDDProfilEtudiant.php" enctype="multipart/form-data"><br/>
                            <h2>Les champs suivis d'une étoile (*) sont obligatoires</h2>
                            <input type="text" name="NomEtudiant" placeholder="NOM*" <?php echo 'value=' . '\'' . $ancien_nom . '\'' ;?> size="30" maxlength="20"/> <br/><br/>
                            <input type="text" name="PrenomEtudiant" placeholder="Prenom*" <?php echo 'value=' . '\'' . $ancien_prenom . '\'' ;?> size="30" maxlength="20"/> <br/><br/>
                            <input type="text" name="MailEtudiant" placeholder="E-mail*" <?php echo 'value=' . '\'' . $ancien_email . '\'' ;?> size="30" maxlength="30"/> <br/><br/>
                            <input type="password" name="PasswordEtudiant" placeholder="Mot de passe*" size="30" maxlength="30"/> <br/><br/>
                            <input type="password" name="PasswordConfirmationEtudiant" placeholder="Confirmation du mot de passe*" size="30" maxlength="30"/> <br/><br/>
                            <label>Date de naissance*</label>
                            <input type="number" name="JourNaissance" placeholder="Jour" <?php echo 'value=' . '\'' . $ancien_jourNaissance . '\'' ;?> min="1" max="31"/>
                            <label>/</label>
                            <input type="number" name="MoisNaissance" placeholder="Mois" <?php echo 'value=' . '\'' . $ancien_moisNaissance . '\'' ;?> min="1" max="12"/>
                            <label>/</label>
                            <input type="number" name="AnneeNaissance" placeholder="Année" <?php echo 'value=' . '\'' . $ancien_anneeNaissance . '\'' ;?> min="1900" max="2016"/> <br/> <br/>
                            <input type="text" name="CodePostal" placeholder="Code Postal*" <?php echo 'value=' . '\'' . $ancien_cp . '\'' ;?> size="10" maxlength="5"/> <br/><br/>
                            <input type="text" name="AdresseEtudiant" placeholder="Adresse*" <?php echo 'value=' . '\'' . $ancien_adresse . '\'' ;?> size="30" maxlength="50"/> <br/><br/>
                            <input type="number" name="TelephoneEtudiant" placeholder="Téléphone*" <?php echo 'value=' . $ancien_telephone ;?> max="9999999999"/> <br/><br/>
                            <input type="number" name="Prix" placeholder="Prix*" <?php echo 'value=' . $ancien_tarif ;?> min='10' max="99"/> <br/><br/>
                            <label>Temps de réponse moyen (en heure)*</label>
                            <input type="number" name="tempsReponse" placeholder="Temps de réponse moyen (en heure)*" <?php echo 'value=' . $ancien_temps ;?> min='1' max="72"/> <br/><br/>
                            <input type="number" name="NumeroCNIEtudiant" placeholder="Numéro de carte d'identité*" <?php echo 'value=' . '\'' . $ancien_cni . '\'' ;?> max="999999999999"/> <br/><br/>
                            <input type="text" name="EtudesEtudiant" placeholder="Niveau d'études" <?php
                            //ce champs peut rester vide. On vérifie qu'il ne le soit pas avant de concaténer
                            if($ancien_etudes) {
                                echo 'value=' . '\'' . $ancien_etudes . '\'' ;
                            }
                                ?> size="30" maxlength="30"/> <br/><br/>
                            <input type="text" name="VehiculeEtudiant" placeholder="Véhicule" <?php
                            //ce champs peut rester vide. On vérifie qu'il ne le soit pas avant de concaténer
                            if($ancien_permis) {
                                echo 'value=' . '\'' . $ancien_permis . '\'' ;
                            }
                            ?> size="30" maxlength="30"/> <br/><br/>
                            <textarea name="DescriptionEtudiant" rows="10" cols="50" maxlength="750"><?php
                            //ce champs peut rester vide. On vérifie qu'il ne le soit pas avant de le remplir
                            if($ancien_description)
                            {
                                echo $ancien_description ;
                            }
                            else
                            {
                                echo 'Description personnelle';

                            } ?></textarea><br/><br/>
                            <label>Image :</label><br/><br/>
                            <input type="hidden" name="oldImage" <?php echo 'value=' . '\'' . $ancien_image . '\'' ;?>>
                            <input type="file" name="image" /><br/><br/>
                            <input type="submit" name="submit" /> <br/><br/>
                        </form>
                    </div>
                    <?php
                    }
                    elseif($type_utilisateur=='Famille')
                    { ?>
                    <h1>Modification de profil famille</h1>

                        <div id="formDiv">
                            <form method="post" action="ModificationBDDProfilFamille.php" enctype="multipart/form-data"><br/>
                                <h2>Les champs suivis d'une étoile (*) sont obligatoires</h2>
                                <input type="text" name="NomFamille" placeholder="NOM*" <?php echo 'value=' . '\'' . $ancien_nom . '\'' ;?> size="30" maxlength="20"/> <br/><br/>
                                <input type="text" name="MailFamille" placeholder="E-mail*" <?php echo 'value=' . '\'' . $ancien_email . '\'' ;?> size="30" maxlength="30"/> <br/><br/>
                                <input type="password" name="PasswordFamille" placeholder="Mot de passe*" size="30" maxlength="30"/> <br/><br/>
                                <input type="password" name="PasswordConfirmationFamille" placeholder="Confirmation du mot de passe*" size="30" maxlength="30"/> <br/><br/>
                                <input type="text" name="CodePostal" placeholder="Code Postal*" <?php echo 'value=' . '\'' . $ancien_cp . '\'' ;?> size="10" maxlength="5"/> <br/><br/>
                                <input type="text" name="AdresseFamille" placeholder="Adresse*" <?php echo 'value=' . '\'' . $ancien_adresse . '\'' ;?> size="30" maxlength="50"/> <br/><br/>
                                <input type="text" name="TelephoneFamille" placeholder="Téléphone*" <?php echo 'value=' . '\'' . $ancien_telephone . '\'' ;?> size="30" maxlength="10"/> <br/><br/>
                                <input type="number" name="NombreEnfantsFamille" placeholder="Nombre d'enfants" <?php
                                //ce champs peut rester vide. On vérifie qu'il ne le soit pas avant de concaténer
                                if($ancien_enfants) {
                                    echo 'value=' . $ancien_enfants ;
                                }
                                    ?> max="30"/> <br/><br/>  <!-- A SURVEILLER -->
                                <textarea name="DescriptionFamille" rows="10" cols="50" maxlength="750"><?php
                                //ce champs peut rester vide. On vérifie qu'il ne le soit pas avant de le remplir
                                if($ancien_description)
                                {
                                    echo $ancien_description ;
                                }
                                else
                                {
                                    echo 'Description personnelle';

                                } ?></textarea><br/><br/>
                                <label>Image :</label><br/><br/>
                                <input type="hidden" name="oldImage" <?php echo 'value=' . '\'' . $ancien_image . '\'' ;?>>
                                <input type="file" name="image" /><br/><br/>
                                <input type="submit" name="submit" /> <br/><br/>
                            </form>
                        </div>
                    <?php
                    }
                    else
                    {
                        echo 'problème de type d\'utilisateur' ;
                    }
                    ?>

                </article>
            </section>


            <footer>
            </footer>
        </div>
    </body>
</html>
