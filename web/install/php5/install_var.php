<?php
/*
 * $Author ：维特网络技术支持
 *
 * 官网: http://www.weitenet.com
 *
 * 技术电话：18668215192 技术微信：18668215192
 *
 * 【主营业务】网站建设、源码模板、服务器空间租售、网站维护、网站托管、网站优化、百度推广、自媒体营销、微信公众号分销商城、如有意向-联系我们。
 */
define('KEKE_OFF', FALSE );
define('ENV_ERROR', 2);
$func_dir = array('config_dir' => array('type' => 'dir', 'path' => './config'),'uploads' => array('type' => 'dir', 'path' => './data/uploads'));
$gdarr=gd_info();
$gddata=explode(" ",$gdarr["GD Version"]);
$gddata=str_replace("(","",$gddata[1]);

$func_items = array('mysql_connect', 'fsockopen', 'gethostbyname', 'file_get_contents', 'xml_parser_create');
$env_items = array(
'os' => array('c' => 'PHP_OS', 'r' =>PHP_OS, 'b' => 'unix'),
'php' => array('c' => 'PHP_VERSION', 'r' => PHP_VERSION, 'b' => '5.4 以上'),
'attachmentupload' => array('r' =>get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许上传", 'b' => '2M'),
'gdversion' => array('r' =>$gddata, 'b' => '2.0'),
);

$dirfile_items = array (
	'config' => array (
		'type' => 'dir',
		'path' => '../config'
	),
	'data_dir' => array (
		'type' => 'dir',
		'path' => '../data'
	),
	'news_dir' => array (
		'type' => 'dir',
		'path' => '../news'
	),
	'about_dir' => array (
		'type' => 'dir',
		'path' => '../about'
	)
);