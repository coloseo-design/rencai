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
class index_controller extends train{

	function index_action(){
	
		$TrainM		=	$this->MODEL('train');
		$UserinfoM	=	$this->MODEL('userinfo');		
		$StatisM	=	$this->MODEL('statis');
		$statis		=	$StatisM->getInfo($this->uid,array('usertype'=>'4'));
		$this->yunset("statis",$statis);
		$where['s_uid']		=	$this->uid;
		$where['orderby']	=	array('id,desc');
		$where['limit']		=	4;
		$zixun	=	$TrainM->getPxzxList($where);
  
		foreach($zixun	as $v){

			$uids[]=$v['uid'];
		}
   
		$mwhere['uid']	=	array('in', pylode(',', $uids));
		$minfo			=	$UserinfoM->getList($mwhere,array('field'=>'uid,username'));
  
		if(is_array($zixun)){

			foreach($zixun as $k=>$v){

				foreach($minfo as $val){

					if($v['uid']==$val['uid']){

						$zixun[$k]['nickname']=$val['username'];
					}
				}
			}
		}
    
		$this->yunset("zixun",$zixun);
		//课程数目
   
		$subject_num	=	$TrainM->getPxSubjectNum(array('uid'=>$this->uid));
		$this->yunset("subject_num",$subject_num);
   
		//课程预约数目
		//$nwhere['s_uid']	=	$this->uid;
		$baoming_num		  =	$TrainM->getPxBaomingNum(array('s_uid'=>$this->uid));
		$this->yunset("baoming_num",$baoming_num);
		//咨询留言数目
		$zixun_num	=	$TrainM->getZixungNum(array('s_uid'=>$this->uid));
		$this->yunset("zixun_num",$zixun_num);
  
		//预约名单
		$bwhere['s_uid']	=	$this->uid;
		$bwhere['orderby']	=	array('id,desc');
		$bwhere['limit']	=	4;
		$baominglist		=	$TrainM->getBmList($bwhere);
		
		foreach($baominglist as $v){

			$sid[]=$v['sid'];
		}

		$swhere['id']	=	array('in', pylode(',', $sid));
  
		$subjectlist	=	$TrainM->getSubList($swhere,array('field'=>'uid,id,name'));
  
		if(is_array($baominglist) && $baominglist){

			foreach($baominglist as $k=>$v){

				foreach($subjectlist as $val){

					if($v['sid']==$val['id']){

						$baominglist[$k]['sub_name']	=	$val['name'];
					}
				}
			}
		}
		$this->yunset("baoming",$baominglist);
			
		$this->train_tpl('index');
	}

}
?>