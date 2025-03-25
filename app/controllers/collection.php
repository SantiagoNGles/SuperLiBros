<?php
function addToCollection($userId, $gameId, $platformId, $userRating)
{
    $conn = connexionPDO();

    try {
        $stmt = $conn->prepare("
            INSERT INTO collections (user_id, game_id, platform_id, user_rating) 
            VALUES (:user_id, :game_id, :platform_id, :user_rating)
        ");

        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':game_id', $gameId, PDO::PARAM_INT);
        $stmt->bindParam(':platform_id', $platformId, PDO::PARAM_INT);
        $stmt->bindParam(':user_rating', $userRating, PDO::PARAM_INT);

        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        // Gérer les erreurs spécifiques (par exemple, doublon)
        if ($e->getCode() == '23000') {
            $_SESSION['errors'][] = "Ce jeu existe déjà dans votre collection.";
        } else {
            $_SESSION['errors'][] = "Erreur lors de l'ajout du jeu : " . $e->getMessage();
        }
        return false;
    }
}

function getUserCollection($userId)
{
    $conn = connexionPDO();

    $stmt = $conn->prepare("
        SELECT 
            c.id AS collection_id, 
            g.id AS game_id, 
            g.title, 
            g.developer, 
            g.release_date, 
            g.image_url, 
            g.description,
            p.name AS platform_name,
            c.user_rating
        FROM 
            collections c
        JOIN 
            games g ON c.game_id = g.id
        JOIN 
            platforms p ON c.platform_id = p.id
        WHERE 
            c.user_id = :user_id
        ORDER BY 
            c.added_date DESC
    ");

    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll();
}

include_once ROOT_PATH . 'app/views/header.php';
include_once ROOT_PATH . 'app/views/collection.php';
include_once ROOT_PATH . 'app/views/footer.php';