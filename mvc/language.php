<?php

namespace MVC;

abstract class Language {
    public static $lang = array(); 

    public static function loadLanguage($language = null){
        if($language){
            self::$lang[(string) $language] = include \Install\Path::LANGUAGE . $language.'.php';
        }else{
            self::$lang[(string) \Install\App::LANGUAGE] = include \Install\Path::LANGUAGE . \Install\App::LANGUAGE.'.php';
        }
    }
    
    public static function T($expression){
        if(isset($_SESSION['language'])){
            if (!isset(self::$lang[$_SESSION['language']])) self::loadLanguage($_SESSION['language']);
            return self::$lang[$_SESSION['language']][$expression];
        }else{
            return self::$lang[\Install\App::LANGUAGE][$expression];
        }
        
    }
}
