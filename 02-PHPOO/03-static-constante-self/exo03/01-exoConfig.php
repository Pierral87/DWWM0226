<?php
/* 

    Créez une classe Config qui contiendra :

        Une constante APP_NAME qui stockera le nom de l'application.
        Une propriété statique $settings qui contiendra les paramètres globaux de l'application sous forme de key=>value (c'est un array) (comme le mode de débogage, ou l'URL de la base de données, mettez des infos aléatoires).
        Une méthode statique setSetting($key, $value) pour ajouter une valeur dans $settings.
        Une méthode statique getSetting($key) pour récupérer une valeur de $settings.
        Une méthode statique getAppName() qui retourne le nom de l'application stocké dans la constante.

        */


class Config
{
    // une const APP_NAME 
    private const APP_NAME = "MonApplication";
    // une prop static $settings 
    private static $settings = array("debut" => true, "db_url" => "localhost/....");

    // 3 méthodes static, setSetting, getSetting, getAppName 
    public static function setSetting($key, $value)
    {
        self::$settings[$key] = $value;
    }

    public static function getSetting($key)
    {
        // return isset(self::$settings[$key]) ? self::$settings[$key] : null; // Ici un if ternaire 
        return self::$settings[$key] ?? null;  // ici un isset ternaire

    }

    public static function getAppName()
    {
        return self::APP_NAME;
    }
}

// Utilisation 
echo "Nom de l'application : " . Config::getAppName() . "<br>";
echo "Url de la database : " . Config::getSetting("db_url") . "<hr>";

// Ajout d'un param dans settings avec le setter 
Config::setSetting("db_login", "root");
echo "Login de la database : " . Config::getSetting("db_login") . "<hr>";
