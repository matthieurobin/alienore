<?php

namespace Appli\C;

class Tags extends \MVC\Controleur {

    public static function all() {
        $tags = \Appli\M\Links::getInstance()->getAllTagsByUtilisation();
        $minSize = 14; 
        $maxSize = 20;
        $max = current($tags); 
        $min = end($tags);
        $difference = ($max === $min) ? 1: $max - $min;
        $tagsByUse = [];
        foreach ($tags as $key => $nbTag){
            $fontSize = intval($minSize + (($nbTag - $min) * (($maxSize - $minSize) / ($difference))));
            $tagsByUse[$key]['nbLinks'] = $nbTag;
            $tagsByUse[$key]['fontSize'] = $fontSize;
        }
        self::getVue()->tags = $tagsByUse;
        self::getVue()->nbTags = sizeof($tags);
    }

    public static function delete() {
        if (\MVC\A::get('tag') != '') {
            $objLink = \Appli\M\Links::getInstance();
            $data = $objLink->deleteTag(\MVC\A::get('tag'));
            $objLink->setFileData($data);
            $objLink->saveData($data);
        }
    }

    public static function form() {
        self::getVue()->tag = \MVC\A::get('tag');
    }

    public static function saved() {
        if (\MVC\A::get('tagName') != '' and \MVC\A::get('tag') != '') {
            $newTagName = strtolower(trim(htmlspecialchars(\MVC\A::get('tagName'))));
            $objLink = \Appli\M\Links::getInstance();
            $data = $objLink->editTagName($newTagName, \MVC\A::get('tag'));
            $objLink->setFileData($data);
            $objLink->saveData($data);
        }
    }

}
