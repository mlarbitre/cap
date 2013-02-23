<?php

namespace lib\core;

/**
 * Classe représentant l’application Web.
 * Assure la cohésion entre les différents composants de l’application 
 * pour obtenir la réponse souhaitée par l’utilisateur en fonction de l’url entrée.
 * @author M. l’Arbitre
 */
abstract class Application
{

    /**
     *
     * @var \lib\core\HttpRequest La requête d'entrée 
     */
    protected $httpRequest;

    /**
     *
     * @var \lib\core\HttpResponse La réponse à apporter 
     */
    protected $httpResponse;

    /**
     *
     * @var string Le nom de l’application
     */
    protected $name;

    /**
     * Constructeur d’instance
     * @param string $name Le nom de l’application
     */
    public function __construct($name)
    {
        $this->httpRequest  = new HTTPRequest;
        $this->httpResponse = new HTTPResponse;
        $this->name         = $name;
    }

    /**
     * Méthode d’exécution de l’application
     * Il s’agit de la méthode centrale de l’application,
     * celle qui régit tout le reste.
     */
    abstract public function run();

    /**
     * Getter de la requête
     * @return \lib\core\HttpRequest La requête d'entrée
     */
    public function httpRequest()
    {
        return $this->httpRequest;
    }

    /**
     * Getter de la réponse de l’appli à la requête
     * @return \lib\core\HttpResponse La réponse
     */
    public function httpResponse()
    {
        return $this->httpResponse;
    }

    /**
     * Getter du nom de l’application
     * @return string Le nom de l’application
     */
    public function name()
    {
        return $this->name;
    }

}

?>
