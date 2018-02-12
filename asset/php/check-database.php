<?php
	require_once '../../fonctions.php';

	if(isset($_POST['host'], $_POST['port'], $_POST['bdd'], $_POST['user'], $_POST['passwd'])) {
		$host=htmlspecialchars($_POST['host']);
		if(!empty($host) && !ctype_space($host)) {
			$port=htmlspecialchars($_POST['port']);
			if(!empty($port) && !ctype_space($port)) {
				$bdd=htmlspecialchars($_POST['bdd']);
				if(!empty($bdd) && !ctype_space($bdd)) {
					$user=htmlspecialchars($_POST['user']);
					if(!empty($user) && !ctype_space($user)) {
						$passwd = $_POST['passwd'];
						setFormToSession($host, $port, $bdd, $user, $passwd);
						$returnBDD = doConnexion();
						echo json_encode($returnBDD);
					}					
				}
			}
		}
	}
?>