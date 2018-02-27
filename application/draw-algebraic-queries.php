<?php
	require_once('../fonctions.php');	
	$returnBDD = doConnexion();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Algebraic Queries - drawing</title>
	<meta content="" name="description">
	<meta content="RTAI - ANGLES HIOT SOLE TRESCARTES" name="author">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="html, css, js, bootstrap, fabric.js, intreract.js, requêtes algébriques" name="keywords">
	
	<link rel="stylesheet" href="librairies/bootstrap-4.0.0-dist/css/bootstrap.min.css" type="text/css">
	<script defer src="librairies/fontawesome-free-5.0.6/on-server/js/fontawesome-all.min.js"></script>
	<script src="librairies/jquery-3.3.1.min.js"></script>
	<script src="librairies/bootstrap-4.0.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="librairies/interact.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../asset/css/drawing-style.css" type="text/css">
</head>
<body>
	<div id="menu">
		<?php
			if($returnBDD['success'] == true) {
				require_once('modules/navbar/navbar-drawing.php');
				echo "<div class='alert alert-success alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fas fa-check'></i><strong> Connexion réussie avec la BDD [".$_SESSION['bdd']."] !</strong> Bienvenue dans l'assistant de requêtes albégrique.	
					</div>";			
			}
			else {
				require_once('modules/navbar/navbar-default.php');
				echo "<div class='alert alert-danger alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fas fa-ban'></i><strong> Erreur !</strong> Vous devez être connecté pour accéder à ce contenu. <a href='home.php' class='alert-link'>Se connecter</a>
					</div>";
			}
		?>		
	</div>	

	<?php if($returnBDD['success'] == true) : ?>

	<div id="main">
		<div id="forms">
			<ul class="list-group">
				<button id="copy" class="list-group-item list-group-item-action">Copy</button>
			    <button id="paste" class="list-group-item list-group-item-action">Paste</button>
			    <button id="delete" class="list-group-item list-group-item-action">Delete</button>
			    <button id="zoomIn" class="list-group-item list-group-item-action">Zoom in</button>
			    <button id="zoomOut" class="list-group-item list-group-item-action">Zoom out</button>
			    <button id="zoomReset" class="list-group-item list-group-item-action">Reset zoom</button>
				<button id="selectObject" data-form="1" class="list-group-item list-group-item-action">SELECT</button>
			    <button id="fromObject" data-form="2" class="list-group-item list-group-item-action">FROM</button>
				<button id="whereObject" data-form="3" class="list-group-item list-group-item-action">WHERE</button>
			    <button id="joinObject" data-form="4" class="list-group-item list-group-item-action">JOIN</button>
			    <button id="joinObject" class="list-group-item list-group-item-action">SUBQUERY</button>
			    <button id="clear" class="list-group-item list-group-item-action">Clear</button>
			    <button id="grid" class="list-group-item list-group-item-action">Show / Hide grid</button>
			</ul>
		</div>
		<div id="drawing">	

		</div>
	</div>

	<div id="footer">
		<?php
			require_once('modules/footer/footer.php');
		?>
	</div>	

	<?php endif; ?>

	<script src="../asset/js/drawing-js.js" type="text/javascript"></script>
</body>
</html>