<?php

	//	------------------------------------------------------------------
	//	DATABSE CONFIGURATION
	//	------------------------------------------------------------------
	$databaseName     = 'kaamelott';
	$databaseUser     = 'root';
	$databasePassword = 'toni';
	$host             = 'localhost';

	//	Database connexion
	$database = new PDO("mysql:host=$host;dbname=$databaseName", $databaseUser, $databasePassword);

	//	------------------------------------------------------------------
	//	REQUETE PREPARÉE	
	//	------------------------------------------------------------------
	$addPersonnageSQL = $database->prepare('INSERT INTO personnage (nom) VALUES (?);');
	$addLivreSQL      = $database->prepare('INSERT INTO livre (nom) VALUES (?);');
	$addCitationSQL   = $database->prepare('INSERT INTO citation (content, episode, idPersonnage, idLivre) VALUES (?, ?, ?, ?);');

	//	------------------------------------------------------------------
	//	RECUPERATION DU CONTENU JSON
	//	------------------------------------------------------------------
	$content = file_get_contents('data.json');
	$json    = json_decode($content);

	
	foreach ($json as $index => $element) {

		//	Ajout des persos
		$addPersonnageSQL->execute(array( $index ));

		$lastUserId = $database->lastInsertId();

		//	Ajout des livres
		foreach ($json->$index as $idx => $el) {

			$addLivreSQL->execute(array( $idx ));

			$lastLivreId = $database->lastInsertId();

			foreach ($json->$index->$idx as $key => $value) {
				//	Citation, enfin
				$addCitationSQL->execute(array( $value[0], $value[1], $lastUserId, $lastLivreId ));
			}
		}
	}