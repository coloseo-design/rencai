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
class friendhelp_controller extends wxapp_controller{
	
	function share_action()
	{
		$helpM		=	$this -> MODEL('friendhelp');
		$return		=	$helpM -> getTokenInfo($_POST['id'],rawurldecode($_POST['token']));
		
		if($return['error']  == '1'){

			if($return['helpinfo']['etime']<time()){
				
			    $this->render_json(1,'本次助力已结束');
			
			}else{
				//权益套餐
				$package  =  $helpM->packageList($return['helpinfo']);
				
				$data['package']  =  $package;
				$data['etime']    =  $return['helpinfo']['etime'];
				
				// app用分享数据
				if (isset($_POST['provider']) && $_POST['provider'] == 'app'){
				    
				    $data['shareData']  =  array(
				        'url'       =>  Url('wap').'index.php?c=friendhelp&a=show&id='.$return['helpinfo']['id'].'&token='.rawurlencode($_POST['token']),
				        'title'     =>  '帮我助力',
				        'summary'   =>  '我在'.$this->config['sy_webname'].'上发布了一则招聘启示，急需您的助力',
				        'imageUrl'  =>  checkpic($this->config['sy_wx_sharelogo'])
				    );
				}
				$this->render_json(0,'ok',$data);
			}
			
		}else{
		    $this->render_json(2,'参数错误');
		}
	}
	function show_action()
	{
		$helpM	 =	$this  -> MODEL('friendhelp');
		$return  =	$helpM -> getTokenInfo($_POST['id'],rawurldecode($_POST['token']));
	
		//验证token 是否有效
		if($return['error']  == '1'){
			if($return['helpinfo']['etime']<time()){
				
			    $this->render_json(1,'本次助力已结束');
			
			}else{
				//查询相关企业、招聘职位信息
				$CompanyM	=   $this -> MODEL('company');
				$cominfo	=	$CompanyM -> getInfo($return['helpinfo']['comid'], array('logo' => '1'));
			
				$JobM	   =   $this -> MODEL('job');
				$joblist   =   $JobM -> getList(array('uid' => $return['helpinfo']['comid'], 'status' => '0', 'state' => '1', 'orderby' => 'lastupdate,desc', 'limit'=>'5'),array('isurl'=>'yes','field'=>'`id`,`uid`,`name`,`edu`,`exp`,`minsalary`,`maxsalary`'));
			
				//
				$loglist	=	$helpM -> getLogList(array('pid' => $return['helpinfo']['id']));
				
				$data  =  array(
				    'loglist'   =>  !empty($loglist) ? $loglist : array(),
				    'helpinfo'  =>  $return['helpinfo'],
				    'cominfo'   =>  $cominfo,
				    'joblist'   =>  !empty($joblist['list']) ? $joblist['list'] : array()
				);
				$data['helped']  =  false;
				if ($_POST['provider'] == 'weixin'){
				    
				    $result =  $this->getOpenid($_POST['sign']);
				    
				    if (!empty($result['unionid'])){
				        
				        $logInfo  =  $helpM -> getSharelogInfo(array('pid'=>$_POST['id'],'unionid'=>$result['unionid']));
				        
				    }else{
				        
				        $logInfo  =  $helpM -> getSharelogInfo(array('pid'=>$_POST['id'],'wxid'=>$result['openid']));
				    }
				    if (!empty($logInfo)){
				        
				        $data['helped']  =  true;
				    }
				}
				$this->render_json(0,'ok',$data);
			}
			
		}else{
		    $this->render_json(1,'本次助力已结束');
		}
	}

	//添加助力
	function addlog_action()
	{
		if($_POST['id'] && $_POST['token']){
		    
			$result =  $this->getOpenid($_POST['sign']);
			if(isset($result['errcode'])){
			    $errmsg = $result['errcode'] == 40125 ? '微信小程序配置错误，请联系网站管理员' : '错误号:' .$result['errcode'];
			    $this->render_json(-1, $errmsg);
			}
			$wxuser  =  array(
			    'nickname'    =>  $_POST['nickName'],
			    'province'    =>  $_POST['province'],
			    'city'        =>  $_POST['city'],
			    'headimgurl'  =>  $_POST['avatarUrl'],
			    'openid'      =>  $result['openid'],
			    'unionid'     =>  $result['unionid']
			);
		    //进入页面就视为已助力
		    $helpM			=	$this  -> MODEL('friendhelp');
		    $return			=	$helpM -> getTokenInfo($_POST['id'],rawurldecode($_POST['token']));
		    
		    if($return['error']  == '1'){
		        
		        if($return['helpinfo']['etime']>=time()){
		            
		            $returnShare	=	$helpM -> checkHelp($return['helpinfo'],$wxuser);
		            
		            $this->render_json($returnShare['error'],$returnShare['msg']);
		        }else{
		            
		            $this->render_json(2,'本次助力已结束');
		        }
		    }
		}else{
		
		    $this->render_json(2,'助力失败');
		}
	}
}
?>