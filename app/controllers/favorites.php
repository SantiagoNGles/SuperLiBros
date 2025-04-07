<?php
include_once ROOT_PATH . "app/models/Favorites.php";
include_once ROOT_PATH . "app/models/Game.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if not logged in
    header("Location: " . BASE_URL . "?action=login");
    exit();
}

$title = "Mes Jeux Favoris";
$favoritesModel = new Favorites();
$gameModel = new Game();

// Fetch user's favorite games
$favoriteGames = $favoritesModel->getFavoriteGamesByUser($_SESSION['user_id']);

include_once ROOT_PATH . "app/views/header.php";
include_once ROOT_PATH . "app/views/favorites.php";
include_once ROOT_PATH . "app/views/footer.php";