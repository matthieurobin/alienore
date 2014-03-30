<?php

namespace Appli\C;

class Links extends \MVC\Controleur {
    
    public static function all() {
        $tag = null;
        $search = null;
        $text = '';
        $page = (\MVC\A::get('page') != '') ? \MVC\A::get('page') : 1;
        if(\MVC\A::get('tagId')){
            $tag = \Appli\M\Tag::getInstance()->get(\MVC\A::get('tagId'));
            $nbLinks = \Appli\M\Link::getInstance()->countLinksByTag($tag->id)->count;
            $pagination = \MVC\Pagination::buildPaging($nbLinks, $page);
            $links =  \Appli\M\Link::getInstance()->getLinksByTag($tag->id, $pagination['limit']);
        }else if(\MVC\A::get('search')){
            $search = htmlspecialchars(trim(\MVC\A::get('search')));
            $nbLinks = \Appli\M\Link::getInstance()->countSearch($search)->count;
            $pagination = \MVC\Pagination::buildPaging($nbLinks, $page);
            $links = \Appli\M\Link::getInstance()->search($search, $pagination['limit']);
            $text = \MVC\Language::T('No results').' : "'.$search.'"';
        }else{
            $nbLinks = \Appli\M\Link::getInstance()->countAll()->count;
            $pagination = \MVC\Pagination::buildPaging($nbLinks, $page);
            $links = \Appli\M\Link::getInstance()->getLinksForPage($pagination['limit']);
            $text = \MVC\Language::T('You do not have links already');
        }
        $links = array_reverse($links);
        $linksToDisplay = [];
        //search tags of links
        for($i = 0; $i < sizeof($links); ++$i){
            $linksToDisplay[$i]['link'] = $links[$i];
            $linksToDisplay[$i]['tags'] = \Appli\M\Link::getInstance()->getLinkTags($links[$i]->id);
        }
        self::getVue()->pagination = array('links' => $linksToDisplay, 'page' => $page, 'nbPages' => $pagination['nbPages']);
        self::getVue()->nbLinks = $nbLinks;
        self::getVue()->helper = $text;
        self::getVue()->tag = $tag;
        self::getVue()->search = $search;
    }

    public static function delete() {
        \Appli\M\Link::getInstance()->get(\MVC\A::get('id'))->delete();
    }

   public static function data_form(){
        self::getVue()->link = json_encode(\Appli\M\Link::getInstance()->get(\MVC\A::get('id')));
    }

    public static function saved() {
        //à migrer vers SQL
        /*if (\MVC\A::get('url') != '') {
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
            $linkObj = \Appli\M\Link::getInstance();
            $data = $linkObj->getFileData();
            $data[$linkDate] = $link;
            $linkObj->setFileData($data);
            $linkObj->saveData(); //save modifications
        }*/
    }
    
    public static function research(){
        
    }

}
