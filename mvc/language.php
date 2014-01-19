<?php

namespace MVC;

abstract class Language {
    private static $lang; 

    public static function loadLanguage(){
        self::$lang = include \Install\Path::LANGUAGE . \Install\App::LANGUAGE.'.php';
    }
    
    public static function T($expression){
        return self::$lang[$expression];
    } 
}
