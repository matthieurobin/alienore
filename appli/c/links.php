<?php

namespace Appli\C;

class Links extends \MVC\Controleur {

    public static function all() {
        $links = \Appli\M\Links::getInstance()->getFileData();
        $page = (\MVC\A::get('page') != '') ? \MVC\A::get('page') : 1;
        $links = array_reverse($links);
        self::getVue()->pagination = \MVC\Pagination::buildPaging($links,$page);
        self::getVue()->nbLinks = sizeof($links);
    }

    public static function delete() {
        $link = \Appli\M\Links::getInstance();
        $link->deleteLink(\MVC\A::get('id'));
        $link->saveData();
         \Appli\M\Page::getInstance()->deleteHtmlFile(\MVC\A::get('filename'));
        self::redirect('links', 'all');
    }

    public static function form() {
        self::getVue()->link = \Appli\M\Links::getInstance()->get(\MVC\A::get('id'));
    }

    public static function saved() {
        if (\MVC\A::get('url') != '') {
            if (\MVC\A::get('linkdate') != '') {
                $linkDate = \MVC\A::get('linkdate');
            } else {
                $linkDate = \MVC\Date::getDateNow();
            }
            $saved = \MVC\A::get('saved') == '' ? 0 : 1;
            $link = array(
                'title' => htmlspecialchars(trim(\MVC\A::get('title'))),
                'url' => htmlspecialchars(trim(\MVC\A::get('url'))),
                'description' => htmlspecialchars(trim(\MVC\A::get('description'))),
                'linkdate' => $linkDate,
                'tags' => strtolower(trim(htmlspecialchars(\MVC\A::get('tags')))),
                'saved' => $saved,
                'datesaved' => \MVC\A::get('datesaved')
            );
            $linkObj = \Appli\M\Links::getInstance();
            $data = $linkObj->getFileData();
            $data[$linkDate] = $link;
            $linkObj->setFileData($data);
            $linkObj->saveData(); //save modifications
        }
        self::redirect('links', 'all');
    }

    public static function savedLink() {
        //case : saved
        if (\MVC\A::get('saved')) {
            if(\Appli\M\Page::getInstance()->deleteHtmlFile(\MVC\A::get('filename'))){
                $saved = 0;
                $dateSaved = '';
            }
            //case : not saved
        } else {
            if(\Appli\M\Page::getInstance()->savedHtmlPage(\MVC\A::get('url'), \MVC\A::get('filename'))){
                $saved = 1;
                $dateSaved = $linkDate = \MVC\Date::getDateNow();
            }
        }
        $link = \Appli\M\Links::getInstance();
        $data = $link->getFileData();
        $data[\MVC\A::get('id')]['saved'] = $saved;
        $data[\MVC\A::get('id')]['datesaved'] = $dateSaved;
        $link->setFileData($data);
        $link->saveData(); //save modifications
        self::redirect('links', 'all');
    }
    
    public static function research(){
        
    }

}
