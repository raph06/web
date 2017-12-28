<?php

    try
    	{
        $bdd = new PDO('mysql:host=localhost;dbname=projetesi;charset=utf8', 'root', '');
        }
        catch (Exception $e)
        {
        die('Erreur : ' . $e->getMessage());
    	}

    session_start(); /* on ouvre la session ici, il faudra inclure connect.php dans chaque page de notre site qui en auront besoin */

?>
