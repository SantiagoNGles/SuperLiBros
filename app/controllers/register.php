<?php
require_once ROOT_PATH . 'config/database.php';
require_once ROOT_PATH . 'app/models/User.php';

$userModel = new User();

// Traite la soumission du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $errors = [];

    if (empty($username)) {
        $errors[] = "Le nom d'utilisateur est obligatoire.";
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $errors[] = "Le nom d'utilisateur doit contenir entre 3 et 50 caractères.";
    }

    if (empty($email)) {
        $errors[] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Veuillez entrer un email valide.";
    }

    if (empty($password)) {
        $errors[] = "Le mot de passe est obligatoire.";
    } elseif (strlen($password) < 12) {
        $errors[] = "Le mot de passe doit contenir au moins 12 caractères.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    if (empty($errors)) {
        $result = $userModel->create($username, $email, $password);
        
        if ($result === true) {
            $_SESSION['message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            header("Location: " . BASE_URL . "?action=login");
            exit;
        } else {
            $errors[] = $result;
        }
    }

    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = ['username' => $username, 'email' => $email];

    header("Location: " . BASE_URL . "?action=register");
    exit;
}

// Affichage du formulaire
include_once ROOT_PATH . 'app/views/header.php';
include_once ROOT_PATH . 'app/views/register.php';
include_once ROOT_PATH . 'app/views/footer.php';
