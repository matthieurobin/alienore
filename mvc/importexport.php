<?php

namespace MVC;

Abstract class ImportExport {

    public static function exportHtml($links) {
        $str = '<!DOCTYPE NETSCAPE-Bookmark-file-1>'
                . '<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">'
                . '<Title>Bookmarks</Title>'
                . '<H1>Bookmarks</H1>';
        $nbLinks = sizeof($links);
        for($i = 0; $i < $nbLinks; ++$i) {
            $link = $links[$i];
            $str .= '<DT><A HREF="' . htmlspecialchars($link['link']->url) . '" ADD_DATE="' . strtotime($link['link']->linkdate) . '"';
            if (sizeof($link['tags'])){
                $nbTags = sizeof($link['tags']);
                $str .= ' TAGS="';
                for($j = 0; $j < $nbTags; ++$j){
                    $str .= $link['tags'][$j]->label .',';
                }
                $str = substr($str,0,-1);
                $str .= '"';
            }
            
            $str .= '>' . htmlspecialchars($link['link']->title) . "</A>\n";
            if ($link['link']->description != '') {
                $str .= '<DD>' . htmlspecialchars($link['link']->description) . "\n";
            }
        }
        return $str;
    }

    //sebsauvage funtion (base)
    public static function import($fileData) {
        $links = [];
        $importCount = 0;
        foreach (explode('<DT>', $fileData) as $html) { // explode is very fast
            $link = array('linkdate' => '', 'title' => '', 'url' => '', 'description' => '', 'tags' => '', 'saved' => 0, 'datesaved' => null, 'extensionfile' => '');
            $d = explode('<DD>', $html);
            if (self::startsWith($d[0], '<A ')) {
                $link['description'] = (isset($d[1]) ? htmlentities(html_entity_decode(trim($d[1]), ENT_QUOTES, 'UTF-8')) : '');  // Get description (optional)
                preg_match('!<A .*?>(.*?)</A>!i', $d[0], $matches);
                $link['title'] = (isset($matches[1]) ? htmlentities(trim($matches[1])) : '');  // Get title
                $link['title'] = htmlentities(html_entity_decode($link['title'], ENT_QUOTES, 'UTF-8'));
                preg_match_all('! ([A-Z_]+)=\"(.*?)"!i', $html, $matches, PREG_SET_ORDER);  // Get all other attributes
                foreach ($matches as $m) {
                    $attr = $m[1];
                    $value = $m[2];
                    if ($attr == 'HREF') {
                        $link['url'] = htmlentities(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
                    } else if ($attr == 'ADD_DATE') {
                        $link['linkdate'] = htmlentities(date("Y-m-d H:i:s", intVal($value)));
                    } else if ($attr == 'TAGS') {
                        $link['tags'] = htmlentities(html_entity_decode(str_replace(',', ' ', $value), ENT_QUOTES, 'UTF-8'));
                    }
                }
                $links[] = $link;
                ++$importCount;
            }
        }
        return array('links' => $links, 'nbLinks' => $importCount);
    }

    public static function startsWith($haystack, $needle, $case = true) {
        if ($case) {
            return (strcmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
        }
        return (strcasecmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
    }

}
