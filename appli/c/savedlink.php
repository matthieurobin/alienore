<?php

namespace Appli\C;

class SavedLink extends \MVC\Controleur {

    public static function display() {
        $link = \Appli\M\Links::getInstance()->get(\MVC\A::get('linkdate'));
        self::getVue()->link = $link;
        self::getVue()->html = \Appli\M\Page::getInstance()->getPathToSavedLink($link['title']);
    }
}
