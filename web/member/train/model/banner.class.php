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
class banner_controller extends train{
	function index_action(){
		$trainM		=	$this->MODEL('train');
		
		if($_POST['submit'] || $_POST['update']){
			
			$data['uid']		=	$this->uid;
			$data['usertype']	=	$this->usertype;
			$data['file']		=	$_FILES['file'];
			

			if($_POST['submit']){

				$data['type']		=	'add';
				
			}elseif($_POST['update']){
				
				$data['type']		=	'update';
				
			}

			$return	=	$trainM		->	setBanner($data);

			$this	->	ACT_layer_msg($return['msg'],$return['cod'],$return['url']);
		}
		
		$banner	=	$trainM	->	getBannerInfo(array('uid'=>$this->uid,'pic'=>array('<>','')),array('pic'=>'1'));
		
		$this	->	yunset("banner",$banner);
		$this	->	train_satic();
		$this	->	train_tpl('banner');
	}
}
?>