<?php

/**
* Dynamically calls an AJAX enabled Controller
*
* @author Torsten Oppermann
* @since 18.03.2015
*/ 
try {
    $target    = $_POST['target'];
    $className  = strtoupper($target) . 'Controller';
    $fileName   = __DIR__ . '/controller/' . $className . '.php';
    require_once $fileName;
    
    $controller = new $className;
    $response   = $controller->execute($_REQUEST);
    echo json_encode($response);
} catch (Exception $e) {
    $errorMessage = "AJAX handler error";
    include("./view/error.php");
    exit();
}