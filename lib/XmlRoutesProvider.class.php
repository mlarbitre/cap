<?php

namespace lib;

/**
 * Un fournisseur de routes basé sur un fichier XML
 * décrivant la liste des routes acceptables
 * @author M. l’Arbitre
 */
class XmlRoutesProvider implements core\IRoutesProvider
{

    const NO_FILE        = 1;
    const INCORRECT_FILE = 2;
    const NO_ROUTE       = 3;

    /**
     * Le chemin complet du fichier des routes
     * @var string 
     */
    private $routesFile;

    /**
     * Setter du chemin du fichier des routes
     * @param string $routesFile
     */
    public function setRoutesFile($routesFile)
    {
        if (empty($routesFile) || (!is_string($routesFile)))
        {
            throw new \InvalidArgumentException("XmlRoutesProvider::setRouteFile : '$routesFile' is not a valid path", self::INCORRECT_FILE);
        }
        $this->routesFile = $routesFile;
    }

    /**
     * Constructeur d'instance
     * @param string $fileName Le nom complet du fichier contenant les routes
     */
    public function __construct($fileName = '')
    {
        if ($fileName != '')
        {
            $this->setRoutesFile($fileName);
        }
    }

    /**
     * Fournit la liste des routes acceptables pour l'application
     * @return array Le tableau des routes disponibles pour l'application
     * @throws \RuntimeException 
     */
    public function getAvailableRoutes()
    {
        // Si on n'a pas défini le fichier des routes
        if (empty($this->routesFile) || !is_string($this->routesFile))
        {
            throw new \RuntimeException('XmlRoutesProvider::getAvailableRoutes : incorrect specified file.', self::NO_FILE);
        }

        // Si le fichier des routes n'est pas un fichier
        if (!is_file($this->routesFile))
        {
            throw new \RuntimeException("XmlroutesProvider::getAvailableRoutes : $this->routesFile is not a file.", self::INCORRECT_FILE);
        }

        // On ouvre le fichier
        $routesDoc = new \DOMDocument();
        $routesDoc->load($this->routesFile);

        // Récupération des routes
        $routes = $routesDoc->getElementsByTagName('route');
        if ($routes->length == 0)
        {
            throw new \RuntimeException("XmlroutesProvider::getAvailableRoutes : no routes in $this->routesFile.", self::NO_ROUTE);
        }

        // On parcourt chacune des routes récupérées du fichier xml
        $availableRoutes = array();
        foreach ($routes as $route)
        {
            $varsNames = array();
            // Si la route a également une liste de variables
            if ($route->hasAttribute('vars'))
            {
                // On applique la fonction "trim" à chaque élément du tableau
                // récupéré par le "explode"
                $varsNames = array_map('trim',
                                       explode(",", $route->getAttribute('vars')));
            }

            // On ajoute une nouvelle route à la liste finale
            $availableRoutes[] = new core\Route(
                            $route->getAttribute('url'),
                            $route->getAttribute('module'),
                            $route->getAttribute('action'),
                            $varsNames);
        }
        return $availableRoutes;
    }

}

?>
