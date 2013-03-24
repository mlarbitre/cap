<?php

/**
 * Bootstrap pour les tests, chargé au démarrage des tests
 * @author alexandre
 */

namespace test;

// Pour tous les tests, on charge l’autoload
require_once(__DIR__ . '/../autoload.php');
// et on ajoute l'autoload Composer
// pour l'utilisation de VfsStream
require_once(__DIR__ .  '/vendor/autoload.php');

// Pour tous les tests, on déclare une classe TestApplication
/**
 * Dérivée minimale d'Application, de nom "test"
 */
class TestApplication extends \lib\core\Application
{

    /**
     * Surcharge du constructeur pour lui passer le nom de l’application
     */
    public function __construct()
    {
        parent::__construct('test');
    }

    /**
     * Surcharge de la méthode "run"
     */
    public function run()
    {
        ;
    }

}

?>
