<?php
require_once('../fonctions.php');
require_once('forms/HelpDataEntry.php');
$returnBDD = doConnexion();

$help = new HelpDataEntry();
$table = $help->allTables($_SESSION['bdd']);
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
				<button id="selectObject" class="list-group-item list-group-item-action" data-form="1" data-toggle="tooltip" data-placement="right" title="SELECT">
					<svg width="100" height="50">
						<path id="polySelect" d="M10 10L30 40L70 40L90 10z" fill="#FFFFFF" stroke="#000" stroke-width="2"></path>
					</svg> 
				</button>
			    <button id="fromObject" class="list-group-item list-group-item-action" data-form="2" data-toggle="tooltip" data-placement="right" title="FROM">
			    	<svg height="50" width="100">
						<circle id="polyFrom" r="20" cx="50" cy="25" fill="#FFFFFF" stroke="#000" stroke-width="2"></circle>
					</svg>
			    </button>
				<button id="whereObject" class="list-group-item list-group-item-action" data-form="3" data-toggle="tooltip" data-placement="right" title="WHERE">
					<svg height="50" width="100">
						<path id="polyWhere" d="M10 5L10 45L90 32L90 18z" fill="#FFFFFF" stroke="#000" stroke-width="2"></path>
					</svg>
				</button>
			    <button id="joinObject" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="right" title="JOIN">
			    	<svg height="50" width="100">
						<path id="polyJoin" d="M20 10L20 40L80 10L80 40z" fill="#FFFFFF" stroke="#000" stroke-width="2"></path>
					</svg>
			    </button>
			    <button id="subQueryObject" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="right" title="SOUS REQUÊTE">
			    	<svg height="80" width="100">
			    		<path id="polySubQuery" d="M20 40L35 33L35 10L80 10L80 70L35 70L35 48z" fill="#FFFFFF" stroke="#000" stroke-width="2"></path>
			    	</svg>
			    </button>
			    <button id="groupByObject" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="right" title="GROUP BY">GROUP BY</button>
			    <button id="havingObject" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="right" title="HAVING">HAVNG</button>
			    <button id="orderByObject" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="right" title="ORDER BY">ORDER BY</button>
			    <button id="link" class="list-group-item list-group-item-action" data-toggle="tooltip" data-placement="right"  data-processing="false" title="LINE">
			    	<svg height="50" width="100">
			    		<polyline id="polyLine" points="10,40 90,10" fill="none" stroke="#000" stroke-width="2"></polyline>
			    	</svg>
			    </button>
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
			<div id="line-container">
			</div>
		</div>
	</div>
        <div id="test">

        </div>
        <!-- Modal Select -->
        <div class="modal fade" id="modalSelect" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Select</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="textModal">
                        <div id="divSelect">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="button" id="btdModalSelect" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal From -->
        <div class="modal fade" id="modalFrom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">From</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="textModal">
                        <select id="from">
                            <option value="null"></option>
                            <?php
                            foreach ($table as $t) {
                                echo '<option value="' . $t["TABLE_NAME"] . '">' . $t["TABLE_NAME"] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div id="console">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="button" id="btdModalFrom" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Where -->
        <div class="modal fade" id="modalWhere" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Where</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="textModal">
                        <select id="where1">

                        </select>
                        <br>
                        <br>
                        <select id="where2">
                            <option value=""></option>
                            <option value="=">=</option>
                            <option value="<>"><></option>
                            <option value="!=">!=</option>
                            <option value=">">></option>
                            <option value="<"><</option>
                            <option value=">=">>=</option>
                            <option value="<="><=</option>
                            <option value="IN">IN</option>
                            <option value="BETWEEN">BETWEEN</option>
                            <option value="LIKE">LIKE</option>
                            <option value="IS NULL">IS NULL</option>
                            <option value="IS NOT NULL">IS NOT NULL</option>
                        </select>
                        <br>
                        <br>
                        <input type="text" id="where3" value="">
                        <br>
                        <div id="divBetween">
                            <p>And</p>
                            <input type="text" id="where4" value="">
                        </div>

                    </div>
                    <div id="console">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="button" id="btdModalWhere" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </div>
            </div>
        </div>



	<div id="footer">
		<?php
			require_once('modules/footer/footer.php');
		?>
	</div>	

	<?php endif; ?>
    <script defer src="librairies/fontawesome-free-5.0.6/on-server/js/fontawesome-all.min.js"></script>
    <script src="librairies/jquery-3.3.1.min.js"></script>
    <script src="librairies/popper.min.js" type="text/javascript"></script>
    <script src="librairies/svg.min.js" type="text/javascript"></script>
    <script src="librairies/bootstrap-4.0.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="librairies/interact.min.js" type="text/javascript"></script>
	<script src="../asset/js/drawing-js.js" type="text/javascript"></script>
</body>
</html>