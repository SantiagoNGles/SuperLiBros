<?php
class Favorites
{
    private $conn;

    public function __construct()
    {
        $this->conn = connexionPDO();
    }

    public function getFavoriteGamesByUser($userId)
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT g.* 
                FROM favorites f 
                JOIN games g ON f.game_id = g.id 
                WHERE f.user_id = :userId 
                ORDER BY f.added_date DESC
            ");
            $stmt->execute(['userId' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur getFavoriteGamesByUser : " . $e->getMessage());
            return [];
        }
    }

    public function removeGameFromFavorites($userId, $gameId)
    {
        try {
            $stmt = $this->conn->prepare("
                DELETE FROM favorites 
                WHERE user_id = :userId AND game_id = :gameId
            ");
            return $stmt->execute([
                'userId' => $userId,
                'gameId' => $gameId
            ]);
        } catch (PDOException $e) {
            error_log("Erreur removeGameFromFavorites : " . $e->getMessage());
            return false;
        }
    }
}