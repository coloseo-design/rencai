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
class resume_controller extends user{
	//简历管理
	function index_action(){

		$this->public_action();
        
        $ResumeM        =     $this->MODEL('resume');
        
        $where['uid']   =     $this->uid;
        
        if (!empty($this->config['user_number'])){
            
            $num		=     $ResumeM->getExpectNum($where);
            $maxnum		=  $this->config['user_number'] - $num;
            
            if($maxnum <= 0){$maxnum='0';}
        }else{

            $maxnum		=  '';
        }
        $this->yunset("maxnum",$maxnum);
		
        $rows  =  $ResumeM -> getSimpleList($where,array('field'=>'id,name,lastupdate,doc,tmpid,integrity,hits,height_status,statusbody,`topdate`,`is_entrust`,`top`,`state`,`status`'));
    
        if($rows&&is_array($rows)){
		
            foreach($rows as $key=>$val){
    				
                if($val['topdate']>1){
        				
                $rows[$key]['topdate']=date("Y-m-d",$val['topdate']);
        
                $rows[$key]['topdatetime']=$val['topdate']-time();
        	
                }else{
                  
    				$rows[$key]['topdate']='未设置';
          
    			}
    		}
		}
       
		$this->yunset("rows",$rows);

        $row    =    $ResumeM->getResumeInfo($where,array('field'=>'def_job,idcard_status,idcard_pic'));
        
        $rexpectwhere['uid']          =     $this->uid;
        
        $rexpectwhere['defaults']     =     1;
        $rexpectwhere['id'] = $row['def_job'];
        $resume                       =     $ResumeM->getExpect($rexpectwhere,array('member'=>1,'needCache'=>1,'field'=>'id,uid,integrity,statusbody,sex,whour,jobstatus,report,status'));

        $this->yunset("expectStatus",$resume);
        $integrity                    =     $resume['integrity'];
        
        $renumwhere['integrity']      =     array('>',$integrity);
        
        $resumepm                     =     $ResumeM->getExpectNum($renumwhere);
    
		$this->yunset("resumepm",$resumepm);//简历完整度排名
		
		$CacheArr=$this->MODEL('cache')->GetCache(array('user'));
    
        $eduwhere['uid']              =     $this->uid;
        
        $eduwhere['eid']              =     $row['def_job'];
        
        $eduwhere['orderby']          =     array('sdate,desc');
        
        $edu                          =     $ResumeM-> getResumeEdus($eduwhere);    
    		
        $gdeu=0;
        
		foreach ($edu as $v){
          
			if (in_array($CacheArr['userclass_name'][$v['education']],array('本科','硕士','研究生','硕士研究生','MBA','博士研究生','博士','博士后'))){
    				
                $gdeu=1;
        			
            }
		}
    
		if($gdeu==1){//学历本科以上才可以申请优质简历！
    
			$this->yunset('heightone',1);
		
        }
    
        $workwhere['uid']              =     $this->uid;
        
        $workwhere['eid']              =     $row['def_job'];
        
        $workwhere['orderby']          =     array('sdate,desc');
        
        $work                           =     $ResumeM-> getResumeWorks($workwhere);  

		if($resume['whour']>24 || count($work)>3){//工作经历二年以上或工作经历三项以上
    
			$this->yunset('heighttwo',2);
      
		}
		$this->yunset("def_job",$row['def_job']);
		$this->user_tpl('resume');
	}
	//删除简历
	function del_action(){
    
        $ResumeM          =       $this->MODEL('resume');
        
        $id               =       $_GET['id'];
        
        $return           =       $ResumeM->delResume($id,array('uid' => $this -> uid));
        
        $this -> layer_msg($return['msg'], $return['errcode'], $return['layertype'], $_SERVER['HTTP_REFERER']);
	}
    //删除简历附表
	function publicdel_action()
    {
        $ResumeM = $this->MODEL('resume');
        
        $uid = $this->uid;
        
        if ($_POST['id'] && $_POST['table']) {
            
            $tables = array("skill","work","project","edu","training","cert","other");
            
            if (in_array($_POST['table'], $tables)) {
                
                $table  =  "resume_" . $_POST['table'];
                $eid    =  (int) $_POST['eid'];
                $id     =  (int) $_POST['id'];
                $url    =  $_POST['table'];
                
                $nid  =  $ResumeM->delFb($_POST['table'], array('id'=>$id,'uid'=>$uid,'eid'=>$eid), array('utype' => 'user'));
                
                if ($nid) {
                    
                    $expect = $ResumeM->getExpect(array('id'=>$eid,'uid'=>$uid),array('field'=>'integrity'));
                    $fbrow  = $ResumeM->getUserResumeInfo(array('eid'=>$eid,'uid'=>$uid));
                    $data   = array(
                        'num'        =>  $fbrow[$url],
                        'integrity'  =>  $expect['integrity']
                    );
                    
                    echo json_encode($data);die();
                } else {
                    echo 0;die();
                }
            } else {
                echo 0;die();
            }
        }
    }
    //购买简历置顶和简历委托
	function resumeOrder_action(){
		if($_POST){
      
  			$M=$this->MODEL('userpay');
			
			$_POST['uid']		=	$this->uid;
			$_POST['usertype']	=	$this->usertype;
			$_POST['did']		=	$this->userdid;
        
			if ($_POST['resumeid']){
        
				$return = $M->buyZdresume($_POST);
        
				$msg="购买简历置顶";
        
			}elseif ($_POST['wteid']){
        
				$return = $M->wtResume($_POST);
        
				$msg="购买委托简历";
        
			}
			if($return['order']['order_id'] && $return['order']['id']){
        
				//订单生成成功
                echo json_encode(array('error' => 0, 'orderid' => $return['order']['order_id'], 'id' => $return['order']['id']));

			}else{
				//生成失败 返回具体原因
        
				echo json_encode(array('error'=>1,'msg'=>$return['error']));
        
			}
		}else{
      
			echo json_encode(array('error'=>1,'msg'=>'参数错误，请重试！'));
      
		}
    
	}
	/**
	 * 单个简历刷新
	 */
	function refresh_action()
	{
    
        $resumeM  =  $this->MODEL('resume');
        
        $data     =  array('lastupdate'=>time());
        
        $nid      =  $resumeM -> upInfo(array('id'=>(int)$_GET['id'],'uid'=>$this->uid),array('eData'=>$data));

        if ($nid) {

            $resumeM->upResumeInfo(array('uid' => $this->uid), array('rData' => $data, 'port' => 1));
        }
            
        $nid?$this->layer_msg('刷新成功！',9,0):$this->layer_msg('刷新失败！',8,0);
    
 	}
	
	/**
	 * 会员中心首页提醒弹出框刷新
	 */
	function resumerefresh_action()
	{
	    $resumeM  =  $this->MODEL('resume');
	    
	    $data     =  array(
	        'lastupdate'  =>  time(),
	        'jobstatus'   =>  $_POST['jobstatus']
	    );
	    
	    $nid  =  $resumeM -> upInfo(array('id'=>(int)$_POST['id'],'uid'=>$this->uid),array('eData'=>$data));
    		
        if($nid){
            
            $resumeM -> upResumeInfo(array('uid'=>$this->uid),array('rData'=>array('lastupdate'=>time()), 'port' => 1));
    			
            echo 1;die;
        }
    }
 	
 	
 	//取消优质简历
    function exite_height_action(){
      
      $ResumeM    =     $this->MODEL('resume');
          
      if($_POST['id']!=""){ 
      
          $id                            =         (int)$_POST['id'];
          
          $uid                           =          $this->uid;
          
          $where['height_status']        =          array('>','0');
          
          $where['uid']                  =          $uid;
          
          $rows                          =          $ResumeM->getExpect($where);
          
          if(!empty($rows)&&$id!=$rows['id']){

              $this->layer_msg('数据异常，请重试',8,0,"index.php?c=resume");
          
          }else if($rows && $rows['id']==$id){
            
             $expectwhere['id']         =           $id;
             
             $expectwhere['uid']        =           $uid;
             
             $expectdata                =           array(
             
                   'height_status'      =>          0   
                        
             );
             
             $nid        =        $ResumeM->upInfo($expectwhere,array('eData'=>$expectdata));
			 
            if($nid){
            
            echo 1;die;//取消成功

            }else{

            echo 2;die;//取消失败

            }

          }
      }
   
   }
   //申请优质简历
	function height_action(){
    
		$ResumeM	=	$this->MODEL('resume');
    
		$uid		=	$this->uid;
    
		if($_GET['id'] && $this->config['sy_lietou_web'] == 1){//申请优质简历
    
			$id	=	(int)$_GET['id'];
      
			$expectwhere['uid']              =      $uid;
			$expectwhere['height_status']    =      array('>','0');
			$rows                            =      $ResumeM->getExpect($expectwhere);
	  
			if(!empty($rows)&&$id!=$rows['id']){
        
				$this->layer_msg('一个人只能申请一份优质简历！',8,0,"index.php?c=resume");
        
			}else{
        
				include PLUS_PATH."/user.cache.php";
			  
				$eduwhere['eid']      =     $id;
			  
				$eduwhere['uid']      =     $uid;
			  
				$row                  =     $ResumeM->getResumeEdus($eduwhere);
			  
				$gdeu=0;
			
				foreach ($row as $v){
          
				    if (in_array($userclass_name[$v['education']],array('本科','硕士','研究生','硕士研究生','MBA','博士研究生','博士','博士后'))){
              
				        $gdeu=1;
				    }
				}
          
				if($gdeu!=1){
          
				    $this->layer_msg('学历本科以上才可以申请优质简历！',8,0,"index.php?c=resume");
			    }
          
				$workwhere['eid']      =     $id;
				$workwhere['uid']      =     $uid;
				$wklist                =     $ResumeM->getResumeWorks($workwhere,'sdate,edate');
		  
				if(is_array($wklist)){
          
					$whour = 0;
					$hour=array();
            
					foreach($wklist as $value){
					//计算每份工作时长(按月)
						if ($value['edate']){
                    
							$workTime = ceil(($value['edate']-$value['sdate'])/(30*86400));
						}else{
							$workTime = ceil((time()-$value['sdate'])/(30*86400));
						}
						$hour[] = $workTime;
						$whour += $workTime;
					}
					$worknum = count($hour);
          
				}
          
				if(!($whour>24 || $worknum>3)){
          
					if ($whour<24){
              
						$this->layer_msg('工作经历二年以上才可以申请优质简历！',8,0,"index.php?c=resume");
                
					}elseif ($worknum<4){
						
						$this->layer_msg('工作经历三项以上才可以申请优质简历！',8,0,"index.php?c=resume");
					}
				}	
          
				if($this->config['user_height_resume']=='2'){
             
             
					$redata   =     array(
						'height_status'   =>  2,
						'status_time'     =>  time()
					);
                  
					$rewhere['id']      =     $id;
					$rewhere['uid']     =     $uid;
					$nid                =     $ResumeM->upInfo($rewhere,array('eData'=>$redata));
			  
					$msg="申请成功！";
				}else{
					
					$redata	=	array(
						'height_status'   =>  1
					);
					$rewhere['id']      =     $id;
					$rewhere['uid']     =     $uid;
					$nid                =     $ResumeM->upInfo($rewhere,array('eData'=>$redata));
            
					$msg="申请成功，请等待审核！";
					
					$resume = $ResumeM->getResumeInfo(array('uid'=>$uid));
					$expect = $ResumeM->getExpect(array('uid'=>$uid,'id'=>$id));

					$adminM	=	$this->MODEL('admin');
					$adminM->sendAdminMsg(array('first'=>'有新的优质简历需要审核，用户《'.$resume['name'].'》申请优质简历《'.$expect['name'].'》','type'=>10));
				}
				if($nid){
					$this->layer_msg($msg,9,0,"index.php?c=resume");
				}else{
					$this->layer_msg('申请失败！',8,0,"index.php?c=resume");
				}
			}
		}else{
			$this->layer_msg('数据异常请重试！',8,0,"index.php?c=resume");
		}
	}
	//设置默认简历，TODO:仅个人会员中心
    function defaultresume_action()
    {
     
        $resumeM  =  $this->MODEL('resume');
        
        $resumeM -> defaults(array('id'=>(int)$_GET['id'],'uid'=>$this->uid));
    
		$this->layer_msg('操作成功！',9,0,"index.php?c=resume");
	}
}
?>