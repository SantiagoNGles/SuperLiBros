<?php
// If direct access, set root path
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}else {
  $action = "home"; // Action par défaut
}

// Fetch featured games for the homepage if needed
$featuredGames = []; // Replace with actual data from a model

// Display the home view
$title = "SuperLiBros - Accueil";
include_once ROOT_PATH . '/app/views/home.php';