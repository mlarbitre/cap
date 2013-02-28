<?php

namespace lib\core;

/**
 * Classe assurant la redirection d'une URL vers un couple
 * module/action
 * @author M. l’Arbitre
 */
class Router
{

    const NO_ROUTE = 1;

    /**
     * Liste des routes connues du Router
     * @var array 
     */
    protected $routes = array();

    /**
     * Permet d'ajouter une route à la liste des routes connues
     * du Router
     * @param \lib\core\Route $route La route à ajouter
     */
    public function addRoute(Route $route)
    {
        // Remarque : la comparaison d'objets dans le in_array correspond
        // à un "==" ; dans ce cas, la valeur de chaque propriété de l’objet 
        // est comparée à son équivalent sur l’autre objet.
        // Dans ce cas précis, une route déjà enregistrée ne le sera
        // donc pas deux fois, même si on passe deux instances différentes.
        if (!in_array($route, $this->routes))
        {
            $this->routes[] = $route;
        }
    }

    /**
     * Permet d'ajouter les routes en lot
     * @param array $routes Le tableau des routes à ajouter
     */
    public function addRoutes(array $routes)
    {
        if (count($routes) > 0)
        {
            foreach ($routes as $route)
            {
                $this->addRoute($route);
            }
        }
    }

    /**
     * Permet de récupérer la route EXACTE (valeurs paramétrées incluses)
     * correspondant à l’url passée en paramètre
     * @param string $url L’url dont on souhaite récupérer la route
     * @return Route La route correspondante
     * @throws \RuntimeException
     */
    public function getRoute($url)
    {
        foreach ($this->routes as $route)
        {
            // On regarde si la route correspond à l’url passée
            // Au passage, on récupère les valeurs paramétrées si besoin
            if (($varsValues = $route->match($url)) !== false)
            {
                // Si on est là, $varsValues est un tableau contenant les 
                // correspondances de l’url
                if ($route->hasVars())
                {
                    $varsNames = $route->varsNames();
                    $vars      = array();

                    // On parcourt les correspondances
                    foreach ($varsValues as $key => $value)
                    {
                        if ($key > 0)
                        {
                            // Et on remplit notre tableau $vars avec :
                            //  - en index, le nom prévu de la variable (attention, $varsValues[0] contient l’url complète)
                            //  - en valeur, la valeur récupérée sur l’url
                            $vars[$varsNames[$key - 1]] = $value;
                        }
                    }
                    // On assigne le tableau des variables à la route
                    $route->setVars($vars);
                }
                // On renvoie la route
                return $route;
            }
        }

        throw new \RuntimeException('Router::getRoute : route "' . $url . '" not found', self::NO_ROUTE);
    }

}

?>
