<?php

namespace Appli\C;

class Tags extends \MVC\Controleur {

    public static function all() {
        $tags = \Appli\M\Tag::getInstance()->getAllTagsByUtilisation();
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
                $tagsByUse[$i]['tag'] = $tags[$i];
                $tagsByUse[$i]['nbLinks'] = $nb;
                $tagsByUse[$i]['fontSize'] = $fontSize;
            }
        }else{
            self::getVue()->helper = \MVC\Language::T('You do not have any tag');
        }
        shuffle($tagsByUse);
        self::getVue()->tags = $tagsByUse;
        self::getVue()->nbTags = $nbTags;
    }

    public static function saved() {
        if (\MVC\A::get('tagName') != '') {
            if(\MVC\A::get('tagId') != ''){
                $tag = \Appli\M\Tag::getInstance()->get(\MVC\A::get('tagId'));
            }else{
                $tag = \Appli\M\Tag::getInstance()->newItem();
            }
            $tag->label = strtolower(htmlentities(trim(\MVC\A::get('tagName'))));
            //if the tag doesn't exist
            if(!\Appli\M\Tag::getInstance()->getTagByLabel($tag->label)){
                $tag->store();
            }else{
                $_SESSION['errors']['danger'][] = \MVC\Language::T('The tag always exsits');
            }
            
        }
    }
    
    public static function data_searchTag(){
        self::getVue()->data = json_encode(\Appli\M\Tag::getInstance()->getSearchTag(\MVC\A::get('search')));
    }

}
