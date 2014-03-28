<?php

namespace Appli\M;

class Link extends \MVC\Table {
    protected $_table = 'link';
    protected $_tableRow = 'LinkRow';

    /**
     * delete a specific element
     * @param string $id
     */
    public function deleteLink($id) {
        $data = $this->getFileData();
        if (isset($data[$id])) {
            unset($data[$id]);
            $this->setFileData($data);
        }
    }

    /**
     * get a specific element
     * @param string $id
     * @return array()
     */
    public function get($id) {
        if (!is_null($id)) {
            $result = $this->getFileData();
            if (isset($result[$id])) {
                return $result[$id];
            }
        }
    }

    
    public function getLinksByTag($tagSearch) {
        $links = array();
        foreach ($this->getFileData() as $link) {
            foreach (explode(' ', $link['tags']) as $tag) {
                if ($tag == $tagSearch) {
                    $links[$link['linkdate']] = $link;
                }
            }
        }
        return $links;
    }

    public function editTagName($newTagName, $tagEdit) {
        $links = $this->getFileData();
        foreach ($links as $link) {
            $tagString = '';
            foreach (explode(' ', $link['tags']) as $tag) {
                if ($tag == $tagEdit) {
                    $tagString .= ' ' . $newTagName;
                } else {
                    $tagString .= ' ' . $tag;
                }
            }
            $links[$link['linkdate']]['tags'] = trim($tagString);
        }
        return $links;
    }

    public function deleteTag($tagName) {
        $links = $this->getFileData();
        foreach ($links as $link) {
            $tagString = '';
            foreach (explode(' ', $link['tags']) as $tag) {
                if ($tagName != $tag) {
                    $tagString .= ' ' . $tag;
                }
            }
            $links[$link['linkdate']]['tags'] = trim($tagString);
        }
        return $links;
    }
    

    public function search($str) {
        $links = $this->getFileData();
        $res = [];
        $str = explode(' ', $str);
        for ($i = 0; $i < sizeof($str); ++$i) {
            if (strlen($str[$i]) >= 4) {
                foreach ($links as $link) {
                    $strToSearch = $str[$i];
                    //we search in title, in description and tag
                    if(stripos($link['title'], $strToSearch) !== false) {
                        $res[$link['linkdate']] = $link;
                    } else if(stripos($link['description'],$strToSearch) !== false) {
                        $res[$link['linkdate']] = $link;
                    } else {
                        $tags = explode(' ', $link['tags']);
                        for($j = 0; $j < sizeof($tags); ++$j){
                            if (!empty($tags[$j]) && (stripos($tags[$j],$strToSearch)!== false)) {
                                $res[$link['linkdate']] = $link;
                            }
                        }
                    }
                }
            }
        }

        return $res;
    }

}
