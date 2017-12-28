<?php include ("connect.php");
include("case_contrats.php"); // Fichier reprennant les fonctions qui pioches dans la BDD les info pour les contrats


$prof = $bdd->prepare('SELECT * FROM users WHERE ID = ?');
$prof->execute(array($_SESSION['ID']));      //permet de récupérer toutes les informations du profil grâce à ID transmis par $SESSION


$com = $bdd->prepare('SELECT * FROM commentaire WHERE destinataire = ? ORDER BY ID DESC ');
$com->execute(array($_SESSION['ID']));      //permet de récupérer toutes les informations des commentaires grâce à ID transmis par $SESSION

while($donnees =$prof -> fetch())   //les données du profil sont représentées par $donnees
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
                <div id="banniere_image">
                </div>
                <section>
                    <article>
                        <h1>Mon Profil</h1>
                        <form action="ModificationProfilUtilisateur.php" method="post">
                        <input type="submit" value="Modifier mon profil" class="ModifProfil" />
                        </form>         <!-- Si l'utilisateur étudiant veut modifier son profil Il ira sur la page correspondante -->
                        <div class="profilDiv">
                            <article id = "Photo_Profil_absentéisme">
                                <?php
                                if($donnees['user_type']=='Etudiant')
                                {
                                ?>
                                    <p> <img src=<?php echo "\"images/".$donnees['image']."\"";?>  alt="user_pic"/> </p>
                                    <h2>Taux de <br /> validation :</h2>    <!-- Si l'utilisateur est étudiant il a obligatoirement une photo à afficher. -->
                                    <?php
                                    if ($donnees['contrats_acceptes'] != 0 AND $donnees['contrats_annules'] != 0)
                                    {
                                        $Taux_de_validation=(int)($donnees['contrats_acceptes']/($donnees['contrats_acceptes']+$donnees['contrats_annules'])*100);
                                        $Taux_de_validation=(string)$Taux_de_validation."%";
                                    }
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
                            <article id = "Informations">    <!-- Dans cet article, les informations sont affiché. Les "if" permettent de discriminé les informations propres aux étudiants et propres aux familles. -->
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
                                    Tarif : ".$donnees['tarif']."€/h<br />
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
                            </article>
                            <?php
                            if($donnees['user_type']=='Etudiant') //Seul l'étudiant peut visualiser ses propres commentaires
                            {
                            ?>
                                <article id = "notecom">
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
                                        echo "<input type=\"hidden\" name=\"destin\" value=\"".$_SESSION['ID']."\" />";
                                        echo "<input type=\"hidden\" name=\"retour\" value=\"0\" />";
                                        echo "<input type=\"submit\" value=\"Signaler\" id=\"report_button\" /></form>";
                                    }
                                    ?>
                                </article>
                            <?php
                            }
                          ?>
                        </div>

            <?php   if(($donnees['user_type']=='Etudiant') || ($donnees['user_type']=='Famille')){ ?>
                                    <div class="profilDiv">
                                        <article id="Attente_réponse">  <!-- Ici s'affiche les contrat en attente suite à une demande de la famille -->
                                            <h3>Contrats en attente de réponse :</h3>
                                            <?php
                                            if($_SESSION['type'] == 'Etudiant'){
                                            $a = recup_data_contrat_unlock_etudiant($bdd); // Fait appel a la fonction présent dans case_contrat
            								if($a != 0){ // Si les éléments récupéré dans la base de données ne sont pas vide
            								for ($i = 0; $i <= count($a)-1; $i++) { // Initialisation i qui est la clé de l'array. Nous sert à ressortir les éléments ensuite 'Famille/Date/Start'
                                                $id_famille_visit=$a[$i]['id_famille'];//on récupère l'id de la famille
            									echo("Vous avez un contrat en attente de validation avec la famille : ".$a[$i]['famille']." à : ".$a[$i]['start']." le : ".$a[$i]['date']);
            									echo('<br/>');
            									echo('<br/>');
                              echo("<form action='decision_contrat.php' method='post'>
							  <input type='hidden' name='numero' value='$i'></input>
                                    <button type='submit' name='Accepter' value = 'A' class='btn-link'>Accepter</button>
                                   <button type='submit' name='Refuser' value = 'R' class='btn-link'>Refuser</button>
                                  </form>".'</br>'.// Affiche 2 boutons Accepté/Refusé -> Renvoie a decision_contrat.php
                                  "<form action='ConsultationProfilUtilisateurTiers.php' method='post'>
                                  <input type ='hidden' name='ID' value='$id_famille_visit'</input>
                                  <input type='hidden' name='numero' value='$i'></input>
                                  <button type='submit' name='Voirprofil' class='btn-link'>Voir le profil</button>
                                  </form>"); //affiche un bouton d'accès au profil


            								}
            								}
            								}

            								else if($_SESSION['type'] == 'Famille'){ // La famille a réservé un étudiant. Le contrat est mnt en attente de validation.
                                            $a = recup_data_contrat_unlock_famille($bdd);
            								if($a != 0){
            								for ($i = 0; $i <= count($a)-1; $i++) {
            									echo("Vous avez un contrat en attente de validation avec l'étudiant : ".$a[$i]['famille']." à : ".$a[$i]['start']." le : ".$a[$i]['date']);
            									echo('<br/>');
            									echo('<br/>');
            								}
            								}
            								}
                                         ?>
                                        </article>
                                        <article id="En_cours">
                                            <h3>Mes Contrats en cours :</h3> <!-- Pour les contrats en cours les utilisateurs doivent avoir le choix d'Annuler le contrat.-->
                                            <?php
                                            if($_SESSION['type'] == 'Etudiant'){
                                            $a = recup_data_contrat_lock_etudiant($bdd);
            								if($a != 0){
            								for ($i = 0; $i <= count($a)-1; $i++) {
												$id_famille = $a[$i]['id_famille'];
            									echo("Vous avez un contrat validé avec la famille : ".$a[$i]['famille']." à : ".$a[$i]['start']." le : ".$a[$i]['date']);
            									echo('<br/>');
            									echo('<br/>');
                              echo("<form action='decision_contrat.php' method='post'>
                <input type='hidden' name='numero' value='$i'></input>
                <input type='hidden' name='fam' value='$id_famille'></input>
                                   <button type='submit' name='Cancel' value = 'R' class='btn-link'>Annuler</button>
                                  </form>".'</br>');
            								}
            								}
            								}

            								else if($_SESSION['type'] == 'Famille'){
                                            $a = recup_data_contrat_lock_famille($bdd);
            								if($a != 0){
            								for ($i = 0; $i <= count($a)-1; $i++) {

                              $id_etud=$a[$i]['login'];

            									echo("Vous avez un contrat validé avec l'étudiant : ".$a[$i]['famille']." à : ".$a[$i]['start']." le : ".$a[$i]['date']);
            									echo('<br/>');
            									echo('<br/>');
                              echo("<form action='decision_contrat.php' method='post'>
                <input type='hidden' name='numero' value='$i'></input>
                <input type='hidden' name='etu' value='$id_etud'></input>
                                   <button type='submit' name='Refuser' value = 'R' class='btn-link'>Annuler</button>
                                  </form>".'</br>');
            								}
            								}
            								}

                                         ?>
                                    </article>
                            <article id="Effectue">
                                <h3>Mes derniers contrats effectués :</h3>

								<?php

           								if($_SESSION['type'] == 'Famille'){
                                            $a = recup_contrat_passes_famille($bdd);
            								if($a != 0){
            								for ($i = 0; $i <= count($a)-1; $i++) {

                              $id_etud=$a[$i]['login'];
                              $id_fam = $_SESSION['ID'];

            									echo("Vous avez un contrat passé avec l'étudiant : ".$a[$i]['famille']." à : ".$a[$i]['start']." le : ".$a[$i]['date']);
            									echo('<br/>');
            									echo('<br/>');
                             echo("<form action='decision_contrat.php' method='post'>
                <input type='hidden' name='numero' value='$i'></input>
                <input type='hidden' name='etu' value='$id_etud'></input>
                                   <button type='submit' name='Litige' value = 'R' class='btn-link'>Déclarer un Litige</button>
                                  </form>".'</br>');

							if($a[$i]['Note'] != 2  and $a[$i]['Note'] != 3){
							$id_contrat = $a[$i]['id'];
                                  echo("<form action='Notation.php' method='post'>
                     <input type='hidden' name='numero' value='$i'></input>
                     <input type='hidden' name='etu' value='$id_etud'></input>
                     <input type='hidden' name='fam' value='$id_fam'></input>
                     <input type='hidden' name='id_contrat' value='$id_contrat'></input>
                     <input type='hidden' name='valeur_notation' value='2'></input>
                                        <button type='submit' name='Eval' value = 'R' class='btn-link'>Evaluer la prestation</button>
                                       </form>".'</br>');
							}
							else print("Ce contrat a déja été noté.");

                                       echo('</br>');

            								}
            								}
            								}

           								if($_SESSION['type'] == 'Etudiant'){
                                            $a = recup_contrat_passes_etudiant($bdd);
            								if($a != 0){
            								for ($i = 0; $i <= count($a)-1; $i++) {
                              $id_famille = $a[$i]['id_famille'];
            									echo("Vous avez un contrat passé avec la famille: ".$a[$i]['famille']." à : ".$a[$i]['start']." le : ".$a[$i]['date']);
            									echo('<br/>');
            									echo('<br/>');

                              $id_fam=$a[$i]['id_famille'];
                              $id_etud = $_SESSION['ID'];
								if($a[$i]['Note'] != 3 and $a[$i]['Note'] != 2){
								$id_contrat = $a[$i]['id'];
                                  echo("<form action='Notation.php' method='post'>
                     <input type='hidden' name='numero' value='$i'></input>
                     <input type='hidden' name='etu' value='$id_fam'></input>
                     <input type='hidden' name='fam' value='$id_etud'></input>
                     <input type='hidden' name='id_contrat' value='$id_contrat'></input>
                     <input type='hidden' name='valeur_notation' value='3'></input>
                                        <button type='submit' name='Eval' value = 'R' class='btn-link'>Evaluer la prestation</button>
                                       </form>".'</br>');
								}
								else echo("Ce contrat a déja été noté.");

            								}
            								}
            								}

								?>

                            </article>
                        </div>
                    </article>
                </section>
                <footer>
                </footer>
        </div>
        <?php
        }

      ?>
    </body>
    </html>
<?php
}
$prof->closeCursor();
$com ->closeCursor();
?>
