<?php
function controleurPrincipal($action) {
    $lesActions = array();

    $lesActions = [
        "home" => "home.php",
        "login" => "login.php",
        "register" => "register.php",
        "logout" => "logout.php",
        "profile" => "profile.php"
    ];

    return $lesActions[$action] ?? $lesActions["home"];
}