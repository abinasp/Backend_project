<?php
require_once 'config/config.php';
require_once 'services/ProductService.php';
require_once 'services/UserService.php';

function routes($moduleName, $method)
{
    try {
        $allRoutes = GetallRoutes();
        if (! isset($allRoutes[$moduleName])) {
            throw new Exception('Invalid API!!');
        }
        $className = $allRoutes[$moduleName];
        $execute = new $className();
        echo $execute->OnRun($method);
    } catch (Exception $ex) {
        echo json_encode(array(
            'success' => FALSE,
            'message' => 'Invalid API.'
        ));
    }
}
?>