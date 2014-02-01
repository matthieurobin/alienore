<?php

namespace Appli\C;

class Tags extends \MVC\Controleur {

    public static function all() {
        self::getVue()->tags = \Appli\M\Links::getInstance()->getAllTagsByUtilisation();
    }

    public static function linksBytag() {
        $links =  \Appli\M\Links::getInstance()->getLinksByTag(\MVC\A::get('tag'));
        self::getVue()->tag = \MVC\A::get('tag');
        self::getVue()->links = $links;
        self::getVue()->nbLinks = sizeof($links);
    }

    public static function delete() {
        if (\MVC\A::get('tag') != '') {
            $objLink = \Appli\M\Links::getInstance();
            $data = $objLink->deleteTag(\MVC\A::get('tag'));
            $objLink->setFileData($data);
            $objLink->saveData($data);
        }
        self::redirect('links', 'all');
    }

    public static function form() {
        self::getVue()->tag = \MVC\A::get('tag');
    }

    public static function saved() {
        if (\MVC\A::get('tagName') != '' and \MVC\A::get('tag') != '') {
            $newTagName = htmlspecialchars(\MVC\A::get('tagName'));
            $objLink = \Appli\M\Links::getInstance();
            $data = $objLink->editTagName($newTagName, \MVC\A::get('tag'));
            $objLink->setFileData($data);
            $objLink->saveData($data);
        }
        self::redirect('links', 'all');
    }

}
