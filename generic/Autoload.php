<?php
spl_autoload_register(function($class){
    // Converte namespace separators para directory separators
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    
    // Tenta incluir o arquivo
    if (file_exists($file)) {
        include $file;
    }
});