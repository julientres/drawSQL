<?php

	try{
		$bdd = new PDO('mysql:host=localhost;dbname=projet_sql;charset=utf8', 'root', '');
	} catch (Exception $e){
		die('Erreur :'.$e->getMessage());
	}
	
	if(isset($_GET['select_table'])){
		$requete = $bdd->prepare('SELECT column_name FROM information_schema.columns WHERE table_name = :table AND table_schema=\'projet_sql\'');
		$requete->execute(array('table' => $_GET['select_table']));
	}else{
		$requete = $bdd->prepare('SELECT table_name FROM information_schema.tables WHERE table_schema = \'projet_sql\'');
		$requete->execute();
	}

	$reponse = $requete->fetchAll();
	$requete->closeCursor();
	echo json_encode($reponse, true);

?>