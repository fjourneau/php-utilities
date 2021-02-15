<?php

namespace fjourneau\Utilities;


use DateTime;

/**
 * Useful functions for PHP dev.
 * List the main functions used by fjo.
 *
 * @package fjourneau\Utilities
 * @author    fJourneau
 */
class FjoUtilities
{

    /**
     * Converti la date interne passée en date courte format Fr.
     * Retourne par exemple : 01.11.2020
     * 
     * @param string Date au format interne (YYYY-MM-DD)
     * @param string Separateur (optionnel, par défaut '.')
     * @return string Date formatée.
     */
    public static function convertToShortDate($date, $separator = '.'): string
    {
        return date_format(date_create($date), "d" . $separator . "m" . $separator . 'Y');
    }

    /**
     * Converti la date interne passée en date medium format Fr.
     * Retourne par exemple : 01 nov. 2020
     * 
     * @param string Date au format interne (YYYY-MM-DD)
     * @return string Date formatée.
     */
    public static function convertToMediumDate($date): string
    {
        self::setlocaleTimeFr();
        $return = ucfirst(strftime("%d %b %Y", strtotime($date)));

        if (self::isWindowsServer()) $return = utf8_encode($return);  // Compatibilité avec Wamp server

        return $return;
    }

    /**
     * Converti la date interne passée en date longue format Fr.
     * Retourne par exemple : 01 novembre 2020
     * 
     * @param string Date au format interne (YYYY-MM-DD)
     * @return string Date formatée.
     */
    public static function convertToLongDate($date): string
    {
        self::setlocaleTimeFr();
        $return = strftime("%d %B %Y", strtotime($date));

        if (self::isWindowsServer()) $return = utf8_encode($return);  // Compatibilité avec Wamp server

        return $return;
    }

    /**
     * Converti la date interne passée en date longue format Fr.
     * Retourne par exemple : Dimanche 01 novembre 2020
     * 
     * @param string Date au format interne (YYYY-MM-DD)
     * @return string Date formatée.
     */
    public static function convertToLongDateWithDay($date): string
    {
        self::setlocaleTimeFr();
        $return = ucfirst(strftime("%A %d %B %Y", strtotime($date)));

        if (self::isWindowsServer()) $return = utf8_encode($return);  // Compatibilité avec Wamp server

        return $return;
    }

    /**
     * Converti la date externe passée en date interne (YYYY-MM-DD).
     * Par exemple : 21.11.2020 => 2020-11-21
     * 
     * @param string Date au format externe a spécifier
     * @param string Format externe (optionnel, par défaut 'j.m.Y')
     * @return string Date au format interne (YYYY-MM-DD).
     */
    public static function convertDateToInternal($external_date, $external_format = 'j.m.Y'): DateTime
    {
        return DateTime::createFromFormat($external_format, $external_date);
    }

    /**
     * Vérifie si le serveur PHP est un serveur Windows
     *
     * @return bool TRUE : serveur Windows, FALSE : serveur unixoide
     */
    public static function isWindowsServer(): bool
    {
        return strtolower(substr(PHP_OS, 0, 3)) == "win";
    }

    /**
     * Définie la configuration locale en Français
     */
    public static function setlocaleTimeFr()
    {
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
    }

    /**
     * Génère une clé aléatoire
     *
     * @param  int $nbCar Nombre de caractères aléatoire à générer
     * @return string
     */
    public static function generateRandomKey(int $nbCar = 32): string
    {
        $string = "";
        $chaine = "abcdefghijklmnpqrstuvwxy1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        srand((float)microtime() * 1000000);
        for ($i = 0; $i < $nbCar; $i++) {
            $string .= $chaine[rand() % strlen($chaine)];
        }
        return $string;
    }
}
