<?php
function controleurPrincipal($action) {
    $lesActions = [
        "home" => "homeController.php",
        "login" => "login.php",
        "register" => "register.php",
        "logout" => "logout.php"
    ];

    return $lesActions[$action] ?? $lesActions["home"];
}
