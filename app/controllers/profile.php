<?php
require_once ROOT_PATH . 'app/models/User.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo "<p style='color: red;'>Aucun utilisateur connecté.</p>";
    exit;
}


$userModel = new User();
$user = $userModel->getUserById($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    $errors = [];

    if (empty($username)) {
        $errors[] = "Le nom d'utilisateur est obligatoire.";
    }

    if (empty($email)) {
        $errors[] = "L'adresse est obligatoire.";
    }

    if (!$user) {
      $_SESSION['message'] = "Erreur : Impossible de récupérer vos informations.";
      header("Location: " . BASE_URL . "?action=home");
      exit;
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    
    // Modification du nom d'utilisateur
    if (isset($_GET['edit']) && $_GET['edit'] == 'username') {
        $username = trim($_POST['username'] ?? '');
        
        if (empty($username)) {
            $errors[] = "Le nom d'utilisateur est obligatoire.";
        }
        
        if (empty($errors)) {
            $updated = $userModel->updateUsername($_SESSION['user_id'], $username);
            
            if ($updated) {
                $_SESSION['message'] = "Nom d'utilisateur mis à jour avec succès.";
                $_SESSION['username'] = $username;
                header("Location: " . BASE_URL . "?action=profile");
                exit;
            } else {
                $errors[] = "Erreur lors de la mise à jour du nom d'utilisateur.";
            }
        }
    }
    
    // Modification de l'email
    else if (isset($_GET['edit']) && $_GET['edit'] == 'email') {
        $email = trim($_POST['email'] ?? '');
        
        if (empty($email)) {
            $errors[] = "L'email est obligatoire.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Veuillez entrer un email valide.";
        }
        
        if (empty($errors)) {
            $updated = $userModel->updateEmail($_SESSION['user_id'], $email);
            
            if ($updated) {
                $_SESSION['message'] = "Email mis à jour avec succès.";
                header("Location: " . BASE_URL . "?action=profile");
                exit;
            } else {
                $errors[] = "Erreur lors de la mise à jour de l'email.";
            }
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: " . BASE_URL . "?action=profile");
        exit;
    }
  }
}

include_once ROOT_PATH . 'app/views/header.php';
include_once ROOT_PATH . 'app/views/profile.php';
include_once ROOT_PATH . 'app/views/footer.php';
