<?php

namespace Appli\Controllers;

class Tags extends \MVC\Controller {

    public static function data_get(){
        self::getVue()->data = json_encode(\Appli\Models\Tag::getInstance()->get(\MVC\A::get('tagId')));
    }
    
    public static function data_all() {
        self::getVue()->data = json_encode( array('tags' => \Appli\Models\Tag::getInstance()->getAllTagsByUtilisation($_SESSION['idUser'])));
    }

    public static function saved() {
        if (\MVC\A::get('tagName') != '') {
            if(\MVC\A::get('tagId') != ''){
                $tag = \Appli\Models\Tag::getInstance()->get(\MVC\A::get('tagId'));
            }else{
                $tag = \Appli\Models\Tag::getInstance()->newItem();
            }
            $tag->label = htmlspecialchars(strtolower(trim(\MVC\A::get('tagName'))));
            //if the tag doesn't exist
            if(!\Appli\Models\Tag::getInstance()->getTagByLabel($tag->label, $_SESSION['idUser'])){
                $tag->store();
            }else{
                $_SESSION['errors']['danger'][] = \MVC\Language::T('The tag always exsits');
            }
            
        }
    }
    
    public static function data_searchTag(){
        $tags = \Appli\Models\Tag::getInstance()->getSearchTag(\MVC\A::get('search'),$_SESSION['idUser']);
        self::getVue()->data = json_encode($tags);
    }

    public static function data_linksByTag(){
        $tag = \Appli\Models\Tag::getInstance()->get(\MVC\A::get('tagId'));
        $nbLinks = \Appli\Models\Link::getInstance()->countLinksByTag($tag->id, $_SESSION['idUser'])->count;
        $pagination = \MVC\Pagination::buildPaging($nbLinks, 1);
        $links = \Appli\Models\Link::getInstance()->getLinksByTag($tag->id, $pagination['limit'], $_SESSION['idUser']);
        self::getVue()->data = json_encode($links);
    }

    public static function data_form(){
        $tag = \MVC\Display::displayTag(\Appli\Models\Tag::getInstance()->get(\MVC\A::get('tagId')));
        self::getVue()->data = json_encode($tag);
    }

}