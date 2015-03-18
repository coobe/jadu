<?php

try {
    $target    = $_POST['target'];
    $className  = strtoupper($target) . 'Controller';
    $fileName   = __DIR__ . '/controller/' . $className . '.php';
    require_once $fileName;
    
    $controller = new $className;
    $response   = $controller->execute($_REQUEST);
    echo json_encode($response);
} catch (Exception $e) {
    header("404 not found");
    exit();
}