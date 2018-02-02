<?php 
require_once 'fonctionsUtiles.php';
require_once 'header.php';

if(isset($_POST['nom'], $_POST['prenom'], $_POST['organisme'], $_POST['codePostal'], $_POST['adresse'], $_POST['ville'], $_POST['pays'], $_POST['email'], $_POST['statut'])) {
	$nom = htmlspecialchars($_POST['nom']);
	if(!empty($nom) && !ctype_space($nom)) {
		$prenom = htmlspecialchars($_POST['prenom']);
		if(!empty($prenom) && !ctype_space($prenom)) {
			$organisme = htmlspecialchars($_POST['organisme']);
			if(!empty($organisme) && !ctype_space($organisme)) {
				$codePostal = htmlspecialchars($_POST['codePostal']);
				if(is_numeric($codePostal)) {
					if (preg_match("/^(F-)?((2[A|B])|[0-9]{2})[0-9]{3}$/i",$codePostal)){
						$adresse = htmlspecialchars($_POST['adresse']);
						if(!empty($adresse) && !ctype_space($adresse)) {
							$ville = htmlspecialchars($_POST['ville']);
							if(!empty($ville) && !ctype_space($ville)) {
								$pays = htmlspecialchars($_POST['pays']);
								if(!empty($pays) && !ctype_space($pays)) {
									$email = htmlspecialchars($_POST['email']);
									if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
										$mailExist = verif_mail_exists($email);
										if(!$mailExist) {
											$statut = htmlspecialchars($_POST['statut']);
											$realStatut = get_statut_by_id($statut);
											if($realStatut) {
												if(isset($_POST['confirm']) && $_POST['confirm'] == 'true') {
													$query = $bdd->prepare('INSERT INTO participants VALUES(null, :statut, :nom, :prenom, :organisme, :codePostal, :adresse, :ville, :pays, :email, :dateInscription)');
													$resultInsert = $query->execute([
														'statut' => $realStatut->CODESTATUT,
														'nom' => $nom,
														'prenom' => $prenom,
														'organisme' => $organisme,
														'codePostal' => $codePostal,
														'adresse' => $adresse,
														'ville' => $ville,
														'pays' => $pays,
														'email' => $email,
														'dateInscription' => date('Y-m-d')
													]);
													if($resultInsert) {
														$success = 'Inscription réussie avec succès !';
													} else {
														$error = 'Impossible de vous enregistrer en base de données !';
													}
												} else {
													$formIsGood = true;
													$info = 'Vérifiez le formulaire et soumettez le à nouveau';
												}
											} else {
												$error = 'Ce statut n\'existe pas';
											}
										} else {
											$error = 'Cette adresse e-mail est déjà inscrite';
										}
									} else {
										$error = 'Vous devez saisir une adresse e-mail correcte';
									}
								} else {
									$error = 'vous devez saisir un pays';
								}
							} else {
								$error = 'Vous devez saisir une ville';
							}
						} else {
							$error = 'Vous devez saisir une adresse';
						}
					} else {
						$error = 'Le code postal saisi est invalide';
					}
				} else {
					$error = 'Vous devez saisir un code postal numérique';
				}
			} else {
				$error = 'Vous devez saisir un organisme';
			}
		} else {
			$error = 'Vous devez saisir un prénom';
		}
	} else {
		$error = 'Vous devez saisir un nom';
	}
}
?>
<main role="main" class="container">
	<div class="jumbotron">
		<h1>Participant</h1>
		<p>Remplissez le formulaire ci-dessous pour inscrire un nouveau participant</p>
		<p>
			<?php if(isset($error)) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>
			<?php if(isset($success)) echo '<div class="alert alert-success">'.$success.'</div>'; ?>
			<?php if(isset($info)) echo '<div class="alert alert-info">'.$info.'</div>'; ?>
		</p>
		<?php if(!isset($success)) { ?>
		<form id="" class="form" method="POST">
			<div class="form-group custom-style">
				<label for="nom">Nom</label>
				<input type="text" name="nom" id="nom" class="form-control" value="<?=getStringFromPost('nom')?>">
			</div>
			<div class="form-group custom-style">
				<label for="prenom">Prénom</label>
				<input type="text" name="prenom" id="prenom" class="form-control" value="<?=getStringFromPost('prenom')?>">
			</div>
			<div class="form-group custom-style">
				<label for="organisme">Organisme</label>
				<input type="text" name="organisme" id="organisme" class="form-control" value="<?=getStringFromPost('organisme')?>">
			</div>
			<div class="form-group custom-style">
				<label for="codePostal">Code postal</label>
				<input type="text" name="codePostal" id="codePostal" class="form-control" value="<?=getStringFromPost('codePostal')?>">
			</div>
			<div class="form-group custom-style">
				<label for="adresse">Adresse</label>
				<input type="text" name="adresse" id="adresse" class="form-control" value="<?=getStringFromPost('adresse')?>">
			</div>
			<div class="form-group custom-style">
				<label for="ville">Ville</label>
				<input type="text" name="ville" id="ville" class="form-control" value="<?=getStringFromPost('ville')?>">
			</div>
			<div class="form-group custom-style">
				<label for="pays">Pays</label>
				<input type="text" name="pays" id="pays" class="form-control" value="<?=getStringFromPost('pays')?>">
			</div>
			<div class="form-group custom-style">
				<label for="email">E-mail</label>
				<input type="mail" name="email" id="email" class="form-control" value="<?=getStringFromPost('email')?>">
			</div>
			<div class="form-group custom-style">
				<label for="statut">Votre statut</label>
				<?php 
					$statuts = getAllFromTable('statuts');
					echo '<div class="buttons-group"><div class="btn-group" data-toggle="buttons">';
					foreach($statuts as $statut) {
						$checked = null;
						$active = null;
						if(isset($_POST['statut']) && $statut->CODESTATUT == $_POST['statut']) {
							$active = 'active';
							$checked = 'checked="checked"';
						}
						echo '<label class="btn btn-primary btn-sm '.$active.'"><input autocomplete="off" type="radio" name="statut" '.$checked.' id="statut_'.$statut->CODESTATUT.'" value="'.$statut->CODESTATUT.'">'.$statut->NOMSTATUT.'</label>';
					}
					echo '</div></div>';
				?>
			</div>
			<?php if(isset($formIsGood) && $formIsGood) {?>
				<input type="hidden" name="confirm" value="true">
			<?php } ?>
			<button type="submit" class="btn btn-success">Enregistrer</button>
			<button type="reset" class="btn btn-default">Remettre à zéro</button>
		</form>
		<?php } ?>
	</div>
</main>
<?php require_once 'footer.php'; ?>