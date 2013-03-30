<?php

namespace lib\core;

/**
 * Classe de gestion de la configuration d'une application
 * @author M. l’Arbitre
 */
class Config extends ApplicationComponent
{

    const INVALID_FILENAME       = 1;
    const INVALID_FILE           = 2;
    const INVALID_ASKED_VARIABLE = 3;

    /**
     * Tableau des éléments de configuration
     * @var array 
     */
    protected $vars;

    /**
     * Le nom complet du fichier de configuration
     * @var string 
     */
    protected $configFileName;

    /**
     * Constructeur d'instance
     * @param \lib\core\Application $app L'application dont dépend l'élément
     * @param string $configFileName Le nom complet du fichier de configuration
     */
    public function __construct(Application $app, $configFileName = '')
    {
        parent::__construct($app);
        if ($configFileName !== '')
        {
            $this->setConfigFileName($configFileName);
        }
    }

    /**
     * Setter de $configFileName
     * @param string $configFileName Le nom complet du fichier de configuration
     * @throws \InvalidArgumentException Si le nom donné n'est pas une chaîne de caractères ou est vide
     */
    public function setConfigFileName($configFileName)
    {
        if (empty($configFileName) || !is_string($configFileName))
        {
            throw new \InvalidArgumentException("Config::setConfigFileName : invalid argument ($configFileName)", self::INVALID_FILENAME);
        }
        $this->configFileName = $configFileName;
    }

    /**
     * Donne la valeur de la variable de paramétrage passée en paramètre
     * @param string $varName Le nom de la variable de paramétrage à lire
     * @return string La valeur de la variable de paramétrage
     */
    public function get($varName)
    {
        if (empty($varName) || !is_string($varName))
        {
            throw new \InvalidArgumentException("lib\core\Config::get : $varName is not a valid argument", self::INVALID_ASKED_VARIABLE);
        }

        if (!$this->vars)
        {
            if (!is_file($this->configFileName))
            {
                throw new \RuntimeException("Config::get : $this->configFileName is not a valid file", self::INVALID_FILE);
            }

            // Chargement unique du fichier XML de configuration
            $configFile = new \DOMDocument();
            $configFile->load($this->configFileName);

            /* @var $elements \DOMNodeList */
            $elements = $configFile->getElementsByTagName('define');
            foreach ($elements as $element)
            {
                /* @var $element \DOMElement */
                $this->vars[$element->getAttribute('var')] = $element->getAttribute('value');
            }
        }

        if (isset($this->vars[$varName]))
        {
            return $this->vars[$varName];
        }
        return null;
    }

}

?>
