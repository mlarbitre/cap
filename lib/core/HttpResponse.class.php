<?php

namespace lib\core;

/**
 * Classe représentant la réponse du serveur à la requête d’entrée.
 * Permet la redirection, l’ajout de "header" et l’envoi d’une page html en réponse.
 * @author M. l’Arbitre
 */
class HttpResponse
{
    /**
     * 
     * @var \lib\core\Page La page en réponse à la requête initiale
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
     */
    public function redirect($location)
    {
        header('Location: ' . $location);
        exit;
    }

    /**
     * Permet de renvoyer vers une page d'erreur 404
     * @todo Implémenter la méthode pour page 404
     */
    public function redirect404()
    {
        throw new \Exception;
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
