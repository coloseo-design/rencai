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
class lt_job_controller extends company{
  
	function index_action(){
    
		$ltjobM      	=   $this -> MODEL('lietoujob');
		$jobM       	=   $this -> MODEL('job');
		
		$uid            =   $this->uid;
		$where['uid'] 	=   $uid;

        $jobM       =   $this->MODEL('job');
        $this->yunset('jobNum', $jobM->getJobNum($where));
        $partM          =   $this -> MODEL('part');
        $this->yunset('partNum', $partM->getpartJobNum($where));
		$this->yunset('ltjobNum', $ltjobM->getLtjobNum($where));
        $this -> yunset('i_know_ltjob', !empty($_COOKIE['i_know_ltjob_' . $this->uid]) ? 1 : 0);
		
		$where['usertype'] 	=   $this->usertype;
		
		$urlarr["c"]	=   "lt_job";
		$urlarr["page"]	=   "{{page}}";
		$pageurl     	= 	Url('member',$urlarr);
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('lt_job',$where,$pageurl,$_GET['page']);
		
		$where['limit']	=   $pages['limit'];

		$rows         	=	$ltjobM -> getList($where,array('field'=>'job_name,status,id,lastupdate,edate,rec,rec_time,zp_status,hits,statusbody'));

		if($rows && is_array($rows)){
      
			$jobs=array();
      
			foreach($rows as $key=>$val){
        
        		$rows[$key]['num']	=	0;
				$jobids[]			=	$val['id'];
        
			}
      
			$swhere['com_id']       =   $uid;
			$swhere['groupby']      =  	'com_id';
			$swhere['job_id']       =  	array('in', pylode(',', $jobids));
			$nums	=	$jobM -> getSqJobList($swhere,array('field'=>'job_id,count(id) as num'));
			
			foreach($rows as $key=>$val){
		
				foreach($nums as $v){

					if($val['id']==$v['job_id']){
			
						$rows[$key]['num']=$v['num'];
					}
				}
			} 
		}
		$this->yunset('rows',$rows);

		$this->company_satic();
		$this->public_action();
		
		$this->com_tpl('lt_job');
	}
	function jobset_action(){
    
		$ltjobM           =   $this -> MODEL('lietoujob');
		$logM	          =	  $this -> MODEL('log');
		//招聘状态
		$status           =   intval($_GET['status']);
		
		if($status){
      
			$where['id']	=	intval($_GET['id']);
			$where['uid']	=	$this->uid;

			if($status=='2'){
				$data['zp_status']	=	0;
			}else{
				$data['zp_status']	=	1;
			}
      	    $ltjobM ->  upInfo($where,$data);
      		$logM   ->  addMemberLog($this->uid,$this->usertype,'设置猎头职位招聘状态',1,2);
			$this->layer_msg('设置成功！',9,0,$_SERVER['HTTP_REFERER']);
		}
	}
    
    function add_action(){

        $company    =   $this -> comInfo['info'];

        if(!$company['name'] || ! $company['provinceid'] || (!$company['linktel'] && ! $company['linkphone'])){
            $this->ACT_msg('index.php?c=info', '请先完善基本资料！');
        }
        $this->yunset('company', $company);
        // 身份认证信息，强制邮箱、手机、企业资质认证配置--start
        $msg        =   array();

        $isallow_addjob =   '1';

        $url        =   $this->spid ? 'index.php' : 'index.php?c=binding';

        if ($this->config['com_enforce_emailcert'] == '1') {
            if ($company['email_status'] != '1') {

                $isallow_addjob =   '0';
                $msg[]          =   '邮箱认证';
            }
        }
        if ($this->config['com_enforce_mobilecert'] == '1') {
            if ($company['moblie_status'] != '1') {

                $isallow_addjob =   '0';
                $msg[]          =   '手机认证';
            }
        }

        if ($this->config['com_enforce_licensecert'] == '1') {

            $comM   =   $this->MODEL('company');
            $cert   =   $comM -> getCertInfo(array('uid'=>$this->uid,'type'=>3), array('field' => '`uid`,`status`'));

            if ($company['yyzz_status'] != '1' && (empty($cert) || $cert['status'] == 2)) {

                $isallow_addjob =   '0';
                $msg[]          =   '企业资质认证';
            }
        }

        if ($isallow_addjob == '0') {
            if ($this->spid) {

                $this -> ACT_msg($url, '请联系主账号，先完成'.implode('、', $msg).'！');
            }else{

                $this -> ACT_msg($url, '请先完成'.implode('、', $msg).'！');
            }
        }

        if ($this->config['com_enforce_setposition'] == '1') {
            if (empty($company['x']) || empty($company['y'])) {

                $this->ACT_msg('index.php?c=map', '请先完成地图设置！');
            }
        }

        if ($this->config['com_gzgzh'] == '1') {

            $userinfoM	=	$this->MODEL('userinfo');
            $uInfo		=	$userinfoM->getInfo(array('uid' => $this->uid),array('field' => '`wxid`,`unionid`'));
            if (empty($uInfo['wxid']) && empty($uInfo['unionid'])) {

                $this->cookie->SetCookie('gzh','',(strtotime('today') - 86400));
                $this->ACT_msg('index.php', '请先关注公众号！');
            }
        }

		$statisM	=	$this -> MODEL('statis');

		$statics	=	$this->company_satic();
    
		if($statics['addjobnum']==0){//会员过期
		    if($this->spid){
		        
		        $this->ACT_msg('index.php', '当前账号会员已到期，请联系主账号进行升级！', 8);
		    }else{
		        
		        $this->ACT_msg("index.php?c=right","你的会员已到期！",8);
		    }
		}

		if($statics['addjobnum']==2){//套餐会员，发布职位套餐为0 
			if($this->config['integral_job']!='0'){
			    if($this->spid){
			        
			        $this->ACT_msg('index.php', '您的套餐已用完，请联系主账号进行分配！', 8);
			    }else{

			        $this->ACT_msg("index.php?c=right","你的套餐已用完！",8);
			    }
			}else{
				if($this->spid){
			        
			        $statisM->upInfo(array('job_num'=>1),array('uid'=>$this->spid,'usertype'=>$this->usertype));
			    }else{

			        $statisM->upInfo(array('job_num'=>1),array('uid'=>$this->uid,'usertype'=>$this->usertype));
			    }
			}
		}
 
    	$this->yunset($this->MODEL('cache')->GetCache(array('lt','com','ltjob','city','lthy')));
         
		$this->public_action();

		$this->com_tpl('lt_jobadd');
	}

    function edit_action()
    {

        $this->public_action();
        $this->company_satic();

        $this->yunset($this->MODEL('cache')->GetCache(array('lt', 'com', 'ltjob', 'city', 'lthy')));

        $ltJobM =   $this->MODEL('lietoujob');
        $row    =   $ltJobM->getInfo(array('uid' => $this->uid, 'id' => intval($_GET['id'])));

        $this->yunset('row', $row);

        $this->com_tpl('lt_jobadd');
    }
	
	function save_action(){

	 	 $ltjobM         	=   $this -> MODEL('lietoujob');
	  
      	if($_POST['submit']){

			$company    =   $this -> comInfo['info'];
            
            $rstaus     =   $company['r_status'];

			$post	= 	array(
				'job_name'    	=>	$_POST['job_name'],
				
				'jobone'       	=>	$_POST['jobone'],
				'jobtwo'       	=>	$_POST['jobtwo'],
				
				'department'   	=>	$_POST['department'],
				'report'       	=>	$_POST['report'],

				'provinceid'  	=>	$_POST['provinceid'],
				'cityid'       	=>	$_POST['cityid'],
				'three_cityid'	=>	$_POST['three_cityid'],

				'minsalary'  	=>	$_POST['minsalary'],
				'maxsalary'    	=>	$_POST['maxsalary'],

				'constitute'   	=>	@implode(',',$_POST['constitute']),
				'job_desc'    	=>	$_POST['job_desc'],
				'age'         	=>	$_POST['age'],
				'sex'         	=>	$_POST['sex'],
				'exp'         	=>	$_POST['exp'],
				'edu'         	=>	$_POST['edu'],
				'eligible'    	=>	$_POST['eligible'],
				'welfare'      	=>	@implode(',',$_POST['welfare']),
				'language'     	=>	@implode(',',$_POST['language']),
				'rebates'     	=>	$_POST['rebates'],
				'other'      	=>	$_POST['other'],
				'r_status'      =>	$rstaus,
			    'lastupdate'  	=>	time(),
			    'uid'       	=>	$this->uid,
			    'spid'       	=>	$this->spid,
			    'usertype'		=>	$this->usertype,
				'did'			=>	$this->userdid
			);

            $data	=	array(
				'post'	=>	$post,
				'id'	=>	!empty($_POST['id']) ? intval($_POST['id']) : ''
			);

             
			$return	=	$ltjobM->addLtJobInfo($data);

          	if($return['errcode']==9){
          	    
				$this->ACT_layer_msg($return['msg'],$return['errcode'],"index.php?c=lt_job");
			}else{
			    
				$this->ACT_layer_msg($return['msg'],$return['errcode']);
			}
		} 
	}
	function del_action(){

		$ltjobM	=   $this -> MODEL('lietoujob');
		$logM	=	$this -> MODEL('log');
		
		$delID	=	is_array($_POST['checkboxid']) ? $_POST['checkboxid'] : $_GET['id'];
		
		$delRes	=	$ltjobM -> delLietouJob($delID,array('uid'=>$this->uid));
		
		$logM -> addMemberLog($this->uid,$this->usertype,"删除猎头职位",1,3);

		$this -> layer_msg($delRes['msg'], $delRes['errcode'], $delRes['layertype'], $_SERVER['HTTP_REFERER']);

	}

	// 刷新猎头职位方法，套餐处理集合到comtc.model.php类里面
	function refresh_ltjob_action(){

		if($_POST){
			$comtcM	=	$this->MODEL('comtc');
			
			$_POST['spid']		=	$this->spid;
			$_POST['uid']		=	$this->uid;
			$_POST['usertype']	=	$this->usertype;
			
 			$return	=	$comtcM->refresh_ltjob($_POST);
      
 			if($return['status']==1){//猎头职位刷新成功
				
				echo json_encode(array('error'=>1,'msg'=>$return['msg']));

			}else if($return['status']==2){//套餐不足，金额消费
				
			    echo json_encode(array(
			        'error'     =>  2,
			        'pro'       =>  $return['pro'],
			        'online'    =>  $return['online'],
			        'integral'  =>  $return['integral'],
			        'jifen'     =>  $return['jifen'],
			        'price'     =>  $return['price']
			    ));
			}else{
				//猎头职位刷新失败
				echo json_encode(array('error'=>3,'msg'=>$return['msg'],'url'=>$return['url']));
			}
		}else{
			echo json_encode(array('error'=>3,'msg'=>'参数错误，请重试！'));
		}
	} 
}
?>