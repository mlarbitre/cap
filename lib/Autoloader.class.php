<?php

/**
 * Classe permettant de gérer l’autoload php 
 */
class AutoLoader
{
    const NOT_DIRECTORY = 1;
    
    /**
     * Tableau interne stockant les classes connues de l’Autoloader
     * @var type 
     */
    static private $classNames = array();

    /**
     * Store the filename (sans extension) & full path of all "class.php" files found
     * @param string $dirName Le dossier à explorer pour enregistrer les classes
     * @expectedException InvalidArgumentException
     * @expectedExceptionCode 1
     */
    public static function registerDirectory($dirName)
    {
        // On vérifie que le chemin passé est bien un répertoire
        if (!is_dir($dirName))
        {
            throw new InvalidArgumentException('Autoloader::registerDirectory : directory expected.', AutoLoader::NOT_DIRECTORY);
        }
        
        // On récupère un itérateur sur le dossier passé
        $directoryIterator = new DirectoryIterator($dirName);
        foreach ($directoryIterator as $file)
        {

            if ($file->isDir() && !$file->isLink() && !$file->isDot())
            {
                // recurse into directories other than a few special ones
                self::registerDirectory($file->getPathname());
            }
            elseif (substr($file->getFilename(), -10) === '.class.php')
            {
                // save the class name / path of a .php file found
                $className = substr($file->getFilename(), 0, -10);
                AutoLoader::registerClass($className, $file->getPathname());
            }
        }
    }

    /**
     * Enregistre une classe dans la liste des classes de l’Autoloader
     * @param string $className Le nom de la classe
     * @param string $fileName Le nom complet du fichier contenant la classe
     */
    public static function registerClass($className, $fileName)
    {
        // On ajoute la référence à la classe
        AutoLoader::$classNames[$className] = $fileName;
    }

    /**
    * Fonction de chargement automatique des classes
    * @param string $class Le nom de la classe (avec son espace de noms) à charger
    */
    public static function loadClass($className)
    {
        // TODO : gérer les namespaces
        $temp = explode("\\", $className);
        
        $className = $temp[count($temp)-1];
        
        if (isset(AutoLoader::$classNames[$className]))
        {
            require_once(AutoLoader::$classNames[$className]);
        }
    }

}

// On signale à php que la fonction à utiliser lorsqu’il rencontre
// une classe inconnue est la fonction loadClass de la classe Autoloader
spl_autoload_register(array('AutoLoader', 'loadClass'));