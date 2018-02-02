<?php
	session_start();
	$_SESSION['databaseConnected']=false;

	$bdd=null;
	function doConnexion(){
		global $bdd;

		if(isset($_SESSION['host'], $_SESSION['port'], $_SESSION['bdd'], $_SESSION['user'], $_SESSION['passwd'])){
			define('DB_HOST', $_SESSION['host']);
			define('DB_PORT', $_SESSION['port']);
			define('DB_DATABASE', $_SESSION['bdd']);
			define('DB_USERNAME', $_SESSION['user']);	
			define('DB_PASSWORD', $_SESSION['passwd']);

			try
			{
				$params = 'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_DATABASE.';charset=utf8';
				$PDO_BDD= new PDO($params, DB_USERNAME, DB_PASSWORD);
				$PDO_BDD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$PDO_BDD->exec("SET NAMES 'utf8'");
				$PDO_BDD->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
				$_SESSION['databaseConnected']=true;
				$bdd=$PDO_BDD;
				return array('success' => true,
							'object' => $bdd);
			}
			catch (PDOException $e)
			{
				//echo 'erreur : '.$e->getMessage()."<br />";
				//echo 'N° : '.$e->getCode();
				//exit();
				return array('success' => false,
							'object' => $e);
			}
		}
	}
?>