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
class admin_siteadmin_controller extends adminCommon{
	function index_action(){
		$adminM			=	$this  -> MODEL('admin');
		
		$where['did']	=	array('>','0');
		$urlarr        	=   $_GET;
		$urlarr['page']	=	"{{page}}";
		
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('admin_user',$where,$pageurl,$_GET['page'],$this->config['sy_listnum']);
		
		if($pages['total'] > 0){
			//limit order 只有在列表查询时才需要
			if($_GET['order'])
			{
				$where['orderby']		=	$_GET['t'].','.$_GET['order'];
				$urlarr['order']		=	$_GET['order'];
				$urlarr['t']			=	$_GET['t'];
			}else{
				$where['orderby']		=	'uid,desc';
			}
			$where['limit']	=	$pages['limit'];
			
			$List	=	$adminM -> getList($where);
			
			$this->yunset("rows" , $List);
		}
		$this->yuntpl(array('admin/admin_siteadmin'));
	}
	function add_action(){
		
		$adminM	=	$this  -> MODEL('admin');
		
		$group	=	$adminM -> getAdminGroup(array('group_type'=>'2'));
		
		if($group['id']==''){
			$this->yunset("nogroup",1);
		} 
		if(isset($_GET['uid'])){
			
			$adminuser	=	$adminM -> getAdminUser(array('uid'=>$_GET['uid']));
			
			$this->yunset("adminuser",$adminuser);
		}
		
		$domain	=	$this -> MODEL('site') -> getList(array('orderby'=>'id,desc'),array('field'=>"`id`,`title`"));


		$where['PHPYUNBTWSTART']=	'';
		
		$where['group_type']	=	'2';
		
		$where['did']			=	array('>','0','OR');
		
		$where['PHPYUNBTWEND']	=	'';
		
		$where['orderby']		=	'id,desc';
		
		$user_group	=	$adminM ->	getAdminGroupList($where);
		
		$this->yunset("user_group",$user_group);

		$this->yunset("domain",$domain);
		
		$this->yuntpl(array('admin/admin_siteadmin_add'));
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
	        );
	        
	        if($_POST['password']){
	            $post['password']  =  $_POST['password'];
	        }
	        if($_POST['did']){
	            $post['did']  =  intval($_POST['did']);
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
	        $this->ACT_layer_msg($return['msg'],$return['errcode'],'index.php?m=admin_siteadmin',2,1);
	    }
	}
	function group_action(){
		$adminM	=	$this  -> MODEL('admin');
		
		$where['PHPYUNBTWSTART']=	'';
		
		$where['group_type']	=	'2';
		
		$where['did']			=	array('>','0','OR');
		
		$where['PHPYUNBTWEND']	=	'';
		
		$where['orderby']		=	'id,desc';
		
		$adminusergroup	=	$adminM->getAdminGroupList($where,array('utype'=>'admin','uwhere'=>array('groupby'=>'m_id')));
		
		$domain=$this->MODEL('site')->getList(array('orderby'=>'id,desc'),array('field'=>"`id`,`title`"));
	
		
		foreach($adminusergroup as $key=>$val){
			foreach($domain as $v){
				if($val['did']==$v['id']){
					$adminusergroup[$key]['domain']=$v['title'];
				}
			}
		}
		

		$this->yunset("adminusergroup",$adminusergroup);
		$this->yuntpl(array('admin/admin_siteadmin_group_list'));
	}
	
	/**
	 * @desc 添加 /  修改 分站管理员类型
	 */
	function addgroup_action(){
	    
        if ((int) $_GET['id']) {

            $adminM =   $this->MODEL('admin');

            $admingroup =   $adminM->getAdminGroup(array('id' => $_GET['id']));

            $this->yunset('admin_group', $admingroup);

            $this->yunset('power', unserialize($admingroup['group_power']));
        }
        
        $navigationM    =   $this->MODEL('navigation');

        $return         =   $navigationM->getAdminNavList(array( 'display' => array( '<>', '1'), 'dids' => '1', 'orderby' => 'sort'), array('utype' => 'power'));

        $setarr         =   array(
            'one_menu'      =>  $return['one_menu'],
            'two_menu'      =>  $return['two_menu'],
            'navigation'    =>  $return['navigation']
        );

        $this->yunset($setarr);

        $siteM  =   $this->MODEL('site');
        
        $domain =   $siteM -> getList(array('orderby' => 'id,desc'), array('field' => "`id`,`title`"));

        $this->yunset('domain', $domain);

        $this->yuntpl(array('admin/admin_siteadmin_group'));
    }
    
	function delgroup_action()
	{
		$this->check_token();
		if(isset($_GET['id'])){
			$adminM  =  $this -> MODEL('admin');
		    
		    $return  =  $adminM -> delAdminGroup(array('id'=>intval($_GET['id'])));
		    
		    $this->layer_msg($return['msg'],$return['errcode']);
		}else{
			$this->layer_msg('非法操作！',8);
		}
	}
	function savagroup_action(){
		$adminM	=  $this -> MODEL('admin');
		
		if(empty($_POST['group_name'])){
			$this->ACT_layer_msg( "请填写权限组名称",8);
		}
		$power = array_filter($_POST['power']);
		
		if(empty($power)){
			$this->ACT_layer_msg( "请至少选择一项权限",8);
		}

		$value['group_name']	=	$_POST['group_name'];
		$value['group_power']	=	serialize(array_filter($power));
		$value['group_type']	=	'2';
		$value['did']			=	$_POST['did'];
		
		if(!$_POST['groupid']){
		
			$return	=	$adminM -> addAdminGroup($value);
		}else{

			$return	=	$adminM -> upAdminGroup($value,array('id'=>$_POST['groupid']));
		}
		$this->ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
	}
}

?>