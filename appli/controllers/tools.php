<?php

namespace Appli\Controllers;

class Tools extends \MVC\Controller {

    /**
     * accéder à la vue
     */
    public static function all() {
        
    }

    /**
     * méthode appelé lors de l'envoi du formulaire,
     * permet d'importer à partir d'un fichier des liens et des tags
     */
    public static function import() {
        if (isset($_FILES['filePath']['tmp_name'])) {
            $fileData = file_get_contents($_FILES['filePath']['tmp_name']);
            if (\MVC\ImportExport::startsWith($fileData, '<!DOCTYPE NETSCAPE-Bookmark-file-1>')) {
                $res = \MVC\ImportExport::import($fileData);
                $links = $res['links'];
                $nbLinks = sizeof($links);
                if ($nbLinks > 0) {
                    $userId = $_SESSION['idUser'];
                    for ($i = 0; $i < $nbLinks; ++$i) {
                        $link = $links[$i];
                        $url = $link['url'];
                        if (!\Appli\Models\Link::getInstance()->getLinkByUrl($url, $userId)) {
                            //first we process the link
                            $linkBdd = \Appli\Models\Link::getInstance()->newItem();
                            $linkBdd->linkdate = htmlspecialchars(trim($link['linkdate']));
                            $linkBdd->title = htmlspecialchars(trim($link['title']));
                            $linkBdd->url = htmlspecialchars(trim($url));
                            $linkBdd->description = htmlspecialchars(trim($link['description']));
                            $linkBdd->idUser = $userId;
                            $linkBdd->store();
                            //then we look at the tags
                            $tags = explode(' ', htmlspecialchars(trim($link['tags'])));
                            if ($tags[0] != '') { //even if there is no space, there is one result at the index 0
                                for ($j = 0; $j < sizeof($tags); ++$j) {                     
                                    $tag = mb_strtolower($tags[$j],'UTF-8');
                                    $tagBdd = \Appli\Models\Tag::getInstance()->getTagByLabel($tag);
                                    //if there is no result, we create the tag
                                    if (!$tagBdd) {
                                        $tagBdd = \Appli\Models\Tag::getInstance()->newItem();
                                        $tagBdd->label = $tag;
                                        $tagBdd->store();
                                    }else{
                                        $tagBdd = $tagBdd[0];
                                    }
                                    //if taglist doesn't exist anymore
                                    $taglink = \Appli\Models\Taglink::getInstance()->newItem();
                                    $taglink->idTag = $tagBdd->id;
                                    $taglink->idLink = $linkBdd->id;
                                    $taglink->store();
                                }
                            }
                        }
                    }
                }   
                $_SESSION['errors']['info'][] = $res['nbLinks'] . ' ' . \MVC\Language::T('links imported');
            } else {
                $_SESSION['errors']['danger'][] = \MVC\Language::T('The file has an unknown file format. Nothing was imported.');
            }
        }
    }

    /**
     * permet d'exporter les liens et les tags dans un fichier html
     */
    public static function exportHtml() {
        $userId = $_SESSION['idUser'];
        $links = \Appli\Models\Link::getInstance()->getUserLinks($userId);
        $linksToExport = [];
        //search tags of links
        for ($i = 0; $i < sizeof($links); ++$i) {
            $linksToExport[$i]['link'] = $links[$i];
            $linksToExport[$i]['tags'] = \Appli\Models\Link::getInstance()->getLinkTags($links[$i]->id,$userId);
        }
        self::getVue()->html = \MVC\ImportExport::exportHtml($linksToExport);
    }

}
