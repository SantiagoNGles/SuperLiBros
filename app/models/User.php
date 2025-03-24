<?php
class User {
    private $conn;
    
    public function __construct() {
        $this->conn = connexionPDO();
    }

    public function create($username, $email, $password) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                return "Un utilisateur avec ce nom ou cet email existe déjà.";
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashedPassword])) {
                return true;
            } else {
                return "Erreur lors de l'inscription.";
            }
        } catch (PDOException $e) {
            error_log("Erreur d'inscription : " . $e->getMessage());
            return "Une erreur est survenue. Veuillez réessayer.";
        }
    }
}
