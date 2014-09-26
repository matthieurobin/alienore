<?php

namespace Appli\Controllers;

class Tags extends \MVC\Controller {

    /**
     * cherche le tag identifié par tagId
     */
    public static function data_get(){
        self::getVue()->data = json_encode(\Appli\Models\Tag::getInstance()->get(\MVC\A::get('tagId')));
    }
    

    /**
     * méthode appelée lors de l'initialisation de 'links'.'all' , cherche les tags et les tris par le nombre de liens par tag
     */
    public static function data_all() {
        self::getVue()->data = json_encode( array('tags' => \Appli\Models\Tag::getInstance()->getAllTagsByUtilisation($_SESSION['idUser'])));
    }

    /**
     * enregistrer le tag lors de l'envoi du formulaire
     */
    public static function data_saved() {
        if (\MVC\A::get('label') != '') {
            if(\MVC\A::get('tagId') != ''){
                $tag = \Appli\Models\Tag::getInstance()->get(\MVC\A::get('tagId'));
            }else{
                $tag = \Appli\Models\Tag::getInstance()->newItem();
            }
            $tag->label = htmlspecialchars(strtolower(trim(\MVC\A::get('label'))));
            //if the tag doesn't exist
            if(!\Appli\Models\Tag::getInstance()->getTagByLabel($tag->label, $_SESSION['idUser'])){
                $tag->store();
                $saved = true;
                $text = \MVC\Language::T('The tag was edited');
            }else{
                $text = \MVC\Language::T('The tag always exsits');
                $saved = false;
            }
            self::getVue()->data = json_encode(array(
                'tag' => $tag,
                'saved' => $saved,
                'text' => $text
            )); 
        }
    }

    /**
     * cherche le tag identifié par tagId et appelle la méthode displayTag pour décoder les htmlspecialchars
     */
    public static function data_form(){
        $tag = \MVC\Display::displayTag(\Appli\Models\Tag::getInstance()->get(\MVC\A::get('tagId')));
        self::getVue()->data = json_encode($tag);
    }

}
