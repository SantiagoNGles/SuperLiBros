<?php
require_once ROOT_PATH . 'app/models/User.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "Vous devez être connecté pour supprimer votre compte.";
    header("Location: " . BASE_URL . "?action=login");
    exit;
}

$userModel = new User();
$deleted = $userModel->deleteUserById($_SESSION['user_id']);

if ($deleted) {
    session_destroy(); // Déconnecter l'utilisateur après suppression
    header("Location: " . BASE_URL . "?action=home");
    exit;
} else {
    $_SESSION['message'] = "Erreur lors de la suppression du compte.";
    header("Location: " . BASE_URL . "?action=profile");
    exit;
}
