<?php

namespace Appli\C;

class Tags extends \MVC\Controleur {

    public static function all() {
        $tags = \Appli\M\Tags::getInstance()->getAllTagsByUtilisation();
        $nbTags = sizeof($tags);
        $tagsByUse = [];
        if ($nbTags > 0) {
            $minSize = 14;
            $maxSize = 28;
            $max = $tags[0]->count;
            $min = end($tags)->count;
            $difference = ($max === $min) ? 1 : $max - $min;            
            for ($i = 0; $i < $nbTags; ++$i) {
                $nb = intval($tags[$i]->count);
                $label = $tags[$i]->label;
                $fontSize = intval($minSize + ($nb - $min) * (($maxSize - $minSize) / ($difference)));
                $tagsByUse[$label]['nbLinks'] = $nb;
                $tagsByUse[$label]['fontSize'] = $fontSize;
            }
        }else{
            self::getVue()->helper = \MVC\Language::T('You do not have any tag');
        }
        self::getVue()->tags = self::shuffle_assoc($tagsByUse);
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
