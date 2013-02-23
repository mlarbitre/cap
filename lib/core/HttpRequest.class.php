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
    // Codes d'erreur
    const EMPTY_KEY      = 1; // Code d'erreur en cas de clé vide
    const ARRAY_EXPECTED = 2; // Code d'erreur en cas de tableau attendu non obtenu

    /**
     * Détermine si une valeur est définie à l'index $key du tableau $table
     * @param string $key L'index où chercher
     * @param array $table Le tableau dans lequel on cherche
     * @return bool TRUE si la valeur est définie, FALSE sinon
     * @throws \InvalidArgumentException
     */
    private function dataExists($key, $table)
    {
        if ($key == '')
        {
            throw new \InvalidArgumentException('HttpRequest::dataExists : empty key', HttpRequest::EMPTY_KEY);
        }
        if (!is_array($table))
        {
            throw new \InvalidArgumentException('HttpRequest::dataExists : table expected', HttpRequest::ARRAY_EXPECTED);
        }

        return isset($table[$key]);
    }

    /**
     * Retourne la valeur définie à l'index $key du tableau $table
     * @param string $key L'index où chercher
     * @param array $table Le tableau dans lequel on cherche
     * @return string La valeur trouvée
     */
    private function data($key, $table)
    {
        return ($this->dataExists($key, $table)) ? $table[$key] : null;
    }

    // <editor-fold defaultstate="collapsed" desc="$_GET">
    /**
     * Vérifie si $_GET contient la clé $key
     * @param string $key La clé cherchée dans le $_GET
     * @return bool True si $key est un indice défini dans $_GET
     */
    public function getExists($key)
    {
        return $this->dataExists($key, $_GET);
    }

    /**
     * Récupère la valeur de $_GET[$key]
     * @param string $key La clé dont on souhaite la valeur "GET"
     * @return string La valeur de $_GET[$key], null si non définie
     */
    public function getData($key)
    {
        return $this->data($key, $_GET);
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="$_POST">
    /**
     * Vérifie si $_POST contient la clé $key
     * @param string $key La clé cherchée dans le $_POST
     * @return bool True si $key est un indice défini dans $_POST
     */
    public function postExists($key)
    {
        return $this->dataExists($key, $_POST);
    }

    /**
     * Récupère la valeur de $_POST[$key]
     * @param string $key La clé dont on souhaite la valeur "POST"
     * @return string La valeur de $_POST[$key], null si non définie
     */
    public function postData($key)
    {
        return $this->data($key, $_POST);
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="$_COOKIE">
    /**
     * Vérifie si $_COOKIE contient la clé $key
     * @param string $key La clé cherchée dans le $_COOKIE
     * @return bool True si $key est un indice défini dans $_COOKIE
     */
    public function cookieExists($key)
    {
        return $this->dataExists($key, $_COOKIE);
    }

    /**
     * Récupère la valeur de $_COOKIE[$key]
     * @param string $key La clé dont on souhaite la valeur "COOKIE"
     * @return string La valeur de $_COOKIE[$key], null si non définie
     */
    public function cookieData($key)
    {
        return $this->data($key, $_COOKIE);
    }

    // </editor-fold>
}

?>
