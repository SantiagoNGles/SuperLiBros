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

// Handle removing a game from favorites
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["remove_favorite"])) {
    $gameId = intval($_POST["game_id"]);
    $userId = $_SESSION["user_id"];

    if ($favoritesModel->removeGameFromFavorites($userId, $gameId)) {
        $_SESSION["message"] = "Jeu retiré de vos favoris !";
    } else {
        $_SESSION["errors"][] = "Une erreur s'est produite lors de la suppression du jeu.";
    }

    // Redirect to prevent form resubmission
    header("Location: " . BASE_URL . "?action=favorites");
    exit();
}

// Fetch user's favorite games
$favoriteGames = $favoritesModel->getFavoriteGamesByUser($_SESSION['user_id']);

include_once ROOT_PATH . "app/views/header.php";
include_once ROOT_PATH . "app/views/favorites.php";
include_once ROOT_PATH . "app/views/footer.php";