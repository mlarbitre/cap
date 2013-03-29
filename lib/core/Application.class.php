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
     * @param \lib\core\IRoutesProvider $routesProvider Un fournisseur de routes
     */
    public function __construct($name, IRoutesProvider $routesProvider)
    {
        $this->httpRequest    = new HttpRequest($this);
        $this->httpResponse   = new HttpResponse($this);
        $this->name           = $name;
        $this->routesProvider = $routesProvider;
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
        // On instancie un router
        /* @var $router \lib\core\Router */
        $router = new Router();
        // On lui donne la liste des routes disponibles
        $router->addRoutes($this->routesProvider->getAvailableRoutes());
        try
        {
            // On essaie de trouver une équivalence à la requête
            /* @var $matchedRoute \lib\core\Route */
            $matchedRoute = $router->getRoute($this->httpRequest->requestUri());
        }
        catch (\RuntimeException $ex)
        {
            // Si le router n'a pas trouvé de route correspondante…
            if ($ex->getCode == Router::NO_ROUTE)
            {
                // … on envoie sur la 404
                $this->httpResponse->redirect404();
            }
            else
            {
                // On transmet simplement l'exception
                throw $ex;
            }
        }

        // On a la route, avec dans son tableau "vars" les
        // valeurs entrées dans l'url.
        // Il faut donc les mettre sur la variable globale $_GET
        $_GET = array_merge($_GET, $matchedRoute->vars());

        // Reste à instancier le controller, en choisissant son type.
        // Par convention, le controller est de type "ModuleController"
        $controllerType = '\\apps\\' . strtolower($this->name) .
                '\\modules\\' . strtolower($matchedRoute->module()) .
                ucfirst($matchedRoute->module()) . 'Controller';

        return new $controllerType($this, $matchedRoute->module(),
                        $matchedRoute->action());
    }

}

?>
