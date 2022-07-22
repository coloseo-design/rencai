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
class index_controller extends adminCommon{
	function index_action(){ 
		if($_POST['login_sub']){			
			if($_POST['username'] && $_POST['password']){			
				$islogin = $this->wapadmin_get_user_login($_POST['username'], $_POST['password']);
				if(!$islogin){

					$data['msg']='用户名或密码错误！';
					$data['url']='';
					$this->yunset("layer",$data);
					$this->yuntpl(array('wapadmin/login'));
				}else{
					header("location:index.php");
					//$this->yuntpl(array('wapadmin/index'));
				}
				
			}else{
				$data['msg']='请完整输入账户名、密码！';
				$data['url']='';
				$this->yunset("layer",$data);
				$this->yuntpl(array('wapadmin/login'));
			}
		}else{

			if($_SESSION['wuid']){
				$jobM		=	$this->MODEL('job');
				$linkM		=	$this->MODEL('link');
				$resumeM	=	$this->MODEL('resume');
				$companyM	=	$this->MODEL('company');
				$userinfoM	=	$this->MODEL('userinfo');
				$comorderM	=	$this->MODEL('companyorder');
				
			/*************登录以后调用数据Start***************/
			$today		=	strtotime('today');
			$yesterday	=	$today-86400;
			$tocomwh['usertype']		=	$yestercomwh['usertype']	=	'2';
			$tocomwh['reg_date']		=	array('>=',$today);
			$yestercomwh['reg_date'][]	=	array('>=',$yesterday);
			$yestercomwh['reg_date'][]	=	array('<',$today);
			$list['com_num_now']	=	$userinfoM -> getMemberNum($tocomwh);//企业会员(今日)
			$list['com_num']		=	$userinfoM -> getMemberNum($yestercomwh);//企业会员(昨日)
			$yesterjobwh['sdate'][]	=	array('>=',$yesterday);
			$yesterjobwh['sdate'][]	=	array('<',$today);
			$list['job_num_now']	=	$jobM -> getJobNum(array('sdate'=>array('>=',$today)));//职位数(今日)
			$list['job_num']		=	$jobM -> getJobNum($yesterjobwh);//职位数(昨日)
			$touserwh['usertype']		=	$yesteruserwh['usertype']	=	'1';
			$touserwh['reg_date']		=	array('>=',$today);
			$yesteruserwh['reg_date'][]	=	array('>=',$yesterday);
			$yesteruserwh['reg_date'][]	=	array('<',$today);
			$list['user_num_now']	=	$userinfoM -> getMemberNum($touserwh);//个人会员(今日)
			$list['user_num']		=	$userinfoM -> getMemberNum($yesteruserwh);//个人会员(昨日)
			$yesterresumewh['ctime'][]	=	array('>=',$yesterday);
			$yesterresumewh['ctime'][]	=	array('<',$today);
			$list['resume_num_now']	=	$resumeM -> getExpectNum(array('ctime'=>array('>=',$today)));//简历数(今日)
			$list['resume_num']		=	$resumeM -> getExpectNum($yesterresumewh);//简历数(昨日)
			
			$list['user_num_dsh']		=	$resumeM -> getResumeNum(array('r_status'=>'0'));//待审核个人会员
			$list['resume_num_dsh']		=	$resumeM -> getExpectNum(array('state'=>'0'));//待审核个人简历
			$list['com_num_dsh']		=	$companyM -> getCompanyNum(array('r_status'=>'0'));//待审核企业会员
			$list['job_num_dsh']		=	$jobM -> getJobNum(array('state'=>'0'));//待审核职位
			$list['link_num_dsh']		=	$linkM -> getLinkNum(array('link_state'=>'0'));//待审核链接
			$list['order_num_dsh']		=	$comorderM -> getCompanyOrderNum(array('order_state'=>'1'));//待处理订单
			$list['comcert_num_dsh']	=	$companyM -> getCertNum(array('type'=>'3','status'=>'0'));//待审核企业认证
			$list['usercert_num_dsh']	=	$resumeM -> getResumeNum(array('idcard_status'=>'0','idcard_pic'=>array('<>','')));//待审核个人认证
			
			$this->yunset("list",$list);

			/*************登录以后调用数据END***************/
				
				
				$this->yuntpl(array('wapadmin/index'));
			}else{
				$this->yuntpl(array('wapadmin/login'));
			}
		}
	}
	function logout_action(){
		unset($_SESSION['authcode']);
		unset($_SESSION['wuid']);
		unset($_SESSION['wusername']);
		unset($_SESSION['wshell']);
		unset($_SESSION['md']);
		unset($_SESSION['tooken']);
		unset($_SESSION['xsstooken']);
		$this->layer_msg("您已成功退出！",9,0,"index.php");
	}
}
?>