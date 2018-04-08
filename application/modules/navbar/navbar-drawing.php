<?php
	require_once('../fonctions.php');
	require_once('modules/modal/modal-generate.php');
	require_once('modules/modal/modal-help-drawing.php');
    $_SESSION['from'] = null;
    $_SESSION['select'] = null;
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="draw-algebraic-queries.php"><b>DrawSQL</b> - <?php echo $_SESSION['bdd']; ?></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">
	    	<!--<div class="dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Fichier</a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">Export algébrique</a>
                    <a class="dropdown-item" href="#">Import algébrique</a>
                  </div>
            </div>
            -->
	        <li class="nav-item">
	        	<!--<a class="nav-link" href="#generateCodeModal" id="btdGenerer" data-toggle="modal" data-target="#generateCodeModal">Générer</a>-->
                <a class="nav-link" href="#" id="btdGenerer">Générer</a>
	        </li>
	    </ul>

	    <ul class="navbar-nav ml-auto">
	    	<li class="nav-item">
	        	<a class='nav-link' href="helpDrawingModal" data-toggle="modal" data-target="#helpDrawingModal">Aide <i class='fas fa-question-circle'></i></a>	        			
		    </li>
	        <li class="nav-item">
	        	<a class='nav-link' href='disconnect.php'>Se déconnecter <i class='fas fa-sign-out-alt'></i></a>
		    </li>
	    </ul>
    </div>
</nav>