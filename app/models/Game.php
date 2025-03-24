<?php
class Game {
    private $conn;
    
    public function __construct() {
        $this->conn = connexionPDO();
    }

    public function getAllGames() {
        try {
            $stmt = $this->conn->query("SELECT * FROM games ORDER BY id");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur getAllGames : " . $e->getMessage());
            return [];
        }
    }

    public function getGameById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM games WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur getGameById : " . $e->getMessage());
            return false;
        }
    }

    public function addGameToFavorites($userId, $gameId) {
        try {
            // Check if the game is already in favorites
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM favorites WHERE user_id = ? AND game_id = ?");
            $stmt->execute([$userId, $gameId]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                return false; // Game already in favorites
            }

            // Add game to favorites
            $stmt = $this->conn->prepare("INSERT INTO favorites (user_id, game_id) VALUES (?, ?)");
            return $stmt->execute([$userId, $gameId]);
        } catch (PDOException $e) {
            error_log("Erreur addGameToFavorites : " . $e->getMessage());
            return false;
        }
    }
}