<?php
function controleurPrincipal($action) {
    $lesActions = array();

    $lesActions["home"] = "homeController.php";
    
    
    if (array_key_exists($action, $lesActions)) {
        return $lesActions[$action];
    } else {
        return $lesActions["home"];
    }
}