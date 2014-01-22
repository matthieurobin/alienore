<?php

namespace Appli\C;

class Links extends \MVC\Controleur {

    public static function all() {
        $links = \Appli\M\Links::getInstance()->getFileData();
        self::getVue()->links = $links;
        self::getVue()->nbLinks = sizeof($links);
    }

    public static function delete() {
        $link = \Appli\M\Links::getInstance();
        $link->deleteLink(\MVC\A::get('id'));
        $link->saveData();
        $link->deleteHtmlFile(\MVC\A::get('filename'));
    }

    public static function form() {
        self::getVue()->link = \Appli\M\Links::getInstance()->get(\MVC\A::get('id'));
    }

    public static function saved() {
        if (\MVC\A::get('url') != '') {
            if (\MVC\A::get('linkdate') != '') {
                $linkDate = \MVC\A::get('linkdate');
            } else {
                $linkDate = date('Ymd') . '_' . date('His');
            }
            $saved = \MVC\A::get('saved') == '' ? 0 : 1;
            $link = array(
                'title' => htmlspecialchars(\MVC\A::get('title')),
                'url' => htmlspecialchars(\MVC\A::get('url')),
                'description' => htmlspecialchars(\MVC\A::get('description')),
                'linkdate' => $linkDate,
                'tags' => trim(htmlspecialchars(\MVC\A::get('tags'))),
                'saved' => $saved,
                'datesaved' => \MVC\A::get('datesaved')
            );
            $linkObj = \Appli\M\Links::getInstance();
            $data = $linkObj->getFileData();
            $data[$linkDate] = $link;
            $linkObj->setFileData($data);
            $linkObj->saveData(); //save modifications
        }
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
                $dateSaved = $linkDate = date('Ymd') . '_' . date('His');
            }
        }
        $link = \Appli\M\Links::getInstance();
        $data = $link->getFileData();
        $data[\MVC\A::get('id')]['saved'] = $saved;
        $data[\MVC\A::get('id')]['datesaved'] = $dateSaved;
        $link->setFileData($data);
        $link->saveData(); //save modifications
    }

}
