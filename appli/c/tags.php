<?php

namespace Appli\C;

class Tags extends \MVC\Controleur {

    public static function all() {
        self::getVue()->tags = \Appli\M\Links::getInstance()->getAllTagsByUtilisation();
    }

    public static function linksBytag() {
        self::getVue()->links = \Appli\M\Links::getInstance()->getLinksByTag(\MVC\A::get('tag'));
    }
}
