 <?php

//on récupère l'auteur du commentaire et son destinataire

$auteur=$_POST['auteur'];
$destinataire=$_POST['commentaire_destinataire'];

// On récupère les champs
if(isset($_POST['rating']))                        $note=$_POST['rating'];
else      $note="";

if(isset($_POST['Commentaires']))                     $message=$_POST['Commentaires'];
else      $message="";

// On vérifie si les champs sont vides
if(empty($note) OR empty($message))
    {
    $alerte = 'Veuillez mettre une note et un commentaire svp !';
    echo '<script type="text/javascript">window.alert("'.$alerte.'");</script>';
    }

// les champs sont bons, on peut enregistrer dans la table
else
    {
    include("connect.php"); // connexion à la base

    //La valeur de modération de base est à 0 pour 'non signalé'
    $moderation_commentaire = 0 ;

    // on écrit la requête sql
    $req = $bdd->prepare('INSERT INTO commentaire(emmeteur,destinataire,message,note,moderation) VALUES(:auteur, :destinataire, :message, :note, :moderation)');
    //on l'execute
    $req->execute(array(
        'auteur' => $auteur,
        'destinataire' => $destinataire,
        'message' => $message,
        'note' => $note,
        'moderation' => $moderation_commentaire
        ));
	
	$id_contrat = $_POST['id_contrat'];
	$Valeur_notation = $_POST['valeur_notation'];
	$req = $bdd->exec("UPDATE bookings SET Note=$Valeur_notation WHERE id = '$id_contrat' ");
		
    // on affiche le résultat pour le visiteur
    $alerte = 'Notation et commentaires faits !';
    echo '<script type="text/javascript">window.alert("'.$alerte.'");</script>';
    }

header("Refresh:0;ConsultationProfilUtilisateur.php");

?>
