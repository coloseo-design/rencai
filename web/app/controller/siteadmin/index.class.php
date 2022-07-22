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
class index_controller extends siteadmin_controller{
	function index_action($set=''){
		
		global $db_config;
		$this->yunset("db_config",$db_config);
		$_POST=$this->post_trim($_POST);	
		if (!empty ($_POST['username']) && !empty ($_POST['password'])){
		    if(strpos($this->config['code_web'],'后台登录')!==false){
		        if ($this->config['code_kind']==1){
					if(md5(strtolower($_POST['authcode']))===$_SESSION['authcode']){
						unset($_SESSION['authcode']);
						$this->admin_get_user_login($_POST['username'], $_POST['password']);
					}else{
						unset($_SESSION['authcode']);
						$this->ACT_layer_msg("验证码错误！",8,"index.php");
					}
		        }elseif ($this -> config['code_kind'] > 2) {
                    
					$check	=	verifytoken($this->config);
                    // 极验验证
                    if ($check['code'] != '200') {
                        $this -> ACT_layer_msg($check['msg'], 8, 'index.php');
                    } else {
                        $this -> admin_get_user_login($_POST['username'], $_POST['password']);
                    }
                    
                }
		    }else{
				$this->admin_get_user_login($_POST['username'], $_POST['password']);
			}
		} 
		$tpname=$this->admin_get_user_shell($_SESSION['auid'],$_SESSION['ashell'])? 'index':'login'; 
		if($tpname=="login"){

			$this->siteadmin_tpl(array($tpname));
			die;
		}

		//权限配置
		$adminM    =  $this -> MODEL('admin');
		
		$power     =  $adminM -> getPower(array('uid'=>$_SESSION['auid']));
		
		$this -> yunset('power', $power['power']);
		
		$nav_user  =  array(
			'name'        =>  $power['name'],
			'group_name'  =>  $power['group_name']
		);
		//查询最近登录时间
        $logM  =  $this->MODEL('log');

        $adminLog  =  $logM -> getAdminLog(array('uid' => $_SESSION['auid'],'content' => '登录成功','orderby' => 'ctime'));
		//导航配置，$config['did']当前分站的编号，dids包含s或$config['did']的导航栏为当前分站可访问的
		$navM		=	$this -> MODEL('navigation');
		
		$navList	=	$navM -> getAdminNavList(array('dids'=>1,'display'=>array('<>',1),'id'=>array('in', pylode(',', $power['power'])),'orderby'=>'sort,ASC'),array('utype'=>'power'));
		
		$setarr		=	array(
			'one_menu'        =>  $navList['one_menu'],
			'two_menu'        =>  $navList['two_menu'],
			'navigation'      =>  $navList['navigation'],
			'menu'            =>  $navList['menu'],
			'nav_user'        =>  $nav_user,
			'admin_lasttime'  =>  $adminLog['ctime'] ? $adminLog['ctime'] : time()
		);
		
        $this -> yunset($setarr);
		
		//获取默认页面
		if(is_array($navList['navigation'])){
			foreach($navList['navigation'] as $v){
				$navigation_url_id[]=$v['id'];
			} 
			$navigation_url=$this->GET_web_default($navigation_url_id,$power['power']);
		}
		if($set == ''){
			$this->siteadmin_tpl(array($tpname));
		}
	}
	function logout_action()
	{
		$this -> adminlogout();
		
		$this->layer_msg("您已成功退出！",9,0,"index.php");
	}
	function del_cache_action(){
		$cache=$this->del_dir("../data/templates_c",1);
		$cache=$this->del_dir("../data/cache",1);
		if($cache==true){
			$this->layer_msg("更新成功！",9,0,"index.php");
		}else{
			$this->layer_msg("更新失败,请检查是否有权限！",8,0,"index.php");
		}
	}
	//后台地图
	function map_action(){
		
		$this->index_action(1);
		
		$this->siteadmin_tpl(array('admin_map'));
	}
	//后台地图
	function topmenu_action(){
		
		$id	=	(int)$_GET['id'];
		//解决ie9 $.get $.post 回调函数的返回值为undefine
		header("Content-Type: text/html; charset=UTF-8");
		
		if($id=="1000"){
			echo  "管理首页";
		}else{
			$arr	=	$this->GET_web_check($id);
			
			$n		=	explode("-",$arr);
			
			unset($n[count($n)-1]);
			
			echo implode("-",$n);
		}
	}
	function shortcut_menu_action(){
		
		$tpname	=	$this->admin_get_user_shell($_SESSION['auid'],$_SESSION['ashell']);
		
		if($_POST['chk_value'] && is_array($tpname)){
			
			$navM    =  $this -> MODEL('navigation');
			
			$navM -> upAdminNav(array('menu'=>1),array('menu'=>2));
			
			$navM -> upAdminNav(array('menu'=>2),array('id'=>array('in',@implode(',', $_POST['chk_value']))));
			
			echo 1;die;
		}else{
			$this->ACT_layer_msg("无权操作！",8,$this->config['sy_weburl'],2,1);
		}
	}
	function msgNum_action(){
		
		$MsgNum	=	$this -> MODEL('msgNum');
		
		echo $MsgNum->msgNum();
	}
}
?>