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
class resume_controller extends com_controller{
    /**
     * 申请职位的人才
     */
    function hrlist_action()
    {
    	$uid		=	$this->member['uid'];
    	$usertype	=	$this->member['usertype'];

    	$statis  	=  	$this->company_statis($this->member['uid']);

		$JobM		=   $this->MODEL('job');

		$page					=	$_POST['page'];
		
		$where['com_id']		=	$uid;
		$where['type']			=	array('<>',3);
		$where['isdel']			=	9;

		if($_POST['jobid']){
			$where['job_id']		=	$_POST['jobid'];
		}
        if($_POST['is_browse']){
            $where['is_browse']		=	$_POST['is_browse'];
        }

        $data['total'] = $JobM->getSqJobNum($where);
		
		$where['orderby']		=	array('is_browse,asc','datetime,desc');

		$limit					=	$_POST['limit'] ? $_POST['limit'] : 10;
		if($page){//分页
			$pagenav			=	($page-1)*$limit;
			$where['limit']		=	array($pagenav,$limit);
		}else{
			$where['limit']		=	$limit;
		}
		$rows	=	$JobM -> getSqJobList($where,array('uid'=>$uid,'usertype'=>$usertype));
        
        foreach($rows as $k=>$v){
            if($v['islink']==1 || in_array($statis['rating'],@explode(',', $this->config['com_look']))){
                $rows[$k]['name'] = $v['username_n'];
            }
            unset($rows[$k]['username_n']);
        }
            
		$list	=	count($rows) ? $rows : array();
		
		$data['list']	=	$list;
		
		$this	->	render_json(0,'',$data);
		
	}
	function hrset_action()
	{
		if(!$_POST['id']||!$_POST['browse']){
			$data['error']	=	3;
			$data['msg']	=	'参数不正确';
		}else{
			$id		=	(int)$_POST['id'];
			$browse	=	(int)$_POST['browse'];
			
			$JobM   =   $this -> MODEL('job');

			$data	=	array(
			    'uid'		=>	$this->member['uid'],
			    'usertype'	=>	$this->member['usertype'],
			    'username'	=>	$this->member['username'],
				'browse'	=>	$browse,
			    'port'		=>	$this->plat == 'mini' ? '3' : '4'
			);
			$nid    =   $JobM -> BrowseSqJob($id,$data);
			if($nid){
				$data['error']	=	1;
				$data['msg']	=	'设置成功';
			}else{
				$data['error']	=	2;
				$data['msg']	=	'设置失败';
			}
		}
		$this->render_json($data['error'],$data['msg']);
	}
	function hr_del_action()
	{
		if(!$_POST['ids']){
			$data['error']=3;
			$data['msg']='参数不正确';
		}else{
			$JobM   =   $this -> MODEL('job');
			$arr    =   $JobM -> delSqJob($_POST['ids'],array('utype'=>'com','uid'=>$this->member['uid'],'usertype'=>$this->member['usertype']));
			if($arr){
				$data['error']	=	1;
				$data['msg']	=	'删除成功';
			}else{
				$data['error']	=	2;
				$data['msg']	=	'删除失败';
			}
		}

		$this->render_json($data['error'],$data['msg']);
		
	}
	function hrRemark_action(){
		
        $ResumeM    =   $this->MODEL('resume');
        $data       =   array(
            'remark'    =>  $_POST['remark'],
            'id'        =>  $_POST['id'],
            'rname'     =>  $_POST['rname'],
            'uid'       =>  $this->member['uid'],
            'usertype'  =>  $this->member['usertype']
        );
        $return         =   $ResumeM -> RemarkHr($data);
        $data['error']  =   $return['errcode'] == '9' ? 1: 0;
        $this->render_json($data['error'],$return['msg']);
        
    }
	/**
	 * 已下载简历的人才
	 */
	function downlist_action()
	{
		$downM  	=	$this -> MODEL('downresume');
		$order		=	$_POST['order'];
		
		$where['comid']			=	$this->member['uid'];
		$where['usertype']		=	$this->member['usertype'];
		$where['isdel']			=	9;
		$page					=	$_POST['page'];
		
		$data['total']          =   $downM->getDownNum($where);
		
		if($order){//排序
			$where['orderby']	=	$order.',desc';
		}else{
			$where['orderby']	=	'id,desc';
		}

		$limit					=	$_POST['limit'] ? $_POST['limit'] : 10;
		if($page){//分页
			$pagenav			=	($page-1)*$limit;
			$where['limit']		=	array($pagenav,$limit);
		}else{
			$where['limit']		=	$limit;
		}

		$List   		=  	$downM  ->  getList($where,array('uid'=>$this->member['uid']));
		
		$data['list']	=	count($List['list'])?$List['list']:array();
		
		$data['iosfk']	=	$this->config['sy_iospay'];

		$this->render_json(0,'',$data);
		
	}
	function down_del_action()
	{
		if(!$_POST['ids']){
			$data['error']	=	3;
			$data['msg']	=	'参数不正确';
		}else{
			$downM    =  $this	->	MODEL('downresume');
			$return   =  $downM -> delInfo( intval($_POST['ids']),array('uid'=>$this->member['uid'],'usertype'=>$_POST['usertype']));
			if($return['errcode']==9){
				$data['error']	=	1;
			}else{
				$data['error']	=	2;
			}
			$data['msg']	=	$return['msg'];
		}
		echo json_encode($data);die;
	}

    function dRemark_action(){

        $ResumeM    =   $this->MODEL('downresume');
        $data       =   array(
            'remark'    =>  $_POST['remark'],
            'remarkid'  =>  $_POST['id'],
            'rname'     =>  $_POST['rname'],
            'uid'       =>  $this->member['uid'],
            'usertype'  =>  $this->member['usertype']
        );
        $return         =   $ResumeM -> Remark($data);

        $data['error']  =   $return['errcode'] == '9' ? 1: 0;

        $this->render_json($data['error'],$return['msg']);
    }

    function talentpoollist_action()
    {
        $page  = $_POST['page'];
        $limit = $_POST['limit'] ? $_POST['limit'] : 10;
        if ($page) { // 分页
            $pagenav = ($page - 1) * $limit;
            $where['limit'] = array(
                $pagenav,
                $limit
            );
        } else {
            $where['limit'] = $limit;
        }
        
        $ResumeM = $this->MODEL('resume');
        $where['cuid']    = $this->member['uid'];
        $where['orderby'] = 'id,desc';
        
        $List = $ResumeM->getTalentList($where, array(
            'uid'    => $this->member['uid'],
            'isdown' => 1
        ));
        $data['list']  = count($List) ? $List : array();
        $data['iosfk'] = $this->config['sy_iospay'];
        $data['total'] = $ResumeM->getTalentNum(array('cuid'=>$this->member['uid']));
        
        $this->render_json(0, '', $data);
    }
	function talentpooldel_action()
	{
		if(!$_POST['ids']){
			$data['error']	=	3;
			$data['msg']	=	'参数不正确';
		}else{
			$ResumeM    =	$this->MODEL('resume');
			$return   	=	$ResumeM -> delTalentPool($_POST['ids'],array('uid'=>$this->member['uid'],'usertype'=>$_POST['usertype']));
			if($return['errcode']==9){
				$data['error']	=	1;
			}else{
				$data['error']	=	2;
			}
			$data['msg']	=	$return['msg'];
		}
		echo json_encode($data);die;
	}
    function tRemark_action(){

        $ResumeM    =   $this->MODEL('resume');
        $data       =   array(
            'remark'    =>  $_POST['remark'],
            'id'        =>  $_POST['id'],
            'rname'     =>  $_POST['rname'],
            'uid'       =>  $this->member['uid'],
            'usertype'  =>  $this->member['usertype']
        );
        $return         =   $ResumeM -> RemarkTalent($data);

        $data['error']  =   $return['errcode'] == '9' ? 1: 0;

        $this->render_json($data['error'],$return['msg']);
    }
	/**
	 * 已邀请人才
	 */
	function invitelist_action()
	{
		$JobM		=   $this -> MODEL('job');
		
		$page		=	$_POST['page'];
		$limit		=	$_POST['limit'] ? $_POST['limit'] : 10;
		$order		=	$_POST['order'];
		
		
		$where['fid']	=  	$this->member['uid'];
		$where['isdel']	=  	9;
		$data['total'] = $JobM->getYqmsNum($where);
		
		if($order){//排序
			$where['orderby']	=	$order.',desc';
		}else{
			$where['orderby']	=	'id,desc';
		}

        if($page){//分页
            $pagenav			=	($page-1)*$limit;
            $where['limit']		=	array($pagenav,$limit);
        }else{
            $where['limit']		=	$limit;
        }

		$list    		=   $JobM -> getYqmsList($where,array('uid'=>$this->member['uid'],'usertype'=>$this->member['usertype']));
		
		$data['list']	=	count($list) ? $list : array();

		$this->render_json(0,'',$data);
		
	}
	function invite_del_action()
	{
		if(!$_POST['ids']){
			$data['error']	=	3;
			$data['msg']	=	'参数不正确';
		}else{
			$id 		=  intval($_POST['ids']);
			$JobM		=  $this -> MODEL('job');
			$return		=  $JobM -> delYqms($id,array('uid'=>$this->member['uid'],'usertype'=>$_POST['usertype']));
			if($return['errcode']==9){
				$data['error']	=	1;
			}else{
				$data['error']	=	2;
			}
			$data['msg']=	$return['msg'];
			echo json_encode($data);die;
		}
	}
	/* wxapp浏览简历记录 */
	function look_resume_action()
	{
		$lookresumeM  			=   $this -> MODEL('lookresume');
		$where['com_id']		=   $this->member['uid'];
		$where['usertype']		=   2;
		$where['com_status']	=   0;
		$where['orderby']		=	'datetime,desc';
		$page					=	$_POST['page'];
		$limit					=	$_POST['limit'] ? $_POST['limit'] : 10;
		if($page){//分页
			$pagenav			=	($page-1)*$limit;
			$where['limit']		=	array($pagenav,$limit);
		}else{
			$where['limit']		=	$limit;
		}
		
		$List					=	$lookresumeM  ->  getList($where,array('uid'=>$this->member['uid']));

		$data['list']			=	count($List['list'])?$List['list']:array();
		
		$data['iosfk']			=	$this->config['sy_iospay'];
		
		$data['total']          =   $lookresumeM->getLookNum(array('com_id'=>$this->member['uid'],'usertype'=>2,'com_status'=>0));
		
		$this->render_json(0,'',$data);
		
	}
	/* wxapp删除浏览简历记录 */
	function look_resume_del_action()
	{
		if(!$_POST['ids']){
			$data['error']	=	3;
			$data['msg']	=	'参数不正确';
		}else{
			$lookresumeM    =  $this->MODEL('lookresume');
			$return         =  $lookresumeM -> delInfo(array('id'=>$_POST['ids'],'uid'=>$this->member['uid'],'usertype'=>2));
			if($return['errcode']==9){
				$data['error']	=	1;
			}else{
				$data['error']	=	2;
			}
			$data['msg']	=	$return['msg'];
		}
		echo json_encode($data);die;
	}
	/* wxapp谁看过我记录 */
	function look_job_action()
	{
		$JobM					=	$this -> MODEL("job");
		$where['com_id']		=	$this->member['uid'];
		$where['com_status']	=	0;

		$data['total'] = $JobM->getLookJobNum($where);

		$where['orderby']		=	'datetime,desc';
		$page					=	$_POST['page'];
		$limit					=	$_POST['limit'] ? $_POST['limit'] : 10;
		if($page){//分页
			$pagenav			=	($page-1)*$limit;
			$where['limit']		=	array($pagenav,$limit);
		}else{
			$where['limit']		=	$limit;
		}

		$List					=  	$JobM  ->  getLookJobList($where,array('uid'=>$this->member['uid'],'usertype'=>$this->member['usertype']));

		$data['list']			=	count($List)?array_values($List):array();
		
		$data['iosfk']			=	$this->config['sy_iospay'];

		$this->render_json(0,'',$data);
		
	}
	/* wxapp删除谁看过我记录 */
	function look_job_del_action()
	{
		if(!$_POST['ids']){
			$data['error']	=	3;
			$data['msg']	=	'参数不正确';
		}else{
			$jobM	=	$this -> MODEL('job');
			$return	=	$jobM -> delLookJob($_POST['ids'],array('uid'=>$this->member['uid'],'usertype'=>$this->member['usertype']));
			if($return['errcode']==9){
				$data['error']	=	1;
			}else{
				$data['error']	=	2;
			}
			$data['msg']	=	$return['msg'];
		}
		echo json_encode($data);die;
	}
	function resumecolumn_action()
	{
		
		$jobM			=	$this -> MODEL('job');
		
		$atnM			=	$this -> MODEL('atn');
		
		$resumeM		=	$this -> MODEL('resume');
		
		$lookresumeM	=	$this -> MODEL('lookresume');
		
		$downresumeM	=	$this -> MODEL('downresume');
		//应聘简历数	
		$sqnum			=	$jobM -> getSqJobNum(array('com_id'=>$this->member['uid'],'isdel'=>9,'type'=>array('<>',3)));
		
		$list['sqnum']	=	$sqnum;
		
		$userid_jobnum	=	$jobM -> getSqJobNum(array('com_id'=>$this->member['uid'],'isdel'=>9,'is_browse'=>'1','type'=>array('<>',3)));
		
		$list['userid_jobnum']	=	$userid_jobnum;
		
		//面试邀请数
		$userid_msgnum	=	$jobM -> getYqmsNum(array('fid'=>$this->member['uid'],'isdel'=>9));
		
		$list['userid_msgnum']	=	$userid_msgnum;
		
		//浏览简历数
		$looknum		=	$lookresumeM -> getLookNum(array('com_id'=>$this->member['uid'],'usertype'=>2,'com_status'=>'0'));
		
		$list['looknum']=	$looknum;
		
	    //收藏简历数
		$talentnum		=	$resumeM -> getTalentNum(array('cuid'=>$this->member['uid']));
		
		$list['talentnum']		=	$talentnum;
	    
	    //下载简历数
		$downnum		=	$downresumeM -> getDownNum(array('comid'=>$this->member['uid'],'usertype'=>2,'isdel'=>9));
		
		$list['downnum']		=	$downnum;
	    
	    //关注我的人才数
		$atnnum			=	$atnM -> getAtnNum(array('sc_uid'=>$this->member['uid']));
		
		$list['atnnum']			=	$atnnum;
	    
	    //被浏览的职位数
		$lookjobnum		=	$jobM -> getLookJobNum(array('com_id'=>$this->member['uid'],'com_status'=>'0'), array('usertype' => $this->member['usertype']));
		
		$list['lookjobnum']		=	$lookjobnum	;
	    
	    $data['error']	=	0;
		
		$this->render_json(0,'',$list);
	    
	}
	function attention_me_action(){
		$atnM  				=  $this -> MODEL('atn');
		
	    $where['sc_uid']	=  $this -> member['uid'];

        $data['total'] = $atnM->getantnNum($where);

		$where['orderby']	=	'id';
        $page				=	$_POST['page'];
		$limit				=	$_POST['limit'] ? $_POST['limit'] : 10;
		if($page){//分页
			$pagenav		=	($page-1)*$limit;
			$where['limit']	=	array($pagenav,$limit);
		}else{
			$where['limit']	=	$limit;
		}
		
        $List   			=  $atnM  ->  getatnList($where,array('utype'=>'user','uid'=>$this->member['uid']));
		
		$data['list']		=	$List ;
		
		$data['iosfk']		=	$this->config['sy_iospay'];

		$this->render_json(0,'',$data);
	}
}