<?php

namespace lib\core;

/**
 * Classe décrivant une page HTML à retourner au client
 * @author M. l’Arbitre
 */
class Page extends ApplicationComponent
{

    const INVALID_KEY    = 0; // Si la clé n'est pas une chaîne de caractères alphanumérique
    const INVALID_VIEW   = 1; // Si le nom de fichier de vue n'est pas une chaîne de caractères alphanumérique
    const VIEW_NOT_FOUND = 2; // Si la vue précisée n'existe pas

    /**
     * Le nom de la "vue" à intégrer à la page
     * @var string 
     */

    protected $view;

    /**
     * Les données à intégrer à la vue
     * @var array 
     */
    protected $vars = array();

    /**
     * Ajoute une donnée pour la vue
     * @param string $key La clé de la donnée
     * @param mixed $value La valeur de la donnée
     * @throws \InvalidArgumentException
     */
    public function addVar($key, $value)
    {
        if (!is_string($key) || empty($key) || is_numeric($key))
        {
            throw new \InvalidArgumentException('\lib\core\Page::addVar : $key must be a string', self::INVALID_KEY);
        }

        $this->vars[$key] = $value;
    }

    /**
     * Définit la vue à utiliser pour générer la page
     * @param string $view Le nom complet du fichier à utiliser
     * @throws \InvalidArgumentException
     */
    public function setView($view)
    {
        if (!is_string($view) || empty($view) || is_numeric($view))
        {
            throw new \InvalidArgumentException('\lib\core\Page::setView : $view must be a string', self::INVALID_VIEW);
        }

        $this->view = $view;
    }

    /**
     * Génère et retourne la page html à afficher.
     * Le layout utilisé doit utiliser la variable $content
     * @return string La page html générée
     * @throws \RuntimeException
     */
    public function getGeneratedPage()
    {
        if (!file_exists($this->view))
        {
            throw new \RuntimeException('\lib\core\Page::getGeneratedPage : view not found', self::VIEW_NOT_FOUND);
        }

        extract($this->vars);

        // On commence par récupérer la vue
        ob_start();
        require $this->view;
        $content = ob_get_clean();

        // Puis on l'insère dans le layout
        // Le layout doit contenir une variable $content,
        // et être stocké dans le répertoire templates de l'application
        ob_start();
        require __DIR__ . '/../..' . '/apps/' . $this->app->name() . '/templates/layout.php';
        return ob_get_clean();
    }

}

?>
