<?php

require_once('Smarty/libs/Smarty.class.php');
require_once('locale_read.php');

$smarty = new Smarty();
$smarty->template_dir = 'views';
$smarty->compile_dir = 'tmp';

$smarty->assign('people', $pieces);

$smarty->display('index.inc');
