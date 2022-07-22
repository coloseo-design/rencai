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
class crm_org_controller extends adminCommon
{

    function index_action()
    {
    	
    	$crmM		=	$this->MODEL('crm');
    	$orgList	=	$crmM -> getOrgList(array('orderby' => 'sort,desc'), 'org');
    	$this->yunset(array('orgList' => $orgList, 'orgArr' => $orgList['orgArr']));

    	if ($_GET['id']){
    		$where['id']	=	$_GET['id'];
    	}
    	$where['orderby']	=	'id,asc';
     	$orgInfo	=	$crmM -> getOrgInfo($where);
    	$this->yunset('orgInfo', $orgInfo);
    	
    	$this->yunset(array('musers' => $orgInfo['musers'], 'muserids' => json_encode($orgInfo['muserids']), 'ausers' => json_encode($orgInfo['ausers'])));
        $this->yuntpl(array('admin/crm_org_list'));
    }
    
    function orgShow_action()
    {
    	
    	$crmM		=	$this->MODEL('crm');
    	$orgList	=	$crmM -> getOrgList(array('orderby' => 'sort,desc'), 'org');
    	$this->yunset(array('orgList' => $orgList, 'orgArr' => $orgList['orgArr']));

    	if ($_GET['id']){
    		$where['id']	=	$_GET['id'];
    	}
    	$where['orderby']	=	'id,asc';
     	$orgInfo	=	$crmM -> getOrgInfo($where);
    	$this->yunset('orgInfo', $orgInfo);
    	
    	$this->yunset(array('musers' => $orgInfo['musers'], 'muserids' => json_encode($orgInfo['muserids']), 'ausers' => json_encode($orgInfo['ausers'])));
        $this->yuntpl(array('admin/crm_org_show'));
    }
    
    
    function addOrg_action(){
    	
    	$_POST							=	$this->post_trim($_POST);
	    $position						=	explode('-', trim($_POST['name']));
	    
	    foreach ($position as $k => $val){
	    	$v	=	trim($val);
	    	if (!empty($v)){
	       		$name[]					=	$v;
	    	}
		}
		
		if(empty($name)){
			echo 3;die;
		}

		$crmM							=	$this -> MODEL('crm');
		$parts							=	$crmM -> getOrgList(array('name' => array('in', implode(",", $name))));
 
	    if(empty($parts)){
	        $fid						=	intval($_POST['fid']);
	        $fInfo						=	$crmM -> getOrgInfo(array('id' => $fid));
	        $level						=	intval($fInfo['level']) + 1;
			foreach ($name as $key=>$val){
				$orgAdd					=	array();
				$orgAdd['name']			=	$val;
				$orgAdd['fid']			=	$fid;
				$orgAdd['level']		=	$level;
				$add					=	$crmM -> addCrmOrg($orgAdd);
			}
	        $add ? $msg = 2 : $msg = 3;
	        $this -> MODEL('log') -> addAdminLog('组织架构添加成功');
	    }else{
	        $msg						=	3;
	    }
	    echo $msg;die;
    	
    }
    
    function upOrg_action(){
    	
    	if ($_POST){
    		
    		$crmM 	= 	$this->MODEL('crm');
    		
    		$id		=	$_POST['id'];
    		
    		$vData	=	array('name' => $_POST['name']);
    		
    		$return	=	$crmM -> upCrmOrg($id,$vData);
    		
    		echo json_encode($return);die;
    	}
 
    }
    
	function delOrg_action(){
    	 
		if($_GET['id']){
			
			$this -> check_token();
			$delId	=	intval($_GET['id']);
		}
		
		$crmM	=	$this->MODEL('crm');	

		$return	=	$crmM -> delOrg($delId);

		if($return['errcode'] == '9'){

			$this -> MODEL('log') -> addAdminLog("删除CRM部门（ID：".$delId."）");
		}

		$this -> layer_msg($return['msg'], $return['errcode'], $return['layertype'], 'index.php?m=crm_org&c=orgShow&id='.$return['org']);
 
    }
    
    
    function addOrgUser_action(){
    	
    	if ($_POST){

    		$data	=	array(
    			'id'	=>	intval($_POST['id']),
    			'uids'	=>	$_POST['uids']
    		);
    		
    		$crmM	=	$this->MODEL('crm');
    		
    		$return	=	$crmM -> configCrmOrg($data);
    		
    		echo $return; die;
    		
    	}else {
    		
    		echo 3; die;
    	}
    }
    
	function delOrgUser_action(){
    	
		
		
		if($_POST['del']){
			
			$delId	=	$_POST['del'];
		}else if($_GET['id']){
			
			$this -> check_token();
			$delId	=	intval($_GET['id']);
		}
		
		$crmM	=	$this->MODEL('crm');	

		$return	=	$crmM -> delOrgUser($delId);

		if($return['errcode'] == '9'){

			$this -> MODEL('log') -> addAdminLog("删除CRM部门成员（ID：".$delId."）");
		}

		$this -> layer_msg($return['msg'], $return['errcode'], $return['layertype'], $_SERVER['HTTP_REFERER']);
 
    }
    
    function setCrmPower_action(){
    	if($_POST){
    		
    		$uid	=	intval($_POST['uid']);
    		
    		if ($_POST['type'] == 'power'){
    			
    			$data	=	array( 
    				'power'	=>	$_POST['power']
    			);
    		}else if($_POST['type'] == 'spower'){
    			$data	=	array(
    				'spower'=>	$_POST['power']
    			);
    		}
    		
    		$crmM	=	$this->MODEL('crm');
    		 
    		$result	=	$crmM -> configCrmPower($uid, $data);
    		
    		echo $result; die;
    	}else{
    		
    		echo 3; die;
    	}
    }
}

?>