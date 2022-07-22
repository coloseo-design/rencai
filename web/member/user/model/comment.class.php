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
class comment_controller extends user{
	//面试评价
	function index_action(){

		if($_GET['id'] && $this -> config['com_msg_status'] == '1'){
			$this->public_action();
			$jobM		=	$this->MODEL('job');
			$companyM	=	$this->MODEL('company');
			//验证信息
			$msg 		=	$jobM->getYqmsInfo(array('id'=>(int)$_GET['id'],'uid'=>$this->uid,'isdel'=>9));
			
			if(!empty($msg)){
				if($msg['is_browse']=='3'){
					
					//查询是否已经评论过
					$msgInfo	=	$companyM->getCompanyMsgInfo(array('msgid'=>$msg['id']));
					$this->yunset("msgInfo",$msgInfo);
					
					$this->yunset("msg",$msg);
					
					$this->yunset($this->MODEL('cache')->GetCache(array('com')));
					$this->user_tpl('comment');
				}else{
					$this->layer_msg('参与面试后方可评论！',8,0,$_SERVER['HTTP_REFERER']);
				}
			}else{
				$this->layer_msg('请选择正确的信息！',8,0,$_SERVER['HTTP_REFERER']);
				
			}
		}
	}
    //面试评价修改保存
	function save_action(){
		$companyM	=	$this->MODEL('company');
		
		$data		=	array(
			'id'			=> (int)$_POST['id'],
			'uid'			=> $this->uid,
			'did'			=> $this->userdid,
			'desscore' 		=> (int)$_POST['desscore'],
			'hrscore' 		=> (int)$_POST['hrscore'],
			'comscore' 		=> (int)$_POST['comscore'],
			'content'  		=> strip_tags($_POST['content']),
			'othercontent'  => strip_tags($_POST['othercontent']),
			'tag'			=> $_POST['tag'],
			'isnm'			=> (int)$_POST['isnmval']
		);
		$return		=	$companyM->addCompanyMsg($data);
		
		$this->ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER']);
	}
	
}
?>