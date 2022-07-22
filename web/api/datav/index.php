<?php
include (dirname(dirname(dirname(__FILE__))) . '/global.php');

$pageType = 'datav';
$model    = $_GET['m'];
$action   = $_GET['c'];
$member   = '';

if (isset($_GET['h'])){
    $member   = $_GET['h'];
}
if ($model == '')
    $model = 'index';
if ($action == '')
    $action = 'index';


require (APP_PATH . 'app/public/common.php');
require ('datav.controller.php');


require ('model/' . $model . '.class.php');

$conclass = $model . '_controller';
$actfunc = $action . '_action';

$views = new $conclass($phpyun, $db, $db_config['def']);
if (! method_exists($views, $actfunc)) {
    $views->DoException();
}

$views->$actfunc();
?>