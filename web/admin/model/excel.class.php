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
class excel_controller extends adminCommon
{

	function index_action()
	{
		$this->yuntpl(array('admin/admin_excel'));
	}

	function resume_action()
	{
		set_time_limit(0);

		include LIB_PATH."reader.php";
	
		$data	=	new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('utf-8');

		if($_FILES['excel']['name']!=""){
	
			$time	=	time();
			$excel	=	$time.".xls";
			move_uploaded_file($_FILES['excel']['tmp_name'],DATA_PATH."upload/excel/".$excel);
		}else{
		
			$this->ACT_layer_msg("无文件上传！",8,$_SERVER['HTTP_REFERER'],2,1);
		}
	
		$data->read(DATA_PATH.'upload/excel/'.$excel);
	
		if($data->sheets[0]['numRows']<1){

			$this->ACT_layer_msg("数据读取失败，请检查excel格式！",8,$_SERVER['HTTP_REFERER'],2,1);
		}
	
		$user		=	array(); 
		$cells		=	count($data->sheets[0]['cells']);
		$cellsnum	=	count($data->sheets[0]['cells'][1]); 

		for ($i = 2; $i <= $cells; $i++){

			$user[$i]['username'] 	= trim($data->sheets[0]['cells'][$i][1]);
			$user[$i]['name'] 		= trim($data->sheets[0]['cells'][$i][2]); 

			if($user[$i]['name']){ 

				for($j=3;$j<=$cellsnum;$j++){

					$value	=	trim($data->sheets[0]['cells'][$i][$j]);

					switch($data->sheets[0]['cells'][1][$j]){ 
						case	'性别':
							$user[$i]['sex_n']			=	$value;break;
						case	'年龄':
							$user[$i]['age_n']			=	$value;break;
						case	'婚姻':
							$user[$i]['marriage_n']		=	$value;break;
						case	'籍贯':
							$user[$i]['jiguan_n']		=	$value;break;
						case	'联系电话':
							$user[$i]['telphone']		=	$value;break;
						case	'固定电话':
							$user[$i]['homephone']		=	$value;break;
						case	'邮箱':
							$user[$i]['email']			=	$value;break;
						case	'学历':
							$user[$i]['edu_n']			=	$value;break;
						case	'经验':
							$user[$i]['exp_n']			=	$value;break;
						case	'现居住地':
							$user[$i]['xcity']			=	$value;break;
						case	'详细地址':
							$user[$i]['address']		=	$value;break;
						case	'期望工作地址':
							$user[$i]['jobaddress']		=	$value;break;
						case	'期望工作岗位':
							$user[$i]['job']			=	$value;break;
						case	'期望薪资':
							$user[$i]['salary_n']		=	$value;break;
						case	'教育经历':
							$user[$i]['eduexcel']		=	$value;break;
						case	'工作经历':
							$user[$i]['work_n']			=	$value;break;
						case	'专业擅长':
							$user[$i]['other_n']		=	$value;break;
						case	'个人介绍':
							$user[$i]['description']	=	$value;break;
					}  
				} 
			}			
		}

		if(is_array($user)){

		    $resumeM	=	$this->MODEL('resume');

		    $numres		=	0;	
			$numuser	=	0;
			$numwork	=	0;
			$numedu		=	0;
			$losnum		=	0;

		    include PLUS_PATH."user.cache.php";

		    foreach($user as $key=>$value){

		        if($value['name']!=""){

		            $salt      =  substr(uniqid(rand()), -6);
		            $password  =  $this->randomPass();
		            $npass     =  passCheck($password,$salt);

		            $time      =  time();
		            if(!$value['username']){
						$value['username']	=	'py'.date('mdHis').rand(100,999);
					}
		            $mvalue = array(
		                'username'	=>	$value[username],
		                'password'	=>	$npass,
		                'email'		=>	$value[email],
		                'usertype'	=>	'1',
		                'address'	=>	$value[address],
		                'status'	=>	'1',
		                'salt'		=>	$salt,
		                'moblie'	=>	$value[telphone],
		                'reg_date'	=>	$time,
		                'passtext'	=>	$password,
		                'source'	=>	'7'
		            );
		            $uvalue=array(
		                'email'		=>	$value[email],
		                'telphone'	=>	$value[telphone],
		                'r_status'	=>	$this->config['user_state']
		            );

					$uid	=	$this -> addUser($mvalue, $uvalue);

		            if($uid && is_numeric($uid) && $uid > 0){
		                $jobname	=	$value['job'];
		                if(!is_array($uid) && $uid>0){
		                    $numuser++;
		                    $sqlval['uid']	=	$uid;
		                    $sqlval['name']	=	$jobname;
		                    $job_row=$this->get_user_job($jobname, 60);
	                        $sqlval['job_classid']=pylode(',',$job_row);
	                        
		                    $pcity	=	$value['jiguan_n'];
		                    $xcity	=	$value['xcity'];
		                    
		                    if($value['jobaddress']){
		                        $city_row  =  $this->get_city($value['jobaddress'], 60);
		                        
		                        $sqlval['provinceid']	=  $city_row[0];
		                        $sqlval['cityid']		=  $city_row[1];
		                        $sqlval['three_cityid']	=  $city_row[2];
		                        
		                        if ($city_row[2]){
		                            $city_classid	=	$city_row[2];
		                        }elseif ($city_row[1]){
		                            $city_classid	=	$city_row[1];
		                        }elseif($city_row[0]){
		                            $city_classid	=	$city_row[0];
		                        }
		                        if ($city_classid){
		                            $sqlval['city_classid']	=	$city_classid;
		                        }
		                    }
		                    
		                }
		                $sqlval['lastupdate']	=	time();
		                $salaryN                =   @explode('-',trim($value['salary_n']));
		                $sqlval['minsalary']	=	$salaryN[0];
		                $sqlval['maxsalary']	=	$salaryN[1];
		                $sqlval['type']			=	$userdata['user_type'][0];
		                $sqlval['report']		=	$userdata['user_report'][0];
		                $sqlval['source']		=	'7';
		                $sqlval['jobstatus']	=	$userdata['user_jobstatus'][0];
		                $sqlval['r_status']		=	$this->config['user_state'];
		                $sqlval['state']		=	$this->config['user_state']==1?$this->config['resume_status']:0;
		                $resume   = $resumeM -> addInfo(array('uid'=>$uid,'eData'=>$sqlval));
		                $resumeid = $resume['id'];
		                $numres++;
		                if($resumeid){
		                    $ressql['def_job']	=	$resumeid;
		                    $ressql['name']		=	$value['name'];
		                    $resume_expect_data['uname']= $value['name'];
		                    if($value['sex_n']=="女"){
		                        $ressql['sex']					=	'2';
		                        $resume_expect_data['sex']		=	'2';
		                    }else{
		                        $ressql['sex']					=	'1';
		                        $resume_expect_data['sex']		=	'1';
		                    }

		                    $logo = $resumeM->deflogo($ressql);
		                    
		                    if($logo){
		                    	$ressql['photo'] 			= $logo;
				    			$ressql['defphoto'] 		= 2;
				    			$ressql['photo_status'] 	= 1;
		                    }
				    		

		                    if((int)$value['age_n']>0){
		                        $birthday = date("Y")-$value['age_n']."-".date("m-d");
		                        $ressql['birthday']				=	$birthday;
		                        $resume_expect_data['birthday']	=	$birthday;
		                    }
		                    
		                    if($value['marriage_n']!=""){
		                        
		                        $ressql['marriage']  =  $this->locoytostr($this->get_user_type('marriage'),$value['marriage_n']);
		                    }
		                    $ressql['telphone']					=	$value['telphone'];
		                    $ressql['telhome']					=	$value['homephone'];
		                    $ressql['living']					=	$xcity;
		                    $ressql['domicile']					=	$pcity;
		                    $ressql['email']					=	$value['email'];
		                    if($value['edu_n']!=""){
		                        $edu  =  $this->locoytostr($this->get_user_type('edu'),$value['edu_n']);
		                        
		                        $ressql['edu']					=	$edu;
		                        $resume_expect_data['edu']		=	$edu;
		                    }
		                    if($value['exp_n']!=""){
		                        $exp  =  $this->locoytostr($this->get_user_type('word'),$value['exp_n']);
		                        $ressql['exp']					=	$exp;
		                        $resume_expect_data['exp']		=	$exp;
		                    }
		                    $ressql['address']					=	$value['address'];
		                    $ressql['description']				=	$value['description'];
		                    $resume_expect_data['defaults']		=	'1';
		                    $resume_expect_data['ctime']		=	time();
		                    $resumeM -> upResumeInfo(array('uid'=>$uid),array('rData'=>$ressql));
		                    
		                    $resumeM -> upInfo(array('uid'=>$uid),array('eData'=>$resume_expect_data));
		                    
		                    $whour		=	0;
		                    if($resumeid  && $value['work_n']!=""){
		                        
		                        $work_arr = @explode("【#】",$value['work_n']);
		                        
		                        if(is_array($work_arr)){
		                            foreach($work_arr as $k=>$v){
		                                $sonv = @explode("||",$v);
		                                for ($i = 0; $i < count($sonv); $i ++) {
		                                    
		                                    $workson_arra = @explode("-", $sonv[$i]);
		                                    $sdate = $this->uparr($workson_arra[0]);
		                                    $workson = @explode("***", $workson_arra[1]);
		                                    $edate = $this->uparr($workson[0]);
		                                    $name = $workson[1];
		                                    $content = $workson[2];
		                                    $title = $workson[3];
		                                    if ($edate) {
		                                        $workTime = ceil(($edate - $sdate) / (30 * 86400));
		                                    } else {
		                                        $workTime = ceil((time() - $sdate) / (30 * 86400));
		                                    }
		                                    
		                                    $whour += $workTime;
		                                    
		                                    if ($sdate != "" || $edate != "" || $content != "") {
		                                        
		                                        $resumeM -> addResumeWork(array('uid'=>$uid,'eid'=>$resumeid,'sdate'=>$sdate,'edate'=>$edate,'name'=>$name,'title'=>$title,'content'=>$content));
		                                        $numwork ++;
		                                    }
		                                }
		                                
		                            }
		                            
		                            $avghour = ceil($whour/$numwork);
		                            $resume_time['whour']	 =	$whour;
		                            $resume_time['avghour']  =	$avghour;
		                        }
		                        $resumeM -> upInfo(array('uid'=>$uid),array('eData'=>$resume_time));
		                    }
		                    if ($resumeid && $value['eduexcel'] != "") {
		                        $edu_arr = @explode("【#】", $value['eduexcel']);
		                        
		                        if (is_array($edu_arr)) {
		                            foreach ($edu_arr as $k => $v) {
		                                $sonv = @explode("||", $v);
		                                for ($i = 0; $i < count($sonv); $i ++) {
		                                    $eduson_arra = @explode("-", $sonv[$i]);
		                                    
		                                    $sdate = $this->uparr($eduson_arra[0]);
		                                    $eduson = @explode("***", $eduson_arra[1]);
		                                    $edate = $this->uparr($eduson[0]);
		                                    $name = $eduson[1];
		                                    $specialty = $eduson[2];
		                                    if ($eduson[3]) {
		                                        $education  =  $this->locoytostr($this->get_user_type('edu'), $eduson[3]);
		                                    } else {
		                                        $education = '';
		                                    }
		                                    if ($eduson[1] != "" || $eduson[2] != "") {
		                                        $resumeM -> addResumeEdu(array('uid'=>$uid,'eid'=>$resumeid,'sdate'=>$sdate,'edate'=>$edate,'name'=>$name,'specialty'=>$specialty,'education'=>$education));
		                                        $numedu ++;
		                                    }
		                                }
		                            }
		                        }
		                    }
		                    if($resumeid  && $value['other_n']!=""){
		                        $other_arr = @explode("【#】",$value['other_n']);
		                        if(is_array($other_arr)){
		                            foreach($other_arr as $k=>$v){
		                                $sonv = @explode("|",$v);
		                                if($sonv[0]!="" || $sonv[1]!=""){
		                                    $resumeM -> addResumeOther(array('uid'=>$uid,'eid'=>$resumeid,'name'=>$sonv[0],'content'=>$sonv[1]));
		                                }
		                            }
		                        }
		                    }
		                }
		                $where_data   =   array(
		                    
		                    'uid' =>  $uid,
		                    'eid' =>  $resumeid
		                );
		                
		                $user_data    =   array(
		                    
		                    'work'    =>  $numwork,
		                    'edu'     =>  $numedu
		                );
		                
		                $resumeM -> upUserResume($user_data,$where_data);
		            }else{

                        $losnum++;
                    }
		        }
		    }
		    $msg = "本次新增个人会员：".$numuser."人，新增简历：".$numres."份;新增工作经历:".$numwork."份;新增教育经历:".$numedu."份,新增简历失败:".$losnum."份.";
		    $this->ACT_layer_msg($msg,9,$_SERVER['HTTP_REFERER'],2,1);
		}else{
		    $this->ACT_layer_msg("没有找到合适的数据，请查看格式是否规范！",8,$_SERVER['HTTP_REFERER'],2,1);
		}
    }

    function comexcel_action()
    {
        include LIB_PATH."/reader.php";
        $data	=	new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('utf-8');
        
        if ($_FILES[excel][name] != "") {

            $time	=	time();
            $excel	=	$time.".xls";
            move_uploaded_file($_FILES[excel][tmp_name], DATA_PATH."upload/excel/".$excel);
        }
        
        $data -> read(DATA_PATH."upload/excel/".$excel);

        $user	=	array();

        if ($data->sheets[0]['numRows'] < 1) 
		{
            $this->ACT_layer_msg("数据读取失败，请检查excel格式！", 8, $_SERVER['HTTP_REFERER'], 2, 1);
        }

        $cells    =	count($data->sheets[0]['cells']);
        $cellsnum = count($data->sheets[0]['cells'][1]);

        for ($i = 2; $i <= $cells; $i ++) {

            $user[$i]['comname']	=	trim($data->sheets[0]['cells'][$i][1]);

            for ($j = 2; $j <= $cellsnum; $j ++) {

                $value = $data->sheets[0]['cells'][$i][$j];

                switch ($data->sheets[0]['cells'][1][$j]) {
                    case '联系人':
                        $user[$i]['linkman'] = $value;
                        break;
                    case '联系人职位':
                        $user[$i]['linkjob'] = $value;
                        break;
                    case '联系电话':
                        $user[$i]['linktel'] = $value;
                        break;
                    case '籍贯':
                        $user[$i]['jiguan_n'] = $value;
                        break;
                    case '联系电话':
                        $user[$i]['telphone'] = $value;
                        break;
                    case '固定电话':
                        $user[$i]['linkphone'] = $value;
                        break;
                    case '联系QQ':
                        $user[$i]['linkqq'] = $value;
                        break;
                    case '联系地址':
                        $user[$i]['address'] = $value;
                        break;
                    case '联系邮箱':
                        $user[$i]['email'] = $value;
                        break;
                    case '企业行业':
                        $user[$i]['hy'] = $value;
                        break;
                    case '企业规模':
                        $user[$i]['mun'] = $value;
                        break;
                    case '企业简介':
                        $user[$i]['content'] = $value;
                        break;
                    case '招聘职位':
                        $user[$i]['name'] = $value;
                        break;
                    case '招聘岗位':
                        $user[$i]['jobclass'] = $value;
                        break;
                    case '招聘人数':
                        $user[$i]['num'] = $value;
                        break;
                    case '岗位要求':
                        $user[$i]['description'] = $value;
                        break;
                    case '薪资待遇':
                        $user[$i]['salary'] = $value;
                        break;
                    case '工作经验':
                        $user[$i]['exp'] = $value;
                        break;
                    case '学历要求':
                        $user[$i]['edu'] = $value;
                        break;
                    case '工作地点':
                        $user[$i]['city'] = $value;
                        break;
                }
            }
        }
        
        if (is_array($user)) {
            $numjob  = 0;
            $numuser = 0;
            $los     = 0;
            
            include PLUS_PATH . "job.cache.php";
            include PLUS_PATH . "industry.cache.php";
            include PLUS_PATH . "com.cache.php";
            
            foreach ($user as $key => $value) {
                
                $salt     =	substr(uniqid(rand()), - 6);
                $password =	$this->randomPass();
                $npass    =	passCheck($password, $salt);
                $time     =	time();

                if ($value[comname] != "") {

                    $comname	=	$value[comname];

                    $mvalue	=	array(

                        'username' =>	'py'.date('mdHis').rand(100,999),
                        'password' =>	$npass,
                        'email'    =>	$value[email],
                        'usertype' =>	'2',
                        'address'  =>	$value[address],
                        'status'   =>	'1',
                        'salt'     =>	$salt,
                        'moblie'   =>	$value[telphone] ? $value[telphone] : $value[linktel],
                        'reg_date' =>	$time,
                        'passtext' =>	$password,
                        'source'   =>	'7'
                    );
                     
					$result =	$this->addUser($mvalue, array('name' => $comname));

                    $uid    =   $result['uid'];
                    $noAdd  =   $result['noAdd'];

                    if ($uid && is_numeric($uid) && $noAdd == 1) {

                        $numuser ++;
                        $comval['name']      = $value[comname];
                        $comval['r_status']  = '1';
                        $comval['linkman']   = $value[linkman];
                        $comval['linkjob']   = $value[linkjob];
                        $comval['linktel']   = $value[telphone] ? $value[telphone] : $value[linktel];
                        $comval['linkphone'] = $value[linkphone];
                        $comval['linkqq']    = $value[linkqq];
                        $comval['address']   = $value[address];
                        $comval['linkmail']  = $value[email];
                        $comval['content']   = $value[content];
                        if (is_array($industry_name) && $value['hy'] != "") {
                            
                            $comval['hy'] = $this->locoytostr($industry_name, $value['hy']);
                        }
                        
                        if ($value['mun']) {
                            
                            $munval = $this->locoytostr($this->get_com_type('mun'), $value['mun']);
                            
                            $comval['mun'] = $munval;
                            $mun = $munval;
                        }
                        if (!empty($value['city'])) {
                            $city_row = $this->get_city($value['city']);
                            
                            $comval['provinceid']   = $city_row[0];
                            $comval['cityid']       = $city_row[1];
                            $comval['three_cityid'] = $city_row[2];
                        }
                        $this->MODEL('company')->upInfo($uid, '', $comval);
                    }
                }
                
                if ($uid && is_numeric($uid)) {
                    $stime = time();
                    $etime = $stime + 3600 * 24 * 30;
                    if ($value['jobclass'] != "") {
                        
                        $jobval['uid']         = $uid;
                        $jobval['hy']          = $comval['hy'];
                        $jobval['description'] = $value['description'];
                        $jobval['name']        = $value['name'];
                        $jobval['state']       = 1;
                        $jobval['sdate']       = $stime;
                        $jobval['edate']       = $etime;
                        $jobval['lastupdate']  = $stime;
                        
                        $job_row = $this->get_job_class($value['jobclass'], 60);
                        if ($job_row) {
                            $i = 1;
                            foreach ($job_row as $v) {
                                if ($i == 1) {
                                    $jobval['job1'] = $v;
                                }
                                if ($i == 2) {
                                    $jobval['job1_son'] = $v;
                                }
                                if ($i == 3) {
                                    $jobval['job_post'] = $v;
                                }
                                $i ++;
                            }
                        }
                        if ($value['num']) {
                            $num = $this->locoytostr($this->get_com_type('number'), $value['num']);
                            $jobval['number'] = $num;
                        }
                        if ($value[sex] == "女") {
                            $jobval['sex'] = '2';
                        } elseif ($value[sex] == "男") {
                            $jobval['sex'] = '1';
                        } else {
                            $jobval['sex'] = '3';
                        }
                        
                        if ($value['exp'] != "") {
                            $jobval['exp'] = $this->locoytostr($this->get_com_type('exp'), $value['exp']);
                        }
                        if ($value['edu'] != "") {
                            $jobval['edu'] = $this->locoytostr($this->get_com_type('edu'), $value['edu']);
                        }
                        if ($value['city']) {
                            $city_row = $this->get_city($value['city']);
                            
                            $jobval['provinceid'] = $city_row[0];
                            $jobval['cityid'] = $city_row[1];
                            $jobval['three_cityid'] = $city_row[2];
                        }
                        
                        $salaryN = explode('-', $value['salary']);
                        $jobval['minsalary'] = $salaryN[0];
                        $jobval['maxsalary'] = $salaryN[1];
                        $jobval['com_name']  = $comname;
                        $jobval['mun']       = $mun;
                        $jobval['source']    = '7';
                        $jobval['r_status']  = '1';
                        $numjob ++;
                        
                        $this->MODEL('job')->addInfo($jobval);
                    }
                }
            }
            $msg = "本次新增企业会员：" . $numuser . "人，新增职位：" . $numjob . "个";
            $this->ACT_layer_msg($msg, 9, $_SERVER['HTTP_REFERER'], 2, 1);
        } else {
            $this->ACT_layer_msg("未读取到合适的数据，请检查格式是否规范！", 8, $_SERVER['HTTP_REFERER'], 2, 1);
        }
    }

    function addUser($mdata = array(), $udata = array())
    {

        if ($mdata['usertype'] == 1) {

            $uid        =   '';
            $exist      =   $this->obj->select_once('member', array('moblie' => $mdata['moblie']));

            if (!$exist) {

                $uid    =   $this->obj->insert_into('member', $mdata);

                if ($uid) {

                    $udata['uid']       =   $uid;
                    $this->obj->insert_into('resume', $udata);

                    $sdata['uid']       =   $uid;
                    $sdata['integral']  =   $this->config['integral_reg'];
                    $this->obj->insert_into('member_statis', $sdata);
                }
            }

            return $uid;
        } else if ($mdata['usertype'] == 2) {

            $uid        =   '';
            $noAdd      =   1;
            $isExist    =   $this->obj->select_once('company', array('name' => $udata['name']));
            if (!$isExist) {

                $exist  =   $this->obj->select_once('member', array('moblie' => $mdata['moblie']));

                if (!$exist) {

                    $uid    =   $this->obj->insert_into('member', $mdata);

                    if ($uid) {
                        $udata['uid']   =   $uid;
                        $this->obj->insert_into('company', $udata);
                        $this->addStatis($uid);
                    }
                }
            } else {

                $uid    =   $isExist['uid'];
                $noAdd  =   2;
            }

            return array('uid' => $uid, 'noAdd' =>  $noAdd);
        }
    }
	
	// 添加企业套餐信息
	function addStatis($uid = null) {
	    
	    $id			=   $this->config['com_rating'];
	    $integral	=   0;

	    $ratingM	=	$this->MODEL('rating');
        
	    // 获取会员等级数据
	    $rInfo		=	$ratingM -> getInfo(array('id' => $id));
	    
        $value		=	array(            
            'uid'           => $uid,
            'rating'        => $id,
            'rating_name'   => $rInfo['name'],
            'rating_type'   => $rInfo['type']
        );
	    if($rInfo['type']  ==  1){
	        
	        $value      =   array_merge($value, array(
                
                'job_num'           =>  $rInfo['job_num'],
                'down_resume'       =>  $rInfo['resume'],
				'invite_resume'     =>  $rInfo['interview'],
				'breakjob_num'      =>  $rInfo['breakjob_num'],
                'zph_num'           =>  $rInfo['zph_num']
            ));
	    } 
	    
	    if($rInfo['service_time']){

	        $time	=   time() + 86400 * $rInfo['service_time'];
	        $value['vip_etime']	.=  $time;
	    }else{
	        $value['vip_etime']	.=  0;
	    }
	    
	    $value['integral']		.=	$rInfo['integral_buy'] + $integral;
        $value['vip_stime']		.=	time();
        $value['vip_etime']		.=	$rInfo['service_time'] ? strtotime('+'+$rInfo['service_time']+' day') : 0;
        
        $comSdata   =   array(
            'rating'        =>  $id,
            'rating_name'   =>  $rInfo['name'],
            'vipstime'      =>  time(),
            'vipetime'      =>  $rInfo['service_time'] ? strtotime('+'+$rInfo['service_time']+' day') : 0
        );

        $this->MODEL('company')->upInfo($uid, '', $comSdata);
        
        /* 待整理归类 */
        if($rInfo['coupon'] > 0){
            
            $couponM	=	$this->MODEL('coupon');
            $coupon		=	$couponM -> getInfo(array('id' => intval($rInfo['coupon'])));
            $val		=	array(
                
                'uid'           =>  $uid,
                'number'        =>  time(),
                'ctime'         =>  time(),
                'coupon_id'     =>  intval($coupon['id']),
                'coupon_name'   =>  trim($coupon['name']),
                'validity'      =>  time() + $coupon['time'] * 86400,
                'coupon_amount' =>  $coupon['amount'],
                'coupon_scope'  =>  $coupon['scope']
                
            );
             
	        $this -> obj -> insert_into('coupon_list',$val);
	    }
	    
        $this -> obj -> insert_into('company_statis',$value);
	    
	}
		
	function uparr($arr){
		$arr	=	str_replace("年","-",$arr);
		$arr	=	str_replace("月","-",$arr);
		$arr	=	str_replace("日","-",$arr);
		$arr	=	str_replace(".","-",$arr);
		$arr	=	str_replace("/","-",$arr);

		$narr	=	@explode("-",$arr);

		if($narr[2]==""){
			$narr[2]	=	"01";
		}
		if($narr[1]==""){
			$narr[1]	=	"01";
		}
		if($narr[0]!=""){
			$arr		=	$narr[0]."-".$narr[1]."-".$narr[2];
		}
		$arr	=	strtotime($arr);
		return $arr;
	}

	function get_city($name, $locoy_rate = 60)
	{
	    include PLUS_PATH."city.cache.php";
	    include PLUS_PATH."cityfs.cache.php";
	    include PLUS_PATH."cityparent.cache.php";
	    $name   =  str_replace(array("省","市","县"), "/", $name);
	    $arr    =  explode("/", $name);
	    
	    if (is_array($arr)) {
	        foreach ($arr as $v) {
	            $data[] = $this->locoytostr($city_name, $v, true);
	        }
	    }
	    
	    $city  =  array(0, 0, 0);
	    // 城市只有一组类别
	    if (count($data) == 1){
	        // 直接取收个，匹配度最高
	        $cid  =  key($data[0]);
	        //获取当前城市级别，根据级别来处理，获得其他级别的数据
	        $lev  =  getLev($cid,$city_parent);
	        if ($lev == 1){
	            $provinceid   =  $cid;
	            $cityid       =  0;
	            $threecityid  =  0;
	        }elseif ($lev == 2){
	            $cityid       =  $cid;
	            $provinceid   =  $city_parent[$cid];
	            $threecityid  =  0;
	        }elseif ($lev == 3){
	            $threecityid  =  $cid;
	            $cityid       =  $city_parent[$threecityid];
	            $provinceid   =  $city_parent[$cityid];
	        }
	        $city = array($provinceid,$cityid,$threecityid);
	    }else{
	        // 处理一级类别
	        if (!empty($data[0])){
	            $oneScore = 0;
	            foreach ($data[0] as $k=>$v){
	                if (in_array($k, $city_index) && $v > $oneScore){
	                    $provinceid  =  $k;
	                    $oneScore    =  $v;
	                }
	            }
	            if (isset($provinceid)){
	                $city[0]  =  $provinceid;
	            }
	        }
	        // 处理二级类别
	        if (!empty($data[1])){
	            $twoScore = 0;
	            foreach ($data[1] as $k=>$v){
	                if (isset($provinceid)){
	                    // 已匹配到一级
	                    if (in_array($k, $city_type[$provinceid]) && $v > $twoScore){
	                        $cityid    =  $k;
	                        $twoScore  =  $v;
	                    }
	                }else{
	                    // 未匹配到一级，直接匹配所有二级
	                    if (in_array($k, $city_two)){
	                        $twoArr[$k]  =  $v;
	                    }
	                }
	            }
	            if (!empty($twoArr)){
	                // 如果有二级匹配数组，倒序排列，取出最高的
	                arsort($twoArr);
	                $cityid  =  key($twoArr);
	                // 如果前面没有匹配到一级，用匹配到的二级反推
	                if (!isset($provinceid)){
	                    $city[0]  =  $city_parent[$cityid];
	                }
	            }
	            if (isset($cityid)){
	                $city[1]  =  $cityid;
	            }
	        }
	        // 处理三级类别
	        if (!empty($data[2])){
	            foreach ($data[2] as $k=>$v){
	                if (isset($cityid)){
	                    // 已匹配到二级
	                    if (in_array($k, $city_type[$cityid])){
	                        $threeArr[$k]  =  $v;
	                    }
	                }else{
	                    // 未匹配到三级
	                    if (in_array($k, $city_three)){
	                        $threeArr[$k]  =  $v;
	                    }
	                }
	            }
	            if (!empty($threeArr)){
	                // 如果有三级匹配数组，倒序排列，取出最高的
	                arsort($threeArr);
	                $threecityid  =  key($threeArr);
	                // 如果前面没有匹配到二级级，用匹配到的三级反推
	                if (!isset($cityid)){
	                    $city[1]  =  $city_parent[$threecityid];
	                    $city[0]  =  $city_parent[$city[1]];
	                }
	            }
	            if (isset($threecityid)){
	                $city[2]  =  $threecityid;
	            }
	        }
	    }
	    return $city;
	}
	/**
	 * 字符串相似度匹配
	 * @param $arr 类别
	 * @param $str 要匹配的字符串
	 * @param $isarr 返回单个还是数组
	 */
	function locoytostr($arr, $str, $isarr = false,$locoy_rate = 60)
	{
	    $str_array = $this->tostring($str);
	    
	    if (is_array($str_array)) {
	        foreach ($arr as $key => $list) {
	            if (is_numeric($str)){
	                // 如果要处理的字符串是全是数字，要过滤掉缓存中的汉字
	                $list = preg_replace('/([\x80-\xff]*)/i','',$list);
	            }
	            $h = 0;
	            foreach ($str_array as $val) {
	                if (substr_count($list, $val))
	                    $h ++;
	            }
	            $categoryname_array = $this->tostring($list);
	            $j = round($h / count($categoryname_array) * 100, 2);
	            if($j >= $locoy_rate && $j<=100){
	                $rows[$key] = $j;
	            }
	        }
	        arsort($rows);
	        // 返回要返回单个还是数组
	        if ($isarr){
	            return $rows;
	        }else{
	            return key($rows);
	        }
	    } else {
	        return false;
	    }
	}
	
	function tostring($string)
	{
	    $length = strlen($string);
	    $retstr = array();
	    for ($i = 0; $i < $length; $i ++) {
	        $retstr[] = ord($string[$i]) > 127 ? $string[$i] . $string[++ $i] : $string[$i];
	    }
	    return $retstr;
	}

	function get_com_type($cat){
		include(PLUS_PATH."com.cache.php");
		foreach($comdata["job_".$cat] as $v){
			$data[$v]	=	$comclass_name[$v];
		}
		return $data;
	}
	function get_job_class($name, $locoy_rate = 60){
	    include(PLUS_PATH."job.cache.php");
	    $arr=explode("/",$name);
	    if(is_array($arr)){
	        foreach($arr as $v){
	            $data[]=$this->locoytostr($job_name, $v, false, $locoy_rate);
	        }
	    }
	    $job_type[0]=$job_index;
	    $val=$this->get_all_class($job_type,$data,$locoy_rate);
	    if(count($val)==1){
	        $val[]=$this->get_once_class($job_type,$job_name,$val[0],$locoy_rate);
	    }
	    return $val;
	}
	function get_all_class($city_type,$data,$locoy_rate,$k=""){
	    if(is_array($data)){
	        foreach($data as $v){
	            foreach($city_type as $key=>$value){
	                $a=$k?$k:$v;
	                if(in_array($a,$value)){
	                    if($key){
	                        $val=$this->get_all_class($city_type,$data,$locoy_rate,$key);
	                    }
	                    $val[$key]=$a;
	                }
	            }
	        }
	    }
	    return $val;
	}
	function get_once_class($t,$n,$id,$locoy_rate){
	    $row=$n[$id];
	    if(is_array($t[$id])){
	        foreach($t[$id] as $k=>$v){
	            $array[$v]=$n[$v];
	        }
	    }
	    $r=$this->locoytostr($array,$row);
	    return $r;
	}
	function get_user_type($cat){
		include(PLUS_PATH."user.cache.php");
		foreach($userdata["user_".$cat] as $v){
			$data[$v]	=	$userclass_name[$v];
		}
		return $data;
	}
	/**
	 * 处理个人意向类型
	 */
	function get_user_job($name,$locoy_rate = 60){
	    
	    include(PLUS_PATH."job.cache.php");
	    $arr=explode(",",$name);
	    if(is_array($arr)){
	        foreach($arr as $v){
	            $data[]=$this->locoytostr($job_name, $v, false, $locoy_rate);
	        }
	    }
	    return $data;
	}
	/**
	 * 生成随机字符串密码
	 */
	function randomPass(){
	    
	    $pass	=	array("a","b","c","d","e","f","g","h","i","g","k","l","m","n","o","p","q","r","s","t","u","v","w","x","w","z","1","2","3","4","5","6","7","8","9","0");
	    $password	=	'';
	    $len	=	rand(8,12);
	    for($i=0;$i<$len;$i++){
	        $k = rand(0,36);
	        $password.=$pass[$k];
	    }
	    return $password;
	}
}
?>