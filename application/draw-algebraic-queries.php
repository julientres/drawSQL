<?php
	require_once('../fonctions.php');	
	$returnBDD = doConnexion();
	var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Requêtes algébriques - Dessin</title>
	<meta content="" name="description">
	<meta content="RTAI - ANGLES HIOT SOLE TRESCARTES" name="author">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="html, css, js, bootstrap, fabric.js, intreract.js, requêtes algébriques" name="keywords">
	
	<link rel="stylesheet" href="librairies/bootstrap-3.3.7-dist/css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="librairies/bootstrap-3.3.7-dist/css/bootstrap-theme.min.css" type="text/css">
	<script src="librairies/jquery-3.3.1.min.js"></script>
	<script src="librairies/fabric.js-master/dist/fabric.min.js" type="text/javascript"></script>
	<script src="librairies/bootstrap-3.3.7-dist/js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
	<?php
		if($returnBDD['success']==true){
			echo "<div class='alert alert-success alert-dismissible' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span><strong> Connexion réussie avec la BDD [".$_SESSION['bdd']."] !</strong> Bienvenue dans l'assistant de requêtes albégrique.	
				</div>";
			
			echo "<a href='display-results.php' class='alert-link'>Partie résultats</a><br>";
			echo "<a href='disconnect.php' class='alert-link'>Se déconnecter</a>";
		}
		else
			echo "<div class='alert alert-danger alert-dismissible' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<span class='glyphicon glyphicon-ban-circle' aria-hidden='true'></span><strong> Erreur !</strong> Vous devez être connecté pour accéder à ce contenu. <a href='home.php' class='alert-link'>Se connecter</a>
				</div>";
	?>

	<div id="menu">
		
	</div>

	<div id="shapesSpace">

	</div>

	<div id="drawSpace">

	</div>

	<div id="footer">

	</div>
</body>
</html>