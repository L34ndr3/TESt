<?php

function includeFileWithClassName($class_name)
{
    // répertoires contenant les classes
    $directorys = array(
        
        'DAO/',
        'DTO/',
        'tools/',
        'controllers/'
    );

    // pour chaque répertoire
    foreach ($directorys as $directory) {
        // si le fichier existe
        if (file_exists($directory . $class_name . '.php')) {
            echo 'ok ';
            // inclus le fichier une seule fois
            require_once($directory . $class_name . '.php');
            return;
        }
    }
}
?>