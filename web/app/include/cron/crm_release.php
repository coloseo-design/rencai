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
/************
* 计划任务：CRM资源释放
* 仅作参考
*/
global $db_config, $db;

include(dirname(dirname(dirname(__FILE__))).'/model/crm.model.php');
$crmM	=	new crm_model($db, $db_config['def']);
$crmM -> releaseCom();


?>