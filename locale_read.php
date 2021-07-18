<?php
$filename  = 'locale/lang_ja.conf';
// require_once('lang_ja.conf');

$fp = fopen($filename, 'r');
$txt = fgets($fp);
$pieces = explode("=", $txt);
fclose($fp);
