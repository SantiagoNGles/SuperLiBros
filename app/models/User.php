<?php

class User {
    private $db;
    
    public function __construct() {
        $this->db = connexionPDO();
    }
    
    /**
     * Crée un nouvel utilisateur
     * @param string $username Le pseudo de l'utilisateur
     * @param string $email L'email de l'utilisateur
     * @param string $password Le mot de passe en clair (sera haché)
     * @return bool|string True si réussi, message d'erreur sinon
     */
    public function create($username, $email, $password) {
        try {
            // Vérifier si l'utilisateur existe déjà
            $checkQuery = "SELECT id FROM users WHERE username = :username OR email = :email";
            $checkStmt = $this->db->prepare($checkQuery);
            $checkStmt->bindParam(':username', $username);
            $checkStmt->bindParam(':email', $email);
            $checkStmt->execute();
            
            if ($checkStmt->rowCount() > 0) {
                return "Ce nom d'utilisateur ou cet email est déjà utilisé.";
            }
            
            // Hacher le mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Insérer le nouvel utilisateur
            $insertQuery = "INSERT INTO users (username, email, password_hashed) VALUES (:username, :email, :password)";
            $insertStmt = $this->db->prepare($insertQuery);
            $insertStmt->bindParam(':username', $username);
            $insertStmt->bindParam(':email', $email);
            $insertStmt->bindParam(':password', $hashedPassword);
            $insertStmt->execute();
            
            return true;
        } catch (PDOException $e) {
            return "Erreur lors de l'enregistrement: " . $e->getMessage();
        }
    }
    
    /**
     * Authentifie un utilisateur
     * @param string $username Le pseudo de l'utilisateur
     * @param string $password Le mot de passe en clair
     * @return array|bool Les données de l'utilisateur si authentifié, false sinon
     */
    public function authenticate($username, $password) {
        try {
            $query = "SELECT id, username, email, password_hashed FROM users WHERE username = :username";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            
            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (password_verify($password, $user['password_hashed'])) {
                    // Ne pas retourner le mot de passe haché
                    unset($user['password_hashed']);
                    return $user;
                }
            }
            
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Récupère un utilisateur par son ID
     * @param int $id L'ID de l'utilisateur
     * @return array|bool Les données de l'utilisateur si trouvé, false sinon
     */
    public function getById($id) {
        try {
            $query = "SELECT id, username, email, created_at FROM users WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt->rowCount() == 1) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}