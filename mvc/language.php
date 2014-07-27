<?php

namespace MVC;

abstract class Language {
    public static $lang = array();

    public static function loadLanguage($language = null){
        if($language){
            self::$lang[(string) $language] = include \Config\Path::LANGUAGE . $language.'.php';
        }else{
            self::$lang[(string) \Config\App::LANGUAGE] = include \Config\Path::LANGUAGE . \Config\App::LANGUAGE.'.php';
        }
    }
    
    public static function T($expression){
        if(isset($_SESSION['language'])){
            if (!isset(self::$lang[$_SESSION['language']])) self::loadLanguage($_SESSION['language']);
            return self::$lang[$_SESSION['language']][$expression];
        }else{
            return self::$lang[\Config\App::LANGUAGE][$expression];
        }
        
    }
}
