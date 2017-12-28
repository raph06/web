<?php include ("connect.php");

if (empty($_POST['ID']))
{
    $_POST['ID']=$_SESSION['prof_visit'];
    unset($_SESSION['prof_visit']);
}

$prof = $bdd->prepare('SELECT * FROM users WHERE ID = ?');
$prof->execute(array($_POST['ID']));    //permet de récupérer toutes les informations du profil grâce à ID transmis par $ID

$com = $bdd->prepare('SELECT * FROM commentaire WHERE destinataire = ? ORDER BY ID DESC');
$com->execute(array($_POST['ID']));     //permet de récupérer toutes les informations des commentaires grâce à ID transmis par $ID

while($donnees =$prof -> fetch())       //les données du profil sont représentée par $donnees
{
    ?>
	<DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" />
            <link rel="stylesheet" href="style_profil.css" />
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
                <div id="banniere_image">
                </div>

                <section>
                    <article>
                    <?php if($_SESSION['type']!='Etudiant'){
                            $debutCreneau = $_POST['debutCreneau'];
                            $finCreneau = $_POST['finCreneau'];
                            if (isset($_POST['CPtrans'])) {?>
                            <form method="POST" action="ResultatConnecte.php">
                            <input type="hidden" name="CP" value="<?php echo $_POST['CPtrans']?>"></input>
                            <input type="hidden" name="NbEnf" value="<?php echo  $_POST['NbEnftrans']?>"></input>
                            <input type="hidden" name="Jour" value="<?php echo  $_POST['Jourtrans']?>"></input>
                            <input type="hidden" name="debutCreneau" value=<?php echo '\'' . $debutCreneau . '\''?>></input>
                            <input type="hidden" name="finCreneau" value=<?php echo '\'' . $finCreneau . '\''?>></input>
                            <input type="submit" class="myButtonConnected" value="Retour aux résultats" />

                            </form>
                            
                            <!--<h1><a href="javascript:history.back()">Retourner aux résultats</h1></a>-->
                        <?php
                        }

                        else
                        {
                        ?>
                            <h1><a href="AccueilConnecte.php">Retourner à l'Accueil</h1></a>
                        <?php
                        }
                    }
                        ?>
                        <div class="profilDiv">
                            <article id = "Photo_Profil_absentéisme">
                                <?php
                                if($donnees['user_type']=='Etudiant')
                                {
                                ?>
                                    <p> <img src=<?php echo "\"images/".$donnees['image']."\"";?>  alt="user_pic"/> </p>
                                    <h2>Taux de validation:</h2>    <!-- Si l'utilisateur est étudiant il a obligatoirement une photo à afficher. -->
                                    <?php
                                    if ($donnees['contrats_acceptes'] != 0 AND $donnees['contrats_annules'] != 0)
                                    {
                                        $Taux_de_validation=(int)($donnees['contrats_acceptes']/($donnees['contrats_acceptes']+$donnees['contrats_annules'])*100);
                                        $Taux_de_validation=(string)$Taux_de_validation."%";                                    }
                                    else
                                    {
                                        $Taux_de_validation="-%";
                                    }
                                        echo"<p>".$Taux_de_validation."</p>";
                                        //Si l'étudiant a déjà eu des contrats, son ratio de validation est affiché, sinon on affiche un "-".
                                }
                                else
                                {
                                    if ($donnees['image']=="")
                                    {
                                    ?>
                                        <p><img src="images/user.png"  alt="user_pic"/> </p>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <p> <img src=<?php echo "\"images/".$donnees['image']."\"";?>  alt="user_pic"/> </p>
                                        <!-- Si l'utilisateur est famille il n'a pas obligatoirement une photo à afficher, on affiche donc une photo de profil par défaut. -->
                                    <?php
                                    }
                                }
                                ?>
                            </article>
                            <article id ="Informations">    <!-- Dans cet article, les informations sont affiché. Les "if" permettent de discriminé les informations propres aux étudiants et propres aux familles. -->
                                <h2> Informations Générales </h2>
                                <?php
                                echo "<p>Nom : ".$donnees['nom']."<br />";
                                if($donnees['user_type']=='Etudiant')
                                {
                                    echo "Prénom : ".$donnees['prenom']."<br />
                                    Date de naissance : ".$donnees['naissance']."<br />";
                                }
                                echo "<br />
                                Email : ".$donnees['email']."<br />
                                Adresse : ".$donnees['adresse']." ".$donnees['code_postal']."<br />
                                Téléphone : ".$donnees['telephone']."<br /><br />";
                                if($donnees['user_type']=='Etudiant')
                                {
                                    echo "Etudes : ".$donnees['etudes']."<br />
                                    Type de permis: ".$donnees['permis']."<br />
                                    Tarif : ".$donnees['tarif']."€/h/enfant<br />
                                    Temps de réponse moyen : ".$donnees['tempsreponse']."h<br /></p>";
                                }
                                else
                                {
                                    echo "Nombre d'enfants : ".$donnees['enfants']."<br /</p>";
                                }
                                ?>
                                <article id ="Description">     <!-- permet d'afficher la description des utilisateurs -->
                                    <h3>Description</h3>
                                    <?php echo "<p>".$donnees['description']."</p>"; ?>
                                </article>
                                <?php
                                if($donnees['user_type']=='Etudiant')   //Si l'utilisateur est étudiant il peut accepter la réservation
                                {
                                    $date=$_POST['Jourtrans'];
                                    $mois=substr($date,5,2);
                                    $annee=substr($date,0,4);
                                    $lejour=substr($date,8,2);
                                ?>
                                    <form method=POST action=Calendrier\calendar_famille.php?month=<?php echo $mois ?>&year=<?php echo $annee ?>&day=<?php echo $lejour ?>>
                                        <input type="hidden" name="Ident" value="<?php echo $_POST['ID'] ?> "></input>
                                        <?php 
                                            if (($_SESSION['type']=='Etudiant') or ($_SESSION['type']=='Famille'))
                                            if ($_POST["dispotrans"] == "oui")                         echo ("<input type='submit' class='myButton' value='RESERVEZ-LE' />");
                                            elseif ($_POST["dispotrans"] == "non")                     echo ("<p class='myButton'>Indisponible</p>");
                                        ?>
                                    </form>
                                <?php
                                }
                                else                                    //Si l'utilisateur est famille elle peut réserver l'étudiant
                                {
                                ?>
                                    <form action='decision_contrat.php' method='post'>
                                    <input type='hidden' name='numero' value='<?php echo $_POST['numero']?>'></input>
                                    <button type='submit' name='Accepter' value = 'A' class='btn-link'>Accepter</button>
                                    <button type='submit' name='Refuser' value = 'R' class='btn-link'>Refuser</button>
                                    </form>
                                <?php
                                }
                                ?>

                            </article>
                            <article id="notecom">      <!-- Les commentaires sont visibles par les autres utilisateurs -->
                                <h2> Notes et commentaires </h2>
                                <br />
                                <?php
                                $commentaires="";
                                while($comment =$com -> fetch())//les données des commentaires sont représentées par $comment
                                {
                                    $emet=$comment['emmeteur'];
                                    $profemet = $bdd->prepare('SELECT nom, prenom FROM users WHERE ID = ?');
                                    $profemet->execute(array($emet));
                                    while($identprofemet =$profemet -> fetch())
                                    {
                                        $nomemet=$identprofemet['nom'];
                                        $prenomemet=$identprofemet['prenom'];
                                    }
                                    $commentaires=$commentaires."<input type=\"checkbox\" name=\"".$comment['ID']."\" id = \"commentaire\" /> <label for=\"commentaire\">".$prenomemet." ".$nomemet." :<br />".$comment['message']."<br />".$comment['note']."/5<br />______________<br /></label><br />";     //Permet de regrouper les commentaires (du plus récent au plus vieux) dans une variable $commentaires.
                                }
                                if ($commentaires=="")    //si il n'y a aucun commentaires
                                {
                                    echo "<p>Il n'y a pas encore</br>de commentaires</p>";
                                }
                                else //si il y'a des commentaires
                                {
                                    echo "<form method=\"post\" action=\"Moderation_com.php\"><p>".$commentaires."</p>"; // Chaque commentaire peut être sélectionner pour être signalé.
                                    echo "<input type=\"hidden\" name=\"destin\" value=\"".$_POST['ID']."\" />";
                                    echo "<input type=\"hidden\" name=\"retour\" value=\"1\" />";
                                    echo "<input type=\"submit\" value=\"Signaler\" id=\"report_button\" /></form>";
                                }
                                ?>
                            </article>
                        </div>
                    </article>
                </section>
                <footer>
                </footer>
        </div>
    </body>
    </html>
<?php
}
$prof->closeCursor();
$com ->closeCursor();
?>
