<?php

namespace Appli\C;

class Links extends \MVC\Controleur {
    
    public static function all() {
        $links = [];
        $tag = null;
        $search = null;
        $text = '';
        if(\MVC\A::get('tag')){
            $tag = \MVC\A::get('tag');
            $links =  \Appli\M\Links::getInstance()->getLinksByTag($tag);
        }else if(\MVC\A::get('search')){
            $search = \MVC\A::get('search');
            $links = \Appli\M\Links::getInstance()->search($search);
            $text = \MVC\Language::T('No results').' : "'.$search.'"';
        }else{
            $links = \Appli\M\Links::getInstance()->getFileData();
            $text = \MVC\Language::T('You do not have links already');
        }
        $page = (\MVC\A::get('page') != '') ? \MVC\A::get('page') : 1;
        $links = array_reverse($links);
        self::getVue()->pagination = \MVC\Pagination::buildPaging($links,$page);
        self::getVue()->nbLinks = sizeof($links);
        self::getVue()->tag = $tag;
        self::getVue()->search = $search;
        self::getVue()->helper = $text;
    }

    public static function delete() {
        $linkToDelete= \Appli\M\Links::getInstance()->get(\MVC\A::get('id'));
        \Appli\M\Links::getInstance()->deleteLink($linkToDelete['linkdate']);
        \Appli\M\Links::getInstance()->saveData();
        \Appli\M\Page::getInstance()->deleteHtmlFile($linkToDelete['linkdate'],$linkToDelete['extensionfile']);
    }

    /*public static function form() {
        self::getVue()->link = \Appli\M\Links::getInstance()->get(\MVC\A::get('id'));
    }*/
    
   public static function data_form(){
        self::getVue()->link = json_encode(\Appli\M\Links::getInstance()->get(\MVC\A::get('id')));
    }

    public static function saved() {
        if (\MVC\A::get('url') != '') {
            if (\MVC\A::get('linkdate') != '') {
                $linkDate = \MVC\A::get('linkdate');
            } else {
                $linkDate = \MVC\Date::getDateNow();
            }
            $saved = \MVC\A::get('saved') == '' ? 0 : \MVC\A::get('saved');
            $url = htmlspecialchars(trim(\MVC\A::get('url')));
            $link = array(
                'title' => htmlspecialchars(trim(\MVC\A::get('title'))),
                'url' => $url,
                'description' => htmlspecialchars(trim(\MVC\A::get('description'))),
                'linkdate' => $linkDate,
                'tags' => strtolower(trim(htmlspecialchars(\MVC\A::get('tags')))),
                'saved' => $saved,
                'datesaved' => \MVC\A::get('datesaved'),
                'extensionfile' => \MVC\SavedLink::getInstance()->getExtension($url)
            );
            $linkObj = \Appli\M\Links::getInstance();
            $data = $linkObj->getFileData();
            $data[$linkDate] = $link;
            $linkObj->setFileData($data);
            $linkObj->saveData(); //save modifications
        }
    }
    
    public static function research(){
        
    }

}
