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
class forgetpw_controller extends wxapp_controller{
	function sendcode_action(){
	    $sendtype 	= $_POST['sendtype'];
	    $noticeM 	= $this->MODEL('notice');
	    if ($sendtype=='moblie') {
	        $sended = $_POST['moblie'];
	        $type	= 'msg';
	        
	        $this->checkMcsdk($sended);
	        
	    }elseif ($sendtype=='email'){
	        $sended = $_POST['email'];
	        $type	= 'email';
	    }
	    $port		=	$this->plat == 'mini' ? '3' : '4';	// 短信发送端口$port : 3-小程序  4-APP
		$result 	=   $noticeM->sendCode($sended, 'getpass', $port, array(), 6 , 120, $type);
		if($result['error']==1){
			$errcode	=	1;
		}else{
			$errcode	=	2;
			$msg		=	$result['msg'];
		}
		$this->render_json($errcode,$msg);
	}
	function checksendcode_action(){
		$moblie		=	$_POST['moblie'];
		$email		=	$_POST['email'];
		
		$userinfoM	=	$this->MODEL("userinfo");
		$companyM	=	$this->MODEL("company");
		$noticeM	=	$this->MODEL("notice");
		
		if($_POST['sendtype']=='email'){
		    $info	= 	$userinfoM->getInfo(array('email'=>$email),array("field"=>"`uid`,`username`,`email`"));
			$check	=	$info['email'];
		}elseif($_POST['sendtype']=='moblie'){
			$info	= 	$userinfoM->getInfo(array('moblie'=>$moblie),array("field"=>"`uid`,`username`,`moblie`"));
			$check	=	$info['moblie'];
		}
		$cert		= 	$companyM->getCertInfo(array("uid"=>$info['uid'],"type"=>"7","check"=>$check,'orderby'=>'ctime,desc'));
		$codeTime   =   $noticeM -> checkTime($cert['ctime']);
		
		if (!$codeTime) {
		    $msg	=	"验证码验证超时，请重新验证！";
		    $error	=	2;
		}else if(($_POST['mobliecode']!=$cert['check2'])||(!$cert)){
		    $msg	=	"验证码错误";
		    $error	=	2;
		}else{
			$error	=	1;
			$data['user']	=	array('uid'=>$info['uid'],'username'=>$info['username']);
		}
		$this->render_json($error,$msg,$data['user']);
	}
	function checklink_action(){
		
	    $username		=	$_POST['username'];
		$userinfoM		=	$this->MODEL("userinfo");
		$member 		= 	$userinfoM->getInfo(array('username'=>$username),array("field"=>"`uid`,`username`"));
		
	    if($member['username']==""){
			$msg		=	"用户名不存在！";
			$error		=	2;
		}else if(CheckRegUser($username)==false && CheckRegEmail($username)==false){
	        $msg		=	"用户名包含特殊字符！";
	        $error		=	2;
	    }else{
			$shensu		=	$_POST['linkman'].'-'.$_POST['linkphone'].'-'.$_POST['linkemail'];
			$nid 		= 	$userinfoM->upInfo(array('username'=>$username),array('appeal'=>$shensu,'appealtime'=>time(),'appealstate'=>'1'));
			if ($nid){
				$error	=	1;
			}
		}
		$this->render_json($error,$msg);
	    
	}
	function editpw_action(){
        $username	=	$_POST['username'];
        $uid		=	$_POST['uid'];
		
		$moblie		=	$_POST['moblie'];
		$email		=	$_POST['email'];
		$code		=	$_POST['code'];

        if($username!=''&&$uid!=''){
			
            $userinfoM		=	$this->MODEL("userinfo");
            $companyM		=	$this->MODEL("company");
            $noticeM		=	$this->MODEL("notice");
			if(!empty($email)){
				$info 		= 	$userinfoM->getInfo(array('email'=>$email),array("field"=>"`uid`,`username`,`email`"));
				$check		=	$info['email'];
			}elseif(!empty($moblie)){
				$info 		= 	$userinfoM->getInfo(array('moblie'=>$moblie),array("field"=>"`uid`,`username`,`moblie`"));
				$check		=	$info['moblie'];
			}
			
			$cert 			= 	$companyM->getCertInfo(array("uid"=>$info['uid'],"type"=>"7","check"=>$check,'orderby'=>'ctime,desc'),array("field"=>"`uid`,`check2`,`ctime`,`id`"));
			
			$codeTime   	=   $noticeM -> checkTime($cert['ctime']);
			
			$pwmsg 	   		=   regPassWordComplex($_POST['password']);

			if (!$codeTime) {
			    $msg		=	"短信验证码验证超时，请重新验证！";
			    $error		=	2;
			}else  if(($code!=$cert['check2'])||(!$cert)){
				$msg		=	"验证码错误";
				$error		=	2;
			}else if($pwmsg!=''){
				$msg		=	$pwmsg;
				$error		=	2;
			}else{
				$info 		= 	$userinfoM->getInfo(array('uid'=>$uid),array("field"=>"`uid`,`username`,`email`,`moblie`,`name_repeat`"));
				
				if ($username==$info['username']){
					$password 	= 	$_POST['password'];
					$userinfoM  ->  upInfo(array("uid"=>$uid),array("password"=>$password));
					
					$msg		=	"密码修改成功";
					$error		=	1;
				}else{
					$msg		=	"对不起,没有该用户";
					$error		=	2;
				}
			}
        }else{
			$msg		=	"对不起,没有该用户";
			$error		=	2;
        }
		$this->render_json($error,$msg);
    }
	
	function getTel_action(){
		$data	=	array(
			'telphone'	=>	$this->config['sy_freewebtel'],
			'reg_pw_sp' =>  $this->config['reg_pw_sp'],
            'reg_pw_zm' =>  $this->config['reg_pw_zm'],
            'reg_pw_num'=>  $this->config['reg_pw_num'],
		);
		$this->render_json(1,'',$data);
	}
}
?>