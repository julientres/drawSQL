<?php
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
					}
				}
			}
		}
	}
?>