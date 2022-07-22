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
class zphnet_controller extends company{
	//招聘会
	function index_action(){
		$this->company_satic();
		$this->public_action();
		$zphnetM        =  $this->MODEL('zphnet');
		$urlarr['c']	=	'zphnet';
		$urlarr['page']	=	'{{page}}';
		$pageurl		=	Url('member',$urlarr);
		$where['uid']	=	$this -> uid;
		
		$pageM	=	$this  -> MODEL('page');
		$pages	=	$pageM -> pageList('zphnet_com',$where,$pageurl,$_GET['page'],$this->config['sy_listnum']);
		
		if($pages['total'] > 0){
			if($_GET['order'])
			{
				$where['orderby']		=	$_GET['t'].','.$_GET['order'];
				$urlarr['order']		=	$_GET['order'];
				$urlarr['t']			=	$_GET['t'];
			}else{
				$where['orderby']		=	'id';
			}
			$where['limit']	=	$pages['limit'];
			
			$List	=	$zphnetM -> getZphnetComList($where,array('comid'=>$this->uid));
			
			$this->yunset('rows' , $List);
		}
		$jobM       =   $this->MODEL('job');

        $jobwhere   =   array(
            'uid'       =>  $this->uid,
            'state'     =>  1,
            'status'    =>  0,
            'r_status'  =>  1
        );

        $List    =   $jobM->getList($jobwhere,array('field'=>'`name`,`id`'));

        foreach ($List['list'] as $key => $value) {
            $jobArr[$value['id']] = $value['name'];

        }
        $this->yunset('job',$jobArr);
		$this->com_tpl('zphnet');
	}
	function editcomjob_action(){
        $zphnet = $this->MODEL('zphnet');

        if($_POST['id']){
            $result = $zphnet->editZphnetComjob(array('id'=>trim($_POST['id'])),array('jobid'=>$_POST['jobid'],'uid'=>$this->uid,'usertype'=>$this->usertype));

        }else{
            $result['errcode'] = 8;
            $result['msg'] = '参数错误！';
        }
        echo json_encode($result);die;
    }
	function spviewLog_action(){

		$zid 		=	$_GET['zid'];

		$urlarr['c']	=	$_GET['c'];
		$urlarr['act']	=	$_GET['act'];
		$urlarr['page']	=	'{{page}}';
		$pageurl		=	Url('member',$urlarr);
		$where 			=	array('zid'=>$zid,'comid'=>$this->uid);

		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('spview_log',$where,$pageurl,$_GET['page'],$this->config['sy_listnum']);
		
		//分页数大于0的情况下 执行列表查询
	    if($pages['total'] > 0){
	        
	        $where['orderby']	=	'ctime,desc';
	        $where['limit']		=	$pages['limit'];

	        $spviewM    =	$this -> MODEL('spview');

			$rows 		= 	$spviewM->getSpLogList($where);
	    }

		$this -> yunset(array('rows' => $rows));
	    $this -> com_tpl('splog');
		
	}

	function del_action()
	{
		$zphnetM    =	$this -> MODEL('zphnet');
		
		$delid		=	$zphnetM -> delZphnetCom($_GET['id'],$this->uid);
		if($delid){
		    $logM  =  $this -> MODEL('log');
			$logM -> addMemberLog($this->uid,$this->usertype,'退出招聘会',14,3);//会员日志
			
			$this -> layer_msg('退出成功！',9,0,$_SERVER['HTTP_REFERER']);
		}else{
			$this -> layer_msg('退出失败！',8,0,$_SERVER['HTTP_REFERER']);
		}
	}
}
?>