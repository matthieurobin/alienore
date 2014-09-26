<?php

namespace MVC;

class Date extends \DateTime {

    public static function getDateNow() {
        return date("Y-m-d H:i:s");
    }
    
    public static function displayDate($date){
        $dateConverted = $date;
        switch (\Config\App::LANGUAGE) {
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
