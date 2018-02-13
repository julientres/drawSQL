<?php
	require_once('../fonctions.php');
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="draw-algebraic-queries.php"><?php echo $_SESSION['bdd']; ?></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">
	    	<li class="nav-item">
	        	<a class="nav-link" href="#">Exporter SQL</a>
	      	</li>	        
	        <li class="nav-item">
	        	<a class="nav-link" href="#">Exporter résultats</a>
	        </li>
	        <li class="nav-item">
	        	<a class="nav-link" href="draw-algebraic-queries.php">Dessin</a>
	        </li>
	    </ul>

	    <ul class="navbar-nav ml-auto">
	    	<li class="nav-item">
	        	<a class='nav-link' href='#'>Aide</a>	        			
		    </li>
	        <li class="nav-item">
	        	<a class='nav-link' href='disconnect.php'>Se déconnecter</a>
		    </li>
	    </ul>
    </div>
</nav>