<?php

namespace lib\core;

// Avant toute chose, on ouvre la session
session_start();

/**
 * Classe représentant un utilisateur de l'application
 * @author M. l’Arbitre
 */
class User extends ApplicationComponent
{

    const USER_INDEX            = 'appUser';
    const AUTH                  = 'auth';
    const FLASH                 = 'flash';
    const INVALID_AUTH_ARGUMENT = 1;

    /**
     * Constructeur d'instance
     * @param \lib\core\Application $app L'application qu'utilise l'utilisateur
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
        if (!isset($_SESSION[self::USER_INDEX]))
        {
            $_SESSION[self::USER_INDEX] = array();
        }
    }

    /**
     * Définit si l'utilisateur est authentifié
     * @param bool $authenticated
     * @throws \InvalidArgumentException
     */
    public function setAuthenticated($authenticated = true)
    {
        if (!is_bool($authenticated))
        {
            throw new \InvalidArgumentException("\lib\core\User::setAuthenticated :  is not a valid argument.", self::INVALID_AUTH_ARGUMENT);
        }

        $_SESSION[self::USER_INDEX][self::AUTH] = $authenticated;
    }

    /**
     * Indique si l'utilisateur est authentifié
     * @return bool
     */
    public function isAuthenticated()
    {
        return (isset($_SESSION[self::USER_INDEX][self::AUTH])) ?
                $_SESSION[self::USER_INDEX][self::AUTH] :
                false;
    }

}

?>
