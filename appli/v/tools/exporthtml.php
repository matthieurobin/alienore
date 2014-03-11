<?php

header('Content-Type: text/html; charset=utf-8');
header('Content-disposition: attachment; filename=bookmarks_'.strval(date('Ymd_His')).'.html');

echo $this->html;

