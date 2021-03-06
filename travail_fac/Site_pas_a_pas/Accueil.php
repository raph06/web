<?php
include('connect.php');
include('functions.php'); //inclure les fonctions relatives aux pages admins
if(logged_in())
    {
    header("location:AccueilConnecte.php"); // permet de rediriger l'utilisateur déja connecté
    exit(); // permet de ne pas exécuter la suite du php
    } // teste la manière dont un utilisateur accède à cette page
//print_r($_SESSION);
?>
<DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style_general.css" />
        <link rel="stylesheet" href="style_accueil.css" />
        <title>E-Sitting - Le babysitting à portée de clic</title>
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
                        <li id="home"><a href="#" class="homeIcon">Accueil</a></li>
                        <li><a href="#">Annonces</a></li>
                        <li><a href="#Whoarewe">Qui sommes-nous ?</a></li>
                        <li><a href="Inscription.html">Rejoignez l'aventure</a></li>
                        <li><a href="#Paiements">Tarifs & Paiements</a></li>
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
                <img src="Pictures/bannière2.png" alt="Presentation site" class="ico_famille" />
                <form class="searchform cf" method="post" action="ResultatVisiteur.php">
                    <input type="text" placeholder="Code Postal (Ex : 06000)" name="CP" minlength="5" maxlength="5">
                    <input type="number" placeholder="Nombre d'enfants" max="10" min="1" name="NbEnf">
                    <button type="submit">Search</button>
                </form>
            </div>
            <section>
                <article>
                    <img src="Pictures/donald.png" alt="Presentation site" class="ico_categorie" />
                    <h1 id = Whoarewe>Qui sommes-nous ?</h1>
                    <p>E-Sitting est avant tout une plateforme participative favorisant le rencontre entre d'une part des familles soucieuses d'aménger quelques créneaux horaires et d'autre part des étudiants dévoués et soucieux de bien faire leur travail. Des heures supplémentaires à effectuer au travail ? Un rendez-vous urgent ? Quel que soit la raison de votre absence au cocon familial E-Sitting est là pour vous apporter la solution.</p>
                    <p>De nombreux parents cherchent à aménager au mieux leurs emploi du temps et il est parfois difficile
                    de concilier vie de famille et travail. Qu'il s'agisse d'impératifs professionnels ou personnels, la surveillance de vos enfants est pour nous une priorité. C'est dans cette optique de permettre une vie plus harmonieuse que E-Sitting est né.</p>
                    <p>Nous vivons à une époque où le temps est une ressource dont nous manquons souvent. Rechercher un baby-sitter peut parfois s'avérer être une véritable corvée et on finit la plupart du temps à annuler ce qui était prévu à défaut d'avoir trouvé la perle rare qui saura satisfaire nos critères. </br>
                    Avec E-Sitting nous garantissons un système efficace et rapide de recherche des meilleurs profils d'étudiants à proximité de chez vous, à l'aide d'un système de notations vous serez à même de voir ce que les autres familles ont pensé de votre futur baby-sitter et pourrez choisir en toute liberté le profil idéal.</p>
                </article>
                <div id = "Presentation_image">
                    <div id = "Categorie_presentation_image">
                        <img src="Pictures/famille.PNG" alt="Presentation site" class="ico_famille" />
                        <p> E-sitting c'est avant tout des familles soucieuses de leurs enfants </p>
                    </div>
                    <div id = "Categorie_presentation_image">
                        <img src="Pictures/Etudiant.png" alt="Presentation site" class="ico_etudiant" />
                        <p> Mais aussi des étudiants triés avec soin </p>
                    </div>
                    <div id = "Categorie_presentation_image">
                        <img src="Pictures/Super.PNG" alt="Presentation site" class="ico_famille" />
                        <p> Pour un résultat SUPER ! </p>
                    </div>
                </div>
                <article>
                    <img src="Pictures/daisy.png" alt="Presentation site" class="ico_categorie" />
                    <h1 id = Esitter>Et vous, vous êtes prêts à E-sitter ?</h1>
                    <p></p>
                    <p>Vivamus sed libero nec mauris pulvinar facilisis ut non sem. Quisque mollis ullamcorper diam vel faucibus. Vestibulum sollicitudin facilisis feugiat. Nulla euismod sodales hendrerit. Donec quis orci arcu. Vivamus fermentum magna a erat ullamcorper dignissim pretium nunc aliquam. Aenean pulvinar condimentum enim a dignissim. Vivamus sit amet lectus at ante adipiscing adipiscing eget vitae felis. In at fringilla est. Cras id velit ut magna rutrum commodo. Etiam ut scelerisque purus. Duis risus elit, venenatis vel rutrum in, imperdiet in quam. Sed vestibulum, libero ut bibendum consectetur, eros ipsum ultrices nisl, in rutrum diam augue non tortor. Fusce nec massa et risus dapibus aliquam vitae nec diam.</p>
                    <p>Phasellus ligula massa, congue ac vulputate non, dignissim at augue. Sed auctor fringilla quam quis porttitor. Praesent vitae dignissim magna. Pellentesque quis sem purus, vel elementum mi. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas consectetur euismod urna. In hac habitasse platea dictumst. Quisque tincidunt porttitor vestibulum. Ut iaculis, lacus at molestie lacinia, ipsum mi adipiscing ligula, vel mollis sem risus eu lectus. Nunc elit quam, rutrum ut dignissim sit amet, egestas at sem.</p>
                </article>
                <article>
                    <img src="Pictures/picsou.png" alt="Presentation site" class="ico_categorie" />
                    <h1 id = Paiements>Tarifs & Paiements</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nec sagittis massa. Nulla facilisi. Cras id arcu lorem, et semper purus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis vel enim mi, in lobortis sem. Vestibulum luctus elit eu libero ultrices id fermentum sem sagittis. Nulla imperdiet mauris sed sapien dignissim id aliquam est aliquam. Maecenas non odio ipsum, a elementum nisi. Mauris non erat eu erat placerat convallis. Mauris in pretium urna. Cras laoreet molestie odio, consequat consequat velit commodo eu. Integer vitae lectus ac nunc posuere pellentesque non at eros. Suspendisse non lectus lorem.</p>
                    <p>Vivamus sed libero nec mauris pulvinar facilisis ut non sem. Quisque mollis ullamcorper diam vel faucibus. Vestibulum sollicitudin facilisis feugiat. Nulla euismod sodales hendrerit. Donec quis orci arcu. Vivamus fermentum magna a erat ullamcorper dignissim pretium nunc aliquam. Aenean pulvinar condimentum enim a dignissim. Vivamus sit amet lectus at ante adipiscing adipiscing eget vitae felis. In at fringilla est. Cras id velit ut magna rutrum commodo. Etiam ut scelerisque purus. Duis risus elit, venenatis vel rutrum in, imperdiet in quam. Sed vestibulum, libero ut bibendum consectetur, eros ipsum ultrices nisl, in rutrum diam augue non tortor. Fusce nec massa et risus dapibus aliquam vitae nec diam.</p>
                    <p>Phasellus ligula massa, congue ac vulputate non, dignissim at augue. Sed auctor fringilla quam quis porttitor. Praesent vitae dignissim magna. Pellentesque quis sem purus, vel elementum mi. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas consectetur euismod urna. In hac habitasse platea dictumst. Quisque tincidunt porttitor vestibulum. Ut iaculis, lacus at molestie lacinia, ipsum mi adipiscing ligula, vel mollis sem risus eu lectus. Nunc elit quam, rutrum ut dignissim sit amet, egestas at sem.</p>
                </article>
            </section>
            <footer>
                <div id="mail">
                    <img src="Pictures/mail.png" alt="logo mail E-sitting"/>
                    <h1 id = "Contact"> Contactez-nous ! </h1>
                    <p><a href="mailto:Adresse_mail_service_com">Nous contacter !</a></p>
                </div>
            </footer>
        </div>
    </body>
</html>
