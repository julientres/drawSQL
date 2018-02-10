<?php
	require_once('../fonctions.php');
	require_once('../asset/php/check-database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Algebraic Queries - connexion</title>
	<meta content="" name="description">
	<meta content="RTAI - ANGLES HIOT SOLE TRESCARTES" name="author">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="html, css, js, bootstrap, fabric.js, intreract.js, requêtes algébriques" name="keywords">

	<link rel="stylesheet" href="librairies/bootstrap-4.0.0-dist/css/bootstrap.min.css" type="text/css">
	<script defer src="librairies/fontawesome-free-5.0.6/on-server/js/fontawesome-all.min.js"></script>
	<script src="librairies/jquery-3.3.1.min.js"></script>
	<script src="librairies/fabric.js-master/dist/fabric.min.js" type="text/javascript"></script>
	<script src="librairies/bootstrap-4.0.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../asset/css/home-style.css" type="text/css">
</head>
<body>
	<div id="connexion_bloc">
		<?php
			if(isset($error)){
				echo "<div class='alert alert-danger alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fas fa-ban'></i><strong> Erreur !</strong> ".$error."
					</div>";
			}

			if(isset($info)){				
				echo "<div class='alert alert-info alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
							<i class='fas fa-info'></i><strong> Information :</strong> ".$info."
					</div>";			
			}

			if(isset($success)){
				echo "<div class='alert alert-success alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<i class='fas fa-check'></i><strong> Succès !</strong> ".$success."
					</div>";
			}
		?>

		<form method="POST" action="home.php" id="connexion_form">
			<div id="errorForm"></div>
			<h3>Application de requêtes algébriques Connexion</h3>
			<hr>
			<br>
			<div class="form-group row">
			    <label for="host" class="col-lg-4 col-form-label">Host*</label>
			    <div class="col-lg-6">
			      <input type="text" class="form-control" id="host" name="host" value="<?= getValueFromPost('host') ?>" placeholder="ex : localhost">
			      <div id="inputHostError" class="errorMsg"></div>
				</div>
			</div>
			<div class="form-group row">
			    <label for="port" class="col-lg-4 col-form-label">Port*</label>
			    <div class="col-lg-6">
			      <input type="text" class="form-control" id="port" name="port" value="<?= getValueFromPost('port') ?>" placeholder="ex : 3306" maxlength="4">
			      <div id="inputPortError" class="errorMsg"></div>
				</div>
			</div>
			<div class="form-group row">
			    <label for="bdd" class="col-lg-4 col-form-label">BDD*</label>
			    <div class="col-lg-6">
			      <input type="text" class="form-control" id="bdd" name="bdd" value="<?= getValueFromPost('bdd') ?>" placeholder="ex : nombdd">
			      <div id="inputBDDError" class="errorMsg"></div>
				</div>
			</div>
			<div class="form-group row">
			    <label for="user" class="col-lg-4 col-form-label">Identifiant*</label>
			    <div class="col-lg-6">
			      <input type="text" class="form-control" id="user" name="user" value="<?= getValueFromPost('user') ?>" placeholder="ex : user">
			      <div id="inputUserError" class="errorMsg"></div>
				</div>
			</div>
			<div class="form-group row">
			    <label for="passwd" class="col-lg-4 col-form-label">Mot de passe</label>
			    <div class="col-lg-6">
			      <input type="password" class="form-control" id="passwd" name="passwd" placeholder="ex : 12345abcde">
			    </div>
			</div>
			<hr>
			<br>
			<p><i>* Champs obligatoires</i></p>
			<div class="btn-group" role="group" aria-label="...">			
				<button type="submit" name="btnCo" id="btnCo" class="btn btn-primary">Se connecter <i class='fas fa-sign-in-alt'></i></button>
				<button type="reset" name="btnReset" id="btnReset" class="btn btn-warning">Réinitialiser <i class='fas fa-sync-alt'></i></button>
			</div>
		</form>
	</div>

	<script src="../asset/js/home-js.js" type="text/javascript"></script>
</body>
</html>