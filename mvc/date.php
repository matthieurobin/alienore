<?php

namespace MVC;

class Date extends \DateTime {

    public static function getDateNow() {
        return time();
    }
    
    public static function displayDate($date){
        $dateConverted = $date;
        date_default_timezone_set('UTC');
        switch (\Install\App::LANGUAGE) {
            case 'fr':
                $dateConverted = date("d/m/Y H:i:s", $date);
                break;
            default:
                $dateConverted = date("Y-m-d H:i:s", $date);
                break;
        }
        return $dateConverted;
    }

}
