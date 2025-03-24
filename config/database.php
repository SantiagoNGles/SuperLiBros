<?php

function connexionPDO()
{
    $login = "root";
    $mdp = "";
    $bd = "superlibros";
    $serveur = "localhost";

    try {
        $conn = new PDO("mysql:host=$serveur;dbname=$bd", $login, $mdp, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]);
        return $conn;
    } catch (PDOException $e) {
        die("Erreur de connexion PDO : " . $e->getMessage());
    }
}
