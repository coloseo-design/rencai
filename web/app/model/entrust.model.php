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
class entrust_model extends model{
	/**
     * @desc   引用log类，添加用户日志   
     */
    private function addMemberLog($uid,$usertype,$content,$opera='',$type='') {
        require_once ('log.model.php');
        $LogM = new log_model($this->db, $this->def);
        return  $LogM -> addMemberLog($uid,$usertype,$content,$opera,$type); 
    }
	
	//获取简历信息列表resume_expect
    private function getResumeExpectList($whereData, $data = array()){
        
        require_once ('resume.model.php');
        
        $resumeM    =   new resume_model($this->db, $this->def);
        
        return  $resumeM   ->  getList($whereData , $data);
    }
	//获取简历信息列表resume
    private function getResumeList($whereData, $data = array()){
        
        require_once ('resume.model.php');
        
        $resumeM    =   new resume_model($this->db, $this->def);
        
        return  $resumeM   ->  getResumeList($whereData , $data);
    }
	
	/**
	 * 获取委托来的人才列表
	 * $whereData 	查询条件
	 * $data 		自定义处理数组
	 */
	 
	public function getList($whereData,$data=array()){
		$field = $data['field'] ? $data['field'] : '*';
        
        $List  =   $this   ->  select_all('entrust',$whereData,$field);
		
		if(!empty( $List )){
			foreach ($List as $v){
				$uids[]     =   $v['uid'];
			}
			//  查询个人简历名称
			$reWhere['uid']			   =  array('in', pylode(',', $uids));
			$reWhere['height_status']  =  2;
			$reData['field']		   =  '`id`,`uid`,`name`,`job_classid`,`minsalary`,`maxsalary`,`height_status`,`edu`,`exp`,`hy`,`lastupdate`,`city_classid`,`sex`';
			
			$resumeexpectList          =  $this -> getResumeExpectList($reWhere, $reData);
			
			$expectuids  =  array();
			foreach ($resumeexpectList['list'] as $v){
				if ($v['uid'] && !in_array($v['uid'],$expectuids)) {
					$expectuids[]  =  $v['uid'];
				}
			}
			
			//  查询个人姓名
			$rWhere['uid']              =   array('in', pylode(',', $uids));
			$rData['field']             =   '`uid`,`name`,`nametype`,`sex`,`def_job`';
			
			$resumeList                 =   $this -> getResumeList($rWhere, $rData);
			
			//简历不存在的情况，去掉委托来的记录
			foreach ($List  as  $k  =>  $v){
				if(!in_array($v['uid'], $expectuids)){
					unset($List[$k]);
				}
			}
			
			foreach ($List  as  $k  =>  $v){
				foreach ($resumeList as $val){
					
					if ($v['uid']   ==  $val['uid']) {
						$List[$k]['name'] = $val['name_n'];
					}
				}
				foreach ($resumeexpectList['list'] as $rv){
					
					if ($v['uid']   ==  $rv['uid']) {
						$List[$k]['eid']			=	$rv['id'];
						$List[$k]['sex']			=	$rv['sex_n'];
						$List[$k]['exp']			=	$rv['exp_n'];
						$List[$k]['edu']			=	$rv['edu_n'];
						$List[$k]['height_status']	=	$rv['height_status'];
						$List[$k]['jobname']		=	$rv['job_classname'];
						$List[$k]['hy']				=	$rv['hy_n'];
						$List[$k]['cityname']		=	$rv['city_classname'];
						$List[$k]['lastupdate']		=	$rv['lastupdate'];
					}
				}
			}
		}
		return	$List;
	}
	 /**
     * @desc    修改委托简历状态
     * @param   array $Where
     * @param   array $data
     * @return  $return
     */
    function upInfo($data = array(),$Where = array()){
        return $this->update_once('entrust', $data, $Where);
    }
	/**
	 * 删除委托简历
	 * $whereData 	查询条件
	 * $data 		自定义处理数组
	 */
	public function delInfo($id,$data){
	    if (!empty($id)){
			if(is_array($id)){
                
                $ids    				=	$id;
                $return['layertype']	=	1;
            }else{
                
                $ids    				=   @explode(',', $id);
                $return['layertype']	=	 0;
            }
            
            $id             =   pylode(',', $ids);
			
			
			if($data['utype'] == 'admin'){
				$delWhere	=	array('id'=>array('in',$id));
			}else{
				$delWhere	=	array('uid'=>$data['uid'],'id'=>array('in',$id));
			}
			 
	        $nid      =  $this->delete_all('entrust',$delWhere,'');
	        
	        if ($nid){
				
				$this -> addMemberLog($data['uid'],$data['usertype'],"删除委托的简历",6,3);
				
	            $return['msg']      =  '删除成功';
	            $return['errcode']  =  '9';
	        }else{
	            $return['msg']      =  '删除失败';
	            $return['errcode']  =  '8';
	        }
	    }
	    return $return;
	}	
	/**
     * @desc    获取委托详细信息
     */
	function getEntrustInfo($whereData,$data=array()){
		
		$field	=	empty($data['field']) ? '*' : $data['field'];
		
		$EntrustInfo 	=	$this -> select_once('entrust', $whereData, $field);
		
		return $EntrustInfo;
		
	}
	/**
     * @desc    获取委托数目
     */
	function getEntrustNum($WhereData = array()){
		
		$Entrustnum	=	$this->select_num('entrust', $WhereData);
		
		return $Entrustnum;
	}
	function addEntrust($data=array()){
		
		if($data['usertype']!="1"){
			$return['msg']		=	'您不是个人用户，不能委托简历！';
			$return['errcode']	=	1;
		}else{
			
			$row	=	$this -> select_once("entrust",array('uid'=>$data['uid'],'lt_uid'=>$data['puid']));
			if(is_array($row)){
				$return['msg']		=	'您已经委托过简历给该猎头！';
				$return['errcode']	=	2;
			}else{
				$resume	=	$this -> select_once("resume_expect",array('uid'=>$data['uid'],'height_status'=>2));
				if(is_array($resume)){
					
					
					$this -> insert_into("entrust",array('uid'=>$data['uid'],'lt_uid'=>$data['puid'],'datetime'=>time()));
					
					$this -> addMemberLog($data['uid'],$data['usertype'],"把优质简历 《".$resume['name']." 》委托给：".$_POST['name'],6,3);
					$return['msg']		=	'委托简历成功！';
					$return['errcode']	=	3;
				}else{
					$return['msg']		=	'先完善简历，成为优质简历以后才可以申请猎头帮您招聘！';
					$return['errcode']	=	4;
				}
			}
		}
		return $return;
	}
}
?>