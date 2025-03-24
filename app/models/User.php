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

    public function authenticate($username, $password) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }

            return false;
        } catch (PDOException $e) {
            error_log("Erreur d'authentification : " . $e->getMessage());
            return false;
        }
    }

    public function getUserById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT id, username, email, email FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
            return $user ? $user : false; // Retourne false au lieu de []
        } catch (PDOException $e) {
            error_log("Erreur getUserById : " . $e->getMessage());
            return false;
        }
    }
    
    public function updateUsername($id, $username) {
        try {
            // Vérifier si le nom d'utilisateur existe déjà
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND id != ?");
            $stmt->execute([$username, $id]);
            $count = $stmt->fetchColumn();
    
            if ($count > 0) {
                return false; // Le nom d'utilisateur existe déjà
            }
    
            $stmt = $this->conn->prepare("UPDATE users SET username = :username WHERE id = :id");
            return $stmt->execute([
                'username' => $username,
                'id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Erreur updateUsername : " . $e->getMessage());
            return false;
        }
    }
    
    public function updateEmail($id, $email) {
        try {
            // Vérifier si l'email existe déjà
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $id]);
            $count = $stmt->fetchColumn();
    
            if ($count > 0) {
                return false; // L'email existe déjà
            }
    
            $stmt = $this->conn->prepare("UPDATE users SET email = :email WHERE id = :id");
            return $stmt->execute([
                'email' => $email,
                'id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Erreur updateEmail : " . $e->getMessage());
            return false;
        }
    }

    public function deleteUserById($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Erreur deleteUserById : " . $e->getMessage());
            return false;
        }
    }
    

}
