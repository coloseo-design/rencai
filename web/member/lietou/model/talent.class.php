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
class talent_controller extends lietou{

	function index_action(){
		$this->public_action();
		$this->yunset("class",14);
		$where['uid']	=  $this->uid;
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	'{{page}}';
	    $pageurl		=	Url('member',$urlarr);

	    $pageM			=	$this->MODEL('page');
	    $pages			=	$pageM->pageList('lt_talent',$where,$pageurl,$_GET['page']);
	    
	    if($pages['total'] > 0){
	        $where['orderby']		=	'id';
	        $where['limit']			=	$pages['limit'];
	        
	        $talentM  =  $this->MODEL('talent');
	        
	        $List   	=  $talentM->getList($where);
	    }
		$this->yunset("rows",$List);
		
		$this->lietou_tpl('talent');
	}

	function expect_action(){
		if($_GET['id']){
			$talentM	=	$this->MODEL('talent');
			$expectInfo	=	$talentM -> getInfo(array('id'=>intval($_GET['id']),'uid'=>$this -> uid));
			
			$this->yunset("resume",$expectInfo);
		}
		$this->yunset($this->MODEL('cache')->GetCache(array('city','user','hy')));
	
		$this->public_action();
		$this->yunset("class",14);
		$this->lietou_tpl('talent_expect');
	}
	function saveexpect_action(){
		if($_POST){
			$talentM = $this->MODEL('talent');
			$_POST['uid']	=	$this->uid;
			$_POST['did']	=	$this->userdid;
			$return  = $talentM->addTalent($_POST);
			
			if($return['error']=='1'){

				$this->ACT_layer_msg($return['msg'],9,'index.php?c=talent');
			}else{
				$this->ACT_layer_msg($return['msg'],8);
			}
		}
	
	}
	function telstatus_action(){
		
		$talentM = $this->MODEL('talent');
		
		$return  = $talentM->telStatus($_POST['id'],$this->uid,$_POST['linktel'],$_POST['code']);
		
		if($return['error']=='1'){

			$this ->MODEL('log')-> addMemberLog($this -> uid, 3,"简历库授权认证",2,2);//会员日志
		}
		echo json_encode($return);
	}
	// 验证手机号
	function regmoblie_action()
	{
	    $userinfoM  =  $this->MODEL("userinfo");
	    
	    $return     =  $userinfoM -> addMemberCheck(array('moblie'=>$_POST['telphone']),$this->uid);
	    
	    if ($return['msg']) {
	        
	        echo 1;die;
	    } else {
	        
	        echo 0;die;
	    }
	}
}
?>