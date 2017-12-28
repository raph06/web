<?php //include ("connect.php");
$_SESSION['type']= "Famille";
$_SESSION['prenom'] = "Mark" ;
$_SESSION['nom'] = "Hamill";
//$prof = $bdd->prepare('SELECT * FROM users WHERE ID = ?');
//$prof->execute(array($_SESSION['ID']));      //permet de récupérer toutes les informations du profil grâce à ID transmis par $SESSION


//$com = $bdd->prepare('SELECT * FROM commentaire WHERE destinataire = ? ORDER BY ID DESC ');
//$com->execute(array($_SESSION['ID']));      //permet de récupérer toutes les informations des commentaires grâce à ID transmis par $SESSION 

//while($donnees =$prof -> fetch())   //les données du profil sont représentées par $donnees
//{
?>
	<DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" />
            <link rel="stylesheet" href="style_contrat.css" />
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
                        <h1>Contrat</h1>
                        <div class="contrat">
                            <article class = "utilisateur">
                                <h3> Client : </h3>
                                    <p><img src="images/user.png"  alt="user_pic"/></p>
                                    <p>Nom : Hamill </p>
                            </article>
                            <article id = "Contrat">
                                <h3> Termes : </h3>
                                    <p>Date : 21-01-2017 <br />
                                    Nombre d'enfants : 2 <br />
                                    Durée : 3h <br />
                                    Majoration : Nuits - Férié </p>
                                    <p>_____________________________<br />
                                    _____________________________</p>
                                    <p>Total : 40€ </p>
                                    <form action="Payer_carte" method="post">
                                    <input type="submit" value="payer par carte"/>
                                    </form>
                                    <form action="Payer_Paypal" method="post">
                                    <input type="submit" value="Paypal"/>
                                    </form>
                                    <form action="Annuler" method="post">
                                    <input type="submit" value="Annuler"/>
                                    </form>
                            </article>
                            <article class = "utilisateur">
                                <h3> Prestataire : </h3>
                                    <p><img src="images/user.png"  alt="user_pic"/></p>
                                    <p>Nom : Kaire <br />
                                    Prénom : Joe <br />
                                    Date de naissance : 13-01-1995</p>
                            </article>
                        </div>
                    </article>
                </section>
                <footer>
                </footer>
        </div>
    </body>
    </html>