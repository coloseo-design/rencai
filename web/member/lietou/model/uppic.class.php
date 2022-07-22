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
class uppic_controller extends lietou
{
	//照片管理
	function index_action(){
		$LietouM	=	$this -> MODEL('lietou');
		
		$row		=   $LietouM -> getInfo(array('uid'=>$this->uid),array('utype'=>'user'));
		
		$this->yunset("bpic",$row['photo_big']);
		
		$this->yunset("row",$row);
		
		$this->yunset("class",8);
		
		$this->public_action();
		
		$this->lietou_tpl('uppic');
	
	}

	
	function ajaxfileupload_action(){
		
		
		if($_FILES['image']['tmp_name']){

			$UploadM	=	$this->MODEL('upload');

			$imginfo  =  getimagesize($_FILES['image']['tmp_name']);

			if($imginfo[0] < 100 || $imginfo[1] < 100){
		        
		        $res['s_thumb']  =  '头像尺寸比例太小,最小尺寸：宽80/高100';
		        
		    }else{
		        $upArr  =  array(
		            'file'  	=>  $_FILES['image'],
		            'dir'   	=>  'lietou',
		            'type'  	=>  'logo',
		            'watermark'	=> 0
		        );
		        $return	  =  $UploadM -> newUpload($upArr);
		        
		        if(!empty($return['msg'])){
		            
		            $res['s_thumb']  =  $return['msg'];
		            
		        }else {
		            
		            $res['url']  =  checkpic($return['picurl']);
		        }
		    }
		}else{ 
			
			$res["s_thumb"]		=	'请选择上传图片';
			
		}
		echo json_encode($res);
	}

	
	function savethumb_action(){
		
		$upload_path = 'data/upload/lietou/';
		
		if(stripos(trim($_POST['img1']),$upload_path)===false ){
			
			$this->ACT_layer_msg("非法操作！",8,$_SERVER['HTTP_REFERER']);
		
		}
		
		$uploadM  =  $this->MODEL('upload');
		
		$thumb    =  $uploadM -> thumb('lietou');
		
		if(!$this -> ltInfo['uid']){
			$userinfoM    =   $this->MODEL("userinfo");
			$userinfoM -> activUser($this->uid,3);
		}

		$LietouM  =  $this->MODEL('lietou');
		
		$return	  =  $LietouM->upLogo(array('uid'=>$this->uid),array('thumb'=>$thumb,'utype'=>'user'));
		
		$this->layer_msg($return['msg'],$return['errcode']);
	
	}
	
}
?>