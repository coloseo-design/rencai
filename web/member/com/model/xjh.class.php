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
class xjh_controller extends company{
	//宣讲会
	function index_action(){
		
		$this->company_satic();
		$this->public_action();
		
		$cacheM    	=  	$this -> MODEL('cache');
		$cache		=	$cacheM->GetCache(array('city'));
		$this->yunset($cache);
		
		$schoolM    	=  $this -> MODEL('school');
		$companyM  		=  $this -> MODEL('company');
     
		$where['uid']   =   $this->uid;
		
		$urlarr["c"] 	=   "xjh";
		$urlarr["page"]	=   "{{page}}";
    	$pageurl   		=   Url('member',$urlarr);
    	$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('school_xjh',$where,$pageurl,$_GET['page']);
    
  		$where['limit']	=   $pages['limit'];
    
		$rows	= 	$schoolM->getSchoolXjhList($where);
		$this->yunset("rows",$rows);
    
		$schoolList	=   $schoolM->getSchoolAcademyList(1,array('field'=>'id,schoolname'));
		$school		=	$schoolList['list'];
		$this->yunset("school",$school);
    
		$certwhere['type']    =   3;
		
		$certwhere['uid']     =   $this->uid;
		
		$cert                 =    $companyM->getCertList($certwhere);
		$this->yunset("cert",$cert);
    
		$this->com_tpl("xjh");
	}
	//宣讲会添加
	function save_action(){
      $schoolM	= 	$this ->  MODEL('school');
      	
        $cache      =   $this->MODEL('cache') -> GetCache('city');
        $citymsg 	= 	false;
        if(!empty($cache['city_type'])){
        	
    		if($_POST['provinceid']==''){
				$this->ACT_layer_msg('请选择宣讲省份',8);
			}
			if($_POST['cityid']==''){
				$this->ACT_layer_msg('请选择宣讲城市',8);
			}
        	
        }else{
        	
    		if($_POST['provinceid']==''){
				$this->ACT_layer_msg('请选择宣讲城市',8);
			}
        	
        }

    	
      //判断选择城市是否有宣讲会
      $where['provinceid']      =   $_POST['provinceid'];
      $where['cityid']          =   $_POST['cityid'];
      $list   =   $schoolM->getSchoolAcademyInfo($where);
      $rowt	=	$list['info'];
      if($rowt){
         if($_POST['schoolid']==''){
          $this->ACT_layer_msg('请选择宣讲院校',8);
        }
      }else{
         if($_POST['schoolid']==''){
          $this->ACT_layer_msg('当前选择城市没有相关院校，无法发布校招宣讲会',8);
        }
      }
    
			if($_POST['address']==''){
				$this->ACT_layer_msg('请填写详细地点',8);
			}
			if($_POST['datetime']==''){
				$this->ACT_layer_msg('请选择宣讲日期',8);
			}
			if($_POST['stime']==''){
				$this->ACT_layer_msg('请选择宣讲开始时间',8);
			}
			if($_POST['etime']==''){
				$this->ACT_layer_msg('请选择宣讲结束时间',8);
			}
			$sdate=strtotime($_POST['datetime'].' '.$_POST['stime']);
			$edate=strtotime($_POST['datetime'].' '.$_POST['etime']);
			if($sdate>$edate){
				$this->ACT_layer_msg('开始时间要小于结束时间',8);
			}
      $post		=	array(
        'provinceid' 	=>  $_POST['provinceid'],
        'cityid'    	=>  $_POST['cityid'],
        'schoolid'   	=>  $_POST['schoolid'],
        'address'  		=>  $_POST['address'],
        'uid'           =>	$this->uid,
        'status'		=>	0,
        'r_status'  	=>  $_POST['r_status'],
      );
		$data	=	array(
			'post'		=>	$post,
			'id'		=>	$_POST['id'],
			'datetime'	=>	$_POST['datetime'],
			'stime'     =>  $_POST['stime'],
			'etime'     =>  $_POST['etime'],
		);
		$return	=	$schoolM -> addSchoolXjh($data);
		
		if($return['errcode']==9){
			
			$this->ACT_layer_msg($return['msg'],$return['errcode'],'index.php?c=xjh');
			
		}else{
			$this->ACT_layer_msg($return['msg'],$return['errcode']);
		}
	}
 	//宣讲会修改
	function edit_action(){
		
		$schoolM       =  $this -> MODEL('school');
		
		$school        =  $schoolM->getSchoolAcademyList('',array('field'=>'id,schoolname'));
		$this->yunset("school",$school['list']);
		
		$cacheM    	=  	$this -> MODEL('cache');
		$cache		=	$cacheM->GetCache(array('city'));
		if($_GET['id']){
			$id         =   intval($_GET['id']);
			$rowlist  	=  	$schoolM->getSchoolXjhInfo($id,array('uid'=>$this->uid));
			$row		=	$rowlist['info'];

			if($row['provinceid']){
        
				$html='<option value="">请选择</option>';
          
				foreach($cache['city_type'][$row['provinceid']] as $v){
              
					$html.="<option value='".$v."'>".$cache['city_name'][$v]."</option>";
				}
			}
			$row['cityhtml']	=	$html;
			$row['datetime']	=	date('Y-m-d',$row['stime']);
			$row['sdate']		=	date('H:i',$row['stime']);
			$row['edate']		=	date('H:i',$row['etime']);
		}
		echo json_encode($row);die;
	}
	//宣讲会删除
	function del_action(){
    
		$schoolM	=	$this -> Model('school');
		$logM		=	$this -> Model('log');
    
		if($_GET['del'] || $_GET['id']){
			
			$delID	    =	is_array($_GET['del']) ? $_GET['del'] : $_GET['id'];
			$return	  	=	$schoolM -> delSchoolxjh($delID,array('uid'=>$this -> uid));
       
			if($_GET['id']){
         
				$logM -> addMemberLog($this->uid,$this->usertype,'删除校招宣讲会','','3');
				$this->layer_msg($return['msg'],$return['errcode'],0,$_SERVER['HTTP_REFERER']);
            
			}else{
				$this->layer_msg($return['msg'],$return['errcode'],1,$_SERVER['HTTP_REFERER']);
			}
		}else{
			$this->ACT_layer_msg("请选择您要删除的校招宣讲会！",8,$_SERVER['HTTP_REFERER']);
		}
	}  
}
?>