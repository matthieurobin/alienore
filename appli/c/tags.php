<?php

namespace Appli\C;

class Tags extends \MVC\Controleur {

    public static function all() {
        self::getVue()->tags = \Appli\M\Links::getInstance()->getAllTagsByUtilisation();
    }

    public static function linksBytag() {
        self::getVue()->links = \Appli\M\Links::getInstance()->getLinksByTag(\MVC\A::get('tag'));
    }

    public static function delete() {
    }

    public static function form() {
        self::getVue()->tag = \MVC\A::get('tag');
    }

    public static function saved() {
        if (\MVC\A::get('tagName') != '' and \MVC\A::get('tag') != '') {
            $newTagName = htmlspecialchars(\MVC\A::get('tagName'));
            $objLink = \Appli\M\Links::getInstance();
            $data = $objLink->editTagName($newTagName,\MVC\A::get('tag'));
            $objLink->setFileData($data);
            $objLink->saveData($data);
        }
    }

}
