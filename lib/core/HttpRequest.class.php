<?php

namespace lib\core;

/**
 * Classe représentant une requête HTTP
 * Toutes les valeurs des propriétés de cette classe 
 * sont directement lues sur les variables globales 
 * serveur ($_POST, $_GET, $_SERVER…)
 * @author alexandre
 */
class HttpRequest
{

    const CLE_VIDE = 1; // Code d'erreur en cas de clé vide

    // <editor-fold defaultstate="collapsed" desc="$_GET">
    /**
     * Vérifie si $_GET contient la clé $key
     * @param string $key La clé cherchée dans le $_GET
     * @return bool True si $key est un indice défini dans $_GET
     * @expectedException InvalidArgumentException
     * @expectedExceptionCode HttpRequest::CLE_VIDE
     */

    public function getExists($key)
    {
        if ($key == '')
        {
            throw new \InvalidArgumentException('HttpRequest::getExists : clé vide', HttpRequest::CLE_VIDE);
        }
        return isset($_GET[$key]);
    }

    /**
     * Récupère la valeur de $_GET[$key]
     * @param string $key La clé dont on souhaite la valeur "GET"
     * @return string La valeur de $_GET[$key], null si non définie
     * @expectedException InvalidArgumentException
     * @expectedExceptionCode HttpRequest::CLE_VIDE
     */
    public function getData($key)
    {
        return ($this->getExists($key)) ? $_GET[$key] : null;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="$_POST">
    /**
     * Vérifie si $_POST contient la clé $key
     * @param string $key La clé cherchée dans le $_POST
     * @return bool True si $key est un indice défini dans $_POST
     * @expectedException InvalidArgumentException
     * @expectedExceptionCode HttpRequest::CLE_VIDE
     */

    public function postExists($key)
    {
        if ($key == '')
        {
            throw new \InvalidArgumentException('HttpRequest::postExists : clé vide', HttpRequest::CLE_VIDE);
        }
        return isset($_POST[$key]);
    }

    /**
     * Récupère la valeur de $_POST[$key]
     * @param string $key La clé dont on souhaite la valeur "POST"
     * @return string La valeur de $_POST[$key], null si non définie
     * @expectedException InvalidArgumentException
     * @expectedExceptionCode HttpRequest::CLE_VIDE
     */
    public function postData($key)
    {
        return ($this->postExists($key)) ? $_POST[$key] : null;
    }

    // </editor-fold>
}

?>
