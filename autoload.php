<?php
// Racine des sources : le dossier où se trouve le fichier autoload.php
define('SOURCES_FILE', __DIR__ . '/');
// Set include path
//$path = SOURCES_FILE . PATH_SEPARATOR . get_include_path();
//set_include_path($path);

// On enregistre une fonction "maison" de chargement des classes
spl_autoload_register(function ($className)
    {
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        if (file_exists(SOURCES_FILE . $className . '.class.php'))
                include_once($className . '.class.php');
    });
// On y ajoute également la fonction magique __autoload, si elle existe
if (function_exists('__autoload'))
{
    spl_autoload_register('__autoload');
}
// On y ajoute également la fonction de chargement native
spl_autoload_register('spl_autoload');
?>
