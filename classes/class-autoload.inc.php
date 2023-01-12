<?php

spl_autoload_register("autoload");

function autoload($className) {
    $path = 'classes/';
    $extension = '.class.php';
    $file = $path.$className.$extension;

    if(!file_exists($file)){
        return false;
    }
    
    include_once($file);
}

?>