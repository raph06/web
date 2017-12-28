<?php include ("connect.php") ?>
<DOCTYPE html>
<html>
<p>

    Veuillez sélectionner un ID:

</p>

<?php
$reponse = $bdd->query('SELECT ID FROM users');
?>

<form action="ConsultationProfilUtilisateurTiers.php" method="post">

<select name="ID">
<?php
while ($donnees=$reponse->fetch())
{
?>
    <option value=<?php echo $donnees['ID']; ?> ><?php echo $donnees['ID']; ?></option>
<?php
}
$reponse->closeCursor();
?>

</select>
<input type="submit" value="Valider" />
</form>
</html>
