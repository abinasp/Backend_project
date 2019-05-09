<?php
define("_INCLUDED", 1);
if(isset($_GET['cn']) && isset($_GET['fn'])){
    
}else{
    echo json_encode(array('success'=>FALSE, 'message'=>"API doesn't exist"));
}
?>