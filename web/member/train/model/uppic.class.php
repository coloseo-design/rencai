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
class uppic_controller extends train
{
	function index_action(){

		$this	->	train_satic();
		$this	->	yunset("js_def",2);
		$this	->	train_tpl('uppic');
	}
	

	function ajaxfileupload_action(){
		if($_FILES['image']['tmp_name']){
		    
		    $UploadM  =  $this->MODEL('upload');
		    $imginfo  =  getimagesize($_FILES['image']['tmp_name']);
		    
		    if($imginfo[0] < 120 || $imginfo[1] < 120){
		        
		        $res['s_thumb']  =  '上传图片尺寸太小';
		        
		    }else{
		        $upArr  =  array(
		            'file'  	=>  $_FILES['image'],
		            'dir'   	=>  'train',
		            'type'  	=>  'logo',
		            'watermark'	=>	0
		        );
		        $return	  =  $UploadM -> newUpload($upArr);
		        
		        if(!empty($return['msg'])){
		            
		            $res['s_thumb']  =  $return['msg'];
		            
		        }else {
		            
		            $res['url']  =  checkpic($return['picurl']);
		        }
		    }
		}else{
			
			$res['s_thumb']  =  '请选择上传图片';
		}
		echo json_encode($res);die;
	}

	function savethumb_action(){
		
		$upload_path = 'data/upload/train/';
		
		if(stripos(trim($_POST['img1']),$upload_path)===false){
			$this -> ACT_layer_msg("非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
		$uploadM  =  $this->MODEL('upload');
		
		$thumb    =  $uploadM -> thumb('train');
		
		 
		if(!$this -> pxInfo['uid']){
			$userinfoM    =   $this->MODEL("userinfo");
			$userinfoM -> activUser($this->uid,4);
		}
		$trainM	  =  $this -> MODEL('train');
		$return	  =	$trainM	-> upLogo(array('uid'=>$this->uid),array('thumb'=>$thumb,'utype'=>'user'));

		$this->layer_msg($return['msg'],$return['errcode']);
	}
}
?>