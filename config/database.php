<?php

function connexionPDO()
{
    $login = "root"; // Remplace par ton utilisateur MySQL si nécessaire
    $mdp = ""; // Remplace par ton mot de passe MySQL si nécessaire
    $bd = "superlibros"; // Nom de ta base de données
    $serveur = "localhost"; // Adresse du serveur MySQL (ex: localhost, 127.0.0.1, etc.)

    try {
        $conn = new PDO("mysql:host=$serveur;dbname=$bd", $login, $mdp, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        print "Erreur de connexion PDO : " . $e->getMessage();
        die();
    }
}

// Programme de test
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    header('Content-Type:text/plain');
    
    echo "Test connexionPDO() : \n";
    print_r(connexionPDO());
}
