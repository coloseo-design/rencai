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
class user_member_controller extends adminCommon{
	
	function index_action(){       
		if(trim($_GET['keyword'])){
			$mwhere['username']	=	array('like',trim($_GET['keyword']));
			$memberlist			=	$this -> MODEL('userinfo')->getList($mwhere,array('field'=>'`uid`'));
			foreach($memberlist  as $val){
				$memberuids[]	=	$val['uid'];
			}
			$where['uid']		=	array('in',pylode(',',$memberuids));
			$urlarr['keyword']	=	$_GET['keyword'];
		}
		if($_GET['status']){
			$status				=	intval($_GET['status']);
			$where['r_status']	=	$status == 4 ? 0 : $status;
			$urlarr['status']	=	$status;
		}
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	'{{page}}';
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM			=	$this -> MODEL('page');
		$pages			=	$pageM -> pageList('resume',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
			$where['orderby']		=	array('uid,DESC');
			$where['limit']			=	$pages['limit'];
			$resumeM	=	$this -> MODEL('resume');
			$List		=	$resumeM -> getResumeList($where,array('utype'=>'admin'));
			$this -> yunset('userrows',$List);
		}
		$this->yunset('backurl','index.php?c=user');
		$this->yunset("headertitle","个人用户");
		$this->yuntpl(array('wapadmin/admin_member_userlist'));
	}
	
	function status_action(){
		$userinfoM	=	$this -> MODEL('userinfo');
		$post		=	array(
			'status'	=>	intval($_POST['status']),
			'lock_info'	=>	trim($_POST['statusbody'])
		);
		$return		=	$userinfoM -> status(array('uid'=> $_POST['id'],'usertype'=>1),array('post'=>$post));
		if($return['errcode']==9){
			$this->layer_msg($return['msg'],$return['errcode'],0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg($return['msg'],$return['errcode']);
		}
	}

	function edit_action(){
	    $_POST=$this->post_trim($_POST);
		if((int)$_GET['id']){
			$userinfoM	=	$this->MODEL('userinfo');
			$member		=	$userinfoM -> getInfo(array('uid'=>(int)$_GET['id']));
			$resumeM	=	$this -> MODEL('resume');
			$return		=	$resumeM -> getInfo(array('uid'=>(int)$_GET['id'], 'needCache'=>1));
			$setarr		=	array(
				'user_info'			=>	$member,
				'row'				=>	$return['resume'],
				'user_sex'			=>	$return['cache']['user_sex'],
				'userdata'			=>	$return['cache']['userdata'],
				'userclass_name'	=>	$return['cache']['userclass_name'],
				'lasturl'			=>	$_SERVER['HTTP_REFERER']
			);
			$this->yunset($setarr);
		}
		if($_POST['com_update']){
			$uid	=	intval($_POST['uid']);
			$mData	=	array(
				'username'	=>	$_POST['username'],
				'password'	=>	$_POST['password'],
				'moblie'	=>	$_POST['moblie'],
				'email'		=>	$_POST['email'],
				'status'	=>	$_POST['status']
			);
			$rData	=	array(
				'name'			=>	$_POST['name'],
				'sex'			=>	$_POST['sex'],
				'birthday'		=>	$_POST['birthday'],
				'exp'			=>	$_POST['exp'],
				'edu'			=>	$_POST['edu'],
				'telphone'		=>	$_POST['moblie'],
				'email'			=>	$_POST['email'],
				'domicile'		=>	$_POST['domicile'],
				'living'		=>	$_POST['living'],
				'marriage'		=>	$_POST['marriage'],
				'height'		=>	$_POST['height'],
				'nationality'	=>	$_POST['nationality'],
				'weight'		=>	$_POST['weight'],
				'idcard'		=>	$_POST['idcard'],
				'address'		=>	$_POST['address'],
				'homepage'		=>	$_POST['homepage'],
				'qq'			=>	$_POST['qq'],
				'description'	=>	$_POST['description'],
				'r_status'		=>	$_POST['status']
			);
			$resumeM	=	$this->MODEL('resume');
			$return		=	$resumeM -> upResumeInfo(array('uid'=>$uid),array('mData'=>$mData,'rData'=>$rData,'utype'=>'admin'));
			$lasturl	=	str_replace('&amp;','&',$_POST['lasturl']);
			$this->ACT_layer_msg($return['msg'], $return['errcode'], $lasturl, 2, 1);
		}
		
		$lasturl=$_SERVER['HTTP_REFERER'];
		if(strpos($lasturl, 'a=edit')===false){
		    if(strpos($lasturl, 'c=user_member')!==false){
		        $this->cookie->setcookie('lasturl',$lasturl,time()+300);
		        $_COOKIE['lasturl']=$lasturl;
		    }
		}
		$this->yunset('lasturl',$_COOKIE['lasturl']);
		
		$this->yunset("headertitle","个人用户");
		$this->yuntpl(array('wapadmin/admin_member_useredit'));
	}

	function add_action(){
		$this->yuntpl(array('wapadmin/admin_member_useradd'));
	}
	function save_action(){
		if($_POST['submit']){
			if($_POST['username']==''||mb_strlen($_POST['username'])<2||mb_strlen($_POST['username'])>16){
				$this -> ACT_layer_msg('用户名格式错误',8);
			}elseif($_POST['password']==''||mb_strlen($_POST['password'])<6||mb_strlen($_POST['password'])>20){
				$this -> ACT_layer_msg('密码格式错误',8);
			}elseif($_POST['moblie']==''){
				$this -> ACT_layer_msg('手机号不能为空',8);
			}
			$userinfoM  =  $this -> MODEL('userinfo');
			$result  	=  $userinfoM -> addMemberCheck($_POST);
			if ($result['msg']){
				$this -> ACT_layer_msg($result['msg'],8);
			}
			if($this->config['sy_uc_type']=='uc_center'){
				$this -> obj-> uc_open();
				$user  =  uc_get_user($_POST['username']);
				if(is_array($user)){
					$this -> ACT_layer_msg('该会员已经存在！',8);
				}
			}
			$time  =  time();
			$ip    =  fun_ip_get();
			$pass  =  $_POST['password'];
			if($this->config['sy_uc_type']=='uc_center'){
				$uid  =  uc_user_register($_POST['username'],$pass,$_POST['email']);
				if($uid < 0){
					switch($uid){
						case '-1' : $data['msg']='用户名不合法!';
						break;
						case '-2' : $data['msg']='包含不允许注册的词语!';
						break;
						case '-3' : $data['msg']='用户名已经存在!';
						break;
						case '-4' : $data['msg']='Email 格式有误!';
						break;
						case '-5' : $data['msg']='Email 不允许注册!';
						break;
						case '-6' : $data['msg']='该 Email 已经被注册!';
						break;
					}
					$this -> ACT_layer_msg($data['msg'],8);
				}else{
					list($uid,$username,$email,$password,$salt)=uc_get_user($_POST['email'],$pass);
				}
			}else{
				$salt  =  substr(uniqid(rand()), -6);
				$password  =  passCheck($pass,$salt);
			}
			$mdata = array(
				'username'	=>	$_POST['username'],
				'password'	=>	$password,
				'usertype'	=>	1,
				'salt'		=>	$salt,
				'moblie'	=>	$_POST['moblie'],
				'email'		=>	$_POST['email'],
				'reg_date'	=>	$time,
				'reg_ip'	=>	$ip,
				'status'	=>	1
			);
			$udata = array(
				'email'		=>	$_POST['email'],
				'telphone'	=>	$_POST['moblie'],
				'r_status'	=>	1
			);
			$nid  =  $userinfoM -> addInfo(array('mdata'=>$mdata,'udata'=>$udata));
			if($nid > 0){
				$this->ACT_layer_msg('个人会员(ID:'.$nid.')添加成功！',9,'index.php?m=user_member');
			}else{
				$this->ACT_layer_msg('个人会员添加失败，请重试！',8);
			}
		}
	}
	function del_action(){
		if ($_GET['del']){
			$uid	=	intval($_GET['del']);
		}elseif ($_POST['del']){
			$uid	=	$_POST['del'];
		}
		$userinfoM	=	$this -> MODEL('userinfo');
		$return		=	$userinfoM -> delInfo($uid, 1);
		$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	}

	function reset_pw_action(){
		$userinfoM	=	$this->MODEL('userinfo');
		$userinfoM -> upInfo(array('uid'=>intval($_GET['uid'])),array('password'=>'123456'));
		$this -> MODEL('log') -> addAdminLog('会员(ID:'.$_GET['uid'].')重置密码成功');
		echo "1";
	}

	//构建用户cookie
	function Imitate_action(){
		$userinfoM	=	$this->MODEL('userinfo');
		$member		=	$userinfoM -> getInfo(array('uid'=> intval($_GET['uid'])),array('field'=>'`uid`,`username`,`salt`,`email`,`password`,`usertype`,`did`'));
		$this -> cookie->unset_cookie();
		$this -> cookie->add_cookie($member['uid'],$member['username'],$member['salt'],$member['email'],$member['password'],1,$this->config['sy_logintime'],$member['did'],'1');
		header('Location: '.$this->config['sy_weburl'].'/member');
	}

	function checksitedid_action(){
		$uid		=	trim($_POST['uid']);
		$did		=	intval($_POST['did']);
		if(empty($uid)){
			$this -> ACT_layer_msg('参数不全请重试！', 8);
		}
		$uids		=	@explode(',',$_POST['uid']);
		$uid 		=	pylode(',',$uids);
		if(empty($uid)){
			$this -> ACT_layer_msg('请正确选择需分配用户！', 8);
		}
		$siteM		=	$this->MODEL('site');
		$didData	=	array('did' => $did);
		$Table		=	array(
			'company_cert','company_msg','company_order','invoice_record','look_job','member',
			'member_statis','resume','resume_expect','user_entrust','userid_job'
		);
		$siteM -> updDid(array('report'), array('p_uid' => array('in', $uid)), $didData);
		$siteM -> updDid(array('company_pay'),array('com_id'=>array('in', $uid)),$didData);
		$siteM -> updDid($Table,array('uid'=>array('in', $uid)),$didData);
		$this->ACT_layer_msg('会员(ID:'.$_POST['uid'].')分配站点成功！',9,$_SERVER['HTTP_REFERER']);
	}
	function lock_action(){
		$userinfoM	=	$this -> MODEL('userinfo');
		$post		=	array(
			'status'     =>  intval($_POST['status']),
			'lock_info'  =>  trim($_POST['lockbody'])
		);
		$return		=	$userinfoM -> lock(array('uid'=>intval($_POST['id']),'usertype'=>1),array('post'=>$post));
		
		if($return['errcode']==9){
			$this->layer_msg($return['msg'],$return['errcode'],0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg($return['msg'],$return['errcode']);
		}
	}
}

?>