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
class friendhelp_controller extends common{
	
	
	function share_action(){
		
		
		$helpM		=	$this -> MODEL('friendhelp');
		$return		=	$helpM -> getTokenInfo($_GET['id'],$_GET['token']);
		
		if($return['error']  == '1'){

			if($return['helpinfo']['etime']<time()){
				
				$this->ACT_msg_wap(Url('wap'), '本次助力已结束！',1 ,5);
			
			}else{
				//权益套餐
				$package		=	$helpM -> packageList($return['helpinfo']);
				$_GET['token']	=	urlencode($_GET['token']);
				
				$this->yunset("shareurl",Url('wap').'index.php?c=friendhelp&a=show&id='.$return['helpinfo']['id'].'&token='.$_GET['token']);
				
				$this->yunset("package",$package);
				$this->yunset("row",$return['helpinfo']);
				
				$this->seo('friendhelp');
				
				$this->yunset("headertitle","分享助力");
			}
			
		}else{
			$this->ACT_msg_wap(Url('wap'), '参数错误！',1 ,5);
		}

		$this->yuntpl(array('wap/helpshare'));

	}
	function show_action(){
		
			$helpM		=	$this  -> MODEL('friendhelp');
		//微信读取放在头部 只有在取得微信ID后才会继续执行 防止产生跳转开销
		if(is_weixin()){
			
			session_start();
			if(!$_SESSION['wxuser']){
				
					//拉取微信OPENID
				$packM 		= $this->MODEL('pack');
				$wxUser = $packM->getWxOpenid(Url('wap').'index.php?c=friendhelp&a=show&id='.$_GET['id'].'&token='.rawurlencode($_GET['token']),1);
				$_SESSION['wxuser']	=	$wxUser;
			}
		
			
			

			$this->yunset('isweixin','1');
			
			//检测是否已助力
			$logInfo	=	$helpM -> getSharelogInfo(array('pid'=>$_GET['id'],'wxid'=>$_SESSION['wxuser']['openid']));
			
			$this->yunset("loginfo",$logInfo);
			
		}
		
	
		$return		=	$helpM -> getTokenInfo($_GET['id'],$_GET['token']);
	
		//验证token 是否有效
		if($return['error']  == '1'){
			if($return['helpinfo']['etime']<time()){
				
				$this->ACT_msg_wap(Url('wap'), '本次助力已结束！',1 ,5);
			
			}else{
				

				//查询相关企业、招聘职位信息
				$CompanyM	=   $this -> MODEL('company');
				$comInfo	=	$CompanyM -> getInfo($return['helpinfo']['comid'], array('logo' => '1'));
			
				$JobM	=   $this -> MODEL('job');

				$joblist   =   $JobM -> getList(array('uid' => $return['helpinfo']['comid'], 'status' => '0', 'state' => '1', 'orderby' => 'lastupdate,desc', 'limit'=>'5'),array('isurl'=>'yes','field'=>'`id`,`uid`,`name`,`edu`,`exp`,`minsalary`,`maxsalary`'));
			
				//
				$loglist	=	$helpM -> getLogList(array('pid' => $return['helpinfo']['id']));
				
				$this->yunset("loglist",$loglist);

				$_GET['token']	=	urlencode($_GET['token']);
				$this->yunset("shareurl",Url('wap').'index.php?c=friendhelp&a=show&id='.$return['helpinfo']['id'].'&token='.$_GET['token']);

				$this->yunset("row",$return['helpinfo']);

				$this->yunset("cominfo",$comInfo);

				$this->yunset("joblist",$joblist['list']);
			}
			
		}else{
			$this->ACT_msg_wap(Url('wap'), '本次助力已结束！',1 ,5);
		}
		
		$this->seo('friendhelp');
		$this->yuntpl(array('wap/helpshow'));
	}

	//添加助力
	function addlog_action(){
		
		if($_POST['id'] && $_POST['token']){
			session_start();
			
			if($_SESSION['wxuser']){
			
				//进入页面就视为已助力
				$helpM			=	$this  -> MODEL('friendhelp');
				$return			=	$helpM -> getTokenInfo($_POST['id'],urldecode($_POST['token']));
					
				if($return['error']  == '1'){
				
					if($return['helpinfo']['etime']>=time()){
						
						$returnShare	=	$helpM -> checkHelp($return['helpinfo'],$_SESSION['wxuser']);
						if($returnShare['error']=='1'){
							
								echo json_encode(array('error'=>'1'));
						}else{
							
								echo json_encode(array('error'=>'0','msg'=>$returnShare['msg']));
						}
					
					}else{
				
						echo json_encode(array('error'=>'0','msg'=>'本次助力已结束！'));
					}
				}
			}else{
				echo json_encode(array('error'=>'0','msg'=>'请使用微信为好友助力'));
			
			}
		}else{
		
			echo json_encode(array('error'=>'0','msg'=>'助力失败'));
		}
	}
}
?>