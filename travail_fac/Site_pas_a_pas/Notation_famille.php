<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Evaluation de la famille</title>
  <link rel="stylesheet" type="text/css" href="style_notation.css"/>
</head>

<body>
	<style>
	/* The Modal (background) */
	.modal {
	    display: none; /* Hidden by default */
	    position: fixed; /* Stay in place */
	    z-index: 1; /* Sit on top */
	    padding-top: 100px; /* Location of the box */
	    left: 0;
	    top: 0;
	    width: 100%; /* Full width */
	    height: 100%; /* Full height */
	    overflow: auto; /* Enable scroll if needed */
	    background-color: rgb(0,0,0); /* Fallback color */
	    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content */
	.modal-content {
		text-align:center;
	    position: relative;
	    background-color: #fefefe;
	    margin: auto;
	    padding: 0;
	    border: 1px solid #888;
	    width: 30%;
	    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
	    -webkit-animation-name: animatetop;
	    -webkit-animation-duration: 0.4s;
	    animation-name: animatetop;
	    animation-duration: 0.4s
	}

	#myModal fieldset
	{
		display:inline-block;
	}

	textarea
	{
    display:inline-block;
    width:300px;
    max-width:100%;
	}

	/* Add Animation */
	@-webkit-keyframes animatetop {
	    from {top:-300px; opacity:0}
	    to {top:0; opacity:1}
	}

	@keyframes animatetop {
	    from {top:-300px; opacity:0}
	    to {top:0; opacity:1}
	}

	/* The Close Button */
	.close {
	    color: white;
	    float: right;
	    font-size: 28px;
	    font-weight: bold;
	}

	.close:hover,
	.close:focus {
	    color: #000;
	    text-decoration: none;
	    cursor: pointer;
	}

	.modal-header {
	    padding: 2px 16px;
	    background-color: #5cb85c;
	    color: white;
	}

	.modal-body {padding: 2px 16px;}

	.modal-footer {
	    padding: 2px 16px;
	    background-color: #5cb85c;
	    color: white;
	}
	</style>
	</head>
	<body>

	<h2>Notation de la famille</h2>

	<!-- Trigger/Open The Modal -->
	<button id="myBtn">Noter</button>

	<!-- The Modal -->
	<div id="myModal" class="modal">

	  <!-- Modal content -->
	  <div class="modal-content">
	    <div class="modal-header">
	      <span class="close">×</span>
	      <h2>Notation de la famille</h2>
	    </div>
	    <div class="modal-body">
		  <form>
		    <fieldset class="starability-checkmark"> <!-- Change starability-basic to different class to see animations. !-->
		      <legend>Note attribuée à la prestation</legend></br>


		      <input type="radio" id="rate5" name="rating" value="5" />
		      <label for="rate5" title="Amazing" aria-label="Amazing, 5 stars">5 stars</label>

		      <input type="radio" id="rate4" name="rating" value="4" />
		      <label for="rate4" title="Very good" aria-label="Very good, 4 stars">4 stars</label>

		      <input type="radio" id="rate3" name="rating" value="3" />
		      <label for="rate3" title="Average" aria-label="Average, 3 stars">3 stars</label>

		      <input type="radio" id="rate2" name="rating" value="2" />
		      <label for="rate2" title="Not good" aria-label="Not good, 2 stars">2 stars</label>

		      <input type="radio" id="rate1" name="rating" value="1" />
		      <label for="rate1" title="Terrible" aria-label="Terrible, 1 star">1 star</label>
		    </fieldset>
		  </form>
		<textarea name="Commentaires" rows="10" cols="50">
Avis sur la famille</textarea><br/><br/>


<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

var Note =  document.getElementsByName("rating")[0].value;
var txt =  document.getElementsByName("Commentaires")[0].value;

var d = new Date();
  d.setTime(d.getTime() + (1500));
  var expires = "expires="+ d.toUTCString();
  document.cookie = "Com" + "=" + txt + ";path=/";
  document.cookie = "Note" + "=" + Note + ";path=/";

</script>

<?php

$Com = $_COOKIE["Com"];
print_r($Com);
$Note = $_COOKIE["Note"];
print_r($Note);
$Etu = $_POST["etu"];
print_r($Etu);
$Famille = $_POST["fam"];
print_r($Famille);

echo("
<form action='commentaires_bdd.php' method='post'>
<input type='hidden' name='Commentaires' value='$Com'></input>
<input type='hidden' name='rating' value='$Note'></input>
<input type='hidden' name='commentaire_destinataire' value='$Etu'></input>
<input type='hidden' name='auteur' value='$Famille'></input>
<button type='submit' name='Eval' value = 'R' class='btn-link'>Evaluer la prestation</button>
     </form> "); ?>

	    </div>
	    <div class="modal-footer">
	      <h3></h3>
	    </div>
	  </div>

	</div>





	</body>
	</html>
