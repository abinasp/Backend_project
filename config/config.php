<?php

    function GetallRoutes(){
        $allRoutes = array(
            'user'=>'UserService',
            'product'=>'ProductService',
            'customer'=>'CustomerService'
        );
        return $allRoutes;
    }
?>
