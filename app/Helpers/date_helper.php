<?php

use CodeIgniter\I18n\Time;

if(!function_exists('format_date_fr')) {
    /**
     * Formate une date/time en français
     * @param Time|string|null $date date que l'on souhaite formater
     * @param string $format format ICU (ex: 'd/m/Y H:i', 'd MMMM yyy')
     * @return string
     */
    function format_date_fr($date, $format = "dd/MM/yyyy HH:mm"): string
    {
        if (empty($date)) {
            return "-";
        }
        if(! $date instanceof Time) {
            $date = Time::parse($date);
        }

        return $date->toLocalizedString($format);
    }
}

if(!function_exists('date_human_fr')) {
    /**
     * Formate une date/time sous forme relative (ex : "Il y a 2 heures")
     * @param Time|string|null $date date que l'on souhaite formater
     * @return string
     */
    function date_human_fr($date): string
    {
        if (empty($date)) {
            return "-";
        }
        if(! $date instanceof Time) {
            $date = Time::parse($date);
        }

        return $date->humanize();
    }
}