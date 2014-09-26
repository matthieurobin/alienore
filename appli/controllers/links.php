<?php

namespace Appli\Controllers;

class Links extends \MVC\Controller {

    /**
     * search links' tags
     * @param  array  $links
     * @param  boolean $isForm : if it is for a form, we call the displayLink method to decode htmlspecialchars
     * @return array : array(array('link' => object, 'tags' => []))
     */
    private static function prepareLinksTodisplay($links,$isForm = false){
        $linksToDisplay = [];
        //search tags of links
        for ($i = 0; $i < sizeof($links); ++$i) {
            $linksToDisplay[$i]['link'] = $links[$i];
            if($isForm){
                $linksToDisplay[$i]['link'] = \MVC\Display::displayLink($links[$i]);
            }
            $tags = \Appli\Models\Link::getInstance()->getLinkTags($links[$i]->id, $_SESSION['idUser']);
            $linksToDisplay[$i]['tags'] = $tags;
        }
        return $linksToDisplay;
    }

    /**
     * chercher les liens identifiés par les tags
     */
    public static function data_getLinksByTags(){
        //le js nous renvoie une chaine d'id des tags sélectionnés ex : 1,2,6
        $page = (\MVC\A::get('page') != '') ? \MVC\A::get('page') : 1;
        $tags = explode(',',\MVC\A::get('tagsId'));
        if(sizeof($tags)<=3){
            $nbLinks = \Appli\Models\Link::getInstance()->countLinksByTags($tags, $_SESSION['idUser'])->count;
            $pagination = \MVC\Pagination::buildPaging($nbLinks, $page);
            $links = \Appli\Models\Link::getInstance()->getLinksByTags($tags, $pagination['limit'], $_SESSION['idUser']);
            $linksToDisplay = self::prepareLinksTodisplay($links);
            self::getVue()->data = json_encode(
                array('links' => $linksToDisplay, 
                    'page' => $page, 
                    'nbPages' => $pagination['nbPages'],
                    'nbLinks' => $nbLinks,
                    'token' => $_SESSION['token'],
                    ));
        }else{
            self::getVue()->data = json_encode(
            array('error' => true,
                'text' => \MVC\Language::T('You already have 3 tags selected, deselect one of them or all')
                ));
        }
    }


    public static function data_search(){
        $page = (\MVC\A::get('page') != '') ? \MVC\A::get('page') : 1;
        $search = htmlspecialchars(trim(\MVC\A::get('search')));
        $nbLinks = 0;
        $pagination['nbPages'] = 0;
        $links = array();
        if(strlen($search) > 2){
            $nbLinks = \Appli\Models\Link::getInstance()->countSearch($search, $_SESSION['idUser'])->count;
            $pagination = \MVC\Pagination::buildPaging($nbLinks, $page);
            $links = \Appli\Models\Link::getInstance()->search($search, $pagination['limit'], $_SESSION['idUser']);
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

    /**
     * méthode appelée lors de l'initialisation de l'accueil
     * @return [type] [description]
     */
    public static function data_all(){
        $page = (\MVC\A::get('page') != '') ? \MVC\A::get('page') : 1;
        $nbLinks = \Appli\Models\Link::getInstance()->countAll($_SESSION['idUser'])->count;
        $pagination = \MVC\Pagination::buildPaging($nbLinks, $page);
        $links = \Appli\Models\Link::getInstance()->getLinksForPage($pagination['limit'], $_SESSION['idUser']);
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

    /**
     * cherche le lien identifié par linkId pour l'afficher dans le formulaire
     * @return [type] [description]
     */
    public static function data_get(){
        self::getVue()->data = json_encode(self::prepareLinksTodisplay(array(\Appli\Models\Link::getInstance()->get(\MVC\A::get('linkId'))),true)[0]);
    }

    /**
     * action par défaut de l'application
     */
    public static function all() {
        $text = \MVC\Language::T('No links');
        self::getVue()->helper = $text;
    }

    /**
     * supprimer un lien
     */
    public static function data_delete() {
        //si le token passé dans l'url est le même que celui de l'utilisateur
        if(\MVC\A::get('t') == $_SESSION['token']){  
            $tags = array();
            $link = \Appli\Models\Link::getInstance()->get(\MVC\A::get('id'));
            $tags = \Appli\Models\Link::getInstance()->getLinkTags($link->id, $_SESSION['idUser']);
            $link->delete();
            //on retourne les tags pour le js
            self::getVue()->data = json_encode(array(
                'tags' => array('deleted' => $tags),
                'text' => \MVC\Language::T('The link was successfully deleted')
                ));
        }else{
            //self::redirect('account','text');
        }
        
    }

    /**
     * méthode appelée lors de l'édition/création d'un lien
     */
    public static function data_saved() {
        if (\MVC\A::get('url') != '') {
            $isEdit = 0;
            $textToDisplay = '';
            if (\MVC\A::get('linkId')) {
                $link = \Appli\Models\Link::getInstance()->get(\MVC\A::get('linkId'));
                //on cherche les tags liés au lien avant l'édition
                $tagsLinkBefore = \Appli\Models\TagLink::getInstance()->getTags($link->id);
                $isEdit = 1;
                $textToDisplay = \MVC\Language::T('The link was successfully edited');
            } else {
                $link = \Appli\Models\Link::getInstance()->newItem();
                $link->linkdate = \MVC\Date::getDateNow();
                $textToDisplay = \MVC\Language::T('The link was successfully saved');
            }
            $link->url = htmlspecialchars(trim(\MVC\A::get('url')));
            $link->description = htmlspecialchars(trim(\MVC\A::get('description')));
            $link->title = htmlspecialchars(trim(\MVC\A::get('title')));
            $link->idUser = $_SESSION['idUser'];
            $link->store();
            //we look at the tags
            $tags = \MVC\A::get('tags');
            $tagsLinkAfterId = array();
            $tagsNew = array();
            if ($tags[0] != '') { //even if there is no space, there is one result at the index 0
                for ($i = 0; $i < sizeof($tags); ++$i) {
                    $tag = \Appli\Models\Tag::getInstance()->getTagByLabel(htmlspecialchars_decode($tags[$i]));
                    //if there is no result, we create the tag
                    if (!$tag) {
                        $tag = \Appli\Models\Tag::getInstance()->newItem();
                        $tag->label = htmlspecialchars((trim($tags[$i])));
                        $tag->store();
                        $tagsNew[] = $tag;
                    }else{
                        $tag = $tag[0];
                    }
                    //if taglist doesn't exist anymore
                    if (!\Appli\Models\Taglink::getInstance()->getTagLink($link->id, $tag->id)) {
                        $taglink = \Appli\Models\Taglink::getInstance()->newItem();
                        $taglink->idTag = $tag->id;
                        $taglink->idLink = $link->id;
                        $taglink->store();
                        $tagsLinkAfterId[] = $taglink->idTag;
                    }else{
                        $tagsLinkAfterId[] = \Appli\Models\Taglink::getInstance()->getTagLink($link->id, $tag->id)[0]->idTag;
                    }
                } 
            }
            $tagsNoChange = array();
            $tagsAdded = array();
            $tagsDeleted = array();
            //si c'est une édition
            if($isEdit){
                $tagsLinkBeforeId = [];
                for($i = 0 ; $i < sizeof($tagsLinkBefore); ++$i){
                    $tagsLinkBeforeId[] = $tagsLinkBefore[$i]->idTag; 
                }
                //on cherche les tags supprimés
                $tagsLinkDeleted = array_diff($tagsLinkBeforeId,$tagsLinkAfterId);
                sort($tagsLinkDeleted); //on trie pour supprimer la clé précédente
                //on supprime les tags dans la bdd
                for($i = 0 ; $i < sizeof($tagsLinkDeleted); ++$i){
                    $taglink = \Appli\Models\Taglink::getInstance()->getTagLink($link->id, $tagsLinkDeleted[$i])[0];
                    $taglink->deleteTagLink();
                    $tagsDeleted[] = \Appli\Models\Tag::getInstance()->get($tagsLinkDeleted[$i]);
                }
                //on cherche les tags ajoutés
                $tagsLinkAdded = array_diff($tagsLinkAfterId, $tagsLinkBeforeId);
                sort($tagsLinkAdded);
                for($i = 0; $i < sizeof($tagsLinkAdded); ++$i){
                    $tagsAdded[] = \Appli\Models\Tag::getInstance()->get($tagsLinkAdded[$i]);
                }
                //on cherche les tags qui n'ont pas été modifiés
                $tagsLinkNoChange = array_intersect($tagsLinkAfterId, $tagsLinkBeforeId);
                sort($tagsLinkNoChange);
                for($i = 0; $i < sizeof($tagsLinkNoChange); ++$i){
                    $tagsNoChange[] = \Appli\Models\Tag::getInstance()->get($tagsLinkNoChange[$i]);
                }
            }else{
                $tagsAdded = \Appli\Models\Link::getInstance()->getLinkTags($link->id, $_SESSION['idUser']);
            }
            //on retourne le lien pour le js
            self::getVue()->data = json_encode(array(
                'link'   => $link,
                'tags'   => array(
                    'deleted' => $tagsDeleted,
                    'added'   => $tagsAdded,
                    'default' => $tagsNoChange,
                    'new'     => $tagsNew
                ),
                'isEdit' => $isEdit,
                'token'  => $_SESSION['token'],
                'text'   => $textToDisplay
            ));
        }
    }

}
