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
class index_controller extends zphnetv_controller{
    function index_action(){
        
    }
    //同步招聘会信息
    function setZphnetClass_action(){
        $post   =   str_replace('“','"',stripslashes($_POST['postdata']));
        
        $post   =   json_decode($post,true);
        
        $zphnetM=   $this->MODEL('zphnet');

        $error  =   1;

        $zclass =   $post['zclass'];

        if(!empty($zclass)){

            $oldidarr   =   array();
            
            foreach($zclass as $k=>$v){

                if($v['oldid']){//更新

                    $zcone      =   $zphnetM->getClass(array('id'=>$v['oldid']));
                    $oldid  =   $v['oldid'];
                    unset($v['oldid']);
                    unset($v['keyid']);
                    unset($v['id']);

                    if(!empty($zcone)){

                        $return =   $zphnetM->upClass(array('id'=>$oldid),$v);

                        $error  =   1;

                    }else{
                        $error  =   3;
                    }

                }else{//添加
                    $id     =   $v['id'];

                    unset($v['oldid']);
                    unset($v['id']);
                    
                    $return =   $zphnetM->insertClass($v);
                    $oldidarr[$id] = $return;

                }

            }
            $data['oldidarr'] = $oldidarr;

        }else{
            $error  =   4;
        }

        $this->render_json($error,'',$data);
    }
    //同步招聘会信息
    function setZphnet_action(){
        $post   =   str_replace('“','"',stripslashes($_POST['postdata']));
        
        $post   =   json_decode($post,true);
        
        $zphnetM=   $this->MODEL('zphnet');

        $error  =   1;

        $zphnet =   $post['zphnet'];

        if(!empty($zphnet)){

            if($zphnet['zphoid']){//更新

                $zninfo     =   $zphnetM->getInfo(array('id'=>$zphnet['zphoid']));

                if(!empty($zninfo)){

                    $return =   $zphnetM->upInfo(array('id'=>$zphnet['zphoid']),$zphnet);

                    $error  =   $return?1:2;

                }else{
                    $error  =   3;
                }

            }else{//添加

                $return =   $zphnetM->addInfo($zphnet);

                $error  =   $return?1:2;

                $data['zphoid'] = $return;
            }

        }else{
            $error  =   4;
        }

        $this->render_json($error,'',$data);
    }
    //同步招聘会记录，保存与删除
    function setZphnetCom_action(){

        $post   =   str_replace('“','"',stripslashes($_POST['postdata']));
        
        $post   =   json_decode($post,true);
        
        $zphnetM=   $this->MODEL('zphnet');

        $error  =   1;

        $act    =   $post['act'];

        if($act == 'add'){

            $zcarr    =   $post['zcarr'];

            if(!empty($zcarr)){

                $return = $zphnetM->insertZphnetCom($zcarr);

            }

            $error  =   $return?1:2;

        }else if($act == 'del'){

            $uid    =   $post['uid'];
            $zid    =   $post['zid'];

            $zcinfo =   $zphnetM -> getZphnetCom(array('uid'=>$uid,'zid'=>$zid));

            

            if(!empty($zcinfo)){

                $return = $zphnetM -> delZphnetCom($zcinfo['id']);

            }
            
            $error  =   $return['errcode']==9?1:2;
        }
        $this->render_json($error,'',$return);
    }
    //查看是否存在账号
    function hasMem_action(){
        $post               =   str_replace('“','"',stripslashes($_POST['postdata']));
        
        $post               =   json_decode($post,true);
        
        $error              =   1;
        if($post['telphone']){
            $userinfoM      =   $this->MODEL('userinfo');

            $mem            =   $userinfoM->getInfo(array('moblie'=>$post['telphone']));
            if(empty($mem)){

                $error      =   2;
                $msg        =   '用户不存在'; 
            }else{
                
                if($mem['usertype']==1){
                    $data['usertype'] =  $mem['usertype'];
                    $data['uid']      =  $mem['uid'];
                    $resumeM      =   $this->MODEL('resume');

                    $returndata       =  $resumeM->getResumeRaw(array('telphone'=>$post['telphone']),array('all'=>1));
                    $data['resume']   =   $returndata['resume'];

                }else if($mem['usertype']==2){
                    $data['usertype'] =  $mem['usertype'];
                    $data['uid']      =  $mem['uid'];
                    //$zphnetM    =   $this->MODEL('zphnet');
                    //$zcnum      =   $zphnetM->getZphnetComNum(array('uid'=>$mem['uid'],'zid'=>$post['zphid'],'status'=>1));
                    
                    //$company    =   $zphnetM->getSyncCompanyData(array('uid' => array('in', pylode(',', $mem['uid'])), 'r_status' => '1', ));
                    //$data['company']    =   $company[0];
                    //$data['zcnum']      =   $zcnum;
                    
                }else{
                    $error      =   3;
                    $msg        =   '只有个人或企业类型才能注册'; 
                }
            }
            //查询该源站用户简历信息
        }else{

            $error      =   3;
            $msg        =   '手机号不能为空';
        }
        $this->render_json($error,$msg,$data);
    }
    //查看是否存在简历
    function getResumeNum_action()
    {
        $post               =   str_replace('“','"',stripslashes($_POST['postdata']));
        
        $post               =   json_decode($post,true);
        
        $error              =   1;
        $msg                =   'ok';
        if($post['telphone']){
            $resumeM        =   $this->MODEL('resume');

            $resume         =   $resumeM->getResumeInfo(array('telphone'=>$post['telphone']),array('field'=>'uid'));
            $num            =   $resumeM->getExpectNum(array('uid'=>$resume['uid']));
            if($num<=0){

                $error      =   2;
                $msg        =   '简历不存在'; 
            }
            //查询该源站用户简历信息
        }else{

            $error      =   2;
            $msg        =   '手机号不能为空';
        }
        $this->render_json($error,$msg);
    }
    //获取简历
    function getResume_action(){
        $post               =   str_replace('“','"',stripslashes($_POST['postdata']));
        
        $post               =   json_decode($post,true);
        
        $error              =   1;
        $msg                =   'ok';
        if($post['telphone'] || $post['olduid']){
            $resumeM		=   $this->MODEL('resume');
            
            if($post['olduid']){
                $rwhere['uid']      = $post['olduid'];
            }else{
                $rwhere['telphone'] = $post['telphone'];
            }

            $resumedata     =   $resumeM->getResumeRaw($rwhere,array('all'=>1));
            if(!empty($resumedata['resume'])){
				
            	
                if($resumedata['resume']['photo']){
                    $resumedata['resume']['photo']  =  checkpic($resumedata['resume']['photo']);
                }
                
                $data   =   $resumedata;

            }else{

                $error      =   2;
                $msg        =   '抱歉！暂无数据,请重试或创建简历'; 
                $data       =   $post;
            }
            //查询该源站用户简历信息
        }else{

            $error      =   2;
            $msg        =   '手机号不能为空';
            $data       =   $post;
            
        }
        $this->render_json($error,$msg,$data);
    }
    
    //同步平台简历
    function setResume_action(){
        // $postdata   =   file_get_contents("php://input");
        // $post       =   json_decode($postdata,true);
        $post               =   str_replace('“','"',stripslashes($_POST['postdata']));
        
        $post               =   json_decode($post,true);
        
        $error              =   1;
         
        if(!empty($post['resume'])){
            $resumeM        =   $this->MODEL('resume');
            $member         =   $post['member'];
            $resume         =   $post['resume'];
            if(!empty($post['resume_expect'])){
                $resume_expect  =   $post['resume_expect'];
            }
           
            $resume_work    =   $post['resume_work'];
            $resume_edu     =   $post['resume_edu'];

            $cache          =   $this->MODEL('cache')->GetCache(array('user','city','job','hy','introduce'));
            $userdata       =   $cache['userdata'];
            $userclass_name =   $cache['userclass_name'];

            $resume['sex']  =   $resume['sex'] == '男'?1:2;

            
            //处理resume表的类别
            if($resume['edu']){
                
                $resume['edu']      =  $this->getCategoryId($resume['edu'],$userdata['user_edu'],$userclass_name);
            }
            if($resume['exp']){
                
                $resume['exp']      =  $this->getCategoryId($resume['exp'],$userdata['user_word'],$userclass_name);
            }
            if($resume['marriage']){
                
                $resume['marriage'] =  $this->getCategoryId($resume['marriage'],$userdata['user_marriage'],$userclass_name);
            }
            //处理resume_expect表的类别
            if(!empty($resume_expect)){
                $resume_expect['sex']          =   $resume_expect['sex'] == '男'?1:2;

                $resume_expect['exp']          =   $this->getCategoryId($resume_expect['exp'],$userdata['user_word'],$userclass_name);

                $resume_expect['edu']          =   $this->getCategoryId($resume_expect['edu'],$userdata['user_edu'],$userclass_name);

                $resume_expect['hy']           =   $this->getCategoryId($resume_expect['hy'],$cache['industry_index'],$cache['industry_name']);

                $resume_expect['report']       =   $this->getCategoryId($resume_expect['report'],$userdata['user_report'],$userclass_name);

                $resume_expect['type']         =   $this->getCategoryId($resume_expect['type'],$userdata['user_type'],$userclass_name);
                $resume_expect['jobstatus']    =   $this->getCategoryId($resume_expect['jobstatus'],$userdata['user_jobstatus'],$userclass_name);
                //处理职位类别id
                if ($resume_expect['job_classid'] ){
                    
                    $job_classname = @explode(',',$resume_expect['job_classid']);
                    
                    if(is_array($job_classname)){
                        
                        foreach($job_classname as $v){

                            $job_classid[]  =   array_search($v, $cache['job_name']);

                        }
                        $resume_expect['job_classid']  =  @implode(',',$job_classid);
                    }
                }
                //处理城市类别id
                if ($resume_expect['city_classid']){
                    
                    $city_classname = @explode(',',$resume_expect['city_classid']);
                    
                    if(is_array($city_classname)){
                        
                        foreach($city_classname as $v){
                            
                            $city_classid[]  =   array_search($v, $cache['city_name']);
                            
                        }
                        $resume_expect['city_classid']  =  @implode(',',$city_classid);
                    }
                }
            }
            //处理resume_edu表的类别
            if(!empty($resume_edu)){

                foreach($resume_edu as $ek=>$ev){

                    $resume_edu[$ek]['education']    =   $this->getCategoryId($ev['education'],$userdata['user_edu'],$userclass_name);

                }

            }

            $olduid     =   $member['web_uid'];
            
            if(!empty($resume_expect)){
                $oldeid     =   $resume_expect['oldeid'];
            }
            unset($member['web_uid']);
            unset($resume_expect['oldeid']);
            //插入数据 设计积分等数据，具体逻辑有待商榷
            $userinfoM = $this->MODEL('userinfo');

            if($olduid){
                $ismember   =   $userinfoM -> getInfo(array('uid'=>$olduid));
            }
            
			$resume['moblie_status']	=	1;

            if(!$olduid || !$ismember['uid']){
                //插入member生产新uid，插入resume表
                $checkData = array(
                    'username' => $member['username'],
                    'moblie'   => $member['moblie'],
                );
                $memberCheck = $userinfoM->addMemberCheck($checkData);//检测用户名、手机号、邮箱是否已被注册
                
                if ($memberCheck['msg']){
                    $this->render_json(2,$memberCheck['msg']);
                }

                $ip    =  fun_ip_get();
                $time  =  time();
                $salt  =  substr(uniqid(rand()), -6);
                $pass  =  passCheck(rand(100000,999999),$salt);

                $mdata = array(
                    'username'		=>  $member['username'],
                    'password'		=>  $pass,
                    'usertype'		=>  1,
                    'salt'			=>  $salt,
                    'moblie'		=>  $member['moblie'],
                    'moblie_status'	=>	1,
                    'reg_date'		=>  $time,
                    'reg_ip'		=>  $ip,
                    'status'		=>  1,
                    'source'		=>  $member['source'] ? $member['source'] : 17
                );

                $resume['r_status'] = 0;
                
                $newuid  =  $userinfoM -> addInfo(array('mdata'=>$mdata,'udata'=>$resume,'sdata'=>array('integral'=>0)));
            }else{//有member 但可能有或没有resume表
                
                $resumeM -> addInfo(array('uid'=>$olduid,'rData'=>$resume,'utype'=>'admin'));

                $newuid =   $olduid;
            }

            if(!empty($resume_expect)){
                $resume_expect['state'] = 0;
                $resume_expect['uid']   = $newuid;
                
                $resume_expect['source'] = $resume_expect['source'] ? $resume_expect['source'] : 17;
            }
            
            if(!empty($resume_expect)){
                if($oldeid){
                    $user_expect     =   $resumeM -> getExpect(array('id'=>$oldeid));
                }
                
                if(!$user_expect['id']){
                    //插入resume_expect表
                    
                    $return  =  $resumeM -> addInfo(array('uid'=>$newuid,'eData'=>$resume_expect,'utype'=>'admin'));

                    $neweid     =  $return['id'];
                    
                }else{
                    $neweid     =  $oldeid;
                    $resumeM -> upInfo(array('id'=>$neweid), array('eData'=>$resume_expect,'utype'=>'admin'));
                    
                }
            }
            

            $backarr        =   array();
            $backarr['eid'] =   $neweid;
            $backarr['uid'] =   $newuid;
            $newwork		=   array();
            $newedu			=   array();

            if(!empty($resume_work)){

                $realworkid  =   array();
            
				foreach ($resume_work as $wkey => $wvalue) {
                    $workid[]=   $wvalue['oldid'];
                }
                
				if(!empty($workid)){
                    $workarr =   $resumeM -> getResumeWorks(array('id'=>array('in',pylode(',',$workid))),'`id`');
                    if(!empty($workarr)){
                        foreach ($workarr as $wrk => $wrv) {
                            $realworkid[]    =   $wrv['id'];
                        }
                    }
                }

                foreach($resume_work as $rwk=>$rwv){
                    $rwv['uid']     =   $newuid;
                    $rwv['eid']     =   $neweid;
                    $oldid          =   $rwv['oldid'];
                    $id             =   $rwv['id'];
                    unset($rwv['oldid']);
                    unset($rwv['id']);
                    if(in_array($oldid, $realworkid)){
                        $resumeM -> addResumeWork($rwv,array('where'=>array('id'=>$oldid),'utype'=>'admin'));
                    }else{
                        $returnW    =   $resumeM -> addResumeWork($rwv,array('utype'=>'admin'));
                        $newwork[$id]    =   $returnW['id'];
                    }
                }
            }
            $backarr['work'] =   $newwork;
            if(!empty($resume_edu)){

                $realeduid  =   array();
                foreach ($resume_edu as $ekey => $evalue) {
                    $eduid[]=   $evalue['oldid'];
                }
                if(!empty($eduid)){
                    $eduarr =   $resumeM -> getResumeEdus(array('id'=>array('in',pylode(',',$eduid))),'`id`');
                    if(!empty($eduarr)){
                        foreach ($eduarr as $erk => $erv) {
                            $realeduid[]    =   $erv['id'];
                        }
                    }
                }
  
                foreach($resume_edu as $rek=>$rev){
                    $rev['uid']     =   $newuid;
                    $rev['eid']     =   $neweid;
                    $oldid          =   $rev['oldid'];
                    $id             =   $rev['id'];
                    unset($rev['oldid']);
                    unset($rev['id']);
                    if(in_array($oldid, $realeduid)){
                        $resumeM -> addResumeEdu($rev,array('where'=>array('id'=>$oldid),'utype'=>'admin'));
                    }else{
                        $returnE =   $resumeM -> addResumeEdu($rev,array('utype'=>'admin'));
                        $newedu[$id]    =   $returnE['id'];
                    }
                    
                }
            } 
            $backarr['edu'] =   $newedu;
            if($newuid){
                $error      =   1;
                $msg        =   'success';
                $data       =   $backarr;
            }else{
                $error      =   2;
                $msg        =   '同步失败';
            }
        }else{

            $error      =   2;
            $msg        =   '同步数据不存在';
            
        }
        $this->render_json($error,$msg,$data);
    }
    
    //同步平台企业信息
    function setCompany_action(){
    	 
        $post	=	str_replace('“','"',stripslashes($_POST['postdata']));
        
        $post	=   json_decode($post,true);
        $error	=   1;
        
        if(!empty($post['company'])){
        	
            $companyM	=   $this->MODEL('company');
            
         	$company  	=   $post['company'];
			$member   	=   $post['member'];
			
			$oldCom	    =	$companyM -> getInfo($company['web_uid']);
			
			if(!empty($company)){
				
	            $cache          =   $this->MODEL('cache')->GetCache(array('com','city','job','hy'));
	            $comdata       	=   $cache['comdata'];
	            $comclass_name 	=   $cache['comclass_name'];
				
	            $newComData		=	array();
	            
	            $newComData['ptuid']	=  	$company['uid'];
	            
	            $newComData['name']		=  	$company['name'] ? $company['name'] : $oldCom['name'];
	            
	            if ($company['hy']){
	            	
	            	$newComData['hy']	=   $this->getCategoryId($company['hy'], $cache['industry_index'], $cache['industry_name']);
	            }
            
	            if($company['pr']){
	                
	           		$newComData['pr']	=  	$this->getCategoryId($company['pr'], $comdata['job_pr'], $comclass_name);
	            }
	            
         		if($company['mun']){
	                
	           		$newComData['mun']	=  	$this->getCategoryId($company['mun'], $comdata['job_mun'], $comclass_name);
	            }
            
	            if ($company['provinceid']){
	            	
	            	$newComData['provinceid']	=	array_search($company['provinceid'], $cache['city_name']);
	            }
	            
	        	if ($company['cityid']){
	            	
	            	$newComData['cityid']		=	array_search($company['cityid'], $cache['city_name']);
	            }
	            
	        	if ($company['three_cityid']){
	            	
	            	$newComData['three_cityid']	=	array_search($company['three_cityid'], $cache['city_name']);
	            }
	            
	            $newComData['address']	=  	$company['address'] ? $company['address'] : $oldCom['address'];
	            $newComData['x']		=  	$company['x'] ? $company['x'] : $oldCom['x'];
    			$newComData['y']		=  	$company['y'] ? $company['y'] : $oldCom['y'];
    			$newComData['linkman']	=  	$company['linkman'] ? $company['linkman'] : $oldCom['linkman'];
     			$newComData['linkphone']=  	$company['linkphone'] ? $company['linkphone'] : $oldCom['linkphone'];
    			$newComData['linktel']	=  	$company['linktel'] ? $company['linktel'] : $oldCom['linktel'];
    			$newComData['content']	=  	$company['content'] ? $company['content'] : $oldCom['content'];
    			
    			$newComData['shortname']=  	$company['shortname'] ? $company['shortname'] : $oldCom['shortname'];
    			$newComData['linkmail']	=  	$company['linkmail'] ? $company['linkmail'] : $oldCom['linkmail'];
         		$newComData['linkjob']	=  	$company['linkjob'] ? $company['linkjob'] : $oldCom['linkjob'];
    			$newComData['linkqq']	=  	$company['linkqq'] ? $company['linkqq'] : $oldCom['linkqq'];
         		$newComData['website']	=  	$company['website'] ? $company['website'] : $oldCom['website'];
    			
           		$newComData['welfare']	=  	$company['welfare'] ? $company['welfare'] : $oldCom['welfare'];
           		
           		$newComData['sdate']	=  	$company['sdate'] ? $company['sdate'] : $oldCom['sdate'];
           		$newComData['money']	=  	$company['money'] ? $company['money'] : $oldCom['money'];
           		$newComData['moneytype']=  	$company['moneytype'] ? $company['moneytype'] : $oldCom['moneytype'];
           		$newComData['busstops']	=  	$company['busstops'] ? $company['busstops'] : $oldCom['busstops'];
    			
           		$newComData['lastupdate']		=	time();
           		$newComData['moblie_status']	=	1;
    			
           		if (!empty($company['logo'])){
           			
           			$newComData['logo']	=	$this->getWebImage($company['logo'],'company');
           		}
           		
           		$newComData['logostatus']	=	$this->config['com_logo_status'] == '1' ? '1' : '0';
			}
			
        	$olduid     =   $member['web_uid'];
 
            unset($member['web_uid']);
            
            $userinfoM = $this->MODEL('userinfo');

            if($olduid){
            	
            	$oldCom		=	$companyM -> getInfo($olduid);
                $ismember   =   $userinfoM -> getInfo(array('uid'=>$olduid));
            }
            
        	if(empty($oldCom) && empty($ismember)){
        		
                 $checkData = array(
                    'username' => $member['username'],
                    'moblie'   => $member['moblie'],
                );
                $memberCheck = $userinfoM->addMemberCheck($checkData); 
                
                if ($memberCheck['msg']){
                    $this->render_json(2,$memberCheck['msg']);
                }

                $ip    =  fun_ip_get();
                $time  =  time();
                $salt  =  substr(uniqid(rand()), -6);
                $pass  =  passCheck(rand(100000,999999),$salt);

                $mdata = array(
                    'username'		=>  $member['username'],
                    'password'		=>  $pass,
                    'usertype'		=>  2,
                    'salt'			=>  $salt,
                    'moblie'		=>  $member['moblie'],
                    'moblie_status'	=>	1,
                    'reg_date'		=>  $time,
                    'reg_ip'		=>  $ip,
                    'status'		=>  1
                );
                 
                $result	=	$userinfoM -> addInfo(array('mdata'=>$mdata,'udata'=>$newComData,'sdata'=>array('rating'=>$this->config['com_rating'])));
                
                $newuid	=	$result;
            }else if (empty($oldCom)){
            	                
                $result	=	$companyM -> addComData($olduid, array('comData' => $newComData,'sdata' => array('rating'=>$this->config['com_rating'])));

                $newuid =   $olduid;
            }else{
            	
            	$result	=	$companyM -> upInfo($olduid, '', $newComData);
            }
			
        	if($result){
                $error      	=   1;
                $msg        	=   'success';
                $data['uid']	=	$newuid;
            }else{
                $error      =   2;
                $msg        =   '同步失败';
            }
        }else{

            $error      =   2;
            $msg        =   '同步数据不存在';
            
        }
        $this->render_json($error,$msg,$data);
    }
    
    function setCompanyJob_action(){
    	
        $post	=	str_replace(array('“','lastＵpdate'), array('"','lastupdate'), stripslashes($_POST['postdata']));
        
        $post	=   json_decode($post,true);
        
        $error	=   1;
        
        if(!empty($post['job'])){
        	
            $companyM    	=   $this->MODEL('company');
         	$job     		=   $post['job'];
			
         	$oldCom			=	$companyM -> getInfo($job['web_uid']);
         	
         	if (!empty($oldCom)){
				
				$jobM    		=   $this->MODEL('job');
				$cache          =   $this->MODEL('cache')->GetCache(array('com','city','job','hy'));
	            $comdata       	=   $cache['comdata'];
	            $comclass_name 	=   $cache['comclass_name'];
				
				$newJobData		=	array();
				 
				$newJobData['status']			=   0;
				
				$newJobData['state']			=   $job['state'];
				
				$newJobData['hy']				=   $this->getCategoryId($job['hy'], $cache['industry_index'], $cache['industry_name']);				
				$newJobData['job1']				=   $this->getCategoryId($job['job1'],$cache['job_type'],$cache['job_name']);
				
				$newJobData['job1_son']			=   $this->getCategoryId($job['job1_son'],$cache['job_type'],$cache['job_name']);
				
				if($job['job_post']){
					
					$newJobData['job1_son']		=   $this->getCategoryId($job['job_post'],$cache['job_type'],$cache['job_name']);
				}
				
				if($job['lang']){
					$lang        =   @explode(',', $job['lang']);
					foreach ($lang as $k=>$v){
						if (empty($v) || $v =='undefined'){
							unset($lang[$k]);
						}
						$langid[]				=	$this->getCategoryId($v,$cache['comdata']['job_lang'],$cache['comclass_name']);
					}
					
					$newJobData['lang']			=	pylode(',',$langid);
					
				}else{
					
					$newJobData['lang']			=	'';
					
				}
				
	            $newJobData['provinceid']		=	$this->getCategoryId($job['provinceid'],$cache['city_type'],$cache['city_name']);
				
				$newJobData['cityid']			=	$this->getCategoryId($job['cityid'],$cache['city_type'],$cache['city_name']);
				
				$newJobData['three_cityid']		=	$this->getCategoryId($job['three_cityid'],$cache['city_type'],$cache['city_name']);
				
				$newJobData['exp']				=	$this->getCategoryId($job['exp'],$cache['comdata']['job_exp'],$cache['comclass_name']);
				
				$newJobData['edu']				=	$this->getCategoryId($job['edu'],$cache['comdata']['job_edu'],$cache['comclass_name']);
				
				$newJobData['number']			=	$this->getCategoryId($job['number'],$cache['comdata']['job_number'],$cache['comclass_name']);
				
				$newJobData['report']			=	$this->getCategoryId($job['report'],$cache['comdata']['job_report'],$cache['comclass_name']);
				
				$newJobData['age']				=	$this->getCategoryId($job['age'],$cache['comdata']['job_age'],$cache['comclass_name']);
				
				$newJobData['sex']				=	$this->getCategoryId($job['sex'],$cache['com_sex'],$cache['com_sex']);
				
				$newJobData['minsalary']		=	$job['minsalary'];
				
				$newJobData['maxsalary']		=	$job['maxsalary'];
				
				$newJobData['description']		=	$job['description'];
				
				$newJobData['is_graduate']		=	$job['is_graduate'];
				
				$newJobData['marriage']			=	$this->getCategoryId($job['marriage'],$cache['comdata']['job_marriage'],$cache['comclass_name']);	
				
 				$newJobData['welfare']			=	$job['welfare'];
				  
				$newJobData['name']				=  	$job['name'];
				
				$newJobData['lastupdate']		=  	time();
			 
				if($job['web_jobid']){
				
					$oldJob		=	$jobM -> getInfo(array('id'=>$job['web_jobid'],'uid'=>$job['web_uid']));
					
					if(!empty($oldJob)){
						
						$result	=	$jobM -> upInfo($newJobData, array('id'=>$job['web_jobid'],'uid'=>$job['web_uid']));
						
						$data['eid']	=	  $job['web_jobid'];
					}else{
						
						$error	=	2;
						$msg	=	'职位数据不存在';
					}
					
				}else{
					
					$newJobData['r_status']		=  $oldCom['r_status'];
					
					$newJobData['uid']		=  $job['web_uid'];
					
					$result	=	$jobM -> addInfo($newJobData);
					  
					$data['eid']	=	  $result;
				}
				
				if($result){
					$error      =   1;
					$msg        =   'success';
				}else{
					$error      =   2;
					$msg        =   '同步失败';
				}
				 
         	}else{
         		
         		$error	=	2;
         		$msg	=	'企业数据不存在';
         	}
        }else{

            $error      =   2;
            $msg        =   '同步数据不存在';
            
        }

        $this->render_json($error,$msg,$data);
    }
    
    public function getCategoryId($data,$cacheidArr,$cacheName){

        $values  =   array_keys($cacheName,$data);
        if(count($values)>1){
            foreach($values as $k=>$v){
                if(in_array($v,$cacheidArr)){
                    $va    =   $values[$k];
                    break;
                }
            }
        }else{
            $va    =   $values[0];
        }

        $id  =  $va ? $va : 0;

        return $id;
    }
    
    
	//缓存提供接口
	public function zphnetCache_action(){
		
		//行业缓存
		$cache['industry']	=	$this -> obj -> select_all("industry",array('orderby'=>'sort,desc'));
		//职位缓存
		$cache['jobclass']	=	$this -> obj -> select_all("job_class",array('orderby'=>'sort,asc'),"`id`,`keyid`,`name`");
		//城市缓存
		$cache['cityclass']	=	$this -> obj -> select_all("city_class",array('orderby'=>'sort,asc'),"`id`,`keyid`,`name`");
		//企业分类缓存
		$cache['comclass']	=	$this -> obj -> select_all("comclass",array('orderby'=>'sort,asc'),"`id`,`keyid`,`name`,`variable`");
		//个人分类缓存
		$cache['userclass']	=	$this -> obj -> select_all("userclass",array('orderby'=>'sort,asc'),"`id`,`keyid`,`name`,`variable`");

		echo json_encode($cache);
	}
	
	/**
	 * 远程拉取图片
	 * @param string $url
	 * @param string $path
	 */
	function getWebImage($url = '',$path = ''){
	    
	    if (!empty($url) && !empty($path)){
			$ch = curl_init();
			$timeout = 10;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:36.0) Gecko/20100101 Firefox/36.0');
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$CurlReturn = curl_exec($ch);
			//if (curl_errno($ch)) {echo 'Errno'.curl_error($ch);}
			curl_close($ch);
	        // 重新定义文件名称 图片一律用 jpeg
	        $filename  =  time().rand(1000,9999).'.jpeg';
	        //自定义目录名称
	        $dirName = APP_PATH . 'data/upload/'.$path.'/' . date('Ymd');
			//定义新名称以及目录
	        if (!file_exists($dirName)){
	            mkdir($dirName, 0777, true);
	        }
	        $res = fopen($dirName . '/' . $filename, 'a');
	        fwrite($res, $CurlReturn);
	        fclose($res);
			//对原图进行强制压缩 防止非法图片上传
			include_once(LIB_PATH.'upload.class.php');
			$upload	=	new Upload();
			$pic	=	$upload -> makeThumb($dirName . '/' . $filename,300,300,'',true);
			$picUrl =	str_replace(APP_PATH.'data', './data', $pic);
			return $picUrl;
	    }
	}
	/**
	 * 都需获取微信登录配置
	 */
	function xjhGetWx_action(){
	    
	    include(PLUS_PATH.'configcache.php');
	    // 公众号分享佣ticket
	    $Ticket     = $configcache['ticket'];
	    $TicketTime = $configcache['ticket_time'];
	    $NowTime = time();
	    if(($NowTime-$TicketTime)>7000 || !$Ticket){
	        $Url          = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.getToken().'&type=jsapi';
	        $CurlReturn   = CurlPost($Url);
	        $Ticket       = json_decode($CurlReturn);
	        $configcache['ticket']      = $Ticket->ticket;
	        $configcache['ticket_time'] = $NowTime;
	        if($configcache['ticket']){
	            made_web(PLUS_PATH."configcache.php",ArrayToString($configcache),"configcache");
	        }
	    }
	    
	    $wx  =  array(
	        'appid'        =>  $config['wx_appid'],
	        'appsecret'    =>  $config['wx_appsecret'],
	        'ticket'       =>  $config['ticket'],
	        'ticket_time'  =>  $config['ticket_time']
	    );
	    
	    $this->render_json(0,'ok',$wx);
	}
	/**
	 * 发送宣讲会公众号通知
	 */
	function xjhSendWx_action(){
	    
	    $data     =  json_decode(str_replace('“','"',json_decode(json_encode(stripslashes($_POST['data'])), true)), true);
	    $weixinM  =  $this->MODEL('weixin');
	    
	    if (!empty($data)){
	        
	        foreach ($data as $v){
	            
	            $weixinM->sendWxXjhLive($v);
	        }
	    }
	}
	/**
	 * 同步个人参会记录
	 */
	function setZphnetUser_action(){
	    
	    $post	=	str_replace(array('“'), array('"'), stripslashes($_POST['postdata']));
	    
	    $post	=   json_decode($post,true);
	    
	    $error	=   1;
	    
	    if(!empty($post)){
	        
	        $zphnetM  =  $this->MODEL('zphnet');
	        
	        $zphnetM->setZphnetUser($post);
	    }else{
	        
	        $error      =   2;
	        $msg        =   '同步数据不存在';
	    }
	    $this->render_json($error,$msg);
	}
}
?>