<?php

namespace lib\core;

/**
 * Classe abstraite représentant un composant d'une application
 * @author M. l’Arbitre
 */
abstract class ApplicationComponent
{

    /**
     * L'application dont dépend l'ApplicationComponent
     * @var \lib\core\Application
     */
    protected $app;

    /**
     * Constructeur d’instance
     * @param \lib\core\Application $app L'application dont dépend le composant
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Getter de l'application
     * @return \lib\core\Application L'application dont dépend le composant
     */
    public function app()
    {
        return $this->app;
    }

}

?>
