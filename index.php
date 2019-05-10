<?php
require_once 'routes.php';

define("_INCLUDED", 1);
if(isset($_GET['cn']) && isset($_GET['fn'])){
    routes($_GET['cn'], $_GET['fn']);
}else{
    echo json_encode(array('success'=>TRUE, 'message'=>'Welcome'));
}
?>