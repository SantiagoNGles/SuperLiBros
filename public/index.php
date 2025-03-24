<?php
define('ROOT_PATH', dirname(__DIR__) . '/');
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/');

session_start();

include_once ROOT_PATH . 'config/database.php';
include_once ROOT_PATH . 'app/controllers/controleurPrincipal.php';

$action = $_GET['action'] ?? 'home';

$controllerFile = controleurPrincipal($action);

include_once ROOT_PATH . 'app/controllers/' . $controllerFile;

if (!empty($_SESSION['message'])) {
    echo "<p style='color: green;'>" . $_SESSION['message'] . "</p>";
    unset($_SESSION['message']);
}

if (!empty($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $error) {
        echo "<p style='color: red;'>$error</p>";
    }
    unset($_SESSION['errors']);
}
