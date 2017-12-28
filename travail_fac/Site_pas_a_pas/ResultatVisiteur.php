<?php
include("connect.php");
include("functions.php"); ?>

<DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style_resultat.css" />
        <link rel="stylesheet" href="style_general.css" />
        <title>E-Sitting - Le babysitting sans bouger de chez vous</title>
    </head>
    <body>
        <div id = "bloc_page">
            <header>
                    <div id="logo">
                        <img src="Pictures/logo.png" alt="Logo E-sitting" />
                    </div>
                    <div id="connexion">
                        <a href="Connexion.html" class="myButton">Connexion</a>
                    </div>
                    <div id="inscription">
                        <a href="Inscription.html" class="myButton">Inscription</a>
                    </div>
            </header>
            <div id = "Menu_Principal">
                    <ul class="fancyNav" id="myTopnav">
                        <li id="home"><a href="Accueil.php" class="homeIcon">Accueil</a></li>
                        <li><a href="#">Annonces</a></li>
                        <li><a href="Accueil.php#Whoarewe">Qui sommes-nous ?</a></li>
                        <li><a href="Accueil.php#Esitter">Rejoignez l'aventure</a></li>
                        <li><a href="Accueil.php#Paiements">Tarifs & Paiements</a></li>
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
                                <a href="Connexion.html" class="myButton">Connexion</a>
                            </div>
                            <div id="inscription_2">
                                <a href="inscription.html" class="myButton">Inscription</a>
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
                elseif(isset($_GET['NbEnf']))                     $NbEnf=$_GET['NbEnf'];
                else      $NbEnf="";

                $type='Etudiant';
                // On vérifie si les champs sont vides

                if(empty($CP) OR empty($NbEnf))
                    {
                    echo ' <font color="red">Veuillez entrer un code postal et un nombre d\'enfants </font>';
                    }
                else if(is_numeric($CP)==false)
                    {
                         echo '<font color="red">Veuillez rentrer un code postal en chiffres seulement !</font>';
                    }
                    else {

                        if (isset($_GET['CP'])) {

                       $Approx_cp=substr($CP,0,2).'%';
                                               $req = $bdd->prepare('SELECT Id,nom,prenom,naissance,code_postal,etudes,description,image FROM users WHERE code_postal like :CP AND user_type=:user_type ORDER BY code_postal' );
                                               $req->execute(array(
                                                   'CP'=> $Approx_cp,
                                                   'user_type'=>$type
                                                   ));
                                           }
                        else {
                        $req = $bdd->prepare('SELECT Id,nom, prenom,naissance,code_postal,etudes,description,image FROM users WHERE code_postal=:CP AND user_type=:user_type');
                        $req->execute(array(
                            'CP'=> $CP,
                            'user_type'=>$type
                            ));
                        }


                        echo "<div id=\"result\">";
                        if (!$donnees = $req->fetch()) {
                            echo "Pas de résultats correspondants à vos critères";
                        }
                        else {
                            $myBtn=0;
                            $Id_profil_consulte = $donnees['Id'];
                            $image=$donnees['image'];
                            echo 'Résultats de la recherche<br/>';
                            echo "<br/>";
                            echo "
                            <div id=\"profil_result\">
                            <img src=images/$image alt='image' height='225'width='225'/>";

                            echo 'Etudiant : ' . $donnees['nom'] . ' ' . $donnees['prenom'] . ' né(e) le ' . $donnees['naissance'] . '<br/>Niveau d\'études :'. $donnees['etudes'] . '<br/> Description : ' . $donnees['description'] . "</br>". $donnees['code_postal'] ;

                            echo "<button id=\"myBtn" . $myBtn . "\">Plus d'informations sur ce profil</button>
                            <script>
                            // Get the modal
                            var modal = document.getElementById('myModal');

                            // Get the button that opens the modal
                            var btn = document.getElementById(\"myBtn" . $myBtn . "\");

                            // Get the <span> element that closes the modal
                            var span = document.getElementsByClassName(\"close\")[0];

                            // When the user clicks the button, open the modal
                            btn.onclick = function() {
                                modal.style.display = \"block\";
                            }

                            // When the user clicks on <span> (x), close the modal
                            span.onclick = function() {
                                modal.style.display = \"none\";
                            }

                            // When the user clicks anywhere outside of the modal, close it
                            window.onclick = function(event) {
                                if (event.target == modal) {
                                    modal.style.display = \"none\";
                                }
                            }
                            </script>
                        </div>";




                        while ($donnees = $req->fetch())
                        {
                            $myBtn=$myBtn+1;
                            $Id_profil_consulte = $donnees['Id'];
                            $image=$donnees['image'];
                            echo "<br/>";
                            echo "
                            <div id=\"profil_result\">
                            <img src=images/$image alt='image' height='225'width='225'/>";

                            echo 'Etudiant : ' . $donnees['nom'] . ' ' . $donnees['prenom'] . ' né(e) le ' . $donnees['naissance'] . '<br/>Niveau d\'études :'. $donnees['etudes'] . "<br/> Description : " . $donnees['description']  . "</br>". $donnees['code_postal'] ;

                            echo "<button id=\"myBtn" . $myBtn . "\">Plus d'informations sur ce profil</button>
                            <script>
                            // Get the modal
                            var modal = document.getElementById('myModal');

                            // Get the button that opens the modal
                            var btn = document.getElementById(\"myBtn" . $myBtn . "\");

                            // Get the <span> element that closes the modal
                            var span = document.getElementsByClassName(\"close\")[0];

                            // When the user clicks the button, open the modal
                            btn.onclick = function() {
                                modal.style.display = \"block\";
                            }

                            // When the user clicks on <span> (x), close the modal
                            span.onclick = function() {
                                modal.style.display = \"none\";
                            }

                            // When the user clicks anywhere outside of the modal, close it
                            window.onclick = function(event) {
                                if (event.target == modal) {
                                    modal.style.display = \"none\";
                                }
                            }
                            </script>
                        </div>";
                            }


                        }

                        $req->closeCursor();

                if(isset($_POST['NbEnf']) AND isset($_POST['CP'])){

                    ?> <a  href=<?php  echo '?CP=' . $CP . '&NbEnf=' . $NbEnf ?> class="myButton" >Elargir la recherche ?</a> <?php }
                }

                ?>



            </div>
                </article>
            </section>


            <footer>
            </footer>
        </div>
    </body>
</html>
