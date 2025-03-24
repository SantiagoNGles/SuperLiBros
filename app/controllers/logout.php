<?php
// Fonction de déconnexion
function logout() {
    // Détruire toutes les variables de session
    $_SESSION = array();
    
    // Détruire la session
    session_destroy();
    
    // Rediriger vers la page d'accueil avec un message
    $_SESSION['message'] = "Vous avez été déconnecté avec succès.";
    header("Location: " . BASE_URL . "?action=home");
    exit;
}

// Exécuter la déconnexion
logout();