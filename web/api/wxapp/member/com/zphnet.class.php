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
class zphnet_controller extends com_controller{
	
	function zphlist_action(){
		
		$where['uid']		=	$this -> member['uid'];
		$page						=		$_POST['page'];
		if ($_POST['limit']){
			$limit					=		$_POST['limit'];
			if($page){
				$pagenav			=		($page-1)*$limit;
				$where['limit']		=		array($pagenav,$limit);
			}else{
				$where['limit']		=		$limit;
			}         
		}
		$where['orderby']	=	array('ctime,desc');
		$zpnetM				=	$this -> MODEL('zphnet');
		$rows				=	$zpnetM -> getZphnetComList($where,array('comid'=>$this->member['uid']));
		$jobM   		=   $this->MODEL('job');
        $jobwhere   	=   array(
            'uid'       =>  $this->member['uid'],
            'state'     =>  1,
            'status'    =>  0,
            'r_status'  =>  1
        );
        $List    		=   $jobM->getList($jobwhere,array('field'=>'`name`,`id`'));
        foreach ($List['list'] as $key => $value) {
            $jobArr[$key]['id'] 		=	$value['id'];
            $jobArr[$key]['name'] 		=	$value['name'];
        }
		include_once(CONFIG_PATH.'db.data.php');
		$data['spviewOpen'] =   isset($arr_data['modelconfig']['spview']) && isset($this->config['sy_spview_web']) ? $this->config['sy_spview_web'] : 2;
		if ($this->platform == 'ios'){
		    // IOS APP 不支持视频面试
		    $data['spviewOpen'] = 2;
		}
		
		$data['total'] = $zpnetM->getZphnetComNum(array('uid'=>$this->member['uid']));
		
		if(is_array($rows) && !empty($rows)){
			$data['list']	=	$rows;
			$data['jobarr']	=	count($jobArr) ? $jobArr : array();
			$this->render_json(0,'ok',$data);
		}else{
			$error	=	2;
			$this->render_json($error);
		}
	}
	function editcomjob_action(){
        $zphnet = $this->MODEL('zphnet');

        if($_POST['id']){
            $result = $zphnet->editZphnetComjob(array('id'=>trim($_POST['id'])),array('jobid'=>$_POST['jobid'],'uid'=>$this -> member['uid'],'usertype'=>$this->member['usertype']));
            if($result['errcode']==9){
                $error =1;
                $msg = "修改成功！";
            }else{
                $error =0;
                $msg = "修改失败！";
            }
        }else{
            $error=0;
            $msg = '参数错误！';
        }
        $this->render_json($error,$msg);
    }
	function spviewLog_action(){

	    $spviewM    =	$this -> MODEL('spview');
	    
		$where['comid']				=	$this -> member['uid'];
		$where['zid']				=	$_POST['zid'];
		
		$data['total']              =   $spviewM->getSplogNum($where);
		
		$page						=		$_POST['page'];
		if ($_POST['limit']){
			$limit					=		$_POST['limit'];
			if($page){
				$pagenav			=		($page-1)*$limit;
				$where['limit']		=		array($pagenav,$limit);
			}else{
				$where['limit']		=		$limit;
			}         
		}
		  
        $where['orderby']	=	'ctime,desc';
        
		$rows 		= 	$spviewM->getSpLogList($where);
	    

		$data	=	array();
		if(is_array($rows) && !empty($rows)){
			$data['list']	=	$rows;
			$error	=	0;
		}else{
			$error	=	2;
		}
		$this->render_json($error,'',$data);
		
	}
	function delzph_action()
	{
	    $zpnetM  =  $this -> MODEL('zphnet');
		$id   	 = 	intval($_POST['ids']);
		$return	 =	$zpnetM -> delZphnetCom($id,$this->member['uid']);
		if($return['errcode']==9){
			$error	=	1;
		}else{
			$error	=	2;
		}
		$this->render_json($error,'ok');
	}
   
}