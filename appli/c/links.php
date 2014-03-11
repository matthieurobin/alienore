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
            $link = array(
                'title' => htmlspecialchars(trim(\MVC\A::get('title'))),
                'url' => htmlspecialchars(trim(\MVC\A::get('url'))),
                'description' => htmlspecialchars(trim(\MVC\A::get('description'))),
                'linkdate' => $linkDate,
                'tags' => strtolower(trim(htmlspecialchars(\MVC\A::get('tags')))),
                'saved' => $saved,
                'datesaved' => \MVC\A::get('datesaved'),
                'extensionfile' => null
            );
            $linkObj = \Appli\M\Links::getInstance();
            $data = $linkObj->getFileData();
            $data[$linkDate] = $link;
            $linkObj->setFileData($data);
            $linkObj->saveData(); //save modifications
        }
    }

    public static function data_savedLink() {
        $linkToSave = \Appli\M\Links::getInstance()->get(\MVC\A::get('id'));
        $text = '';
        $id = $linkToSave['linkdate'];
        $saved = $linkToSave['saved'];
        $dateSaved = $linkToSave['datesaved'];
        $extensionFile = (isset($linkToSave['extensionfile'])) ? $linkToSave['extensionfile'] : null;
        $url = $linkToSave['url'];
        $error = false;
        //case : saved
        if ($linkToSave['saved'] === 1) {
            if(\Appli\M\Page::getInstance()->deleteHtmlFile($id,$extensionFile)){
                $saved = 0;
                $dateSaved = null;
                $text = \MVC\Language::T('The file was remove from the disk');
            }else{
                $text = \MVC\Language::T('An error occured');
                $error = true;
            }
            //case : not saved
        } else {
            if(filter_var($url,FILTER_VALIDATE_URL)){
                if(\Appli\M\Page::getInstance()->savedHtmlPage($url, $id)){
                    $extensionFile = \Appli\M\Page::getInstance()->getExtension($url);
                    $saved = 1;
                    $dateSaved = \MVC\Date::getDateNow();
                    $text = \MVC\Language::T('The content at: "%" was saved');
                    $text = str_replace('%', $url, $text);
                }else{
                    $text = \MVC\Language::T('An error occured');
                    $error = true;
                }
            }else{
                $text = \MVC\Language::T('The url is not valid');
                $error = true;
            }
            
        }
        $link = \Appli\M\Links::getInstance();
        $data = $link->getFileData();
        $data[$id]['saved'] = $saved;
        $data[$id]['datesaved'] = $dateSaved;
        $data[$id]['extensionfile'] = $extensionFile;
        $link->setFileData($data);
        $link->saveData(); //save modifications
        self::getVue()->data = json_encode(array('helper' => $text, 'error' => $error, 'link' => $data[$id]));
    }
    
    public static function research(){
        
    }

}
