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
	//$retour=doConnexion();	
	//$_SESSION['databaseConnected']=false;
	//var_dump($bdd);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Requêtes algébriques - Deconnexion</title>
	<meta content="" name="description">
	<meta content="RTAI - ANGLES HIOT SOLE TRESCARTES" name="author">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="html, css, js, bootstrap, fabric.js, intreract.js, requêtes algébriques" name="keywords">
	
	<link rel="stylesheet" href="librairies/bootstrap-3.3.7-dist/css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="librairies/bootstrap-3.3.7-dist/css/bootstrap-theme.min.css" type="text/css">
	<script src="librairies/jquery-3.3.1.min.js"></script>
	<script src="librairies/fabric.js-master/dist/fabric.min.js" type="text/javascript"></script>
	<script src="librairies/bootstrap-3.3.7-dist/js/bootstrap.min.js" type="text/javascript"></script>

	<style type="text/css">
		body{
			margin:auto;
			width:100%;
			background-color: #34495e;
		}
		#connexion_bloc{
			width:30%;
			margin:auto;
			margin-top:15%;
			border:2px solid #444;
			padding:50px;
			border-radius:10px;
			box-shadow: 10px 10px 0px 2px #222;
			background-color:#ecf0f1;
		}
		#connexion_form{
			text-align: center;
		}
		h3{
			margin:0;
		}
	</style>
</head>
<body>
	<div id="connexion_bloc">
		<?php
			// if(!isset($_SESSION['databaseConnected'])){
			// 	echo "<div class='alert alert-info alert-dismissible' role='alert'>
			// 			<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
			// 			<span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span><strong> Déconnexion réussie !</strong> Vous avez été déconnecté de nos services.
			// 		</div>";
			// }
			if(isset($info['disconnected'])){
				echo "<div class='alert alert-info alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span><strong> Information :</strong> ".$info['disconnected']."
					</div>";
			}
			if(isset($info['info'])){
				echo "<div class='alert alert-info alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span><strong> Information :</strong> ".$info['info']."
					</div>";
			}
		?>
		<p>Pour utiliser les fonctionnalités de l'application, veuillez vous reconnecter avec ce<a href="home.php"> lien de redirection</a></p>
	</div>
</body>
</html>