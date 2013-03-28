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
     * La requête d'entrée 
     * @var \lib\core\HttpRequest
     */
    protected $httpRequest;

    /**
     * La réponse à apporter 
     * @var \lib\core\HttpResponse
     */
    protected $httpResponse;

    /**
     * Le nom de l’application
     * @var string
     */
    protected $name;

    /**
     * Un fournisseur de routes valides
     * @var lib\core\IRoutesProvider 
     */
    protected $routesProvider;

    /**
     * Le nom complet du fichier des routes valides
     * @var string 
     */
    protected $routesFileFullName;

    /**
     * Constructeur d’instance
     * @param string $name Le nom de l’application
     * @param lib\core\IRoutesProvider $routesProvider Un fournisseur de routes
     */
    public function __construct($name, IRoutesProvider $routesProvider,
                                $routesFileName = '')
    {
        $this->httpRequest    = new HttpRequest($this);
        $this->httpResponse   = new HttpResponse($this);
        $this->name           = $name;
        $this->routesProvider = $routesProvider;

        if (empty($routesFileName) || !is_string($routesFileName))
        {
            // Par défaut, on suppose que le chemin d'accès aux routes
            // est dans un dossier "config" dans le répertoire de l'appli
            $routesFileName = __DIR__ . "/../../"
                    . "apps/$this->name/config/routes.xml";
        }
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

    /**
     * Obtient le controller à utiliser pour répondre à la requête
     * @return \lib\core\Controller Le controller attendu
     */
    public function getController()
    {
        
    }

}

?>
