<?php
require_once ROOT_PATH . './app/models/User.php';

// Récupération de l'action à exécuter en fonction de la valeur du paramètre "action"
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "login";
}

$userModel = new User();

// Exécution de l'action
switch ($action) {
    case "register":
        showRegisterForm();
        break;
    case "registerProcess":
        processRegistration();
        break;
    case "login":
        showLoginForm();
        break;
    case "loginProcess":
        processLogin();
        break;
    case "logout":
        logout();
        break;
    default:
        showLoginForm();
}

function showRegisterForm() {
    include_once ROOT_PATH . 'app/views/register.php';
    include_once ROOT_PATH . 'app/views/header.php';
    include_once ROOT_PATH . 'app/views/footer.php';
}

function processRegistration() {
    global $userModel;
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupérer et valider les données du formulaire
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        $errors = [];
        
        // Validation des champs
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
        
        // Si pas d'erreurs, tenter l'inscription
        if (empty($errors)) {
            $result = $userModel->create($username, $email, $password);
            
            if ($result === true) {
                $_SESSION['message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                header("Location: " . BASE_URL . "?action=login");
                exit;
            } else {
                $errors[] = $result; // Message d'erreur retourné par le modèle
            }
        }
        
        // S'il y a des erreurs, les afficher et réafficher le formulaire
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = [
            'username' => $username,
            'email' => $email
        ];
        
        header("Location: " . BASE_URL . "?action=register");
        exit;
    }
}

function showLoginForm() {
    include_once ROOT_PATH . 'app/views/header.php';
    include_once ROOT_PATH . 'app/views/login.php';
    include_once ROOT_PATH . 'app/views/footer.php';
}

function processLogin() {
    global $userModel;
    
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
}

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