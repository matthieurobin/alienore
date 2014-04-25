<?php

namespace Appli\C;

class Links extends \MVC\Controleur {

    public static function all() {
        $tag = null;
        $search = null;
        $text = '';
        $page = (\MVC\A::get('page') != '') ? \MVC\A::get('page') : 1;
        if (\MVC\A::get('tagId')) {
            $tag = \Appli\M\Tag::getInstance()->get(\MVC\A::get('tagId'));
            $nbLinks = \Appli\M\Link::getInstance()->countLinksByTag($tag->id)->count;
            $pagination = \MVC\Pagination::buildPaging($nbLinks, $page);
            $links = \Appli\M\Link::getInstance()->getLinksByTag($tag->id, $pagination['limit']);
        } else if (\MVC\A::get('search')) {
            $search = htmlentities(trim(\MVC\A::get('search')));
            if(strlen($search) > 2){
                $nbLinks = \Appli\M\Link::getInstance()->countSearch($search)->count;
                $pagination = \MVC\Pagination::buildPaging($nbLinks, $page);
                $links = \Appli\M\Link::getInstance()->search($search, $pagination['limit']);
                $text = \MVC\Language::T('No results') . ' : "' . $search . '"';
            }
        } else {
            $nbLinks = \Appli\M\Link::getInstance()->countAll()->count;
            $pagination = \MVC\Pagination::buildPaging($nbLinks, $page);
            $links = \Appli\M\Link::getInstance()->getLinksForPage($pagination['limit']);
            $text = \MVC\Language::T('You do not have links already');
        }
        $linksToDisplay = [];
        //search tags of links
        for ($i = 0; $i < sizeof($links); ++$i) {
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

    public static function data_form() {
        $link = \Appli\M\Link::getInstance()->get(\MVC\A::get('id'));
        self::getVue()->link = json_encode(
                array('link' => $link,
                    'tags' => \Appli\M\Link::getInstance()->getLinkTags($link->id)));
    }

    public static function saved() {
        //TODO migration des tags
        if (\MVC\A::get('url') != '') {
            if (\MVC\A::get('linkId')) {
                $link = \Appli\M\Link::getInstance()->get(\MVC\A::get('linkId'));
            } else {
                $link = \Appli\M\Link::getInstance()->newItem();
                $link->linkdate = \MVC\Date::getDateNow();
            }
            $link->url = htmlentities(trim(\MVC\A::get('url')));
            $link->description = htmlentities(trim(\MVC\A::get('description')));
            $link->title = htmlentities(trim(\MVC\A::get('title')));
            $link->idUser = \Appli\M\user::getInstance()->getByUsername($_SESSION['user'])[0]->id;
            $link->store();
            //we look at the tags
            //$tags = explode(' ', htmlentities(trim(\MVC\A::get('tags'))));
            $tags = \MVC\A::get('tag');
            if ($tags[0] != '') { //even if there is no space, there is one result at the index 0
                for ($i = 0; $i < sizeof($tags); ++$i) {
                    $tag = \Appli\M\Tag::getInstance()->getTagByLabel($tags[$i])[0];
                    //if there is no result, we create the tag
                    if (!$tag) {
                        $tag = \Appli\M\Tag::getInstance()->newItem();
                        $tag->label = $tags[$i];
                        $tag->store();
                    }
                    //if taglist doesn't exist anymore
                    if (!\Appli\M\Taglink::getInstance()->exists($link->id, $tag->id)) {
                        $taglink = \Appli\M\Taglink::getInstance()->newItem();
                        $taglink->idTag = $tag->id;
                        $taglink->idLink = $link->id;
                        $taglink->store();
                    }
                }
            }
        }
    }

}
