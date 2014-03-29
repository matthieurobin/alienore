<?php

namespace MVC;

class Date extends \DateTime {

    public static function getDateNow() {
        return time();
    }
    
    public static function displayDate($date){
        $dateConverted = $date;
        switch (\Install\App::LANGUAGE) {
            case 'fr':
                $dateConverted = date("d/m/Y H:i:s", strtotime($date));
                break;
            default:
                $dateConverted = date("Y-m-d H:i:s", strtotime($date));
                break;
        }
        return $dateConverted;
    }

}
