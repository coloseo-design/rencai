<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class search_resume_controller extends lietou
{
	function index_action(){
		$CacheM		=	$this -> MODEL('cache');
		$cacheList	=	$CacheM -> GetCache(array('job','user','hy','city','uptime'));
		$this -> yunset($cacheList);
		if(empty($cacheList['city_type'])){
            $this   ->  yunset('cionly',1);
        }
        if(empty($cacheList['job_type'])){
            $this   ->  yunset('jionly',1);
        }
        $this -> yunset('ltstyle',$this -> config['sy_weburl'].'/app/template/lietou');
		$this -> public_action();
		$this -> lietou_tpl('search_resume');
	}
}
?>