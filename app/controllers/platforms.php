<?php
require_once ROOT_PATH . 'app/models/platform.php';

header('Content-Type: application/json');

if (!isset($_GET['game_id'])) {
    echo json_encode([]);
    exit;
}

$gameId = intval($_GET['game_id']);

// Utiliser la fonction getAvailablePlatformsForGame définie dans collection.php
$platforms = getAvailablePlatformsForGame($gameId);
echo json_encode($platforms);
exit;