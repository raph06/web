<?php

function get_taux($bdd)
// cette fonction permet d'accéder aux taux en vigueur répertoriés dans la table taux_site
// elle prend en entrée les informations sur la base de donnée et renvoie une liste contenant
// les différents taux du site
    {
      $N = $bdd->query("SELECT valeur FROM taux_site WHERE periode='Nuit'");
      while ($donnees = $N->fetch())
    {
      $Nuit= $donnees['valeur'] ;
    }
    $N->closeCursor();

      $F = $bdd->query("SELECT valeur FROM taux_site WHERE periode='Fériés'");
      while ($donnees = $F->fetch())
    {
      $Fériés= $donnees['valeur'] ;
    }
    $F->closeCursor();

      $WE = $bdd->query("SELECT valeur FROM taux_site WHERE periode='Week-end'");
      while ($donnees = $WE->fetch())
    {
      $Week_end= $donnees['valeur'] ;
    }
    $WE->closeCursor();

       $C = $bdd->query("SELECT valeur FROM taux_site WHERE periode='Commissions'");
      while ($donnees = $C->fetch())
    {
      $Commissions= $donnees['valeur'] ;
    }
    $C->closeCursor();

    return array($Nuit, $Fériés, $Week_end, $Commissions);
 }

function get_comments($bdd)
// cette fonction permet d'accéder à la base de donnée et de récupérer
// les données de l'utilisateur ayant laissé un commentaire signalé ainsi que
// le commentaire en question.

{

      $comments = $bdd->query("SELECT users.user_type, users.nom, users.prenom, users.naissance, users.tarif,users.image,commentaire.ID ,commentaire.message, commentaire.note FROM `commentaire`, `users`WHERE users.ID=commentaire.emmeteur and commentaire.moderation='1'");
      while ($donnees = $comments->fetch())
    {
      $id_comment=$donnees['ID'] ;
      $user_type=$donnees['user_type'];
      $to_moderate= $donnees['message'] ;
      $note=$donnees['note'];
      $prenom= $donnees['prenom'] ;
      $nom= $donnees['nom'] ;
      $naissance=$donnees['naissance'];
      $tarif=$donnees['tarif'];
      $image=$donnees['image'];
      echo('<p>'.'ID commentaire: '.$id_comment.'</p>');
      echo('<p>'.'Utilisateur: '.$user_type.'</p>');
      echo("<p><img src=images/$image alt='image' height='225'width='225'/></p>");
      echo( '<p>'. $nom . ' '. $prenom . ' ' . $naissance . '</p>');
      if ($user_type=='Etudiant')
     {
       echo( '<p>'. 'Prix de la demande : ' .$tarif.'€</p>') ;

         }
      echo( '<p>Note attribuée : '.$note .'</p>');

      echo('<p>Commentaire laissé: '. $to_moderate . '</p>');
      echo("<form action='moderate_comment.php' method='post'>
        <button type='submit' name='Ignorer' value='$id_comment' class='btn-link'>Ignorer</button>
       <button type='submit' name='Supprimer' value='$id_comment' class='btn-link'>Supprimer</button>
      </form>".'</br>');
          }
          $comments->closeCursor();
        
}
 function get_admin($bdd)
 // cette fonction permet d'accéder aux taux administrateurs 'admin' de la table users
 // elle prend en entrée les informations sur la base de donnée et renvoie des echos contenant
 // les différents admins du site
 {

    $admin_in_base = $bdd->query('SELECT email FROM users WHERE user_type="Admin" ORDER BY ID');


    while ($donnees = $admin_in_base->fetch())
    {
      echo htmlspecialchars($donnees['email']).'<br>' ;

    }

    $admin_in_base->closeCursor();
}

function get_number_of_flagged_coments($bdd)
// cette fonction permet d'accéder au nombre de commentaires répertoriés et signalés dans la table commmentaires
// elle prend en entrée les informations sur la base de donnée et renvoie des echos contenant
// le nombre de commentaires à modérer
 {
      $C = $bdd->query("SELECT count(*) AS flagged FROM commentaire WHERE moderation='1'");
      while ($donnees = $C->fetch())
    {
      $Count= $donnees['flagged'] ;
      //print_r($donnees);
    }
    $C->closeCursor();

    echo($Count);
  }

  function get_number_of_flagged_profils($bdd)
  // cette fonction permet d'accéder au nombre de profils répertoriés et initialisés/modifiés dans la table commmentaires
  // elle prend en entrée les informations sur la base de donnée et renvoie des echos contenant
  // le nombre de profils à modérer
   {
        $C = $bdd->query("SELECT count(*) as 'flagged' FROM users WHERE moderation='1' and user_type not in ('Admin','Super')");
        while ($donnees = $C->fetch())
      {
        $Count= $donnees['flagged'] ;
        //print_r($donnees);
      }
      $C->closeCursor();

      return $Count;
    }

function mail_it($bdd,$Week_end,$Nuit,$Commissions,$Fériés)
// cette fonction permet d'envoyer un mail aux utilisateurs de la base pour les informer des changements de taux.
// elle prend en entrée les informations sur la base de donnée ainsi que les variables associées aux taux.
{//message
$message = "'Chers utilisateurs,\n

Voici les nouveaux taux:\n
Taux WE: <?php echo $Week_end ?>\n

Taux Nuit:Taux WE: <?php echo $Nuit  ?>\n

Taux Commissions: <?php echo $Commissions  ?>\n

Taux Fériés:<?php echo $Fériés  ?>\n

A plus les cocos,\n

Les admins. '";

// Plusieurs destinataires
$users='';
$to  = $users;

// Sujet
$subject = 'Taux Esitting';

// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Envoi
mail($to, $subject, $message, $headers);

}

function which_admin() {
  // cette fonction renvoie un booléen en fonction du type d'admin qui accède à la page
    if( $_SESSION['type']=='Admin')
    {
        return 0;
    }
    elseif ($_SESSION['type']=='Super')
    {
      return 1;
    }
}

function try_session()
// cette fonction permet de renvoyer un visiteur non connecté vers la page d'acceuil
// si il essaye d'acceder aux pages admins
{
if (!isset($_SESSION['login']) AND !isset($_SESSION['type']))
{
//Le visiteur n'est pas connecté
echo '<body onLoad="alert(\'Accès interdit\')">';
// puis on le redirige vers la page d'accueil
echo '<meta http-equiv="refresh" content="0;URL=Accueil.html">';
exit;
}


elseif (($_SESSION['type']=='Etudiant') or ($_SESSION['type']=='Famille'))
// cette fonction permet de renvoyer un visiteur non admin vers la page d'acceuil
// si il essaye d'acceder aux pages admins
{

  // Le visiteur n'est pas un admin
echo '<body onLoad="alert(\'Accès interdit\')">';
// puis on le redirige vers la page d'accueil
echo '<meta http-equiv="refresh" content="0;URL=AccueilConnecte.php">';
exit;

}}

?>
