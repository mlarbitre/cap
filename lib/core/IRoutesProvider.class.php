<?php

namespace lib\core;

/**
 * Contrat à respecter pour un fournisseur de routes acceptables pour une application
 * donnée
 * @author M. l’Arbitre
 */
interface IRoutesProvider
{
    /**
     * Fournit la liste des routes acceptables pour l'application
     * @return array Le tableau des routes disponibles pour l'application
     * @throws \RuntimeException 
     */
    function getAvailableRoutes();
}

?>
