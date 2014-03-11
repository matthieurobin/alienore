<?php

namespace Appli\C;

class Tools extends \MVC\Controleur {

    public static function all() {
        
    }

    public static function import() {
        if (isset($_FILES['filePath']['tmp_name'])) {
            $fileData = file_get_contents($_FILES['filePath']['tmp_name']);
            //unset($_FILES['filePath']);
            if (\MVC\ImportExport::startsWith($fileData, '<!DOCTYPE NETSCAPE-Bookmark-file-1>')) {
                $data = \Appli\M\Links::getInstance()->getFileData();
                $res = \MVC\ImportExport::import($fileData, $data);
                foreach ($res['links'] as $key => $link) {
                    $data[$key] = $link;
                }
                \Appli\M\Links::getInstance()->setFileData($data);
                \Appli\M\Links::getInstance()->saveData();
                $_SESSION['errors']['info'][] = $res['nbLinks'] . ' ' . \MVC\Language::T('links imported');
            } else {
                $_SESSION['errors']['danger'][] = \MVC\Language::T('The file has an unknown file format. Nothing was imported.');
            }
        }
    }

    public static function exportHtml() {
        self::getVue()->html = \MVC\ImportExport::exportHtml(\Appli\M\Links::getInstance()->getFileData());
    }

}
