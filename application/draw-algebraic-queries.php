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
	<script src="librairies/fabric.js-master/dist/fabric.min.js" type="text/javascript"></script>
	<script src="librairies/bootstrap-4.0.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../asset/css/drawing-style.css" type="text/css">
</head>
<body>
	<div id="menu">
		<?php
			if($returnBDD['success'] == true) {
				require_once('modules/navbar-drawing.php');
				echo "<div class='alert alert-success alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fas fa-check'></i><strong> Connexion réussie avec la BDD [".$_SESSION['bdd']."] !</strong> Bienvenue dans l'assistant de requêtes albégrique.	
					</div>";			
			}
			else {
				require_once('modules/navbar-default.php');
				echo "<div class='alert alert-danger alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fas fa-ban'></i><strong> Erreur !</strong> Vous devez être connecté pour accéder à ce contenu. <a href='home.php' class='alert-link'>Se connecter</a>
					</div>";
			}
		?>		
	</div>	

	<?php if($returnBDD['success'] == true) : ?>

	<div id="drawing">
		<ul class="list-group">
			<button id="copy" onclick="Copy()" class="list-group-item list-group-item-action">Copy</button>
		    <button id="paste" onclick="Paste()" class="list-group-item list-group-item-action">Paste</button>
		    <button id="delete" onclick="Delete()" class="list-group-item list-group-item-action">Delete</button>
		    <button id="zoomIn" onclick="ZoomIn()" class="list-group-item list-group-item-action">Zoom in</button>
		    <button id="zoomOut" onclick="ZoomOut()" class="list-group-item list-group-item-action">Zoom out</button>
		    <button id="zoomReset" onclick="ResetZoom()" class="list-group-item list-group-item-action">Reset zoom</button>
			<button id="selectObject" onclick="createSelectObject()" class="list-group-item list-group-item-action">SELECT</button>
		    <button id="fromObject" onclick="createFromObject()" class="list-group-item list-group-item-action">FROM</button>
			<button id="whereObject" onclick="createWhereObject()" class="list-group-item list-group-item-action">WHERE</button>
		    <button id="joinObject" onclick="createJoinObject()" class="list-group-item list-group-item-action">JOIN</button>
		    <button id="chooseMode" onclick="chooseMode()" class="list-group-item list-group-item-action">Shapes / Drawing mod</button>
		    <button id="clear" onclick="clearCanvas()" class="list-group-item list-group-item-action">Clear</button>
		    <button id="grid" onclick="showHideGrid()" class="list-group-item list-group-item-action">Show / Hide grid</button>
		</ul>	

		<canvas id="canvas"></canvas>		
	</div>

	<div id="footer">
		<?php
			require_once('modules/footer.php');
		?>
	</div>	

	<?php endif; ?>

	<script src="../asset/js/drawing-js.js" type="text/javascript"></script>
</body>
</html>