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
class spview_controller extends user{
    //视频面试列表
    function index_action(){
		$spviewM		=	$this->MODEL('spview');
		
		$where			=	$urlarr =   array();
        
        $where['uid']   =   $this->uid;

        $urlarr['c']    =   $_GET['c'];
        $urlarr['page'] =   '{{page}}';
        $pageurl        =   Url('member', $urlarr);

        $pageM          =   $this -> MODEL('page');
        $pages          =   $pageM -> pageList('spview_subscribe', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {
            $where['orderby']   =   'ctime,desc';
            $where['limit']     =   $pages['limit'];
			
			$List	=	$spviewM -> getSublist($where,array('job'=>1, 'room'=>1));
        }
        $this -> yunset('rows', $List);
		$this->public_action();
		$this->user_tpl('spview');
    }
    //进入视频面试
    function sproom_action(){
        
        if (empty($this->config['sy_spview_appkey']) || empty($this->config['sy_spview_appsecret'])){
            
            $this->ACT_msg('index.php', '网站未配置视频面试功能');
        }
        if (strpos($this->config['sy_weburl'], 'https') === false) {
            
            $this->ACT_msg('index.php', '网站未配置HTTPS，无法使用视频面试功能');
        }
        
        $this->public_action();
        
        $id 		=	$_GET['id'];
        
        $spviewM	=	$this->MODEL('spview');
        
        $spview		=	$spviewM->getInfo(array('id'=>$id));
        
        $CompanyM			 =  $this -> MODEL('company');
        $company     		 =  $CompanyM -> getInfo($spview['uid'], array('field'=>'`name`,`logo`,`logo_status`,`provinceid`,`cityid`,`hy`,`mun`,`content`,`address`','logo' => '1'));
        $company['content']  =  mb_substr(strip_tags($company['content']), 0, 300);
        
        $jobM				 =  $this -> MODEL('job');
        $job                 =  $jobM -> getInfo(array('id'=>$spview['jobid']));
        $job['description']  =  mb_substr(strip_tags($job['description']), 0, 200);
        
        $linenum  =  $spviewM->getSubNum(array('sid'=>$id,'status'=>0,'rtime'=>array('>',0)));
        $msnum    =  $spviewM->getSubNum(array('sid'=>$id,'status'=>2));
        
        $subinfo  =  $spviewM->getSubinfo(array('uid'=>$this->uid,'sid'=>$id));
        
        $this->yunset(array('spview'=>$spview,'company'=>$company,'job'=>$job,'linenum'=>$linenum,'msnum'=>$msnum,'subinfo'=>$subinfo));
        
        $trtcM  =  $this->MODEL('trtc');
        $trtc   =  $trtcM->getUserSig(array('uid'=>$this->uid, 'fuid'=>$spview['uid'],'usertype'=>1));
        
        if (!empty($trtc['errcode'])){
            
            $this->ACT_msg('index.php', $trtc['msg']);
        }
        
        $trtcConfig  =  array(
            'userId'      =>  $trtc['wid'] .'_'.$this->uid,
            'commentID'   =>  $spview['uid'],
            'roomId'      =>  $trtc['roomid'],
            'sdkAppId'    =>  $trtc['appid'],
            'userSig'     =>  $trtc['usersig'],
            'csRoomId'    =>  $trtc['csroomid'],
            'spWait'      =>  $this->config['sy_spview_wait'] * 1,
            'spLong'      =>  $this->config['sy_spview_time'] * 1
        );
        
        $this->yunset('trtcConfig',$trtcConfig);
        
        $this->user_tpl('sproom');
    }
	//取消预约视频面试
	function delSub_action(){
		
		if($_GET['del']){
			
			$spviewM	=	$this->MODEL('spview');
			
			$id			=   intval($_GET['del']);
			
			$arr		=   $spviewM -> delSub($id, array('uid' => $this->uid, 'usertype' => $this->usertype));
			
			$this ->  layer_msg($arr['msg'], $arr['errcode'], $arr['layertype'],$_SERVER['HTTP_REFERER']);
		}
    }

    function webrtc_action(){
        
        if (empty($this->config['sy_spview_appkey']) || empty($this->config['sy_spview_appsecret'])){
            
            $this->ACT_msg('index.php', '网站未配置视频面试功能');
        }
        if (strpos($this->config['sy_weburl'], 'https') === false) {

            $this->ACT_msg('index.php', '网站未配置HTTPS，无法使用视频面试功能');
        }
        
        $CompanyM			 =  $this -> MODEL('company');
        $company     		 =  $CompanyM->getInfo($_GET['fuid'], array('field'=>'`name`,`logo`,`logo_status`,`provinceid`,`cityid`,`hy`,`mun`,`content`,`address`','logo' => '1'));
        $company['content']  =  mb_substr(strip_tags($company['content']), 0, 300);
        
        $this->yunset('company',$company);
        
        $trtcM  =  $this->MODEL('trtc');
        $trtc   =  $trtcM->getUserSig(array('uid'=>$this->uid,'usertype'=>1,'fuid'=>$_GET['fuid']));
        
        if (!empty($trtc['errcode'])){
            
            $this->ACT_msg('index.php', $trtc['msg']);
        }
        
        $trtcConfig  =  array(
            'userId'      =>  $trtc['wid'] .'_'.$this->uid,
            'commentID'   =>  $_GET['fuid'],
            'roomId'      =>  $trtc['roomid'],
            'sdkAppId'    =>  $trtc['appid'],
            'userSig'     =>  $trtc['usersig'],
            'csRoomId'    =>  $trtc['csroomid'],
            'spWait'      =>  $this->config['sy_spview_wait'] * 1,
            'spLong'      =>  $this->config['sy_spview_time'] * 1
        );
        
        
        $this->yunset('trtcConfig',$trtcConfig);
        
        $this->public_action();
        
        $this->user_tpl('webrtc');
    }
    
}
?>