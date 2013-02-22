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

    const CLE_VIDE = 1;

    /**
     * Vérifie si $_GET contient la clé $key
     * @param string $key La clé cherchée dans le $_GET
     * @return True si $key est un indice défini dans $_GET
     */
    public function getExists($key)
    {
        if ($key == '')
        {
            throw new \InvalidArgumentException('HttpRequest::getExists : clé vide', HttpRequest::CLE_VIDE);
        }
        return (isset($_GET[$key])) ? true : false;
    }

}

?>
