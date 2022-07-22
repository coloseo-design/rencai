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
class admin_nav_controller extends adminCommon{
    /**
     * 后台导航管理
     */
	function index_action(){
        
	    $navigationM  =  $this -> MODEL('navigation');
	    
	    $return       =  $navigationM -> getAdminNavList(array('display'=>array('<>','1'),'orderby'=>'sort'),array('utype'=>'power'));
	    
	    $setarr  =  array(
	        'one_menu'    =>  $return['one_menu'],
	        'two_menu'    =>  $return['two_menu'],
	        'navigation'  =>  $return['navigation']
	    );
	    $this->yunset($setarr);
		$this->yuntpl(array('admin/admin_navigation'));
	}

	/**
	 * 后台导航管理：添加
	 */
	function add_action(){
	    $data  =  array(
	        'keyid'    	=>  $_POST['keyid'],
	        'name'    	=>  $_POST['name'],
	        'url'     	=>  $_POST['url'],
	        'classname'	=>  $_POST['classname'],
	        'display'  	=>  $_POST['display'],
			'dids'    	=>  $_POST['dids'],
	        'sort'    	=>  $_POST['sort'] == '' ? '0' : $_POST['sort']
	    );
	    $navM  =  $this -> MODEL('navigation');
	    $id    =  $navM -> addAdminNav($data);
		if($id){
		    echo '<script>alert("添加成功");location.href="index.php?m=admin_nav";</script>';
		}else{
		    echo '<script>alert("添加失败");location.href="index.php?m=admin_nav";</script>';
		}
	}
	/**
	 * 后台导航管理：修改、删除
	 */
	function edit_action(){
	    
	    $navM  =  $this -> MODEL('navigation');
	    //修改
		if($_POST['update_nav']){
		    $data  =  array(
		        'name'    	=>  $_POST['name'],
		        'url'     	=>  $_POST['url'],
		        'menu'     	=>  $_POST['menu'],
		        'classname'	=>  $_POST['classname'],
		        'display' 	=>  $_POST['display'],
				'dids'    	=>  $_POST['dids'],
		        'sort'    	=>  $_POST['sort'] == '' ? '0' : $_POST['sort']
		    );
		    
		    $id    = $navM -> upAdminNav($data,array('id'=>intval($_POST['id'])));
		    if($id){
		        echo '<script>alert("更新成功");location.href="index.php?m=admin_nav";</script>';
		    }else{
		        echo '<script>alert("更新失败");location.href="index.php?m=admin_nav";</script>';
		    }
		}
		//删除
		if($_POST['del_nav']){
		    $id  =  $navM -> delAdminNav(array('id'=>intval($_POST['id'])));
			if($id){
				echo '<script>alert("删除成功");location.href="index.php?m=admin_nav";</script>';
			}else{
				echo '<script>alert("删除失败");location.href="index.php?m=admin_nav";</script>';

			}
		}
	}
	// 升级记录
	function version_action(){
	    
	    $urlarr        	=   $_GET;
	    $urlarr['page'] =	'{{page}}';
	    
	    $pageurl		=	Url($_GET['m'],$urlarr,'admin');
	    
	    //提取分页
	    $pageM			=	$this  -> MODEL('page');
	    $pages			=	$pageM -> pageList('version',array(),$pageurl,$_GET['page']);
	    
	    //分页数大于0的情况下 执行列表查询
	    if($pages['total'] > 0){
	        
	        $configM = $this->MODEL('config');
	        $rows    = $configM->getVersionList();
	        
	        $this->yunset('rows', $rows);
	    }
	    
	    $this->yuntpl(array('admin/version'));
	}
}

?>