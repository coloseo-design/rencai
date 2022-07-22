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
class userEntrust_model extends model{
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
     * @desc   引用log类，添加用户日志
     */
    private function addMemberLog($uid,$usertype,$content,$opera='',$type='') {
        
        require_once ('log.model.php');
        
        $LogM = new log_model($this->db, $this->def);
        
        return  $LogM -> addMemberLog($uid,$usertype,$content,$opera,$type);
        
    }
    /**
     * 查询个人向网站委托简历列表
     * @param array $whereData
     * @param array $data
     */
    public function getList($whereData,$data=array()) {
        
        $field      =   $data['field'] ? $data['field'] : '*';
        
        $List =   $this -> select_all('user_entrust',$whereData,$field);
        
        if ($data['utype'] == 'admin'){
            
            $List  =  $this -> getDataList($List);
        }
        return $List;
    }
	/**
     * 委托简历展示
     * @param array $whereData
     * @param array $data
     */
	public function getInfo($where = array(), $data = array()) {
        
		$select =   $data['field'] ? $data['field'] : '*';
        
		$Info	=   $this -> select_once('user_entrust', $where, $select);
		
		$expect =  $this -> select_once('resume_expect',array('id'=>$data['eid']),'`name`');
		
		$Info['name']	=	$expect['name'];
        
		return $Info;
        
    }
    /**
     * 审核委托简历
     * @param array $whereData
     * @param array $data
     */
    public function statusEntrust($whereData = array('uid'=>null,'usertype'=>null),$data = array('post'=>null)){
        
        if (!empty($whereData)){
            
            $post   =  $data['post'];
            
            $nid    =  $this -> update_once('user_entrust',$post,$whereData);
            
            if ($nid){
                
                $status  =  $post['status'];
                
                $trust   =  $this->select_once('user_entrust',array('id'=>$whereData['id']));
                
                if ($status == 1){
                    
                    $msg  =  '委托简历通过审核';
                    
                    $this -> update_once('resume_expect',array('is_entrust'=>2),array('id'=>$trust['eid']));
                    
                }elseif ($status == 2){
                    
                    $msg  =  '委托简历未通过审核';
                    
                    $this -> update_once('resume_expect',array('is_entrust'=>0),array('id'=>$trust['eid']));
                    
                    if($trust){
                        
                        include_once('integral.model.php');
                        
                        $integralM  =  new integral_model($this->db, $this->def);
                        
                        $integralM -> company_invtal($trust['uid'],1,$trust['price'],true,'退还委托简历费用',true,2,'packpay');
                    }
                }
                include_once('sysmsg.model.php');
                $sysmsgM    =   new sysmsg_model($this->db, $this->def);
                $sysmsgM    ->  addInfo(array('uid'=>$trust['uid'],'usertype'=>1, 'content'=>$msg));
                $return['msg']      =  '委托简历(ID:'.$whereData['uid'].')设置成功';
                $return['errcode']  =  '9';
            }else{
                $return['msg']      =  '委托简历(ID:'.$whereData['uid'].')设置失败';
                $return['errcode']  =  '8';
            }
        }else{
            $return['msg']      =  '请选择需要审核的委托简历';
            $return['errcode']  =  '8';
        }
        return $return;
    }
    /**
     * 委托简历,推荐列表处理查询条件
     */
    public function getRecordWhere($eid){
        
        if (!empty($eid)){
            $where   =  array();
            
            $expect  =  $this -> select_once('resume_expect',array('id'=>$eid),'`id`,`hy`,`city_classid`,`job_classid`');
            
            if (!empty($expect)){
                
                
                
                if ($expect['job_classid']){
                    
                    $where['PHPYUNBTWSTART_A']     =  '';
                    $where['job1']          =  array('in',$expect['job_classid']);
                    $where['job1_son']      =  array('in',$expect['job_classid'],'OR');
                    $where['job_post']      =  array('in',$expect['job_classid'],'OR');
                    $where['PHPYUNBTWEND_A']  =  '';
                }
                if ($expect['city_classid']){
                    
                    $where['PHPYUNBTWSTART_B']     =  '';
                    $where['provinceid']    =  array('in',$expect['city_classid']);
                    $where['cityid']        =  array('in',$expect['city_classid'],'OR');
                    $where['three_cityid']  =  array('in',$expect['city_classid'],'OR');
                    $where['PHPYUNBTWEND_B']  =  '';
                }
            }
            
            $record  =  $this -> select_all('user_entrust_record',array('eid'=>$eid),'`jobid`');
            
            $jobid   =  array();
            
            if($record){
                
                foreach($record as $v){
                    
                    $jobid[]  = $v['jobid'];
                }
            }
            if (!empty($jobid)){
                
                $where['id']  =  array('notin',pylode(',', $jobid));
            }
            
            return $where;
        }
    }
    /**
     * 委托简历-推荐列表-推荐简历
     */
    public function sendRecord($whereData,$data=array()){
        
        if(!empty($whereData['eid']) && !empty($whereData['jobid'])){
            
            $recoed  =  $this -> select_once('user_entrust_record',array('jobid'=>$whereData['jobid'],'eid'=>$whereData['eid']));
            
            if(empty($recoed)){
                
                $company  =  $this -> select_once('company',array('uid'=>$whereData['comid']),'`uid`,`linkmail`,`did`');
                
                $resume   =  $this -> select_once('resume_expect',array('id'=>$whereData['eid']),'`id`,`uid`,`name`');
                
                $rdata    =  array(
                    'jobid'  =>  $whereData['jobid'],
                    'uid'    =>  $resume['uid'],
                    'eid'    =>  $whereData['eid'],
                    'comid'  =>  $company['uid'],
                    'ctime'  =>  time(),
                    'did'    =>  $company['did']
                );
                
                $nid      =  $this -> insert_into('user_entrust_record',$rdata);
                
                if($nid){
                    //发送系统通知
                    include_once('sysmsg.model.php');
                    
                    $sysmsgM  =  new sysmsg_model($this->db, $this->def);
                    
                    $sysmsgM -> addInfo(array('uid'=>$company['uid'],'usertype'=>2, 'content'=>'管理员为您推荐了简历<a href="resumetpl,'.$resume['id'].'">《'.$resume['name'].'》</a>'));
                    //发送邮件并记录入库
                    if ($company['linkmail']){
                        
                        include_once ('resume.model.php');
                        $resumeM    =   new resume_model($this->db, $this->def);
                        
                        $Info       =   $resumeM -> getInfoByEid(array('eid' => $whereData['eid']));
                        // 简历模糊化
                        $resumeCheck  =  $this->config['resume_open_check'] == 1 ? 1 : 2;
                        global $phpyun;
                        $phpyun -> assign('Info',$Info);
                        $phpyun -> assign('resumeCheck',$resumeCheck);
                        $contents	=	$phpyun -> fetch(TPL_PATH.'resume/sendresume.htm',time());
                        
                        if ($contents){
                            
                            include_once('notice.model.php');
                            
                            $noticeM    =  new notice_model($this->db, $this->def);
                            
                            $emailData  =  array(
                                'email'    =>  $company['linkmail'],
                                'subject'  =>  $this -> config['sy_webname'].'向您推荐了简历！',
                                'content'  =>  $contents
                            );
                            
                            $noticeM -> sendEmail($emailData);
                        }
                    }
                    $return['msg']      =  '推荐简历(ID:'.$whereData['eid'].')成功';
                    $return['errcode']  =  '9';
                }else{
                    $return['msg']      ='推荐失败';
                    $return['errcode']  =  '8';
                }
            }else{
                $return['msg']      =  '请勿重复推荐';
                $return['errcode']  =  '8';
            }
        }else{
            $return['msg']      =  '请选择要推荐的简历';
            $return['errcode']  =  '8';
        }
        return $return;
    }
    /**
     * 委托简历-委托列表-删除委托
     */
    public function delInfo($id){
        
        $limit                =  'limit 1';
        $return['layertype']  =	 0;
        
        if (!empty($id)){
            
            if(is_array($id)){
                
                $id  =  pylode(',', $id);
                $return['layertype']  =  1;
                $limit                =  '';
            }
            
            $entrust  =  $this->select_all('user_entrust',array('id'=>array('in',$id)));
             
            $nid      =  $this->delete_all('user_entrust',array('id'=>array('in',$id)),$limit);
            
            if ($nid){
                //删除委托简历，需要修改委托简历状态
                if (!empty($entrust)){
                    
                    foreach ($entrust as $v){
                        
                        $eids[]  =  $v['eid'];
                    }
                }
                if (!empty($eids)){
                    
                    $this -> update_once('resume_expect',array('is_entrust'=>0),array('id'=>array('in',pylode(',', $eids))));
                }
                
                $return['msg']      =  '委托简历(ID:'.$id.')删除成功';
                $return['errcode']  =  '9';
            }else{
                $return['msg']      =  '委托简历(ID:'.$id.')删除成功';
                $return['errcode']  =  '8';
            }
        }else{
            $return['msg']      =  '请选择您要删除的委托简历';
            $return['errcode']  =  '8';
        }
        return $return;
    }
    /**
     * 获取简历推送记录
     * $whereData 	查询条件
     * $data 		自定义处理数组
     */
    
    public function getRecordInfo($whereData,$data=array()){
        
        $select     =   $data['field'] ? $data['field'] : '*';
        
        $info		=	$this -> select_once('user_entrust_record',$whereData,$select);
        
        if (is_array($info)) {
            
            return	$info;
            
        }    
    }
    
    /**
    * 获取简历推送记录列表
    * $whereData 	查询条件
    * $data 		自定义处理数组
    */
    
    public function getRecordList($whereData,$data=array()){
        $ListNew	=	array();
        $List		=	$this -> select_all('user_entrust_record',$whereData);
        
        if(!empty( $List )){
            $List  =  $this -> getDataRecord($List);
            
            $ListNew['list']	=	$List;
        }
        
        return	$ListNew;
    }
    /**
     * 简历记录管理-简历推送记录-删除推送
     */
    public function delRecord($id, $data = array()){
        
        $limit                =  'limit 1';
        if (!empty($id)){
            
            if(is_array($id)){
                
                $id  =  pylode(',', $id);
                $return['layertype']  =  1;
                $limit                =  '';
            }else{
				$return['layertype']  =  0;
			}
			if($data['uid']){
				if($data['usertype']==2){
					$delWhere = array('id'=>array('in',$id),'comid'=>$data['uid']);
				}else{
					$delWhere = array('id'=>array('in',$id),'uid'=>$data['uid']);
				}
			}else{
				$delWhere = array('id'=>array('in',$id));
			}
            $nid      =  $this->delete_all('user_entrust_record',$delWhere,$limit);
            
            if ($nid){
                $this -> addMemberLog($data['uid'],$data['usertype'],"删除推送的人才",25,3);
				
                $return['msg']      =  '简历推送(ID:'.$id.')删除成功';
                $return['errcode']  =  '9';
            }else{
                $return['msg']      =  '简历推送(ID:'.$id.')删除成功';
                $return['errcode']  =  '8';
            }
        }else{
            $return['msg']      =  '请选择您要删除的简历推送';
            $return['errcode']  =  '8';
        }
        return $return;
    }
    /**
     * 委托简历列表,后台显示数据处理
     */
    private function getDataList($List){
        
        foreach($List as $v){
            
            $eids[]   =   $v['eid'];
        }
        $expect       =   $this -> select_all('resume_expect',array('id'=>array('in',pylode(',', $eids))),'`id`,`name`,`uname`');
        
        foreach($List as $k=>$v){
            
            foreach($expect as $val){
                
                if($val['id'] == $v['eid']){
                    
                    $List[$k]['name']   =  $val['name'];
                    $List[$k]['uname']  =  $val['uname'];
                }
            }
        }
        return $List;
    }
    /**
    * 推送简历列表,后台显示数据处理
    */
    private function getDataRecord($List){
        
        foreach($List as $v){
            $uids[]    =  $v['uid'];
            $eids[]    =  $v['eid'];
            $comids[]  =  $v['comid'];
            $jobids[]  =  $v['jobid'];
        }
		//  查询个人姓名
		$rWhere['uid']    =   array('in', pylode(',', $uids));
        $rData['field']   =   '`uid`,`name`,`nametype`,`sex`,`def_job`';
        
        $resume           =   $this -> getResumeList($rWhere, $rData);
		
		 //  查询个人简历名称
        $reWhere['id']    =   array('in', pylode(',', $eids));
        $reData['field']  =   '`id`,`name`,`job_classid`,`minsalary`,`maxsalary`,`exp`';
        
        $expect  =   $this -> getResumeExpectList($reWhere, $reData);
        
        $com     =   $this -> select_all('company',array('uid'=>array('in',pylode(',', $comids))),'`uid`,`name`');
        
        $job     =   $this -> select_all('company_job',array('id'=>array('in',pylode(',', $jobids))),'`id`,`name`');
		
		$userid_msg  =	$this -> select_all("userid_msg",array('fid'=>array('in',pylode(',', $comids)),'uid'=>array('in',pylode(",",$uids))),'`uid`');
		
        foreach($List as $k=>$v){
            foreach($resume as $val){
	            
	            if($v['uid'] == $val['uid']){
	                $List[$k]['user_name']      =  $val['name_n'];
	            }
	        }
			foreach($expect['list'] as $val){
	            
	            if( $v['eid'] == $val['id']){
					$List[$k]['exp']			=	$val['exp_n'];
					$List[$k]['salary']			=	$val['salary'];
					if ($val['job_classid'] != "") {
	                    $List[$k]['jobclassidname']	= $val['job_classname'];
	                }
	                $List[$k]['resume_name']	=  $val['name'];
	            }
	        }
            foreach($com as $val){
                
                if($val['uid'] == $v['comid']){
                    
                    $List[$k]['com_name']  =  $val['name'];
                }
            }
            foreach($job as $val){
                
                if($val['id'] == $v['jobid']){
                    
                    $List[$k]['job_name']  =  $val['name'];
                }
            }
			foreach($userid_msg as $val){
				if($v['uid']==$val['uid']){
					$List[$k]['userid_msg']		=	1;
				}
			}
        }
        return $List;
    }
	//个人pc取消委托简历
	public function cancelEntrust($data=array()){
		
		require_once ('integral.model.php');      
        $IntegralM    	=   new integral_model($this->db, $this->def);
		
        $expect			=	$this->select_once('resume_expect',array('uid'=>$data['uid'],'id'=>$data['id']),'`id`,`is_entrust`');
		
		if((int)$this->config['user_trust_number']<1 && $expect['is_entrust']=='0'){
			
			$return['type']		=	'8';
			$return['msg']		=	'网站已关闭此服务！';
		}else if($expect['id']){
			
			if($expect['is_entrust']=='0'){
				
				$entrust_num	=	$this->select_num('resume_expect',array('uid'=>$data['uid'],'is_entrust'=>array('>',0)));
				
				if($entrust_num < (int)$this->config['user_trust_number']){
					
					$member_statis	=	$this->select_once("member_statis",array('uid'=>$data['uid']),"`pay`");
					
					if($member_statis['pay'] < $this->config['pay_trust_resume'] && $this->config['pay_trust_resume']){
						
						$return['type']			=	'8';
						$return['msg']			=	'余额不足，无法委托！';
						$return['url']			=	'index.php?c=pay&act=money';
					}else{						
						$res		=	$IntegralM->company_invtal($data['uid'],1,$this->config['pay_trust_resume'],false,"委托简历",true,2,'pay'); 						
						if($res){
							
							$idata['uid']      = $data['uid'];
							$idata['did']      = $data['did'];
							$idata['username'] = $data['username'];
							$idata['eid']      = $expect['id'];
							$idata['status']   = $this->config['user_trust_status'];
							$idata['price']    = $this->config['pay_trust_resume'];
							$idata['add_time'] = time();
							
							$nid	=	$this->insert_into("user_entrust",$idata);
							
							if($nid){
								
								if($this->config['user_trust_status']=='1'){
									
									$this->update_once("resume_expect",array('is_entrust'=>2),array('uid'=>$data['uid'],'id'=>$expect['id']));
								}else{
									
									$this->update_once("resume_expect",array('is_entrust'=>1),array('uid'=>$data['uid'],'id'=>$expect['id']));
								}
								$return['type']		=	'9';
								$return['msg']		=	'简历委托成功！';
							}else{
								$return['type']		=	'8';
								$return['msg']		=	'简历委托失败！';
							}
						}else{
							$return['type']			=	'8';
							$return['msg']			=	'金额扣除失败，请稍后再试！';
						}
					}
				}else{
					$return['type']					=	'8';
					$return['msg']					=	'您已委托'.$entrust_num.'份简历，无法再次操作！';
				}
			}else if($expect['is_entrust']=='1'){//取消委托
			
				$user_entrust	=	$this->select_once("user_entrust",array('uid'=>$data['uid'],'eid'=>$expect['id']));
				
				if($user_entrust['id']){
					
					$res		=	$this->update_once("resume_expect",array('is_entrust'=>0),array('uid'=>$data['uid'],'id'=>$expect['id']));
					
					if($res){
						
						if($user_entrust['status']=='0'){
							
							$IntegralM->company_invtal($data['uid'],1,$user_entrust['price'],true,"退还委托简历费用",true,2,'packpay');   
						}
						
						$this->delete_all('user_entrust', array('uid'=>$data['uid'],'eid'=>$expect['id']),'');
						$return['type']		='9';
						$return['msg']		=	'操作成功！';
					}else{
						$return['type']		=	'8';
						$return['msg']		=	'取消失败，请稍后再试！';
					}
				}else{
					$return['type']			=	'3';
					$return['msg']			=	'非法操作！';
				}
			}else if($expect['is_entrust']=='2'){//取消委托，已通过审核不退还费用
			
				$user_entrust		=	$this->select_once("user_entrust",array('uid'=>$data['uid'],'eid'=>$expect['id']));
				if($user_entrust['id']){
					
					$res	=	$this->update_once("resume_expect",array('is_entrust'=>0),array('uid'=>$data['uid'],'id'=>$expect['id']));
					
					if($res){
						
						$this->delete_all("user_entrust",array('uid'=>$data['uid'],'eid'=>$expect['id']),'');
						
						$return['type']		=	'9';
						$return['msg']		=	'操作成功！';
					}else{
						$return['type']		=	'8';
						$return['msg']		=	'取消失败，请稍后再试！';
					}
				}else{
					$return['type']			=	'3';
					$return['msg']			=	'非法操作！';
				}
			}
		}else{
			$return['type']		=	'3';
			$return['msg']		=	'非法操作！';
		} 
		$return['msg']			=	$return['msg'];
		
		return $return;
	}
	function getEntrustNum($where=array()){
		return $this->select_num('user_entrust',$where);
	}
}
?>