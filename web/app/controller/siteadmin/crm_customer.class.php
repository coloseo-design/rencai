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
class crm_customer_controller extends siteadmin_controller{
	 
    function index_action(){
        
        $comM               =   $this -> MODEL('company');
        
        $where              =   array();
        $swhere             =   array();
        $cwhere             =   array();
        $urlarr             =   array();
        
        if ($_GET['self'] == '1') {
            
            $where['crm_uid']   =   $_SESSION['auid'];

			$urlarr['self']     =   $_GET['self'];
            
            $this -> yunset('self', '1');
            
        }else{
            
            $where['crm_uid']   =   '0';
            
        }
        
        if ($_GET['name']) {
            
            $name   =   trim($_GET['name']);
            
            if (!empty($name)) {
                
                $where['name']  =   array('like', $name);
                
            }
            
            $urlarr['name']     =   $name;
            
        }
        
        if($_GET['rating']){
            
            $swhere['rating']   =   $_GET['rating'];
            
            $urlarr['rating']   =   $_GET['rating'];
            
        }
        
        if($_GET['vtime']){
            
            $time = intval($_GET['vtime']);

            if ($time == 1) {
                
                $num = '+3 day';
            } elseif ($time == 2) {

                $num = '+7 day';
            } elseif ($time == 3) {

                $num = '+1 month';
            } elseif ($time == 4) {

                $num = '+6 month';
            }
            
            $swhere['PHPYUNBTWSTART_A']    =   '';
            
            $swhere['vip_etime'][]         =   array('>', time(),'AND');
            $swhere['vip_etime'][]         =   array('<', strtotime($num),'AND');
            
            $swhere['PHPYUNBTWEND_A']      =   '';
            
            $urlarr['vtime']    =   $time;
            
        }
        
        if(!empty($swhere)){
            
            $sUids      =   array();
            
            $StatisM    =   $this -> MODEL('statis');
            
            $statisList =   $StatisM -> getList($swhere, array('usertype'=>'2','field' => '`uid`'));
             
            if(!empty($statisList)){
                
                foreach($statisList as $sv){
                    
                    
                    $sUids[]    =   $sv['uid'];
                }
            } 
            
            $where['uid']       =   array('in', pylode(',',$sUids));
            
        }
         
        if ($_GET['atime']) {
            
            $atime = intval($_GET['ctime']);
            
            if ($atime == 1) {
                
                $snum = '-3 day';
            } elseif ($atime == 2) {
                
                $snum = '-7 day';
            } elseif ($atime == 3) {
                
                $snum = '-1 month';
            } elseif ($atime == 4) {
                
                $where['isfollow']  =   '0';
            }
            
            $cwhere['atime']    =   array('<', strtotime($snum));
            
            $urlarr['atime']    =   $time;
            
        }
        
        if (!empty($cwhere)) {
            
            $cUids          =   array();
            
            $crmM           =   $this -> MODEL('crm');
            
            $concernList    =   $crmM -> getConcernList($cwhere, array('field' => '`comid`'));
            
            if(!empty($concernList)){
                
                foreach($concernList as $cv){
                    
                    $cUids[]    =   $cv['comid'];
                }
            } 
            
            $where['uid'][]     =   array('in', pylode(',',$cUids));
        }
        
        $urlarr['page']	    =	'{{page}}';
        
        $pageurl            =	Url($_GET['m'], $urlarr, 'admin');
        
        $pageM              =	$this  -> MODEL('page');
        
        $pages              =	$pageM -> pageList('company', $where, $pageurl, $_GET['page']);
        
        if ($pages['total'] > 0) {
            
            if ($_GET['order']) {
                
                $where['orderby']   =   $_GET['t'].','.$_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
                
            }else{
                
                $where['orderby']    =   'uid';
                
            }
            
            $where['limit']         =   $pages['limit'];
            
            $listA                  =   $comM -> getList($where,array('utype' => 'crm'));
            
            $this -> yunset(array('rows' => $listA['list'], 'auid' => intval($_SESSION['auid'])));
            
        }
        
        //会员套餐
        $ratingM	=	$this -> MODEL('rating');
        $ratinglist	=	$ratingM -> getList(array( 'category' => '1'), array('field'=>'`id`,`name`'));
        $this   ->  yunset('ratinglist', $ratinglist);
        
        $this -> siteadmin_tpl(array('crm_customer'));
    }
	
	
	/**
	 * @desc CRM - 录客户
	 */
	function add_action(){
	    
	    if ($_POST['submit']) {
	        
 	        $mPost = array(
 	            'username' =>  trim($_POST['username']),
 	            'moblie'   =>  trim($_POST['moblie']),
 	            'email'    =>  trim($_POST['email'])
 	        );
 	        
	        if($_POST['username'] =='' || mb_strlen($_POST['username']) < 2 || mb_strlen($_POST['username']) > 16){
	            
	            $this -> ACT_layer_msg('客户名称格式错误',8);
	            
	        }elseif($_POST['password']==''||mb_strlen($_POST['password'])<6||mb_strlen($_POST['password'])>20){
	            
	            $this -> ACT_layer_msg('客户账号格式错误',8);
	            
	        }
	        
	        $userinfoM  =  $this -> MODEL('userinfo');
	        
	        $result  =  $userinfoM -> addMemberCheck($mPost);
	        
	        if ($result['msg']){
	            
	            $this -> ACT_layer_msg($result['msg'],8);
	        }
	        
	        if($this->config['sy_uc_type']=='uc_center'){
	            
	            $this -> obj-> uc_open();
	            
	            $user  =  uc_get_user($_POST['username']);
	            
	            if(is_array($user)){
	                
	                $this -> ACT_layer_msg('该会员已经存在！',8);
	                
	            }
	            
	        }
	        $time  =  time();
	        $ip    =  fun_ip_get();
	        $pass  =  $_POST['password'];
	        
	        if($this->config['sy_uc_type'] == 'uc_center'){
	            
	            $uid  =  uc_user_register($_POST['username'],$pass,$_POST['email']);
	            
	            if($uid < 0){
	                
	                switch($uid){
	                    
	                    case '-1' : $data['msg']='用户名不合法!';
	                    break;
	                    case '-2' : $data['msg']='包含不允许注册的词语!';
	                    break;
	                    case '-3' : $data['msg']='用户名已经存在!';
	                    break;
	                    case '-4' : $data['msg']='Email 格式有误!';
	                    break;
	                    case '-5' : $data['msg']='Email 不允许注册!';
	                    break;
	                    case '-6' : $data['msg']='该 Email 已经被注册!';
	                    break;
	                }
	                
	                $this -> ACT_layer_msg($data['msg'],8);
	                
	            }else{
	                
	                list($uid, $username, $email, $password, $salt)    =   uc_get_user($_POST['email'], $pass);
	                
	            }
	        }else{
	            $pwdRes    =   $userinfoM -> generatePwd(array('password' => $pass));
	            
	            $salt      =  $pwdRes['salt'];
	            $password  =  $pwdRes['pwd'];
	            
	        }
	        
	        $mdata = array(
	            
	            'username'  =>  trim($_POST['username']),
	            'password'  =>  $password,
	            'usertype'  =>  2,
	            'salt'      =>  $salt,
	            'address'   =>  $_POST['address'],
	            'moblie'    =>  $_POST['moblie'],
	            'email'     =>  $_POST['email'],
	            'reg_date'  =>  $time,
	            'reg_ip'    =>  $ip,
	            'source'    =>  '16', 
	            'status'    =>  '0'
	            
	        );
	        
	        if($_POST['areacode'] && $_POST['telphone']){
	            
	            $_POST['phone'] =   $_POST['areacode'].'-'.$_POST['telphone'];
	            
	            if($_POST['exten']){
	                
	                $_POST['phone'] .= '-'.$_POST['exten'];
	                
	            }
	        }
	        
	        $udata = array(
	            
	            'name'         =>  $_POST['name'],
	            'hy'           =>  $_POST['hy'],
	            'provinceid'   =>  $_POST['provinceid'],
	            'cityid'       =>  $_POST['cityid'],
	            'three_cityid' =>  $_POST['three_cityid'],
	            'address'      =>  $_POST['address'],
	            'linkman'      =>  $_POST['linkman'],
	            'linktel'      =>  $_POST['moblie'],
	            'linkphone'    =>  $_POST['phone'],
	            'linkmail'     =>  $_POST['email'],
	            'crm_uid'      =>  $_SESSION['auid'],
	            'crm_time'     =>  $time,
	            'crm_status'   =>  $_POST['crm_status']
	            
	        );
	        
	        $sdata = array(
	            
	            'rating'       =>  $this -> config['com_rating']
	            
	        );
	        
	        $nid   =   $userinfoM -> addInfo(array('mdata' => $mdata,'udata' => $udata, 'sdata' => $sdata));
	        
	        if ($nid) {
	            
	            $crmM          =   $this -> MODEL('crm');
	            
	            if ($_POST['crm_status'] == '9' && !empty($_POST['rating_name'])) {   // 成单客户，新建订单（待审核）
	                
	                $dealData  =   array(
	                    
	                    'uid'      =>  $nid,
	                    'rating'   =>  intval($_POST['rating_name']),
	                    'crm_uid'  =>  $_SERVER['auid']
	                    
	                );
	                
	               $crmM  -> addDeal($dealData);
	                
	            }
	            
	            if ($_POST['is_task'] == 'on') {   // 新建待办任务
	                
	                $taskData      =   array(
	                    
	                    'auid'     =>  $_SESSION['auid'],
	                    'uid'      =>  $_SESSION['auid'],
	                    'comid'    =>  $nid,
	                    'title'    =>  $_POST['title'],
	                    'content'  =>  $_POST['task_content'],
	                    'stime'    =>  $_POST['stime'],
	                    'priority' =>  $_POST['priority'],
    	                    
	                );
	                
	               $crmM -> addWaitingTask($taskData);
	                
	            }
	            
	        }
 	        
	        $msg   =   $nid ? '客户（ID：'.$nid.'）新加成功！' : '客户新加失败，请重试！';
	        
	        $layType   =   $nid ? 9 : 8 ;
	        
	        $url       =   $nid ? 'index.php?m=crm_customer&self=1' : 'index.php?m=crm_customer';
	        
	        $this  -> ACT_layer_msg($msg, $layType, $url);
	        
	    }
	    
	    $ratingM   =   $this -> MODEL('rating');
	    
	    $rating    =   $ratingM -> getList(array('category' => '1', 'orderby' => 'sort,asc'), array('field' => '`id`,`name`'));
	    
	    $this  ->  yunset('rating_list',$rating);
	    
	    $cacheM    =   $this->MODEL('cache');
	    
	    $options   =   array('crm','hy','city');
	    
	    $cache     =   $cacheM -> GetCache($options);
	    
	    $this  ->  yunset('cache',  $cache);
	    
	    $this->yuntpl(array('admin/crm_customer_add'));
	    
	}
	
	/**
	 * @desc CRM - 新增客户 - 用户名检测
	 */
	function check_action() {
	    $username  =   trim($_POST['username']);
	    $userinfoM =   $this -> MODEL('userinfo');
	    
	    $check     =   $userinfoM -> addMemberCheck(array('username' => $username));
        	    
	    echo $check['msg'];die;
	}
	
	/**
	 * @desc CRM - 新建订单（业务员开通套餐，待审核）
	 */
	function getstatis_action(){
	    
	    $ratingM   =   $this -> MODEL('rating');
	    
	    $rating    =   $ratingM -> getList(array('category' => '1', 'orderby' => 'sort,asc'), array('field' => '`id`,`name`'));
	    
	    if(!empty($rating)){
	        
	        foreach($rating as $k => $v){
	        
	            $ratingarr[$v['id']]   =   $v['name'];
	        
	        }
	        
	    }
 	    
	    $this -> yunset('ratingarr',$ratingarr);
	    
	    if($_GET['uid']){
	        
	        $uid       =   intval($_GET['uid']);
	        
	        $statisM   =   $this -> MODEL('statis');
	        
	        $row       =   $statisM -> getInfo($uid, array('usertype' => '2'));
	        
	        if($row['vip_etime'] > 0){
	            
	            $row['vipetime']   =   date("Y-m-d",$row['vip_etime']);
	        
	        }else{
	            
	            $row['vipetime']   =   '不限';
	            
	        }
	        
	        $this->yunset('row',$row);
	    }
	    
	    $this->yuntpl(array('admin/crm_customer_rating'));
	    
	}
	
	/**
	 * @desc CRM - 开通套餐  -  选择套餐查询数据返回；
	 */
	function getrating_action(){
	    
	    if($_POST['id']){
	        
	        $id        =   intval($_POST['id']);   
	        
	        $ratingM   =   $this -> MODEL('rating');
	        
	        $rating    =   $ratingM -> getInfo(array('id' => $id, 'category' => '1'));
	        
	        if($rating['service_time'] > 0){
	            
	            $rating['vip_etime']   =   time()  +   $rating['service_time'] *   86400;
	            
	            $rating['vipetime']    =   date('Y-m-d', $rating['vip_etime']);
	        
	        }else{
	            
	            $rating['vip_etime']   =   0;
	            
	            $rating['vipetime']    =   '不限';
	        
	        }
	        
	        if($rating['time_start'] < time() && $rating['time_end'] > time()){
	            
	            $rating['price']       =   $rating['yh_price'];
	            
	        }else{
	            
	            $rating['price']       =   $rating['service_price'];
	        
	        }
	        
	        echo json_encode($rating);
	    }
	    
	}
	

}
?>