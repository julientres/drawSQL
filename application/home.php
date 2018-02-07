<?php
	require_once('../fonctions.php');

	function setFormToSession($h,$p,$b,$u,$m){
		$_SESSION['host']=$h;
		$_SESSION['port']=$p;
		$_SESSION['bdd']=$b;
		$_SESSION['user']=$u;
		$_SESSION['passwd']=$m;		
	}

	function getValueFromPost($string){
		if(!isset($_POST['btnReinit'])){
			if($string === 'host' && isset($_POST['host']))
				$value = $_POST['host'];
			else if($string === 'port' && isset($_POST['port']))
				$value = $_POST['port'];
			else if($string === 'bdd' && isset($_POST['bdd']))
				$value = $_POST['bdd'];
			else if($string === 'user' && isset($_POST['user']))
				$value = $_POST['user'];
			else {
				$value = "";
			}
		}
		else{
			$value = "";
		}		

		return $value;
	}		

	if(isset($_POST['btnCo'])){
		if(isset($_POST['host'], $_POST['port'], $_POST['bdd'], $_POST['user'], $_POST['passwd'])){
			$host=htmlspecialchars($_POST['host']);
			if(!empty($host) && !ctype_space($host)){
				$port=htmlspecialchars($_POST['port']);
				if(!empty($port) && !ctype_space($port)){
					$bdd=htmlspecialchars($_POST['bdd']);
					if(!empty($bdd) && !ctype_space($bdd)){
						$user=htmlspecialchars($_POST['user']);
						if(!empty($user) && !ctype_space($user)){
							$passwd=$_POST['passwd'];
							setFormToSession($host, $port, $bdd, $user, $passwd);
							$returnBDD = doConnexion();
							if($returnBDD['success'] == true){								
								$success = 'Connexion à la base de données réussie avec succès ! Vous allez être redirigé dans 2 secondes.';
								header("Refresh: 2; URL=draw-algebraic-queries.php");
							}
							else{
								$error = 'Impossible de se connecter à la base de données. '.$returnBDD['object']->getMessage();
								$info = 'Vérifiez que les champs du formulaire soient corrects puis essayez à nouveau';
							}													
						}
						else{
							//$error['user'] = 'Veuillez saisir un identifiant';
						}					
					}
					else{
						//$error['bdd'] = 'Veuillez saisir une base de données';
					}
				}
				else{
					//$error['port'] = 'Veuillez saisir un port';
				}
			}
			else{
				//$error['host'] = 'Veuillez saisir un host';
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Requêtes algébriques - Connexion</title>
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
			width:35%;
			margin:auto;
			margin-top:10%;
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
		hr{
			margin:auto;
			margin-top:20px;
			width:60%;
			height:1px;
			background-color: #222;
			border: 0;
			text-align:center;
		}
		#inputHostError, #inputPortError, #inputBDDError, #inputUserError{
			margin-bottom:0;
			color: #F22613;
		}
	</style>
</head>
<body>
	<div id="connexion_bloc">
		<?php
			if(isset($error)){
				echo "<div class='alert alert-danger alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<span class='glyphicon glyphicon-ban-circle' aria-hidden='true'></span><strong> Erreur !</strong> ".$error."
					</div>";
			}

			if(isset($info)){				
				echo "<div class='alert alert-info alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
							<span class='glyphicon glyphicon-info-sign' aria-hidden='true'></span><strong> Information :</strong> ".$info."
					</div>";			
			}

			if(isset($success)){
				echo "<div class='alert alert-success alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						<span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span><strong> Succès !</strong> ".$success."
					</div>";
			}
		?>

		<form method="POST" action="home.php" id="connexion_form" onsubmit="return checkForm(this);">
			<div id="errorForm"></div>
			<h3>Application de requêtes algébriques - Connexion</h3>
			<hr>
			<br><br>
			<div class="form-group row">
			    <label for="host" class="col-lg-4 col-form-label">Host*</label>
			    <div class="col-lg-6">
			      <input type="text" class="form-control" id="host" name="host" value="<?= getValueFromPost('host') ?>" placeholder="ex : localhost" onblur="checkHost(this);">
			      <div id="inputHostError"></div>
				</div>
			</div>
			<div class="form-group row">
			    <label for="port" class="col-lg-4 col-form-label">Port*</label>
			    <div class="col-lg-6">
			      <input type="text" class="form-control" id="port" name="port" value="<?= getValueFromPost('port') ?>" placeholder="ex : 3306" maxlength="4" onblur="checkPort(this);">
			      <div id="inputPortError"></div>
				</div>
			</div>
			<div class="form-group row">
			    <label for="bdd" class="col-lg-4 col-form-label">BDD*</label>
			    <div class="col-lg-6">
			      <input type="text" class="form-control" id="bdd" name="bdd" value="<?= getValueFromPost('bdd') ?>" placeholder="ex : nombdd" onblur="checkBDD(this);">
			      <div id="inputBDDError"></div>
				</div>
			</div>
			<div class="form-group row">
			    <label for="user" class="col-lg-4 col-form-label">Identifiant*</label>
			    <div class="col-lg-6">
			      <input type="text" class="form-control" id="user" name="user" value="<?= getValueFromPost('user') ?>" placeholder="ex : user" onblur="checkUser(this);">
			      <div id="inputUserError"></div>
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
				<button type="submit" name="btnCo" id="btnCo" class="btn btn-primary active">Se connecter <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span></button>
				<button type="reset" name="btnReinit" class="btn btn-warning active">Réinitialiser <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
			</div>
		</form>
	</div>

	<script type="text/javascript">
		function loadError(champ, erreur) {
			if(erreur) {
				champ.style.borderColor = "#F22613";
				champ.style.borderWidth = "1px";
				var div = champ.name;
				switch(div) {
					case 'host':
						document.getElementById("inputHostError").innerHTML = "Le champ [Host] est obligatoire";
						break;
					case 'port':
						document.getElementById("inputPortError").innerHTML = "Le champ [Port] est obligatoire";
						break;
					case 'bdd':
						document.getElementById("inputBDDError").innerHTML = "Le champ [BDD] est obligatoire";
						break;
					case 'user':
						document.getElementById("inputUserError").innerHTML = "Le champ [Identifiant] est obligatoire";
						break;
				}
			}	
			else {
				champ.style.borderColor = "#26A65B";
				champ.style.borderWidth = "1px";
				var div = champ.name;
				switch(div) {
					case 'host':
						document.getElementById("inputHostError").innerHTML = "";
						break;
					case 'port':
						document.getElementById("inputPortError").innerHTML = "";
						break;
					case 'bdd':
						document.getElementById("inputBDDError").innerHTML = "";
						break;
					case 'user':
						document.getElementById("inputUserError").innerHTML = "";
						break;
				}
			}		
		}

		function checkForm(form) {
			var hostOK = checkHost(form.host);
			var portOK = checkPort(form.port);
		    var bddOK = checkBDD(form.bdd);
		    var userOK = checkUser(form.user);
		   
		    if(hostOK && portOK && bddOK && userOK)
		       return true;
		    else
		    {
		    	document.getElementById("errorForm").innerHTML = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><span class='glyphicon glyphicon-ban-sign' aria-hidden='true'></span><strong> Erreur !</strong> Veuillez remplir correctement tous les champs</div>";
		    	return false;
		    }
		}

		function checkHost(champ) {
		    if(champ.value.length == 0)
		    {
		        loadError(champ, true);
		    	return false;
		    }
		    else
		    {
		        loadError(champ, false);
		        return true;
		    }
		}

		function checkPort(champ) {
		    if(champ.value.length < 1 || champ.value.length > 4)
		    {
		        loadError(champ, true);
		        return false;
		    }
		    else
 		    {
		        loadError(champ, false);
		        return true;
		    }
		}	

		function checkBDD(champ) {
		    if(champ.value.length == 0)
		    {
		        loadError(champ, true);
		        return false;
		    }
		    else
		    {
		        loadError(champ, false);
		        return true;
		    }
		}

		function checkUser(champ) {
		    if(champ.value.length == 0)
		    {
		        loadError(champ, true);
		        return false;
		    }
		    else
		    {
		        loadError(champ, false);
		        return true;
		    }
		}	
	</script>
</body>
</html>