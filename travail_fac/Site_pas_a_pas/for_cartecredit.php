<form action="Payer_carte" method="post">
<p>
<label for="Name">Nom du propriétaire : </label>
<input type="text" name="Name" class="propr"/>
<br />
<label for="Num"> Numéro de la carte : </label>
<input type="number" name="41" class="numcarte" min = 0000 max = 9999 />
<input type="number" name="42" class="numcarte" min = 0000 max = 9999 />
<input type="number" name="43" class="numcarte" min = 0000 max = 9999 />
<input type="number" name="44" class="numcarte" min = 0000 max = 9999 />
<br />
<label for="date">Date d'expirtion</label>
<select name="mois">
      <option value="Janvier">Janvier</option>
      <option value="Février">Février</option>
      <option value="Mars">Mars</option>
      <option value="Avril">Avril</option>
      <option value="Mai">Mai</option>
      <option value="Juin">Juin</option>
      <option value="Juillet">Juillet</option>
      <option value="Août">Août</option>
      <option value="Septembre">Septembre</option>
      <option value="Octobre">Octobre</option>
      <option value="Novembre">Novembre</option>
      <option value="Décembre">Décembre</option>
</select>
<select name="annee">
      <option value="2016">2016</option>
      <option value="2017">2017</option>
      <option value="2018">2018</option>
      <option value="2019">2019</option>
      <option value="2020">2020</option>
      <option value="2021">2021</option>
      <option value="2022">2022</option>
      <option value="2023">2023</option>
      <option value="2024">2024</option>
      <option value="2025">2025</option>
      <option value="2026">2026</option>
</select>
<br />
<label for="pass">Votre code de sécurité :</label>
<input type="password" name="pass" />
<br />
<input type="submit" value="Payer!"/>
</p>
</form> 
