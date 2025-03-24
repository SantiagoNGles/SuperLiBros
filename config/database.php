<?php

function connexionPDO()
{
    $login = "root";
    $mdp = "";
    $bd = "superlibros";
    $serveur = "localhost";

    try {
        $conn = new PDO("mysql:host=$serveur;dbname=$bd", $login, $mdp, [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        return $conn;
    } catch (PDOException $e) {
        die("Erreur de connexion PDO : " . $e->getMessage());
    }
}
