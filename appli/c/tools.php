<?php

namespace Appli\C;

class Tools extends \MVC\Controleur {

    public static function all() {
        
    }

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
                        if (!\Appli\M\Link::getInstance()->getLinkByUrl($url, $userId)) {
                            //first we process the link
                            $linkBdd = \Appli\M\Link::getInstance()->newItem();
                            $linkBdd->linkdate = $link['linkdate'];
                            $linkBdd->title = $link['title'];
                            $linkBdd->url = $url;
                            $linkBdd->description = $link['description'];
                            $linkBdd->idUser = $userId;
                            $linkBdd->store();
                            //then we look at the tags
                            $tags = explode(' ', htmlentities(trim($link['tags'])));
                            if ($tags[0] != '') { //even if there is no space, there is one result at the index 0
                                for ($j = 0; $j < sizeof($tags); ++$j) {
                                    $tag = strtolower($tags[$j]);
                                    $tagBdd = \Appli\M\Tag::getInstance()->getTagByLabel($tag)[0];
                                    //if there is no result, we create the tag
                                    if (!$tagBdd) {
                                        $tagBdd = \Appli\M\Tag::getInstance()->newItem();
                                        $tagBdd->label = $tag;
                                        $tagBdd->store();
                                    }
                                    //if taglist doesn't exist anymore
                                    if (!\Appli\M\Taglink::getInstance()->exists($linkBdd->id, $tagBdd->id)) {
                                        $taglink = \Appli\M\Taglink::getInstance()->newItem();
                                        $taglink->idTag = $tagBdd->id;
                                        $taglink->idLink = $linkBdd->id;
                                        $taglink->store();
                                    }
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

    public static function exportHtml() {
        $userId = $_SESSION['idUser'];
        $links = \Appli\M\Link::getInstance()->getUserLinks($userId);
        $linksToExport = [];
        //search tags of links
        for ($i = 0; $i < sizeof($links); ++$i) {
            $linksToExport[$i]['link'] = $links[$i];
            $linksToExport[$i]['tags'] = \Appli\M\Link::getInstance()->getLinkTags($links[$i]->id);
        }
        self::getVue()->html = \MVC\ImportExport::exportHtml($linksToExport);
    }

}
