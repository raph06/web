<?php
include("connect.php");
include("functions.php");
autologout();

 ?>

<DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style_resultat.css" />
        <link rel="stylesheet" href="style_general.css" />
        <link rel="stylesheet" href="style_general_connect.css" />
        <title>E-Sitting - Le babysitting sans bouger de chez vous</title>
    </head>
    <body>
        <div id = "bloc_page">
            <header>
                    <div id="logo">
                        <img src="Pictures/logo.png" alt="Logo E-sitting" />
                    </div>
                    <div id="deconnexion">
                        <a href="logout.php" class="myButton">Déconnexion</a>
                    </div>
                    <div id="bonjour"><?php
                      if ($_SESSION['type']=='Super' or $_SESSION['type']=='Admin')
                      {
                    echo(  "<a href='dash_admin.php' class='myButton'> Dashboard  </a>" );
                  }
                    else
                    {
                        echo("<a href='#' class='myButton'>Bonjour ". $_SESSION['prenom'] . " ". $_SESSION['nom'] . "  </a>");
                      }?>
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
            <?php
            if ($_SESSION['type']!='Etudiant'){ ?>
            <section>
                <article>
                    <h1>Resultats</h1>
                <!-- Definition de la partie MODAL qui pop si l'utilisateur non connecté clique sur le profil -->
                <div id="myModal" class="modal">
                  <!-- Modal content -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="close">×</span>
                            <h2>Oops ...</h2>
                        </div>
                        <div class="modal-body">
                            <form>
                            <legend>Il semblerait que vous ne soyez pas encore un E-sitter (veuillez vous inscrire).</br>
                            <div id="connexion_2">
                                <a href="#" class="myButton">Connexion</a>
                            </div>
                            <div id="inscription_2">
                                <a href="#" class="myButton">Inscription</a>
                            </div>
                            </legend></br>
                            </form>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
                <!-- FIN Definition de la partie MODAL -->
                <?php
                if(isset($_POST['CP']))                        $CP=$_POST['CP'];
                elseif(isset($_GET['CP']))                     $CP=$_GET['CP'];
                else      $CP="";

                if(isset($_POST['NbEnf']))                     $NbEnf=$_POST['NbEnf'];
                elseif(isset($_GET['NbEnf']))                  $NbEnf=$_GET['NbEnf'];
                else      $NbEnf="";

                $_SESSION['NbEnfRecherche'] = $NbEnf;

                if(isset($_POST['Jour']))                      $jour=$_POST['Jour'];
                elseif(isset($_GET['Jour']))                   $jour=$_GET['Jour'];
                else      $jour="";

                if (isset($_POST['debutheure']) AND isset($_POST['debutminute'])){
                    $debutheure = $_POST['debutheure'];
                    $debutminute = $_POST['debutminute'];
                    $debutCreneau=$debutheure . ':' . $debutminute . ':00';
                } 
                elseif (isset($_POST['debutCreneau'])){
                    $debutCreneau =$_POST['debutCreneau'];
                }
                elseif (isset($_GET['debutCreneau'])) {
                    $debutCreneau=$_GET['debutCreneau'];
                }          



                if (isset($_POST['finheure']) AND isset($_POST['finminute'])){
                    $finheure = $_POST['finheure'];
                    $finminute = $_POST['finminute'];
                    $finCreneau=$_POST['finheure'] . ':' . $_POST['finminute'] . ':00';
                } 

                elseif (isset($_POST['finCreneau']))
                    {$finCreneau =$_POST['finCreneau'];}

                elseif (isset($_GET['finCreneau'])) {
                    $finCreneau=$_GET['finCreneau'];
                }    



                $type='Etudiant';
                // On vérifie si les champs sont vides

                if(empty($CP) OR empty($NbEnf) OR empty($jour))
                    {
                    echo ' <p><font color="red">Veuillez entrer un code postal, un nombre d\'enfants et une date </font></p>';
                    }
                    else if(is_numeric($CP)==false)
                    {
                         echo '<font color="red">Veuillez rentrer un code postal en chiffres seulement !</font>';
                    }
                    else {

                        if (isset($_GET['CP'])) {

                       $Approx_cp=substr($CP,0,2).'%';
                                               $req = $bdd->prepare('SELECT users.Id, nom, prenom, naissance, code_postal, tarif, etudes, description, image, status FROM users INNER JOIN bookings ON users.Id = bookings.login WHERE code_postal like :CP AND user_type=:user_type AND date=:dateCreneau AND start>= :debutCreneau AND end<= :finCreneau ORDER BY users.Id #AND status IN (0,1)');
                                               $req->execute(array(
                                                   'CP'=> $Approx_cp,
                                                   'user_type'=>$type,
                                                   'dateCreneau' =>$jour,
                                                   'debutCreneau' => $debutCreneau,
                                                   'finCreneau' => $finCreneau,
                                                   ));
                                           }
                        else {

                            $req = $bdd->prepare('SELECT users.Id, nom, prenom, naissance, code_postal, tarif, etudes, description, image, status FROM users INNER JOIN bookings ON users.Id = bookings.login WHERE code_postal=:CP AND user_type=:user_type AND date=:dateCreneau AND start>= :debutCreneau AND end<= :finCreneau ORDER BY users.Id #AND status IN (0,1)');
                            $req->execute(array(
                                'CP'=> $CP,
                                'user_type'=>$type,
                                'dateCreneau' =>$jour,
                                'debutCreneau' => $debutCreneau,
                                'finCreneau' => $finCreneau,
                                ));

                            //$req = $bdd->query('SELECT users.Id,nom,prenom,naissance,code_postal,etudes,description,image FROM users INNER JOIN bookings ON users.Id = bookings.login WHERE code_postal=\'' . $CP .  '\' AND user_type=\'' . $type .  '\' AND jour=\'' . $jour .  '\' AND start= \'' . $debutCreneau .  '\'');

                        }


                        echo "<div id=\"result\">";
                        if (!$donnees = $req->fetch()) {
                            echo "Pas de résultats correspondants à vos critères";
                        }
                        else {
                            $note = 0;
                            $nombreNote = 0;
                            $reqnote = $bdd->prepare('SELECT note FROM commentaire WHERE destinataire=?');
                            $reqnote ->execute(array($donnees['Id']));

                            while ( $donneesnote = $reqnote -> fetch()) {
                                $note = $note + $donneesnote['note'];
                                $nombreNote = $nombreNote + 1;
                            }

                            $IdSaved = $donnees['Id'];
                            $dispo = "oui";
                            if ($donnees['status']!=0)              $dispo = "non";
                            
                            $Id_profil_consulte = $donnees['Id'];
                            $image=$donnees['image'];
                            echo 'Résultats de la recherche<br/>';
                            echo "<br/>";
                            echo "
                            <div id=\"profil_result\">
                            <img src=images/$image alt='image' height='225'width='225'/>";
                            echo 'Etudiant : ' . $donnees['nom'] . ' ' . $donnees['prenom'] . ' né(e) le ' . $donnees['naissance'] . '<br/>Niveau d\'études :'. $donnees['etudes'] . '<br/> Description : ' . $donnees['description'] . "<br/>Prix par heure : " . $donnees['tarif'] . "€<br/>". $donnees['code_postal'] . "</p>
                            <div id=\"bookme\">";
                            ?>
                            <form method=POST action=ConsultationProfilUtilisateurTiers.php>
                            <input type="hidden" name="ID" value="<?php echo $Id_profil_consulte?>"></input> <!--Envoie de l'id dont le nom est Indent, pour voir récup les infos de l'Id pour afficher le bon profil-->
                            <input type="hidden" name="CPtrans" value="<?php echo $CP?>"></input> <!-- permet d'envoyer les informations du formulaire à ConsultationProfilTiers.php -->
                            <input type="hidden" name="NbEnftrans" value=<?php echo $NbEnf?>></input>
                            <input type="hidden" name="Jourtrans" value="<?php echo $jour?>"></input>
                            <input type="hidden" name="debutCreneau" value=<?php echo '\'' . $debutCreneau . '\''?>></input>
                            <input type="hidden" name="finCreneau" value=<?php echo '\'' . $finCreneau . '\''?>></input>
                            <input type="hidden" name="dispotrans" value="<?php echo $dispo?>"></input>
                            <input type="submit" class="myButton" value="Voir le profil" />
                            </form>
                            <?php

                            $annee = substr($jour,0,4);
                            $mois = substr($jour,5,2);
                            $lejour = substr($jour,8,2);



                        while ($donnees = $req->fetch())
                        {


                            if ($IdSaved == $donnees['Id'] AND $donnees['status']!=0){
                                $dispo = "non";                            
                            } 
                            elseif ($IdSaved != $donnees['Id'] ) {

                            ?>

                            <form method=POST action=Calendrier\calendar_famille.php?month=<?php echo $mois ?>&year=<?php echo $annee ?>&day=<?php echo $lejour ?>>
                            <input type="hidden" name="Ident" value="<?php echo $Id_profil_consulte ?> "></input>
                            <?php if (($_SESSION['type']=='Etudiant') or ($_SESSION['type']=='Famille'))
                                if ($dispo == "oui")                         echo ("<input type='submit' class='myButton' value='RESERVEZ-LE' />");
                                elseif ($dispo == "non")                     echo ("<p class='myButton'>Indisponible</p>");

                                echo ("</br></br>Note moyenne de l'étudiant : ");
                                if ($note == 0)                 echo ("-/5");
                                else                            echo (round($note/$nombreNote,1) . "/5");
                                $note = 0;
                                $nombreNote = 0;
                                $reqnote = $bdd->prepare('SELECT note FROM commentaire WHERE destinataire=?');
                                $reqnote ->execute(array($donnees['Id']));

                                while ( $donneesnote = $reqnote -> fetch()) {
                                    $note = $note + $donneesnote['note'];
                                    $nombreNote = $nombreNote + 1;
                                }
                            ?>
                            </form>
                            </div>
                            <?php
                            echo "</div>";

                                $IdSaved= $donnees['Id'];
                                $dispo = "oui";
                                if ($donnees['status']!=0)              $dispo = "non";

                                $Id_profil_consulte = $donnees['Id'];
                                $image=$donnees['image'];
                                echo "<br/>";
                                echo "
                                <div id=\"profil_result\">
                                <img src=images/$image alt='image' height='225'width='225'/>";
                                echo 'Etudiant : ' . $donnees['nom'] . ' ' . $donnees['prenom'] . ' né(e) le ' . $donnees['naissance'] . '<br/>Niveau d\'études :'. $donnees['etudes'] . '<br/> Description : ' . $donnees['description'] . "<br/>Prix par heure : " . $donnees['tarif'] . "€<br/>". $donnees['code_postal'] . "  </p>
                                <div id=\"bookme\">";
                                ?>
                                <form method=POST action=ConsultationProfilUtilisateurTiers.php>
                                <input type="hidden" name="ID" value="<?php echo $Id_profil_consulte?>"></input> <!--Envoie de l'id dont le nom est Indent, pour voir récup les infos de l'Id pour afficher le bon profil-->
                                <input type="hidden" name="CPtrans" value="<?php echo $CP?>"></input>
                                <input type="hidden" name="NbEnftrans" value=<?php echo $NbEnf?>></input>
                                <input type="hidden" name="Jourtrans" value="<?php echo $jour?>"></input>
                                <input type="hidden" name="debutCreneau" value=<?php echo '\'' . $debutCreneau . '\''?>></input>
                                <input type="hidden" name="finCreneau" value=<?php echo '\'' . $finCreneau . '\''?>></input>
                                <input type="hidden" name="dispotrans" value="<?php echo $dispo?>"></input>
                                <input type="submit" class="myButton" value="Voir le profil" />
                                </form>


                                <!--</div>-->
                                <?php
                                //echo "</div>";

                                }
                            }
                            ?>
                            <form method=POST action=Calendrier\calendar_famille.php?month=<?php echo $mois ?>&year=<?php echo $annee ?>&day=<?php echo $lejour ?>>
                            <input type="hidden" name="Ident" value="<?php echo $Id_profil_consulte ?> "></input>
                            <?php if (($_SESSION['type']=='Etudiant') or ($_SESSION['type']=='Famille'))
                                if ($dispo == "oui")                         echo ("<input type='submit' class='myButton' value='RESERVEZ-LE' />");
                                elseif ($dispo == "non")                     echo ("<p class='myButton'>Indisponible</p>");
                                echo ("</br></br>Note moyenne de l'étudiant : ");
                                if ($note == 0)                 echo ("-/5");
                                else                            echo (round($note/$nombreNote,1) . "/5");
                            ?>
                            </form>
                            </div>
                            <?php
                            echo "</div>";
                            echo "</br>";

                        }
                        $req->closeCursor();


                if(isset($_POST['NbEnf']) AND isset($_POST['CP'])){

                    ?> <a  href=<?php  echo '?CP=' . $CP . '&NbEnf=' . $NbEnf . '&Jour=' . $jour . '&debutCreneau=' . $debutCreneau . '&finCreneau=' . $finCreneau?> class="myButton" >Elargir la recherche ?</a> <?php }
                }
                ?>
            <?php } else { ?>
            <section>
                <article>
                        <p>Accès non-autorisé !</p>
                </article>
            </section>

            <?php } ?>
            </div>
                </article>
            </section>
            <footer>
            </footer>
        </div>
    </body>
</html>
