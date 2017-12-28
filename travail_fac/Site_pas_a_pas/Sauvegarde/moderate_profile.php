<?php
include("connect.php"); /* connexion à la base de données sql */
include("functions_admin.php");

// on prépare les variables
// Action: ignorer
if(isset($_POST['Ignorer']))
 $id_ignore=$_POST['Ignorer'];
else      $id_ignore="";

// Action: supprimer
if(isset($_POST['Supprimer']))
    $id_suppress=$_POST['Supprimer'];
else      $id_suppress="";

// Action: Modérer

if(isset($_POST['Modérer']))
    $id_moderate=$_POST['Modérer'];
else      $id_moderate="";

//ID avant modif
if(isset($_POST['user_type']))
$user_type=$_POST['user_type'];
else      $user_type="";

//ID si modif
if(isset($_POST['user']))
$user=$_POST['user'];
else      $user="";

if(isset($_POST['user_id']))
$user_id=$_POST['user_id'];
else      $user_id="";


// on consulte le choix de l'admin
// Action: supprimer
if(empty($id_ignore) && empty($id_moderate) && isset($_POST['user_type']))
    {
      //suppression du compte
    $suppressing_query = $bdd->query("DELETE FROM users WHERE ID='$id_suppress'");
    // suppression des commentaires associés
    $suppressing_query = $bdd->query("DELETE FROM commentaire WHERE emmeteur='$id_suppress' or destinataire='$id_suppress'");

        switch($user_type)
        {
          case 'etudiant':
          header("Location: dash_admin_profils_etu.php");
          break;
          case 'famille':
          header("Location: dash_admin_profils_fam.php");
          break;
        }
      }
  // Action: ignorer
    elseif (empty($id_suppress) && empty($id_moderate) && isset($_POST['user_type']))
    {
   	$modif_query = $bdd->exec("UPDATE users SET moderation=0 WHERE ID='$id_ignore'");

        switch($user_type)
        {
          case 'etudiant':
          header("Location: dash_admin_profils_etu.php");
          break;
          case 'famille':
          header("Location: dash_admin_profils_fam.php");
          break;
        }

    }
    // Action: Modérer
    // on renvoie des $_get qui affichent un formulaire
    elseif (empty($id_suppress) && empty($id_ignore) && isset($_POST['user_type']) )
    {
      switch($user_type)
      {
        case 'etudiant':
        header("Location: dash_admin_profils_etu.php?open=1&id=".$user_id);
        break;
        case 'famille':
        header("Location: dash_admin_profils_fam.php?open=1&id=".$user_id);
        break;
        case 'Etudiant':
        continue;
        break;
      }


    }
    // on importe les donnée $post dans des variables
    elseif (isset($_POST['Modifié']) and $_POST['Modifié']=='Valider' and isset($user))
    {
          switch ($user) {
            case 'Etudiant':
            $user_id=$_POST['ID_etu'];
            if(isset($_POST['image']))
                $Image=$_POST['image'];
            else      $Image=NULL;
            if(isset($_POST['Prenom']))
                $Prenom=$_POST['Prenom'];
            else      $Prenom=NULL;
            if(isset($_POST['nom']))
                $Nom=$_POST['nom'];
            else      $Nom=NULL;
            if(isset($_POST['JourNaissance']))                      $jourNaissance=$_POST['JourNaissance'];
            else      $jourNaissance=$ancien_jourNaissance;

            if(isset($_POST['MoisNaissance']))                      $moisNaissance=$_POST['MoisNaissance'];
            else      $moisNaissance=$ancien_moisNaissance;

            if(isset($_POST['AnneeNaissance']))                     $anneeNaissance=$_POST['AnneeNaissance'];
            else      $anneeNaissance=$ancien_anneeNaissance;

            // gestion d'erreur pour le champs code postal
           if ((is_numeric($_POST['CP'])==false) or (empty($_POST['CP'])))
                {
                     echo '<font color="red">Veuillez rentrer un code postal en chiffres!</font>';
                     exit;
                }
          else  $CP=$_POST['CP'];

            if(isset($_POST['adresse']))
                $adresse=$_POST['adresse'];
            else      $adresse=NULL;
            if(isset($_POST['tel']))
                $Tel=$_POST['tel'];
            else      $Tel=NULL;
            if(isset($_POST['Tarif']))
                $Tarif=$_POST['Tarif'];
            else      $Tarif=NULL;
            if(isset($_POST['Permis']))
                $Permis=$_POST['Permis'];
            else      $Permis=NULL;
            if(isset($_POST['CNI']))
                $CNI=$_POST['CNI'];
            else      $CNI=NULL;
            if(isset($_POST['minibio']))
                $Minibio=$_POST['minibio'];
            else      $Minibio=NULL;
            if(isset($_POST['etudes']))
                $Etudes=$_POST['etudes'];
            else $Etudes=NULL;
            $dateNaissance = $anneeNaissance . '-' . $moisNaissance . '-' . $jourNaissance ;
//requete base de donnée des changements
$modif_query = $bdd->exec("UPDATE users SET nom='$Nom',
            prenom='$Prenom', naissance='$dateNaissance', code_postal='$CP',
            adresse='$adresse', telephone='$Tel', tarif='$Tarif', cni='$CNI', etudes='$Etudes',
            permis='$Permis', description='$Minibio', image='$Image',moderation=0 WHERE ID='$user_id'");
//redirection page modération
          //echo('test');
          //print_r($_POST);
           header("Location: dash_admin_profils_etu.php");

              break;

            case 'Famille':
            $user_id=$_POST['ID_fam'];
            if(isset($_POST['image']))
                $Image=$_POST['image'];
            else      $Image=NULL;
            if(isset($_POST['nom']))
                $Nom=$_POST['nom'];
            else      $Nom=NULL;
            if(isset($_POST['enfants']))
                $Enfants=$_POST['enfants'];
            else      $Enfants=NULL;
            if(isset($_POST['date']))
                $Date_enfants=$_POST['date'];
            else      $Date_enfants=NULL;
            // gestion d'erreur pour le champs code postal
           if ((is_numeric($_POST['CP'])==false) or (empty($_POST['CP'])))
                {
                     echo '<font color="red">Veuillez rentrer un code postal en chiffres!</font>';
                     exit;
                }
          else  $CP=$_POST['CP'];
            if(isset($_POST['adresse']))
                $adresse=$_POST['adresse'];
            else      $adresse=NULL;
            if(isset($_POST['tel']))
                $Tel=$_POST['tel'];
            else      $Tel=NULL;
            if(isset($_POST['minibio']))
                $Minibio=$_POST['minibio'];
            else      $Minibio=NULL;
//requete base de donnée
$modif_query = $bdd->exec("UPDATE users SET nom='$Nom',
            enfants='$Enfants',date_enfants='$Date_enfants', code_postal='$CP',
            adresse='$adresse', telephone='$Tel', description='$Minibio',
            image='$Image',moderation=0 WHERE ID='$user_id'");
//redirection page modération

          header("Location: dash_admin_profils_fam.php");

              break;
          }

     }
     // si annulation de la modification
    else
    {
      header("Location: dash_admin_profils_etu.php");
    }

?>
