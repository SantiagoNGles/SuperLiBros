<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}

$featuredGames = [];

$title = "SuperLiBros - Accueil";
include_once ROOT_PATH . '/app/views/header.php';
include_once ROOT_PATH . '/app/views/home.php';
include_once ROOT_PATH . '/app/views/footer.php';