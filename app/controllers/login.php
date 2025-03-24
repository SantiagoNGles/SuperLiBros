<?php
require_once ROOT_PATH . 'app/models/User.php';

$userModel = new User();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $errors = [];

    // Validation des champs
    if (empty($username)) {
        $errors[] = "Le nom d'utilisateur est obligatoire.";
    }

    if (empty($password)) {
        $errors[] = "Le mot de passe est obligatoire.";
    }

    // Si pas d'erreurs, tenter l'authentification
    if (empty($errors)) {
        $user = $userModel->authenticate($username, $password);

        if ($user) {
            // Créer la session utilisateur
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['message'] = "Connexion réussie ! Bienvenue, " . $user['username'] . ".";

            header("Location: " . BASE_URL . "?action=home");
            exit;
        } else {
            $errors[] = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }

    // S'il y a des erreurs, les afficher et réafficher le formulaire
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = [
        'username' => $username
    ];

    header("Location: " . BASE_URL . "?action=login");
    exit;
}

include_once ROOT_PATH . 'app/views/header.php';
include_once ROOT_PATH . 'app/views/login.php';
include_once ROOT_PATH . 'app/views/footer.php';
