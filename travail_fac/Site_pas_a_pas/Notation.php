<DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style_inscription.css" />
        <link rel="stylesheet" href="style_general.css" />
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
            </header>
            <div id = "Menu_Principal">
                    <ul class="fancyNav" id="myTopnav">
                        <li id="home"><a href="Accueil.php" class="homeIcon">Accueil</a></li>
                        <li><a href="Accueil.php">Annonces</a></li>
                        <li><a href="Accueil.php#Whoarewe">Qui sommes-nous ?</a></li>
                        <li><a href="#">Rejoignez l'aventure</a></li>
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
                    <h1>Notation d'un contrat</h1>

            <div id="formDiv">
                <form method="post" action="commentaires_bdd.php"><br/>
                    <input type="radio" name="rating" value=1 /> 1 <br/><br/>
                    <input type="radio" name="rating" value=2 /> 2 <br/><br/>
                    <input type="radio" name="rating" value=3 /> 3 <br/><br/>
                    <input type="radio" name="rating" value=4 /> 4 <br/><br/>
                    <input type="radio" name="rating" value=5 /> 5 <br/><br/>

                    <textarea name="Commentaires" rows="10" cols="50" maxlength="750"></textarea><br/><br/>
                    <input type="hidden" name="commentaire_destinataire" <?php echo 'value=' . '\'' . $_POST['etu'] . '\'' ;?> >
                    <input type="hidden" name="auteur"  <?php echo 'value=' . '\'' . $_POST['fam'] . '\'' ;?> >
					<input type="hidden" name="id_contrat" <?php echo 'value=' . '\'' . $_POST['id_contrat'] . '\'' ;?> >
					<input type="hidden" name="valeur_notation" <?php echo 'value=' . '\'' . $_POST['valeur_notation'] . '\'' ;?> >
                    <input type="submit" name="submit" /> <br/><br/>
                </form>
            </div>
                </article>
            </section>


            <footer>
            </footer>
        </div>
    </body>
</html>
