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
class admin_user_controller extends siteadmin_controller{
    /**
     * 管理员-管理员列表
     */
	function index_action(){
	    
	    //分页链接
	    $urlarr['page']	=	'{{page}}';
	    
	    $pageurl		=	Url($_GET['m'],$urlarr,'admin');
	    
	    //提取分页
	    $pageM			=	$this  -> MODEL('page');
	    $pages			=	$pageM -> pageList('admin_user',array(),$pageurl,$_GET['page']);
	    
	    //分页数大于0的情况下 执行列表查询
	    if($pages['total'] > 0){
	        //limit order 只有在列表查询时才需要
	        $where['orderby']  =  'uid';
	        $where['limit']    =  $pages['limit'];
	        
	        $adminM            =  $this -> MODEL('admin');
	        
	        $List	           =  $adminM -> getList($where);
	        
	        $this -> yunset('rows',$List);
	    }
		$this->yuntpl(array('admin/admin_user_list'));
	}
	/**
	 * 管理员-添加管理员
	 */
	function add_action(){
	    
	    $adminM  =  $this -> MODEL('admin');
	    
		if(isset($_GET['uid'])){
		    
		    $adminuser  =  $adminM -> getAdminUser(array('uid'=>intval($_GET['uid'])));
		    
			$this->yunset('adminuser',$adminuser);
		}
		
		$group  =  $adminM -> getAdminGroupList(array('did'=>$this->config['did'],'orderby'=>'id'));
		
		$this->yunset('user_group',$group);
		
		$this->yuntpl(array('admin/admin_user_add'));
	}
	/**
	 * 管理员-管理员类型
	 */
	function group_action(){
	    
	    $adminM  =  $this -> MODEL('admin');
	    
	    $List    =  $adminM -> getAdminGroupList(array('did'=>$this->config['did'],'orderby'=>'id'),array('utype'=>'admin'));
	    
		$this->yunset('adminusergroup',$List);
		
		$this->yuntpl(array('admin/admin_group_list'));
	}
	/**
	 * 管理员-我的账号
	 */
	function myuser_action(){
	    
	    $adminM  =  $this -> MODEL('admin');
	    
	    if ($_SESSION['auid']){
	        
	        $user    =  $adminM -> getAdminUser(array('uid'=>$_SESSION['auid']));
	        
	        if ($user){
	            
	            $group   =  $adminM -> getAdminGroup(array('id'=>$user['m_id'],'did'=>$this->config['did']));
	        }
	        
	        $this->yunset(array('adminuser'=>$user,'user_group'=>$group));
	    }
		$this->siteadmin_tpl(array('admin_myuser'));
	}
	/**
	 * 管理员-我的账号-修改密码
	 */
	function pass_action(){

		$this->siteadmin_tpl(array('admin_mypass'));
	}
	/**
	 * 管理员-我的账号-修改密码保存
	 */
	function savePass_action(){
	    
	    if($_POST['useradd'] && $_SESSION['auid']){
	        
	        $_POST   =  $this -> post_trim($_POST);
	        
	        $adminM  =  $this -> MODEL('admin');
	        
	        $return  =  $adminM ->upAdminUser(array('password'=>$_POST['password']),array('uid'=>$_SESSION['auid']),array('oldpass'=>$_POST['oldpass'],'okpassword'=>$_POST['okpassword']));
	        
	        if ($return['id']){
	            
	            unset($_SESSION['authcode']);
	            unset($_SESSION['auid']);
	            unset($_SESSION['ausername']);
	            unset($_SESSION['ashell']);
	        }
	        
	        $this -> ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
	    }
	}
	/**
	 * 管理员-添加管理员类型
	 */
	function addgroup_action(){
	    //修改管理员类型
		if($_GET['id']){
		    
		    $adminM  =  $this -> MODEL('admin');
		    
		    $group   =  $adminM -> getAdminGroup(array('id'=>intval($_GET['id']),'did'=>$this->config['did']));
		    
		    $this->yunset('admin_group',$group);
			
		    $this->yunset('power',unserialize($group['group_power']));
		}
		
		$navigationM  =  $this -> MODEL('navigation');
		
		$return       =  $navigationM -> getAdminNavList(array('display'=>array('<>','1'),'orderby'=>'sort'),array('utype'=>'power'));
		
		$setarr  =  array(
		    'one_menu'=>$return['one_menu'],
		    'two_menu'=>$return['two_menu'],
		    'navigation'=>$return['navigation']
		);
		
		$this->yunset($setarr);
		
		$this->yuntpl(array('admin/admin_group'));
	}
	/**
	 * 管理员-添加、修改保存
	 */
	function save_action(){
		if(isset($_POST['useradd'])){
		    
		    $_POST   =  $this -> post_trim($_POST);
		    
		    $adminM  =  $this -> MODEL('admin');
		    
		    $post    =  array(
		        'username'  =>  $_POST['username'],
		        'name'      =>  $_POST['name'],
				'm_id'      =>  $_POST['m_id'],
				'moblie' 	=>  $_POST['moblie'],
				'weixin'  	=>  $_POST['weixin'],
				'qq'     	=>  $_POST['qq'],
		    );
		    
		    if($_POST['password']){
		        $post['password']  =  $_POST['password'];
		    }
		    if($_POST['isdid']){
		        $post['isdid']  =  intval($_POST['isdid']);
		    }
		    
		    if (empty($_POST['uid'])){
		        
		        $return  =  $adminM-> addAdminUser($post);
		    }else{
		        $return  =  $adminM ->upAdminUser($post,array('uid'=>$_POST['uid']));
		        
		        if ($return['id'] && $_POST['uid']==$_SESSION['auid']){
		            
		            unset($_SESSION['authcode']);
		            unset($_SESSION['auid']);
		            unset($_SESSION['ausername']);
		            unset($_SESSION['ashell']);
		            
		            if($_POST['uid']==$_SESSION['auid']){
		                
		                $this->ACT_layer_msg( '管理员(ID:'.$_POST['uid'].')修改成功,请重新登录！',9,$_SERVER['HTTP_REFERER'],2,1);
		            }
		        }
		    }
		    $this->ACT_layer_msg($return['msg'],$return['errcode'],'index.php?m=admin_user',2,1);
		}
	}
	/**
	 * 管理员-管理员列表-删除
	 */
	function deluser_action(){
	    
		$this->check_token();
		
		if ($_GET['uid']){
		    
		    $adminM  =  $this -> MODEL('admin');
		    
		    $return  =  $adminM -> delAdminUser(array('uid'=>addslashes($_GET['uid'])));
		    
		    $this->layer_msg($return['msg'],$return['errcode']);
		}
	}
	/**
	 * 管理员-管理员类型-删除
	 */
	function delgroup_action(){
	    
		$this->check_token();
		
		if ($_GET['id']){
		    
		    $adminM  =  $this -> MODEL('admin');
		    
		    $return  =  $adminM -> delAdminGroup(array('id'=>intval($_GET['id'])));
		    
		    $this->layer_msg($return['msg'],$return['errcode']);
		}
	}
	/**
	 * 管理员-管理员类型-添加、修改保存
	 */
	function savagroup_action(){
	    
	    if(empty($_POST['group_name'])){
	        
	        $this -> ACT_layer_msg('请填写权限组名称',8);
	    }
	    
	    $power = array_filter($_POST['power']);
	    
	    if(empty($power)){
	        
	        $this -> ACT_layer_msg('请至少选择一项权限',8);
	    }
	    
	    $post    =  array(
	        'group_name'   =>  $_POST['group_name'],
	        'group_power'  =>  serialize(array_filter($power)),
	        'group_type'   =>  1
	    );
	    $adminM  =  $this -> MODEL('admin');
	    
	    if (empty($_POST['groupid'])){
	        
	        $post['did']  =  $this->config['did'];
	        
	        $return       =  $adminM -> addAdminGroup($post);
	    }else {
	        
	        $return       =  $adminM -> upAdminGroup($post,array('id'=>intval($_POST['groupid'])));
	    }
		if($return['errcode']==9){
			if($_POST['group_name']=='分站管理员'){
				$navigationM	=  $this -> MODEL('navigation');
				
				$navigationM->upAdminNav(array('dids'=>0),array('display'=>array('<>',1)));
				
				$navigationM->upAdminNav(array('dids'=>1),array('id'=>array('in',pylode(',',$power)),'display'=>array('<>',1)));
				
			}
		}
	    $this->ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
	}
}

?>