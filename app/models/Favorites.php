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
}