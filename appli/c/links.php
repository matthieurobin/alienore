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
        self::getVue()->data = json_encode(
            array('links' => $linksToDisplay, 
                'page' => $page, 
                'nbPages' => $pagination['nbPages'],
                'nbLinks' => $nbLinks,
                'token' => $_SESSION['token']
            ));
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
        self::getVue()->data = json_encode(
            array('links' => $linksToDisplay, 
                'page' => $page, 
                'nbPages' => $pagination['nbPages'],
                'nbLinks' => $nbLinks,
                'token' => $_SESSION['token'],
                'search' => $search
            ));
    }

    public static function data_all(){
        $page = (\MVC\A::get('page') != '') ? \MVC\A::get('page') : 1;
        $nbLinks = \Appli\M\Link::getInstance()->countAll($_SESSION['idUser'])->count;
        $pagination = \MVC\Pagination::buildPaging($nbLinks, $page);
        $links = \Appli\M\Link::getInstance()->getLinksForPage($pagination['limit'], $_SESSION['idUser']);
        $text = \MVC\Language::T('You do not have links already');
        $linksToDisplay = self::prepareLinksTodisplay($links);
        self::getVue()->data = json_encode(
            array('links' => $linksToDisplay, 
                'page' => $page, 
                'nbPages' => $pagination['nbPages'],
                'nbLinks' => $nbLinks,
                'token' => $_SESSION['token']
            ));
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

    public static function data_delete() {
        //si le token passé dans l'url est le même que celui de l'utilisateur
        if(\MVC\A::get('t') == $_SESSION['token']){  
            $tags = array();
            $link = \Appli\M\Link::getInstance()->get(\MVC\A::get('id'));
            $tags = \Appli\M\Link::getInstance()->getLinkTags($link->id, $_SESSION['idUser']);
            $link->delete();
            //on retourne les tags pour le js
            self::getVue()->data = json_encode(
                array('tags' => array('deleted' => $tags)));
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

    public static function data_saved() {
        if (\MVC\A::get('url') != '') {
            $isEdit = 0;
            if (\MVC\A::get('linkId')) {
                $link = \Appli\M\Link::getInstance()->get(\MVC\A::get('linkId'));
                //on cherche les tags liés au lien avant l'édition
                $tagsLinkBefore = \Appli\M\TagLink::getInstance()->getTags($link->id);
                $isEdit = 1;
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
            $tagsLinkAfterId = array();
            $tagsNew = array();
            if ($tags[0] != '') { //even if there is no space, there is one result at the index 0
                for ($i = 0; $i < sizeof($tags); ++$i) {
                    $tag = \Appli\M\Tag::getInstance()->getTagByLabel(htmlspecialchars_decode($tags[$i]));
                    //if there is no result, we create the tag
                    if (!$tag) {
                        $tag = \Appli\M\Tag::getInstance()->newItem();
                        $tag->label = htmlspecialchars((trim($tags[$i])));
                        $tag->store();
                        $tagsNew[] = $tag;
                    }else{
                        $tag = $tag[0];
                    }
                    //if taglist doesn't exist anymore
                    if (!\Appli\M\Taglink::getInstance()->getTagLink($link->id, $tag->id)) {
                        $taglink = \Appli\M\Taglink::getInstance()->newItem();
                        $taglink->idTag = $tag->id;
                        $taglink->idLink = $link->id;
                        $taglink->store();
                        $tagsLinkAfterId[] = $taglink->idTag;
                    }else{
                        $tagsLinkAfterId[] = \Appli\M\Taglink::getInstance()->getTagLink($link->id, $tag->id)[0]->idTag;
                    }
                } 
            }
            $tagsNoChange = array();
            $tagsAdded = array();
            $tagsDeleted = array();
            if($isEdit){
                $tagsLinkBeforeId = [];
                for($i = 0 ; $i < sizeof($tagsLinkBefore); ++$i){
                    $tagsLinkBeforeId[] = $tagsLinkBefore[$i]->idTag; 
                }
                //on cherche les tags supprimés
                $tagsLinkDeleted = array_diff($tagsLinkBeforeId,$tagsLinkAfterId);
                sort($tagsLinkDeleted); //on trie pour supprimer la clé précédente
                
                for($i = 0 ; $i < sizeof($tagsLinkDeleted); ++$i){
                    $taglink = \Appli\M\Taglink::getInstance()->getTagLink($link->id, $tagsLinkDeleted[$i])[0];
                    $taglink->deleteTagLink();
                    $tagsDeleted[] = \Appli\M\Tag::getInstance()->get($tagsLinkDeleted[$i]);
                }
                //on cherche les tags ajoutés
                $tagsLinkAdded = array_diff($tagsLinkAfterId, $tagsLinkBeforeId);
                sort($tagsLinkAdded);
                for($i = 0; $i < sizeof($tagsLinkAdded); ++$i){
                    $tagsAdded[] = \Appli\M\Tag::getInstance()->get($tagsLinkAdded[$i]);
                }
                //on cherche les tags qui n'ont pas été modifiés
                $tagsLinkNoChange = array_intersect($tagsLinkAfterId, $tagsLinkBeforeId);
                sort($tagsLinkNoChange);
                for($i = 0; $i < sizeof($tagsLinkNoChange); ++$i){
                    $tagsNoChange[] = \Appli\M\Tag::getInstance()->get($tagsLinkNoChange[$i]);
                }
            }else{
                $tagsAdded = \Appli\M\Link::getInstance()->getLinkTags($link->id, $_SESSION['idUser']);
            }
            $tags = \Appli\M\Link::getInstance()->getLinkTags($link->id, $_SESSION['idUser']);
            //on retourne le lien pour le js
            self::getVue()->data = json_encode(
                array('link' => $link,
                    'tags' => array('deleted' => $tagsDeleted,
                                    'added' => $tagsAdded,
                                    'default' => $tagsNoChange,
                                    'new' => $tagsNew),
                    'isEdit' => $isEdit,
                    'token' => $_SESSION['token']
                ));
        }
    }

}
