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

class zph_controller extends wxapp_controller
{

	function alllist_action()
    {

		$zphM       =  $this->MODEL('zph');
		$zphnetM    =  $this->MODEL('zphnet');
		$time       =  time();

		if (!empty($_POST['did'])){
	        $zphwhere['did']        =   $_POST['did'];
	        $zphnetwhere['did']     =   $_POST['did'];
	    }
		$zphwhere['is_open'] 		= 	1;
		$zphwhere['endtime']		=	array('unixtime','>',time());
		$zphwhere['orderby'] 		=  	'unix_timestamp(`starttime`),DESC';
		$zph  	    =   $zphM->getList($zphwhere, array('utype'=>'app'));

		$zphnetwhere['is_open'] 	= 	1;
		$zphnetwhere['endtime']		=	array('unixtime','>',time());
		$zphnetwhere['orderby'] 	=  	'unix_timestamp(`starttime`),DESC';
		$zphnet     =   $zphnetM->getList($zphnetwhere, array('utype'=>'wxapp'));

		$zphlist    =   array_merge($zph,$zphnet);
		
		$List_sort  =   array();
		foreach ($zphlist as $key => $value) {
			$List_sort[]    =   $value['starttime_timestamp'];
		}
		
		array_multisort($List_sort,SORT_ASC,$zphlist);

        $allList    =   array();
        $top        =   array();

        foreach ($zphlist as $k => $v) {

            $allList[$k]['id']      =   $v['id'];
            $allList[$k]['title']   =   $v['title'];
            $allList[$k]['zphtype'] =   $v['zphtype'];
            $allList[$k]['pic_n']   =   $v['pic_n'];
            $allList[$k]['banner_wap_n']    =   $v['banner_wap_n'];
            $allList[$k]['comnum']  =   $v['comnum'];
            $allList[$k]['jobnum']  =   $v['jobnum'];
            $allList[$k]['zpnum']   =   $v['zpnum'];
            $allList[$k]['unum']    =   $v['unum'];
            $allList[$k]['stime']   =   $v['stime'];
            $allList[$k]['etime']   =   $v['etime'];
            if (isset($v['zw'])){
                $allList[$k]['zw']  =   $v['zw'];
            }
            // 先取第一场现场招聘会
            if (empty($top) && isset($v['sid'])){
                $top = $v;
            }
        }
        // 没取到现场招聘会，取第一场网络招聘会
        if (empty($top)){
            foreach($allList as $k=>$v){
                if (empty($top) && isset($v['zw'])){
                    $top = $v;
                }
            }
        }
        $data['list'] = $allList;
        $data['top'] = $top;

		if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
            $seo            =  $this->seo('zph','','','',false, true);
            $data['seo']    =  $seo;
        }

		$this->render_json(0, 'ok', $data);
	}
	function list_action()
	{
	    $zphM   =  $this->MODEL('zph');
	    $time   =  time();
	    // 处理分站查询条件
	    if (!empty($_POST['did'])){
	        $where['did']  =  $_POST['did'];
	    }
	    $field  =  '*';
        //根据后台设置开启/隐藏
        $where['is_open'] = 1;
	    $zphone  =  $zphM->getInfo(array('unix_timestamp(`endtime`)'=>array('>',$time)),array('field'=>'`id`'));
	    // $where['orderby'] = '`sort` DESC,';
	    if (!empty($zphone)){
	        // 条件排序，进行中在最上面，接着是未开始，最后是已结束
	        $field  .=  ',CASE WHEN unix_timestamp(`endtime`)>'.$time.' THEN unix_timestamp(`starttime`)';
	        $field  .=  ' WHEN unix_timestamp(`endtime`)<'.$time.' THEN -1*unix_timestamp(`starttime`) END AS `zph_px`';

	        $where['orderby'] .=  ' CASE WHEN unix_timestamp(`starttime`)<"'.$time.'" AND unix_timestamp(`endtime`)>"'.$time.'" THEN 0';
	        $where['orderby'] .=  ' WHEN unix_timestamp(`starttime`)>"'.$time.'" THEN 1';
	        $where['orderby'] .=  ' WHEN unix_timestamp(`endtime`)<"'.$time.'" THEN 2';
	        $where['orderby'] .=  ' END,`zph_px` ASC';
	    }else{
	        $where['orderby'] .=  'unix_timestamp(`starttime`)';
	    }

	    $onewhere = $where;

	    if($_POST['state']=='1'){//尚未开始

	    	$where['starttime']		=	array('unixtime','>',time());
			
		}elseif($_POST['state']=='2'){//进行中

			$where['starttime']		=	array('unixtime','<',time());
			$where['endtime']		=	array('unixtime','>',time());

		}elseif($_POST['state']=='3'){//已结束

			$where['endtime']		=	array('unixtime','<',time());
		
		}

	    $page   			=  $_POST['page'];
	    $limit  			=  $_POST['limit'];
	    if($page){

	        $pagenav  =  ($page - 1) * $limit;
	        $where['limit']  =  array($pagenav,$limit);

	    }else{

	        $where['limit']  =  $limit;
	    }

	    $rows  =  $zphM -> getList($where, array('field'=>$field,'utype'=>'app'));

	    if (!empty($rows)){

	        unset($where['limit']);

	        $newZph  =  $zphM -> getInfo($onewhere,array('field'=>$field));

	        $zphcom  =  $zphM -> getZphCompanyList(array('zid'=>$newZph['id'],'status'=>1));

	        $jobnum  =  0;

	        foreach ($zphcom as $v){
	            $jobnum += count($v['job']);
	        }
	        $newZph['comnum']     =  count($zphcom);
	        $newZph['jobnum']     =  $jobnum;
	        $newZph['starttime']  =  date('Y-m-d',strtotime($newZph['starttime']));
	        $newZph['endtime']    =  date('Y-m-d',strtotime($newZph['endtime']));

	        $return['list']    =  $rows;
	        $return['newZph']  =  $newZph;
	        // 百度小程序用seo
            if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
                $seo            =  $this->seo('zph','','','',false, true);
                $data['seo']    =  $seo;
            }

	        $this->render_json(0, 'ok', $return);
	    }else{
	        $this->render_json(2);
	    }
	}
	function show_action()
	{
		$id  =  (int)$_POST['id'];

		if (!empty($id)){

		    $zphM  =  $this->MODEL('zph');
		    $row   =  $zphM -> getInfo(array('id'=>$id),array('utype'=>'wxapp','pic'=>1,'banner'=>1));

		    if (!empty($row)){
		    	if(!empty($_POST['uid']) && !empty($_POST['token'])){

		    		$member     =   $this->yzToken($_POST['uid'],$_POST['token']);
					$uid        =   $member['uid'];
					$usertype   =   $member['usertype'];
		    	}
		        $row['stime']  =  strtotime($row['starttime'])-time();
		        $row['etime']  =  strtotime($row['endtime'])-time();

		        if (!empty($row['body'])){

		            $row['body']  =  strip_tags($row['body'],'<div> <img> <p>');
		        }
		        if (!empty($row['media'])){

		            $row['media']  =  strip_tags($row['media'],'<div> <img> <p>');
		        }
		        if (!empty($row['packages'])){

		            $row['packages']  =  strip_tags($row['packages'],'<div> <img> <p>');

		        }
		        if (!empty($row['booth'])){

		            $row['booth']  =  strip_tags($row['booth'],'<div> <img> <p>');

		        }
		        if (!empty($row['participate'])){

		            $row['participate']  =  strip_tags($row['participate'],'<div> <img> <p>');
		        }
		        $return['cuswitch'] =  $this->config['sy_user_change'];
		        $return['list']  	=  $row;

				$return['iosfk']	=	$this->config['sy_iospay'];

				if (isset($_POST['provider'])){
				    // app用分享数据
				    if ($_POST['provider'] == 'app'){

				        $return['shareData']  =  array(
				            'url'       =>  Url('wap',array('c'=>'zph','a'=>'show','id'=>$id)),
				            'title'     =>  $row['title'],
				            'summary'   =>  mb_substr(strip_tags($row['body']), 0,30,'UTF8'),
				            'imageUrl'  =>  checkpic($row['is_themb_n'],$this->config['sy_wx_sharelogo'])
				        );
				    }
				    // 小程序用seo
				    if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
				        $seodata['zph_title']  =  $row['title'];
				        $seodata['zph_desc']   =  $this->GET_content_desc($row['body']);
				        $this->data	    =  $seodata;
                        $seo            =  $this->seo('zph_show','','','',false, true);
                        $data['seo']    =  $seo;
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
	function getComList_action(){
		$id     =   intval($_POST['zid']);
        
        if($id){
            $page   =   intval($_POST['page']);
            $limit  =   intval($_POST['limit']);
        
            $zphM   =   $this->MODEL('zph');

            
            $zclimit            =   $limit?$limit:10;
            $zcwhere            =   array();
            $zcwhere['zid']     =   $id;
            $zcwhere['status']  =   1;
            $zcwhere['orderby'] =   array('sort,desc','ctime,asc');

            $zcnum              =   $zphM->getZphComNum($zcwhere);
            //$return['total']    =   $zcnum;
            if($page > 0){
                    
                $pagenav  =  ($page - 1) * $zclimit;
                $zcwhere['limit']  =  array($pagenav,$zclimit);
                
            }else{
                
                $zcwhere['limit']  =  $zclimit;
            }

            $zcList             =   $zphM -> getZphCompanyList($zcwhere);
            $error    =   1;
            $msg      =   '';
        }else{
            $zclist   =   array();
            $error    =   0;
            $msg      =   '参数错误请重试';
        }

        $data['list'] =   $zcList;

        $this->render_json($error,$msg,$data);
    }
    function getJobList_action(){

    	$id     =   intval($_POST['zid']);
        
        if($id){
            $page   =   intval($_POST['page']);
        
            $zphM   =   $this->MODEL('zph');
            $limit   =   intval($_POST['limit']);
            
            $zjwhere            =   array();
            $zjwhere['zid']     =   $id;
            $zjwhere['status']  =   1;
            $zjwhere['orderby'] =   array('sort,desc','ctime,asc');

            $zjwhereData        =   array('zwhereData'=>$zjwhere);

            $zjlimit            =   $limit?$limit:10;
            $jwhere['state']    =   1;
            $jwhere['status']   =   0;
            $jwhere['r_status'] =   1;
            if($page > 0){
                    
                $pagenav  =  ($page - 1) * $zjlimit;
                $jwhere['limit']  =  array($pagenav,$zjlimit);
                
            }else{
                
                $jwhere['limit']  =  $zjlimit;
            }
            $jwhere['orderby']  =   'lastupdate,desc';

            $zjwhereData['jwhereData'] = $jwhere;

            $zjList             =   $zphM -> getZphJobList($zjwhereData);
            
            $list     =   $zjList['list'];
            $error    =   1;
            $msg      =   '';
        }else{
            $list     =   array();
            $error    =   0;
            $msg      =   '参数错误请重试';
        }

        $data['list'] =   $list;

        $this->render_json($error,$msg,$data);
    }
	function com_action()
	{
	    $id  =  (int)$_POST['id'];

	    if (!empty($id)){

	        $zphM  =  $this->MODEL('zph');
	        $row   =  $zphM -> getInfo(array('id'=>$id), array('field'=>'`id`,`title`,`starttime`,`endtime`,`phone`,`user`,`organizers`,`address`'));

	        if (!empty($row)){
	            $row['stime']  =  strtotime($row['starttime'])-time();
	            $row['etime']  =  strtotime($row['endtime'])-time();

	            if (isset($_POST['provider'])){
	                // app用分享数据
	                if ($_POST['provider'] == 'app'){
	                    
	                    $return['shareData']  =  array(
	                        'url'       =>  Url('wap',array('c'=>'zph','a'=>'com','id'=>$id)),
	                        'title'     =>  $row['title'],
	                        'summary'   =>  mb_substr(strip_tags($row['body']), 0,30,'UTF8'),
	                        'imageUrl'  =>  checkpic($row['is_themb_n'],$this->config['sy_wx_sharelogo'])
	                    );
	                }
	                // 小程序用seo
	                if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin'|| $_POST['provider'] == 'toutiao'){
	                    $seodata['zph_title']  =  $row['title'];
	                    $seodata['zph_desc']   =  $this->GET_content_desc($row['body']);
	                    $this->data	    =  $seodata;
                        $seo            =  $this->seo('zph_com','','','',false, true);
                        $data['seo']    =  $seo;
	                }
	            }
	            
	            $return['list']  =  $row;

	            $where  =  array(
	                'zid'      =>  $id,
	                'status'   =>  1,
	                'orderby'  =>  array('sort,desc','ctime,asc')
	            );

	            $page   =  $_POST['page'];
	            $limit  =  $_POST['limit'];
	            if($page){

	                $pagenav  =  ($page - 1) * $limit;
	                $where['limit']  =  array($pagenav,$limit);

	            }else{

	                $where['limit']  =  $limit;
	            }

	            $zphCom  =  $zphM -> getZphCompanyList($where);

	            $return['com']  =  $zphCom;

	            $this->render_json(0, 'ok', $return);

	        }else{

	            $this->render_json(2);
	        }
	    }else{

	        $this->render_json(2);
	    }
	}
	function reserve_action()
	{
	    $id  =  (int)$_POST['id'];

	    if (!empty($id)){

	        $zphM  =  $this->MODEL('zph');
	        $row   =  $zphM -> getInfo(array('id'=>$id), array('field'=>'`id`,`title`,`starttime`,`endtime`,`phone`,`sid`,`reserved`'));

	        if (!empty($row)){
	            $row['stime']  =  strtotime($row['starttime'])-time();
	            $row['etime']  =  strtotime($row['endtime'])-time();
	            $row['reserved']  =  @explode(',', $row['reserved']);

	            $return['list']  =  $row;

	            $space	=  $zphM->getZphSpaceInfo(array('id'=>$row['sid']),array('pic'=>1,'field'=>'`pic`'));

	            $return['space']  =  $space;

	            $spaceList	=	$zphM->getZphSpaceList(array('keyid'=>$row['sid'],'orderby'=>'sort,asc'),array('id'=>$id,'utype'=>'index'));

	            $return['spaceList']	=	$spaceList;

				$return['iosfk']		=	$this->config['sy_iospay'] ;
				
				if(!empty($_POST['uid']) && !empty($_POST['token'])){

		    		$member     =   $this->yzToken($_POST['uid'],$_POST['token']);

					$uid        =   $member['uid'];

					$usertype   =   $member['usertype'];
					
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
	            $this->render_json(0, 'ok', $return);

	        }else{

	            $this->render_json(2);
	        }
	    }else{

	        $this->render_json(2);
	    }
	}
	//报名招聘会条件判断
	function ajaxZph_action(){

	    $member  =  $this->yzToken($_POST['uid'], $_POST['token']);

	    $data	=	array(
	        'usertype'	=>	$member['usertype'],
	        'uid'		=>	$member['uid'],
	        'spid'		=>	$member['spid'],
			'jobid'		=>	$_POST['jobid'],
	        'did'		=>	$member['did'],
	        'id'		=>	intval($_POST['id']),
	        'zid'		=>	intval($_POST['zid'])
	    );
	    $zphM	=	$this->MODEL('zph');
	    $arr	=	$zphM->ajaxZph($data);

	    if (!empty($arr['msg'])){
	        $arr['msg']  = strip_tags($arr['msg']);
	    }
	    $this->render_json(0, 'ok', $arr);
	}
	// 报名招聘会条件判断
	function ajaxComJob_action(){
	    
	    $return  =  array();
	    $member  =  $this->yzToken($_POST['uid'], $_POST['token']);
	    
	    $zphM  =  $this->MODEL('zph');
	    $comrow   =  $zphM->getZphComInfo(array('uid'=>$member['uid'],'zid'=>$_POST['id']));
	    
	    if (!empty($comrow)){
	        
	        $error	= 2;
	        
	        if($comrow['status']==0){
	            
	            $msg	= "您已报名,请等待审核！";
	            
	        }else if($comrow['status']==1){
	            
	            $msg	= "您已报名了，请不要重复报名！";
	            
	        }else if($comrow['status']==2){
	            
	            $msg	= "您已报名,且审核未通过！";
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
	            
	            $error =  0;
	            
	        }else{
	            
	            $error	=  2;
	            
	            $msg	=  "您还没有发布职位，请先发布职位！";
	        }
	    }
	    $this->render_json($error, $msg, $return);
	}
}
?>