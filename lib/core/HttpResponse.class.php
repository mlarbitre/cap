<?php

namespace lib\core;

/**
 * Classe représentant la réponse du serveur à la requête d’entrée.
 * Permet la redirection, l’ajout de "header" et l’envoi d’une page html en réponse.
 * @author M. l’Arbitre
 */
class HttpResponse extends ApplicationComponent
{

    /**
     * La page en réponse à la requête initiale
     * @var \lib\core\Page
     */
    protected $page;

    /**
     * Permet d'ajouter un header à la page
     * @param string $header Le header à ajouter
     */
    public function addHeader($header)
    {
        header($header);
    }

    /**
     * Permet de renvoyer vers une autre URL
     * @param string $location L’URL de redirection
     * @param int $time Le temps en secondes avant la redirection
     */
    public function redirect($location, $time = 0)
    {
        //On vérifie si aucun en-tête n'a déjà été envoyé    
        if (!headers_sent())
        {
            if ($time === 0)
            {
                header('Location: ' . $location);
            }
            else
            {
                header("refresh: $time;url=$location");
            }
            exit;
        }
        else
        {
            exit('<meta http-equiv="refresh" content="' . $time . ';url=' . $location . '"/>');
        }
    }

    /**
     * Permet de renvoyer vers une page d'erreur 404.
     * Le fichier correspondant à la vue est attendu dans
     * un dossier "errors" en racine de projet, et doit
     * être nommé "404.html".
     */
    public function redirect404()
    {
        // On crée une nouvelle page de réponse
        $this->page = new Page($this->app);
        // On lui affecte la vue 404.html
        $this->page->setView(__DIR__ . '../../errors/404.html');
        // On ajoute un header pour signaler l'erreur 404
        $this->addHeader('HTTP/1.0 404 Not Found');
        // On envoie la réponse
        $this->send();
    }

    /**
     * Envoie la page au client web en réponse de sa requête
     */
    public function send()
    {
        exit($this->page->getGeneratedPage());
    }

    /**
     * Permet d'affecter une page à l’attribut local page
     * @param \lib\core\Page $page La Page à affecter
     */
    public function setPage(Page $page)
    {
        $this->page = $page;
    }

    /**
     * Permet de créer un cookie
     * Remarque : par défaut httpOnly est à true (contrairement à la méthode standard setcookie())
     * @param string $name
     * @param string $value
     * @param int $expire
     * @param string $path
     * @param type $domain
     * @param type $secure
     * @param bool $httpOnly
     */
    public function setCookie($name, $value = '', $expire = 0, $path = null,
                              $domain = null, $secure = false, $httpOnly = true)
    {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
    }

}

?>
