<?php

    function display($var) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
	//	------------------------------------------------------------------
	//	DATABSE CONFIGURATION
	//	------------------------------------------------------------------
	$databaseName     = 'cpasfaux';
	$databaseUser     = 'root';
	$databasePassword = 'toni';
	$host             = 'localhost';

	//	Database connexion
	$database = new PDO("mysql:host=$host;dbname=$databaseName;charset=utf8", $databaseUser, $databasePassword);

	//	------------------------------------------------------------------
	//	REQUETE PREPARÉE	
	//	------------------------------------------------------------------
	$addPersonnageSQL = $database->prepare('INSERT INTO personnage (nom) VALUES (?);');
	$addLivreSQL      = $database->prepare('INSERT INTO livre (nom) VALUES (?);');
	$addCitationSQL   = $database->prepare('INSERT INTO citation (content, episode, idPersonnage, idLivre) VALUES (?, ?, ?, ?);');

    $getUserIDSQL = $database->prepare('select id from personnage where nom = ?;');
    $getLivreIDSQL = $database->prepare('select id from livre where nom = ?;');

	//	------------------------------------------------------------------
	//	RECUPERATION DU CONTENU JSON
	//	------------------------------------------------------------------
	$content = file_get_contents('data.json');
	$json    = json_decode($content);

    $i = 0;
	
	foreach ($json as $index => $element) {

		$addPersonnageSQL->execute(array( $index ));
        $getUserIDSQL->execute(array($index));
        $id = $getUserIDSQL->fetch();
        $lastUserId = $id[0];

		//	Ajout des livres
		foreach ($json->$index as $idx => $el) {

			$addLivreSQL->execute(array( $idx ));
            $getLivreIDSQL->execute(array( $idx ));
            $id2 = $getLivreIDSQL->fetch();
            echo 'id2';
            display($id2);
            $lastLivreId = $id2[0];

			foreach ($json->$index->$idx as $key => $value) {
				try {
                    display(array( $value[0], $value[1], $lastUserId, $lastLivreId ));
                    $addCitationSQL->execute(array( $value[0], $value[1], $lastUserId, $lastLivreId ));
                } catch(\Exception $e) {
                    display($e);
                }
			}
		}
	}
