<?php

header('Content-Type: text/html; charset=utf-8');
header('Content-disposition: attachment; filename=alienore_'.strval(date('Ymd_Hi')).'.html');

echo $this->html;

