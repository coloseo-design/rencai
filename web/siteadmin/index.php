<?php
/*
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */ 
include(dirname(dirname(__FILE__)).'/global.php');

//判断是否处于分站下,未处于分站下应当跳转到总站后台
global $config;
if(!is_numeric($config['did'])){
    header('Location:/admin/');die;
}

$DirNameList=explode('\\',dirname(__FILE__));

$DirName=end($DirNameList);$ModuleName='siteadmin';$siteAdminDir='siteadmin';
$_GET['a']=$_GET['c'];$_GET['c']=$_GET['m'];//$_GET['m']='';
session_start(); 
include(LIB_PATH.'init.php');
?>