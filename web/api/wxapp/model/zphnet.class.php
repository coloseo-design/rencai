<?php

/**
 * $Author ：PHPYUN开发团队
 *
 * 官网: http://www.phpyun.com
 *
 * 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
 *
 * 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */

class zphnet_controller extends wxapp_controller
{

    function list_action()
	{

	    $time     =  time();
	    $zphnetM  =  $this->MODEL('zphnet');
	    // 处理分站查询条件
	    if (!empty($_POST['did'])){
	        $where['did']  =  $_POST['did'];
	    }
        //根据后台设置开启/隐藏
        $where['is_open'] = 1;
	    $field    =  '`id`,`title`,`starttime`,`endtime`,`pic`,`pnum`,`jnum`,`zpnum`,`anum`,`unum`,`pic_wap`,`banner_wap`';

	    $zphone  =  $zphnetM->getInfo(array('unix_timestamp(`endtime`)'=>array('>',$time)),array('field'=>'`id`'));
	    
	    if (!empty($zphone)){
	        // 条件排序，进行中在最上面，接着是未开始，最后是已结束
	        $field  .=  ',CASE WHEN unix_timestamp(`endtime`)>'.$time.' THEN unix_timestamp(`starttime`)';
	        $field  .=  ' WHEN unix_timestamp(`endtime`)<'.$time.' THEN -1*unix_timestamp(`starttime`) END AS `zph_px`';

	        $where['orderby'] =  ' CASE WHEN unix_timestamp(`starttime`)<"'.$time.'" AND unix_timestamp(`endtime`)>"'.$time.'" THEN 0';
	        $where['orderby'] .=  ' WHEN unix_timestamp(`starttime`)>"'.$time.'" THEN 1';
	        $where['orderby'] .=  ' WHEN unix_timestamp(`endtime`)<"'.$time.'" THEN 2';
	        $where['orderby'] .=  ' END,`zph_px` ASC';
	    }else{
	        $where['orderby'] =  'unix_timestamp(`starttime`)';
	    }
	    $page   			=  $_POST['page'];
	    $limit  			=  $_POST['limit'];
	    if($page){

	        $pagenav  =  ($page - 1) * $limit;
	        $where['limit']  =  array($pagenav,$limit);

	    }else{

	        $where['limit']  =  $limit;
	    }

	    $rows     =  $zphnetM -> getList($where, array('field'=>$field,'utype'=>'wxapp'));

	    if (!empty($rows)){

	        $return['list']    =  $rows;

	        $this->render_json(0, 'ok', $return);
	    }else{
	        $this->render_json(2);
	    }
	}
	function show_action()
	{
		$zid  =  (int)$_POST['id'];

		if (!empty($zid)){

		    $zphnetM  =  $this->MODEL('zphnet');
		    $row      =  $zphnetM -> getInfo(array('id'=>$zid));

		    if (!empty($row)){

		        $return['enum']  =  0;

		    	if(!empty($_POST['uid']) && !empty($_POST['token'])){

		    		$member     =   $this->yzToken($_POST['uid'],$_POST['token']);
                    
		    		//招聘会进行中记录用户进入记录
		    		if ($row['etime'] > 0){
		    		    
		    		    $zphnetM->addZphnetUser(array('zid'=>$zid,'uid'=>$member['uid'],'usertype'=>$member['usertype']));
		    		}
		    		
		    		if ($member['usertype'] == 1){

		    		    $resumeM  =  $this->MODEL('resume');
		    		    $enum     =  $resumeM->getExpectNum(array('uid'=>$member['uid']));
		    		    $return['enum']  =  $enum;
		    		}

		            $return['userData']   =   array(
		                'name'  =>  $member['username'],
		                'type'  =>  $member['usertype'],
		                'mtype' =>  2
		            );
		    	}
		    	$keyword  =  trim($_POST['keyword']);
		    	//进入大厅滚动展示
		    	$horn    =  $zphnetM->getZphnetUser(array('zid'=>$zid,'orderby'=>'ctime','limit'=>10));
		    	$return['horn']  =  $horn;
		    	// 企业列表
		    	if(!empty($row['zw'])){

					$zphArea  =  $zphnetM->getClass(array('id'=>$row['zw']));
					$return['zphArea']  =  $zphArea;
					$area   =  $zphnetM->getClassList(array('keyid'=>$row['zw'],'orderby'=>'sort,asc'));
					$return['area']  =  $area;
				}
				$areaCom    =   $zphnetM->getAreaComList(array('zid'=>$row['id'],'limit'=>'20'),array('zw'=>intval($_POST['zw']),'keyword'=>$keyword));
				$return['areaCom']  =  $areaCom['com'];
                // 数量统计
                $allnum  =  $zphnetM->getZphnetAllNum(array('zid'=>$zid, 'status'=>1));
                $return['allnum'] = $allnum;
		        $return['cuswitch'] =  $this->config['sy_user_change'];
		        $return['zph']  	=  $row;

				$return['iosfk']	  =  $this->config['sy_iospay'] ;
				$return['chatOpen']	  =  $this->config['sy_chat_open'];
				$return['chat_name']  =  $this->config['sy_chat_name'] ? $this->config['sy_chat_name'] : '';
				include(CONFIG_PATH.'db.data.php');
				$return['spview_web']   =  isset($arr_data['modelconfig']['spview']) && isset($this->config['sy_spview_web']) ? $this->config['sy_spview_web'] : 2;
				if ($this->platform == 'ios' && $_POST['provider'] == 'app'){
				    // IOS APP 不支持视频面试
				    $return['spview_web'] = 2;
				}

				if(!empty($_POST['uid']) && !empty($_POST['token'])){

		    		$member     =   $this->yzToken($_POST['uid'],$_POST['token']);

					$uid        =   $member['uid'];

					$usertype   =   $member['usertype'];
					
					if($usertype==2){
						$where	=	array(
							'uid'		=>	$uid,
							'did'		=>	$this->config['did'],
							'state'		=>	1,
							'status'	=>	0,
							'r_status'	=>	array('<>',2),
						);
						$jobM	=	$this->MODEL('job');
						
						$arr	=	$jobM->getList($where,array('field'=>'`id`,name'));
						
						$return['joblist']  =  $arr['list'];
					}
				}
				if (isset($_POST['provider'])){
				    // app用分享数据
				    if ($_POST['provider'] == 'app'){
				        $return['shareData']  =  array(
				            'url'       =>  Url('wap',array('c'=>'zphnet','a'=>'show','id'=>$zid)),
				            'title'     =>  $row['title'],
				            'summary'   =>  mb_substr(strip_tags($row['body']), 0,30,'UTF8'),
				            'imageUrl'  =>  checkpic($row['is_themb_n'],$this->config['sy_wx_sharelogo'])
				        );
				    }
				    // 小程序用seo
				    if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin'|| $_POST['provider'] == 'toutiao'){
				        $seodata['zph_title']  =  $row['title'];
				        $seodata['zph_desc']   =  $this -> GET_content_desc($row['body']);
				        $this->data	    =  $seodata;
                        $seo            =  $this->seo('zphnet_show','','','',false, true);
                        $return['seo']  =  $seo;
				    }
				}
				
		        $this->render_json(0, 'ok', $return);

		    }else{

		        $this->render_json(2);
		    }
		}else{

		    $this->render_json(2);
		}
	}
	/**
	 * 参展企业
	 */
	function getComList_action()
	{
	    $zid  =  (int)$_POST['id'];
	    $zphnetM  =  $this->MODEL('zphnet');

		if($_POST['zw']){
            $zphArea  =  $zphnetM->getClass(array('id'=>$_POST['zw']));
            $zw  =  (int)$zphArea['id'];
        }
	    if (!empty($zid)){

            if($zw){
                $where  =  array('zid'=>$zid,'zw'=>$zw);
            }else{
                $where  =  array('zid'=>$zid);
            }
            $where['orderby']  =  array('sort,desc');

            $page   =  $_POST['page'];
            $limit  =  $_POST['limit'];
            if($page){

                $pagenav  =  ($page - 1) * $limit;
                $where['limit']  =  array($pagenav,$limit);

            }else{

                $where['limit']  =  $limit;
            }
            $keyword  =  trim($_POST['keyword']);

            $zphnetM  =  $this->MODEL('zphnet');
            $comlist  =  $zphnetM->getAreaComList($where,array('utype'=>'wap','keyword'=>$keyword));
            $return['comlist']  =  $comlist['com'];

            $this->render_json(0, 'ok', $return);
        }else{

            $this->render_json(2);
        }

	}
	/**
	 * 求职者大厅
	 */
	function hallView_action()
	{
	    $zid  =  (int)$_POST['id'];

	    if (!empty($zid)){

	        $keyword  =  trim($_POST['keyword']);

	        $zphnetM  =  $this->MODEL('zphnet');

	        $page   =  $_POST['page'];
	        $limit  =  $_POST['limit'];
	        if($page){

	            $pagenav  =  ($page - 1) * $limit;
	            $limit  =  array($pagenav,$limit);
	        }

	        $hall     =  $zphnetM->getZphnetUser(array('zid'=>$zid),array('resume'=>$limit,'keyword'=>$keyword));
	        $return['hall']  =  count($hall) ? $hall : array();

	        $this->render_json(0, 'ok', $return);
	    }else{

	        $this->render_json(2);
	    }

	}
	/**
	 * 保存查看企业、职位记录
	 */
	function setLook_action()
	{

	    $zid    =  intval($_POST['id']);
	    $jobid  =  intval($_POST['jobid']);
	    $comid  =  intval($_POST['comid']);

	    $zphnetM  =  $this->MODEL('zphnet');
	    $row      =  $zphnetM->getInfo(array('id'=>$zid));

	    //招聘会进行中才保存
	    if ($row['stime'] < 0 && $row['etime'] > 0){

	        $data   =  array(
	            'zid'    =>  $zid,
	            'jobid'  =>  $jobid,
	            'comid'  =>  $comid,
	            'ctime'  =>  time()
	        );

	        if(!empty($_POST['uid']) && !empty($_POST['token'])){

	            $member  =  $this->yzToken($_POST['uid'], $_POST['token']);

	            $data['uid']       =  $member['uid'];
	            $data['usertype']  =  $member['usertype'];
	        }

	        $zphnetM  =  $this->MODEL('zphnet');
	        $zphnetM->addZphnetLook($data);
	    }
	    $this->render_json(0, 'ok');
	}
	//报名招聘会条件判断
	function ajaxZphnet_action(){

	    $member  =  $this->yzToken($_POST['uid'], $_POST['token']);

	    $data	=	array(
	        'usertype'	=>	$member['usertype'],
	        'uid'		=>	$member['uid'],
	        'spid'		=>	$member['spid'],
	        'did'		=>	$member['did'],
			'jobid'		=>	$_POST['jobid'],
	        'zid'		=>	intval($_POST['zid'])
	    );
	    $zphnetM  =  $this->MODEL('zphnet');
	    $arr	  =  $zphnetM->ajaxZphnet($data);

	    if (!empty($arr['msg'])){
	        $arr['msg']  = strip_tags($arr['msg']);
	    }
	    $this->render_json(0, 'ok', $arr);
	}
	// 报名网络招聘会条件判断
	function ajaxComJob_action(){
	    
	    $return  =  array();
	    $member  =  $this->yzToken($_POST['uid'], $_POST['token']);
	    
	    $zphnetM  =  $this->MODEL('zphnet');
	    $comrow   =  $zphnetM->getZphnetCom(array('uid'=>$member['uid'],'zid'=>$_POST['id']));
	    
	    if (!empty($comrow)){
	        
	        $error	= 2;
	        
	        if($comrow['status']==0){
	            
	            $msg	= "您已报名,请等待审核！";
	            
	        }else if($comrow['status']==1){
	            
	            $msg	= "您已报名了，请不要重复报名！";
	            
	        }else if($comrow['status']==2){
	            
	            $msg	= "您的报名审核未通过，请联系管理员";
	        }
	        
	    }else{
	        
	        $where	=	array(
	            'uid'		=>	$member['uid'],
	            'state'		=>	1,
	            'status'	=>	0,
	            'r_status'	=>	array('<>',2),
	        );
	        $jobM	=	$this->MODEL('job');
	        $arr	=	$jobM->getList($where, array('field'=>'`id`,`name`'));
	        $list	=	$arr['list'];
	        
	        if(!empty($list)){
	            
	            $return['joblist']  =  $list;
	            
	            $error  =  0;
	            $msg    =  '';
	            
	        }else{
	            
	            $error	=  2;
	            $msg	=  "您还没有发布职位，请先发布职位！";
	        }
	    }
	    $this->render_json($error, $msg, $return);
	}
	/**
	 * 检查企业参会情况
	 */
	function isJoin_action(){
	    
	    $member  =  $this->yzToken($_POST['uid'], $_POST['token']);
	    
	    $zphnetM  =  $this->MODEL('zphnet');
	    $row	  =	 $zphnetM->getZphnetCom(array('uid'=>$member['uid'],'zid'=>$_POST['zid']),array('field'=>'`status`'));
	    
	    if(!empty($row)){
	        if ($row['status'] == 1){
	            
	            if ($_POST['type'] == 'spview'){
	                $trtcM   =  $this->MODEL('trtc');
	                $return  =  $trtcM->getTrcInfo(array('uid'=>$member['uid'], 'usertype'=>$member['usertype'], 'fuid'=>$_POST['fuid']), true, $_POST['provider']);
	            }
	            
	            $return['error']  =  1;
	            
	        }elseif ($row['status'] == 2){
	            $return['error']  =  2;
	            $return['msg']  =  '参会报名审核未通过，请联系管理员';
	        }else{
	            $return['error']  =  3;
	            $return['msg']  =  '参会报名审核中';
	        }
	    }else{
	        $return['error']  =  4;
	        $return['msg']  =  '您尚未参会，请先参会';
	    }
	    
	    $this->render_json(0, 'ok', $return);
	}
}
?>