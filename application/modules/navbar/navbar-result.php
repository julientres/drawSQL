<?php
	require_once('../fonctions.php');
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="draw-algebraic-queries.php"><b>DrawSQL</b> - <em><?php echo $_SESSION['bdd']; ?></em></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">	    
	    <ul class="navbar-nav ml-auto">	    	
	        <li class="nav-item">
	        	<a class='nav-link' href='disconnect.php'>Se déconnecter <i class='fas fa-sign-out-alt'></i></a>
		    </li>
	    </ul>
    </div>
</nav>