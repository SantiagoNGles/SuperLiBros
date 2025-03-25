<?php
function controleurPrincipal($action)
{
    $lesActions = array();

    $lesActions = [
        "home" => "home.php",
        "login" => "login.php",
        "register" => "register.php",
        "logout" => "logout.php",
        "profile" => "profile.php",
        "deleteAccount" => "deleteAccount.php",
        "games" => "games.php",
        "favorites" => "favorites.php",
    ];

    return $lesActions[$action] ?? $lesActions["home"];
}