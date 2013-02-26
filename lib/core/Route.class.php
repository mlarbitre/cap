<?php

namespace lib\core;

/**
 * Classe décrivant une route, à savoir un 
 * lien entre une URL et un couple module/action
 * @author M. l’Arbitre
 */
class Route
{

    /**
     * Le nom de l’action
     * @var string 
     */
    protected $action;

    /**
     * Le nom du module
     * @var string 
     */
    protected $module;

    /**
     * Le masque d’url de la route
     * @var string
     */
    protected $url;

    /**
     * Le nom des variables GET attendues
     * @var array 
     */
    protected $varsNames;

    /**
     * Le tableau de variables GET
     * @var array 
     */
    protected $vars = array();

    /**
     * Constructeur d’instance
     * @param string $url Le masque d’url de la route
     * @param string $module Le nom du module
     * @param string $action Le nom de l’action
     * @param array $varsNames Les noms des variables GET attendues
     */
    public function __construct($url, $module, $action, array $varsNames)
    {
        $this->url       = $url;
        $this->module    = $module;
        $this->action    = $action;
        $this->varsNames = $varsNames;
    }

    /**
     * Détermine si la route attend des variables ou non
     * @return bool
     */
    public function hasVars()
    {
        return !empty($this->varsNames);
    }

    /**
     * Détermine si une url correspond à cette route
     * @param string $url L’url à tester
     * @return mixed Le tableau des correspondances de l’url si l’url correspond à la route, FALSE sinon
     */
    public function match($url)
    {
        $matches = array();
        // S’il y a correspondance entre l’url passée et celle de la route…
        if (preg_match('`^' . $this->url . '$`', $url, $matches))
        {
            // … on renvoie le tableau de correspondances
            return $matches;
        }
        else
        {
            // Sinon, on retourne FALSE
            return false;
        }
    }

    /**
     * Getter du nom de l’action associée à cette route
     * @return string
     */
    public function action()
    {
        return $this->action;
    }

    /**
     * Getter du nom du module associé à cette route
     * @return string
     */
    public function module()
    {
        return $this->module;
    }

    /**
     * Getter du tableau de variables
     * @return array
     */
    public function vars()
    {
        return $this->vars;
    }

    /**
     * Getter du tableau des noms de variables
     * @return array
     */
    public function varsNames()
    {
        return $this->varsNames;
    }

}

?>
