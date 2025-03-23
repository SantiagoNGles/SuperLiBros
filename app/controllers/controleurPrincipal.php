<?php
function controleurPrincipal($action) {
    $lesActions = array();

    $lesActions["home"] = "homeController.php";
    $lesActions["login"] = "authController.php";
    $lesActions["register"] = "authController.php";
    
    
    if (array_key_exists($action, $lesActions)) {
        return $lesActions[$action];
    } else {
        return $lesActions["home"];
    }
}