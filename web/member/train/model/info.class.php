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
class info_controller extends train{
	function index_action(){
		$this -> train_satic();
		$this -> yunset($this->MODEL('cache')->GetCache(array('com','city','subject')));
		$this -> train_tpl('info');
	}
	function save_action(){
	    
		$_POST  =  $this ->	post_trim($_POST);
		
		$px            	=	$this->pxInfo;
		
		if($px){
			$rstaus     =   $px['r_status'];
		}else{
			$rstaus		=	$this->config['px_status'];
		}
		$mData  =  array(
		    'moblie'		=>	$_POST['linktel'],
		    'email'		    =>	$_POST['linkmail']
		);
		$trainData	=	array(
			'name'			=>	$_POST['name'],
			'sid'			=>	$_POST['sid'],
			'pr'			=>	$_POST['pr'],
			'provinceid'	=>	$_POST['provinceid'],
			'cityid'		=>	$_POST['cityid'],
			'threecityid'	=>	$_POST['threecityid'],
			'mun'			=>	$_POST['mun'],
			'address'		=>	$_POST['address'],
			'linkman'		=>	$_POST['linkman'],
			'linkphone'		=>	$_POST['linkphone'],
			'linktel'		=>	$_POST['linktel'],
			'sdate'			=>	$_POST['sdate'],
		    'content' 		=>	str_replace(array("&amp;",'background-color:#ffffff','background-color:#fff','white-space:nowrap;'),array('&','background-color:','background-color:','white-space:'),$_POST['content']),
		    'linkmail'		=>	$_POST['linkmail'],
			'linkqq'		=>	$_POST['linkqq'],
			'r_status' 		=> 	$rstaus,
		    'website'		=>	$_POST['website']
		);
		if(!$this -> pxInfo['uid']){
			$userinfoM    =   $this->MODEL("userinfo");
			$userinfoM -> activUser($this->uid,4);
		}
		$trainM	 =	$this -> MODEL('train');
		$return  =	$trainM	-> upTrainInfo(array('uid'=>$this->uid),array('trainData'=>$trainData,'mData'=>$mData,'utype'=>'user'));
    if($return['url']){
        $this -> ACT_layer_msg($return['msg'], $return['errcode'],$return['url']);
    }else{
       //当前手机号码不存在  页面不要刷新
      $this -> ACT_layer_msg($return['msg'],$return['errcode']);
    
    }
		
	    
	}
}
?>