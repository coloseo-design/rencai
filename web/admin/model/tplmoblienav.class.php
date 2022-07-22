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
class tplmoblienav_controller extends adminCommon{
	function index_action(){
		$NavigationM				=	$this->MODEL('navigation');
		if($_GET['display']){
			if($_GET['display']=='2'){
				$where['display']	=	'0';
			}else{
				$where['display']	=	intval($_GET['display']);
			}
			$urlarr['display']		=	$_GET['display'];
		}
		if($_GET['news_search']){

			if (trim($_GET['keyword'])){
				$where['name']		=	array('like',trim($_GET['keyword']));
				$urlarr['keyword']	=	$_GET['keyword'];
			}
			$urlarr['news_search']	=	$_GET['news_search'];
		}
		$urlarr        	=   $_GET;
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM			=	$this->MODEL('page');
		$pages			=	$pageM->pageList('tplmoblie_navigation',$where,$pageurl,$_GET['page']);
		if($pages['total']>0){
			$where['orderby']		=	'sort,desc';
			
			$where['limit']			=	$pages['limit'];		
			$nav	=	$NavigationM->getMoblieNavList($where);
		}
		$this->yunset("get_type", $_GET);
		$this->yunset("nav",$nav);
		$this->yuntpl(array('admin/admin_tplmoblienav'));
	}
	
	//导航列表
	function add_action(){
		$NavigationM	=	$this->MODEL('navigation');
		//更新操作
		if($_GET['id']){
			$group		=	$NavigationM->getMoblieNav(array('id'=>$_GET['id']));
			$this->yunset("types",$group);
			
			$this->yunset("lasturl",$_SERVER['HTTP_REFERER']);
		}
		$navall			=	$NavigationM -> getNavList(array('nid'=>'26'));
		foreach ($navall as $k=>$val){
			if($val['url']!='index.php'&&$val['url']!='/'){
				$navigation[$k]=$val;
			}
		}
		$this->yunset('navigation',$navigation);
		$this->yuntpl(array('admin/admin_tplmoblienav_add'));
	}

	//导航更新添加
	function save_action(){
		$NavigationM	=	$this->MODEL('navigation');
		
		//更新
		$postData	=	array(
			'display'	=>	$_POST['display'],
			'name'		=>	$_POST['name'],
			'url'		=>	$_POST['url'],
			'sort'		=>	$_POST['sort']
		);
		if ($_FILES['file']) {
		    
		    $postData['file']  =  $_FILES['file'];
		}
		if($_POST['update']){
			$nbid	=	$NavigationM->upMoblieNav($postData,array('id'=>$_POST['id']));
			$this->cache_action();
			$lasturl	=	str_replace("&amp;","&",$_POST['lasturl']);
			isset($nbid)?$this->ACT_layer_msg( "网站导航(ID:".$_POST['id'].")更新成功！",9,"index.php?m=tplmoblienav",2,1):$this->ACT_layer_msg( "更新失败！",8,"index.php?m=tplmoblienav");
		}
		//添加
	    if($_POST['add']){
			$nav	=	$NavigationM->getMoblieNav(array('name'=>$_POST['name']));
			if($nav){
				$this->ACT_layer_msg( "已经存在此导航！",8,$_SERVER['HTTP_REFERER']);
			}else{
				$return	=	$NavigationM->addMoblieNav($postData);
				$this->cache_action();
				$this->ACT_layer_msg($return['msg'],$return['errcode'],"index.php?m=tplmoblienav");
			}
		}
	}

	//删除导航
	function del_action(){
		$this->check_token();
		$NavigationM						=	$this->MODEL('navigation');
		$DescriptionM						=	$this->MODEL('description');
		$ArticleM							=	$this->MODEL('article');
		 //批量删除
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if(is_array($del)){
				
				$NavigationM->delMoblieNav(array('id' => array('in', pylode(',', $del))));
				$this->cache_action();
				$this->layer_msg( "导航(ID:".@implode(',',$_GET['del']).")删除成功！",9,1,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg( "请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
		//删除
	    if(isset($_GET['id'])){
			$result	=	$NavigationM->delMoblieNav(array('id'=>$_GET['id']));
			$this->cache_action();
			isset($result)?$this->layer_msg('导航(ID:'.$_GET['id'].')删除成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg("非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
	}

	function cache_action(){
		include(LIB_PATH."cache.class.php");
		$cacheclass		=	new cache(PLUS_PATH,$this->obj);
		$makecache		=	$cacheclass->moblienav_cache("moblienav.cache.php");
	}
	function nav_xianshi_action(){
	    $this->check_token();
		$NavigationM	=	$this->MODEL('navigation');
		$nid	=	$NavigationM->upMoblieNav(array(''.$_GET['type'].''=>intval($_GET['rec'])),array('id'=>intval($_GET['id'])));
	    if ($_GET['type']=='display'){
	        $this->MODEL('log')->addAdminLog("导航是否显示(ID:".$_GET['id'].")设置成功！");
	    }else{
	        $this->MODEL('log')->addAdminLog("导航是否新窗口打开(ID:".$_GET['id'].")设置成功！");
	    }
		$this->cache_action();
	    echo $nid?1:0;die;
	}
	
}