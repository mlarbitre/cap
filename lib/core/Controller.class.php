<?php

namespace lib\core;

/**
 * Classe décrivant un contrôleur, dans sa plus simple expression.
 * Tout contrôleur de l'application doit dériver de ce contrôleur
 *
 * @author M. l’Arbitre
 */
abstract class Controller extends ApplicationComponent
{

    const BAD_MODULE     = 1;
    const BAD_ACTION     = 2;
    const BAD_VIEW       = 3;
    const UNKNOWN_ACTION = 4;

    /**
     * L'action à effectuer par le contrôleur
     * @var string 
     */
    protected $action;

    /**
     * Le module du contrôleur
     * @var string 
     */
    protected $module;

    /**
     * Le nom du fichier représentant la vue
     * @var string 
     */
    protected $view;

    /**
     * La page à retourner à l'utilisateur
     * @var \lib\core\Page 
     */
    protected $page;

    /**
     * Constructeur d'instance
     * @param \lib\core\Application $app L'application hébergeant ce contrôleur
     * @param string $module Le module du contrôleur
     * @param string $action L'action à effectuer
     */
    public function __construct(Application $app, $module, $action)
    {
        parent::__construct($app);

        $this->page = new Page($app);

        $this->setModule($module);
        $this->setAction($action);
        // Par défaut, la vue a la même valeur que l'action
        $this->setView($action);
    }

    /**
     * Méthode coeur du contrôleur.
     * Exécute la méthode correspondante à l'action souhaitée,
     * méthode nommée par convention "executeAction".
     * La requête HTTP est passée en paramètre à la méthode.
     */
    public function execute()
    {
        $methodName = 'execute' . ucfirst($this->action);
        if (!is_callable(array($this, $methodName)))
        {
            throw new \RuntimeException("Controller::execute : $this->action is not a known method.", self::UNKNOWN_ACTION);
        }
        return $this->$methodName($this->app->httpRequest());
    }

    /**
     * Setter du module
     * @param string $module Le nom du module
     */
    private function setModule($module)
    {
        if (empty($module) || !is_string($module))
        {
            throw new \InvalidArgumentException("Controller::setModule : $module is not a valid argument", self::BAD_MODULE);
        }
        $this->module = $module;
    }

    /**
     * Setter de l'action
     * @param string $action Le nom de l'action
     */
    private function setAction($action)
    {
        if (empty($action) || !is_string($action))
        {
            throw new \InvalidArgumentException("Controller::setAction : $action is not a valid argument", self::BAD_ACTION);
        }
        $this->action = $action;
    }

    /**
     * Setter de la vue
     * @param string $view Nom du fichier de la vue
     */
    public function setView($view)
    {
        if (empty($view) || !is_string($view))
        {
            throw new \InvalidArgumentException("Controller::setAction : $view is not a valid argument", self::BAD_VIEW);
        }
        $this->view   = $view;
        // Il faut également informé la Page que la vue a changé
        // Attention, la page attend le nom complet de la vue
        $viewFileName =
                // TODO : remplacer __DIR__ . "../.." par la racine du projet
                __DIR__ . "../.." . "/Applications/" . $this->app->name() . '/modules/' . $this->module . '/views/' . $this->view;
        $this->page->setView($viewFileName);
    }

    /**
     * Getter de la page
     * @return \lib\core\Page La page générée par le contrôleur
     */
    public function page()
    {
        return $this->page;
    }

}

?>
