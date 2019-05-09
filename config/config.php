<?php
if (! defined("_INCLUDED"))
    exit("Invalid API call.");

    function GetallRoutes(){
        $allRoutes = array(
            'user'=>'UserService',
            'product'=>'ProductService'
        );
        return $allRoutes;
    }
?>
