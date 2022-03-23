<?php
require_once 'config/constants.php';
require_once 'vendor/autoload.php';

spl_autoload_register(function ($className){
    $dirs = ['c', 'm'];
    $found = false;
    foreach ($dirs as $dir) {
        $fileName = __DIR__ . '/' . $dir . '/' . $className . '.php';
        
        if(is_file($fileName)){
            require_once($fileName);
            $found = true;
            break;
        }
    }
    if(!$found){
        throw new Exception('Загрузка не удалась ' . $className);
    }
    return true;
});