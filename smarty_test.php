<?php

require_once('Smarty/libs/Smarty.class.php');

$smarty = new Smarty();
$smarty->template_dir = 'views';
$smarty->compile_dir = 'tmp';

//locale読み込み処理
$filename  = 'locale/lang_ja.conf';
$fp = fopen($filename, 'r');
$txt = fgets($fp);
$pieces = explode("=", $txt);
$word = $pieces[1];
fclose($fp);

$smarty->assign($pieces[0], $word);

$smarty->display('index.inc');
