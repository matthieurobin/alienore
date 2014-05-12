<?php

namespace Appli\C;

class Links extends \MVC\Controleur {

    private static function prepareLinksTodisplay($links){
        $linksToDisplay = [];
        //search tags of links
        for ($i = 0; $i < sizeof($links); ++$i) {
            $linksToDisplay[$i]['link'] = $links[$i];
            $tags = \Appli\M\Link::getInstance()->getLinkTags($links[$i]->id, $_SESSION['idUser']);
            $linksToDisplay[$i]['tags'] = $tags;
        }
        return $linksToDisplay;
    }

    public static function data_getLinksByTag(){
        $page = (\MVC\A::get('page') != '') ? \MVC\A::get('page') : 1;
        $tag = \Appli\M\Tag::getInstance()->get(\MVC\A::get('tagId'));
        $nbLinks = \Appli\M\Link::getInstance()->countLinksByTag($tag->id, $_SESSION['idUser'])->count;
        $pagination = \MVC\Pagination::buildPaging($nbLinks, $page);
        $links = \Appli\M\Link::getInstance()->getLinksByTag($tag->id, $pagination['limit'], $_SESSION['idUser']);
        $linksToDisplay = self::prepareLinksTodisplay($links);
        self::getVue()->data = json_encode(array('links' => $linksToDisplay, 'page' => $page, 'nbPages' => $pagination['nbPages']));
    }

    public static function data_search(){
        $page = (\MVC\A::get('page') != '') ? \MVC\A::get('page') : 1;
        $search = htmlspecialchars(trim(\MVC\A::get('search')));
        if(strlen($search) > 2){
            $nbLinks = \Appli\M\Link::getInstance()->countSearch($search, $_SESSION['idUser'])->count;
            $pagination = \MVC\Pagination::buildPaging($nbLinks, $page);
            $links = \Appli\M\Link::getInstance()->search($search, $pagination['limit'], $_SESSION['idUser']);
            $text = \MVC\Language::T('No results') . ' : "' . $search . '"';
        }
        $linksToDisplay = self::prepareLinksTodisplay($links);
        self::getVue()->data = json_encode(array('links' => $linksToDisplay, 'page' => $page, 'nbPages' => $pagination['nbPages']));
    }

    public static function data_all(){
        $page = (\MVC\A::get('page') != '') ? \MVC\A::get('page') : 1;
        $nbLinks = \Appli\M\Link::getInstance()->countAll($_SESSION['idUser'])->count;
        $pagination = \MVC\Pagination::buildPaging($nbLinks, $page);
        $links = \Appli\M\Link::getInstance()->getLinksForPage($pagination['limit'], $_SESSION['idUser']);
        $text = \MVC\Language::T('You do not have links already');
        $linksToDisplay = self::prepareLinksTodisplay($links);
        self::getVue()->data = json_encode(array('links' => $linksToDisplay, 'page' => $page, 'nbPages' => $pagination['nbPages']));
    }

    public static function all() {
        $page = (\MVC\A::get('page') != '') ? \MVC\A::get('page') : 1;
        $nbLinks = \Appli\M\Link::getInstance()->countAll($_SESSION['idUser'])->count;
        $pagination = \MVC\Pagination::buildPaging($nbLinks, $page);
        $links = \Appli\M\Link::getInstance()->getLinksForPage($pagination['limit'], $_SESSION['idUser']);
        $text = \MVC\Language::T('You do not have links already');
        $linksToDisplay = self::prepareLinksTodisplay($links);
        self::getVue()->pagination = array('links' => $linksToDisplay, 'page' => $page, 'nbPages' => $pagination['nbPages']);
        self::getVue()->tags = \Appli\M\Tag::getInstance()->getAllTagsByUtilisation($_SESSION['idUser']);
        self::getVue()->nbLinks = $nbLinks;
        self::getVue()->helper = $text;
        self::getVue()->token = $_SESSION['token'];
    }

    public static function delete() {
        //si le token passé dans l'url est le même que celui de l'utilisateur
        if(\MVC\A::get('t') == $_SESSION['token']){
            \Appli\M\Link::getInstance()->get(\MVC\A::get('id'))->delete();
        }else{
            self::redirect('account','error');
        }
    }

    public static function data_form() {
        $link = \MVC\Display::displayLink(\Appli\M\Link::getInstance()->get(\MVC\A::get('id')));
        $tags = \Appli\M\Link::getInstance()->getLinkTags($link->id, $_SESSION['idUser']);
        self::getVue()->link = json_encode(
                array('link' => $link,
                    'tags' => $tags));
    }

    public static function saved() {
        if (\MVC\A::get('url') != '') {
            if (\MVC\A::get('linkId')) {
                $link = \Appli\M\Link::getInstance()->get(\MVC\A::get('linkId'));
                //on cherche les tags liés au lien
                $tagsLinkBefore = \Appli\M\TagLink::getInstance()->getTags($link->id);
            } else {
                $link = \Appli\M\Link::getInstance()->newItem();
                $link->linkdate = \MVC\Date::getDateNow();
            }
            $link->url = htmlspecialchars(trim(\MVC\A::get('url')));
            $link->description = htmlspecialchars(trim(\MVC\A::get('description')));
            $link->title = htmlspecialchars(trim(\MVC\A::get('title')));
            $link->idUser = $_SESSION['idUser'];
            $link->store();
            //we look at the tags
            $tags = \MVC\A::get('tag');
            $tagsLinkAfter = array();
            if ($tags[0] != '') { //even if there is no space, there is one result at the index 0
                for ($i = 0; $i < sizeof($tags); ++$i) {
                    $tag = \Appli\M\Tag::getInstance()->getTagByLabel(htmlspecialchars_decode($tags[$i]), $_SESSION['idUser'])[0];
                    //if there is no result, we create the tag
                    if (!$tag) {
                        $tag = \Appli\M\Tag::getInstance()->newItem();
                        $tag->label = $tags[$i];
                        $tag->store();
                    }
                    //if taglist doesn't exist anymore
                    if (!\Appli\M\Taglink::getInstance()->getTagLink($link->id, $tag->id)) {
                        $taglink = \Appli\M\Taglink::getInstance()->newItem();
                        $taglink->idTag = $tag->id;
                        $taglink->idLink = $link->id;
                        $taglink->store();
                        $tagsLinkAfter[] = $taglink;
                    }else{
                        $tagsLinkAfter[] = \Appli\M\Taglink::getInstance()->getTagLink($link->id, $tag->id)[0];
                    }
                } 
            }
            //on cherche les tags qui ont été supprimés
            $tagsLinkBeforeId = [];
            for($i = 0 ; $i < sizeof($tagsLinkBefore); ++$i){
                $tagsLinkBeforeId[] = $tagsLinkBefore[$i]->idTag; 
            }
            $tagsLinkAfterId = [];
            for($i = 0 ; $i < sizeof($tagsLinkAfter); ++$i){
                $tagsLinkAfterId[] = $tagsLinkAfter[$i]->idTag; 
            }
            $tagsLinkDeleted = array_diff($tagsLinkBeforeId,$tagsLinkAfterId);
            sort($tagsLinkDeleted);
            for($i = 0 ; $i < sizeof($tagsLinkDeleted); ++$i){
                $taglink = \Appli\M\Taglink::getInstance()->getTagLink($link->id, $tagsLinkDeleted[$i])[0];
                $taglink->deleteTagLink();
            }
        }
    }

}
