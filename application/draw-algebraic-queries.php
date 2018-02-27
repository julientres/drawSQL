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
	<script src="librairies/popper.min.js" type="text/javascript"></script>
	<script src="librairies/svg.min.js" type="text/javascript"></script>
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
						<i class='fas fa-check-circle'></i><strong> Connexion réussie avec la BDD [".$_SESSION['bdd']."] !</strong> Bienvenue dans l'assistant de requêtes albégrique.	
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
				<button id="selectObject" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="right" title="SELECT">
					<svg height="100" width="200">
						<path id="polySelect" d="M10 30L40 80L120 80L150 30z" fill="#FFFFFF" stroke="#000" stroke-width="2"></path>
					</svg> 
				</button>
			    <button id="fromObject" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="right" title="FROM">
			    	<svg height="100" width="200">
						<circle id="polyFrom" r="30" cx="50" cy="50" fill="#FFFFFF" stroke="#000" stroke-width="2"></circle>
					</svg>
			    </button>
				<button id="whereObject" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="right" title="WHERE">
					<svg height="100" width="200">
						<path id="polyWhere" d="M10 30L10 120L110 90L110 60z" fill="#FFFFFF" stroke="#000" stroke-width="2"></path>
					</svg>
				</button>
			    <button id="joinObject" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="right" title="JOIN">
			    	<svg height="100" width="200">
						<path id="polyJoin" d="M10 30L10 80L60 30L60 80z" fill="#FFFFFF" stroke="#000" stroke-width="2"></path>
					</svg>
			    </button>
			    <button id="subQueryObject" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="right" title="SOUS REQUÊTE">SUBQUERY</button>
			    <button id="groupByObject" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="right" title="GROUP BY">GROUP BY</button>
			    <button id="havingObject" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="right" title="HAVING">HAVNG</button>
			    <button id="orderByObject" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="right" title="ORDER BY">ORDER BY</button>
			    <button id="orderByObject" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="right" title="LINE">LINE</button>
			</ul>
		</div>
		<div id="options">
			<ul class="list-group list-group-horizontal">
				<button id="clone" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="left" title="Cloner un objet"><i class="fas fa-clone"></i></button>
			    <button id="delete" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="left" title="Supprimer un objet"><i class="fas fa-trash-alt"></i></button>
			    <button id="zoomIn" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="left" title="Zoom +"><i class="fas fa-search-plus"></i></button>
			    <button id="zoomOut" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="left" title="Zoom -"><i class="fas fa-search-minus"></i></button>
			    <button id="zoomReset" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="left" title="Revenir au zoom par défaut"><i class="fas fa-expand"></i></button>
			    <button id="clear" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="left" title="Effacer tous les objets présents dans la zone de dessin"><i class="fas fa-eraser"></i></button>
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