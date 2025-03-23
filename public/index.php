<?php
// Define root path and base URL for the application
define('ROOT_PATH', dirname(__DIR__) . '/');
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));

// Start session
session_start();

// Include necessary files
require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/app/controllers/controleurPrincipal.php';

// Get the requested action from URL parameters
$action = isset($_GET['action']) ? $_GET['action'] : 'home';

// Determine which controller should handle the action
$controllerFile = controleurPrincipal($action);

// Include the appropriate controller
require_once ROOT_PATH . '/app/controllers/' . $controllerFile;

// Display messages/errors from session if they exist
if (isset($_SESSION['message'])) {
    // The controller will use this message
    // Unset after it's used to prevent displaying it multiple times
    unset($_SESSION['message']);
}

if (isset($_SESSION['errors'])) {
    // The controller will use these errors
    // Unset after they're used to prevent displaying them multiple times
    unset($_SESSION['errors']);
}