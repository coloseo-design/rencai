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
class index_controller extends school_controller{
	function index_action(){
        $this->public_action();
        $CacheM		=	$this->MODEL('cache');
	    $CacheList	=	$CacheM->GetCache(array('city'));
	    $this->yunset($CacheList);
		
        $this->seo('school');
		$this->school_tpl('index');
	}
    function schoollist_action(){
        
		$schoolM	=	$this->MODEL('school');
		
         if($_GET['provieid']){
			 
            $academyList	=	$schoolM->getSchoolAcademyList(array('provinceid'=>$_GET['provieid'],'limit'=>30),array('field'=>'`id`,`schoolname`,`photo`,`provinceid`,`cityid`,`school_categty`'));
			$academy		=	$academyList['list'];
            if($academy){
				foreach($academy as $v){
					
					$Hotjob		=	array(
						'url'				=>	Url("school",array('c'=>'academyshow','id'=>$v['id'])),
						'id'				=>	$v['id'],
						'photo'				=>	$v['photo_n'],
						'schoolname'		=>	$v['schoolname'],
						'provinceid'		=>	$v['provinceid_n'],
						'cityid'			=>	$v['cityid_n'],
						'school_categty'	=>	$v['school_categty_n']
					); 
					  $data[]	= 	$Hotjob;
				}
            }else{
				$data	=	null;
            }
             echo $_GET['callback']."(".str_replace("\\/", "/",json_encode($data)).")";
        }
    }

    function academy_action(){
        if($_GET[city]){//城市匹配
	        $city					=	explode("_",$_GET[city]);
	        $_GET['provinceid']		=	$city[0];
	        $_GET['cityid']			=	$city[1];
	        $_GET['three_cityid']	=	$city[2];
	    }
        
		$CacheM		=	$this->MODEL('cache');
        $CacheList	=	$CacheM->GetCache(array('city','school'));
	    $this->yunset($CacheList);
		
        $this->public_action();
        $this->yunset('def','3');
        $this->seo('school_academy');
		$this->school_tpl('school_academy');
    }
    function academyshow_action(){
        //查询详细信息
        if($_GET['id']){
			$schoolM		=	$this->MODEL('school');
			$atnM			=	$this->MODEL('atn');
			
            $list	=	$schoolM->getSchoolAcademyInfo(array('id'=>$_GET['id']));
			$row	=	$list['info'];
			$this->yunset("row",$row);
			
            //是其他院校宣讲会
            $academy	=	$schoolM -> getSchoolAcademyList(array('id'=>array('<>',$_GET['id']),'limit'=>10),array('xjh'=>1));
			$this->yunset("academy",$academy['list']);
			
			$atn	    =	$atnM -> getatnInfo(array('sc_uid'=>$_GET['id'],'uid' => $this->uid));
			if (!empty($atn)) {
			    $this->yunset("atn",$atn);
			}
        }
        $this->public_action();
		
		$data['name']	=	$row['schoolname'];
		$this->data		=	$data;
        $this->seo('school_academy_show');
        $this->yunset('def','3');
		$this->school_tpl('school_academy_show');
    }
	function xjh_action(){
		if($_GET['city']){//城市匹配
	        $city					=	explode("_",$_GET['city']);
	        $_GET['provinceid']		=	$city[0];
	        $_GET['cityid']			=	$city[1];
	        $_GET['three_cityid']	=	$city[2];
	    }
		$CacheM		=	$this->MODEL('cache');
		$CacheList	=	$CacheM->GetCache(array('school','city'));
		$this->yunset($CacheList);
		
		$adtime		=	array('1'=>'今天','3'=>'最近3天','7'=>'最近7天','15'=>'最近15天','30'=>'最近一个月','90'=>'最近三个月');
        $this->yunset("adtime",$adtime);
		
		$this->public_action();
		$this->seo('xjh');
		$this->yunset('def','2');
		$this->school_tpl('xjh');
	}
	function job_action(){
		
	    if($_GET[city]){//城市匹配
	        $city					=	explode("_",$_GET[city]);
	        $_GET['provinceid']		=	$city[0];
	        $_GET['cityid']			=	$city[1];
	        $_GET['three_cityid']	=	$city[2];
	    }
		if($this->config['province']){
			$_GET['provinceid'] 	= 	$this->config['province'];
		}
		if($this->config['cityid']){
			$_GET['cityid'] 		= 	$this->config['cityid'];
		}
		if($this->config['three_cityid']){
			$_GET['three_cityid']	= 	$this->config['three_cityid'];
		}
		
        $CacheM		=	$this->MODEL('cache');
        $CacheList	=	$CacheM->GetCache(array('job','city','com','hy','uptime'));
	    $this->yunset($CacheList);
		
		$url 	= $_SERVER["REQUEST_URI"];
		$citys 	= strstr(strstr($url, '-list', TRUE), '-city');
		$citys 	= str_replace("-city_","",$citys);
		$citys 	= @explode('_',$citys);
		if($citys[0]){
			$_GET['provinceid']		=	$citys[0];
		}
		if($citys[1]){
			$_GET['cityid']			=	$citys[1];
		}
		if($citys[2]){
			$_GET['three_cityid']	=	$citys[2];
		}
		$lists = strstr(strstr($url, '.html', TRUE), '-list_');
		$lists = str_replace("-list_","",$lists);
		$lists = @explode('_',$lists);
		if($lists[0]){
			$_GET['edu']		=	$lists[0];
		}
		if($lists[1]){
			$_GET['uptime']		=	$lists[1];
		}
		if($lists[2]){
			$_GET['pr']			=	$lists[2];
		}
		if($lists[3]){
			$_GET['job1']		=	$lists[3];
		}
		if($lists[4]){
			$_GET['job1_son']	=	$lists[4];
		}
		if($lists[5]){
			$_GET['job_post']	=	$lists[5];
		}
		if($lists[6]){
			$_GET['page']		=	$lists[6];
		}
		$_GET['is_graduate']	=	1;
		
		$this->yunset('def','1');
		$this->public_action();
		$this->seo("ws");
		$this->school_tpl('job');
	}
	function atnxjh_action(){
		if(!$this->uid||!$this->username){
			$arr['msg']		=	'请先登录！';
			$arr['status']	=	8;
		}elseif($this->uid==$_POST['comid']){
			$arr['msg']		=	'本人发布，无法关注！';
			$arr['status']	=	8;
		}
		$atnM		=	$this->MODEL('atn');
		$atnnum		=	$atnM->getAtnNum(array('xjhid'=>$_POST['id'],'uid'=>$this->uid));
		
		if($atnnum){
			$arr['msg']		=	'您已关注！';
			$arr['status']	=	8;
		}else{
			$userinfoM		=	$this->MODEL('userinfo');
			$adata	=	array(
				'uid'			=>	$this->uid,
				'usertype'		=>	$this->usertype,
				'sc_uid'		=>	$_POST['comid'],
				'sc_usertype'	=>	2,
				'xjhid'			=>	$_POST['id'],
				'time'			=>	time()
			);
			$nid	=	$atnM->addAtnInfo($adata);
			if($nid){
				$arr['msg']		=	'关注成功！';
				$arr['status']	=	9;
			}else{
				$arr['msg']		=	'关注失败！';
				$arr['status']	=	8;
			}
		}
		echo json_encode($arr);die;
	}
    function add_school_academy_action(){
		$atnM	=	$this->MODEL('atn');
        $value['uid']			=	$this->uid;
        $value['sc_uid']		=	$_POST['id'];
        $value['usertype']		=	$this->usertype;
        $value['sc_usertype']	=	5;
        $value['time']			=	time();
        $nid	=	$atnM->addAtnInfo($value);
        if($nid){
            //关注成功！
            $arr['msg']		=	'关注成功！';
			$arr['status']	=	9;
        }else{
            //关注失败！
            $arr['msg']		=	'关注失败！';
			$arr['status']	=	8;
        }
        echo json_encode($arr);die;
    }
    function del_xjh_action(){
		$atnM		=	$this->MODEL('atn');
		$return		=	$atnM->delAtnAll((int)$_GET['id'],array('sc_usertype'=>2,'xjh'=>1,'uid'=>$this->uid,'usertype'=>$this->usertype));

		$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],"index.php?m=school&c=xjh");
    }
    function del_school_academy_action(){
        //取消关注
		$atnM		=	$this->MODEL('atn');
		$return		=	$atnM->delAtnAll((int)$_POST['id'],array('sc_usertype'=>5,'uid'=>$this->uid,'usertype'=>$this->usertype));
		
		$arr  =   array(
		    'status'  =>  $return['errcode'],
		    'msg'     =>  $return['msg']
		);
		echo json_encode($arr);die;
		
    }
	function report_action(){
		session_start();
		$reportM	= 	$this->MODEL('report');
		if(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode']  || empty($_SESSION['authcode'])){
			unset($_SESSION['authcode']);
			echo 1;die;//验证码不正确！
		}
		$row		=	$reportM->getReportOne(array('p_uid'=>$this->uid,'eid'=>(int)$_POST['id'],'c_uid'=>(int)$_POST['x_uid'],'usertype'=>$this->usertype));
		
		if(is_array($row)){
			echo 2;die;//您已经举报过该用户！
		}
		$data		=	array(
			'c_uid'		=>	(int)$_POST['x_uid'],
			'inputtime'	=>	mktime(),
			'p_uid'		=>	$this->uid,
			'usertype'	=>	(int)$this->usertype,
			'eid'		=>	(int)$_POST['id'],
			'r_name'	=>	$this->stringfilter($_POST['c_name']),
			'username'	=>	$this->username,
			'r_reason'	=>	$this->stringfilter($_POST['e_reason']).'@'.$this->stringfilter($_POST['r_reason']),
			'did'		=>	$this->userdid,
			'type'		=>	3
		);
		
		$nid		=	$reportM->addSchoolReport($data);
		if($nid){
			echo 3;die;//举报成功！
		}else{
			echo 4;die;//举报失败！
		}
	}
}
?>