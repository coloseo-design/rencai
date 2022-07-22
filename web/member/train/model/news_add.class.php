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
class news_add_controller extends train
{
	function index_action(){
		$trainM		=	$this->MODEL('train');
		if($_POST['submit']){
			$pinfo		=	$this->pxInfo;
		
			$rstatus	=	$pinfo['r_status'];
		
			$value['title']	=	$_POST['title'];
      		$value['r_status']	=	$rstatus;
			$value['body']	=	str_replace("&amp;","&",$_POST['body']);
			$value['status']=	'0';
			$value['uid']	=	$this->uid;
			$value['did']	=	$this->userdid;
			$value['ctime']	=	time();
			if(!$_POST['id']){
				$return		=	$trainM->addPxnewsInfo(
					$value,
					array(
						'member'	=>	'train',
						'uid'		=>	$this->uid,
						'usertype'	=>	$this->usertype
					)
				);
			}else{
				$return		=	$trainM->upPxnewsInfo(
					array(
						'id'		=>	(int)$_POST['id'],
						'uid'		=>	$this->uid
					),
					$value,
					array(
						'member'	=>	'train',
						'uid'		=>	$this->uid,
						'usertype'	=>	$this->usertype
					)
				);
			}
			$this			->	ACT_layer_msg($return['msg'],$return['cod'],$return['url']);
		}
		if($_GET['id']){
			$row	=	$trainM	->	getPxnewsInfo(array('id'=>(int)$_GET['id'],'uid'=>$this->uid));
			$this	->	yunset("row",$row);
		}
		$this	->	train_satic();
		$this	->	train_tpl('news_add');
	}
}
?>