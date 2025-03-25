<?php
function getAvailablePlatformsForGame($gameId)
{
    $conn = connexionPDO();
    $stmt = $conn->prepare("
        SELECT p.id, p.name 
        FROM game_platforms gp
        JOIN platforms p ON gp.platform_id = p.id
        WHERE gp.game_id = :game_id
    ");
    $stmt->bindParam(':game_id', $gameId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
