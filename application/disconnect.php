<?php
	require_once('../fonctions.php');

	if(isset($_SESSION['host'], $_SESSION['port'], $_SESSION['bdd'], $_SESSION['user'], $_SESSION['passwd'])){
		session_unset();
		session_destroy();
		$info['disconnected'] = "Vous avez été déconnecté de nos services.";
	}
	else{
		$info['info'] = "Vous devez être connecté pour accéder à ce contenu.";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Algebraic Queries - disconnected</title>
	<meta content="" name="description">
	<meta content="RTAI - ANGLES HIOT SOLE TRESCARTES" name="author">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="html, css, js, bootstrap, fabric.js, intreract.js, requêtes algébriques" name="keywords">
	
	<link rel="stylesheet" href="librairies/bootstrap-4.0.0-dist/css/bootstrap.min.css" type="text/css">
	<script defer src="librairies/fontawesome-free-5.0.6/on-server/js/fontawesome-all.min.js"></script>
	<script src="librairies/jquery-3.3.1.min.js"></script>
	<script src="librairies/bootstrap-4.0.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../asset/css/disconnect-style.css" type="text/css">
</head>
<body>
	<div id="connexion_bloc">
		<?php
			if(isset($info['disconnected'])){
				echo "<div class='alert alert-info' role='alert'>
						<i class='fas fa-info'></i><strong> Information :</strong> ".$info['disconnected']."
					</div>";
			}
			if(isset($info['info'])){
				echo "<div class='alert alert-info' role='alert'>
						<i class='fas fa-info'></i><strong> Information :</strong> ".$info['info']."
					</div>";
			}
		?>
		<p>Pour utiliser les fonctionnalités de l'application, veuillez vous reconnecter avec ce <a href="home.php"> lien de redirection</a></p>
	</div>
</body>
</html>