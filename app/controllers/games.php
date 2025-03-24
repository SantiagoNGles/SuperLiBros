<?php
include_once ROOT_PATH . "app/models/Game.php";

$title = "Liste des Jeux";
$gameModel = new Game();

// Handle adding game to favorites if user is logged in
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["user_id"])) {
    if (isset($_POST["add_favorite"]) && isset($_POST["game_id"])) {
        $gameId = intval($_POST["game_id"]);
        $userId = $_SESSION["user_id"];
        
        if ($gameModel->addGameToFavorites($userId, $gameId)) {
            $_SESSION["message"] = "Jeu ajouté à vos favoris !";
        } else {
            $_SESSION["errors"][] = "Ce jeu est déjà dans vos favoris ou une erreur s'est produite.";
        }
        
        // Redirect to prevent form resubmission
        header("Location: " . BASE_URL . "?action=games");
        exit();
    }
}

// Fetch all games
$games = $gameModel->getAllGames();

include_once ROOT_PATH . "app/views/header.php";
include_once ROOT_PATH . "app/views/games.php";
include_once ROOT_PATH . "app/views/footer.php";