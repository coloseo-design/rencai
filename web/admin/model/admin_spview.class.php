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
class admin_spview_controller extends adminCommon{
	//设置高级搜索功能
	function set_search(){

	    $search_list[]  =  array('param'=>'status','name'=>'审核状态','value'=>array(3=>'未审核',1=>'已审核',2=>'未通过'));
//	    $this->yunset('source',$source);
	    $this->yunset('search_list',$search_list);

	}

	function index_action(){

		$this -> set_search();

		if($_GET['keyword']){
		    
		    $keytype  =   intval($_GET['type']);
		    
		    $keyword  =   trim($_GET['keyword']);
		    
		    if ($keytype == 1){
		        
		        $where['uid']	    =  $keyword;
		        
		    }elseif ($keytype == 2){
		        
		        $cwhere['name']     =  array('like',$keyword);
		        
		        $companyM           =  $this->MODEL('company');
		        $com                =  $companyM->getList($cwhere,array('field'=>'`uid`'));
		        
		        if (!empty($com['list'])){
		            
		            foreach ($com['list'] as $v){
		                
		                $cuid[]  =  $v['uid'];
		            }
		            
		            $where['uid']  =  array('in',pylode(',', $cuid));
		        }
		    }
		    
		    $urlarr['type']	        =  $keytype;
		    
		    $urlarr['keyword']	    =  $keyword;
		}
		if($_GET['status']){
		    
		    $where['status']	    =  intval($_GET['status']) == 3 ? 0 : $_GET['status'];
		    
		    $urlarr['status']		=  $_GET['status'];
		}
		//排序
		if($_GET['order']){

			$where['orderby'] = $_GET['t'].','.$_GET['order'];
			$urlarr['order']  =	$_GET['order'];
			$urlarr['t']	  =	$_GET['t'];

		}else{
			$where['orderby']		=  'id';
		}
		$urlarr        	=   $_GET;
		$urlarr['page']	=	'{{page}}';

		$pageurl		=	Url($_GET['m'],$urlarr,'admin');

		$pageM			=	$this -> MODEL('page');

		$pages			=	$pageM -> pageList('spview',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){

			$where['limit']	   =  $pages['limit'];
			$spviewM	       =  $this->MODEL('spview');
			$rows  			   =  $spviewM -> getList($where,array('utype'=>'admin'));
		}
		$this -> yunset('rows',$rows);

		$this -> yuntpl(array('admin/admin_spview_list'));
	}

	function add_action(){

		//提取分站内容
		$cacheM  =	$this -> MODEL('cache');
		
        $user  =	$cacheM	-> GetCache('user');

        $this -> yunset($user);

        $jobM       =   $this->MODEL('job');

        $jobwhere   =   array(
            'uid'       =>  $_GET['uid'],
            'state'     =>  1,
            'status'    =>  0,
            'r_status'  =>  1
        );
        
        $List    =   $jobM->getList($jobwhere,array('field'=>'`name`,`id`'));

        foreach ($List['list'] as $key => $value) {
            $jobArr[$value['id']] = $value['name'];
        }
      
        $this->yunset('job',$jobArr);


		$spviewM	=	$this->MODEL('spview');

		if(intval($_GET['id'])){

		    $info	=	$spviewM -> getInfo(array('id' => intval($_GET['id'])));

		    $this -> yunset('info',$info);
		}

		$this -> yuntpl(array('admin/admin_spview_add'));
	}

	function save_action(){
		$_POST  =  $this->post_trim($_POST);
        
        $post  =  array(
    		'id'           	=> $_POST['id'],
            'uid'           => $_POST['uid'],
            'jobid'         => trim(pylode(',', $_POST['jid'])),
            'starttime'     => strtotime($_POST['sdate']),
            'exp'           => trim($_POST['exp']),
            'edu'           => trim($_POST['edu']),
            'sex'           => trim(pylode(',', $_POST['sex'])),
            'other'         => trim(pylode(',', $_POST['other'])),
            'remark'       	=> trim($_POST['remark']),
            'status'      	=>  1
        );
        
		$spviewM  =  $this->MODEL('spview');
		$return   =  $spviewM->addInfo($post, 'admin');

		if (isset($return['id'])){
            
            $url  =  'index.php?m=admin_spview&c=add&id='.$return['id'];
            
        }else{
            $url  =  '';
        }
        
        $this->ACT_layer_msg($return['msg'], $return['errcode'], $url);

	}

	//修改审核状态
	function status_action(){
		
		
		$spviewM	=	$this->MODEL('spview');
		
		$id		=	@explode(",",$_POST['pid']);
		
		if(!empty($id)){
			
			$data['status']		=	$_POST['status'];
			$data['statusbody'] = 	trim($_POST['statusbody']);
			
			$nid	=	$spviewM -> upStatusInfo($id, $where = array(), $data);
			
			if($nid){

                $msg    	=   array();
                $uids   	=   array();

            	$spviews	=	$spviewM ->getList(array('id' => array('in',pylode(',',$id))),array('field'=>'`id`,`uid`,`remark`'));

                $uids		=	array();

                foreach ($spviews as $v){

                    $uids[] =   $v['uid'];
                }

                $noticeM    =   $this->MODEL('notice');

                $wxM      	=   $this->MODEL('weixin');

                $userinfoM  =   $this->MODEL('userinfo');

                $member     =   $userinfoM -> getList(array('uid' => array('in', pylode(',', $uids))), array('field' => '`uid`,`email`,`moblie`'));

                foreach ($spviews as $k => $v){

                    if ($_POST['status'] == 2) {

                        $statusInfo         =   '您的视频面试《'.$v['remark'].'》审核未通过';

                        if ($data['statusbody']) {
                            $statusInfo     .=  '，原因：'.$data['statusbody'];
                        }
                        
                        $msg[$v['uid']][]   =   $statusInfo;

                    }elseif ($_POST['status'] == 1){

                        $msg[$v['uid']][]   =  '您的视频面试《'.$v['remark'].'》审核通过';
                    }


                    foreach ($member as $mv){

                        $sendData   =   array();

                        if ($v['uid'] == $mv['uid']) {

                            $sendData['type']           =   $_POST['status'] == 2 ? 'spmsshwtg' : 'spmsshtg';

                            $sendData['uid']            =    $v['uid'];
                            $sendData['email']          =    $mv['email'];
                            $sendData['moblie']         =    $mv['moblie'];

                            $sendData['remark']        	=    $v['remark'];
                            $sendData['date']           =    date('Y-m-d H:i:s');
                            $sendData['status_info']    =    $data['statusbody'];
                            //邮箱短信通知
                            $noticeM -> sendEmailType($sendData);
							$sendData['port']			=	'5';

                            $res=$noticeM -> sendSMSType($sendData);
                            
                            $wxData['id']            	=   $v['id'];
                            $wxM   -> sendWxSpviewStatus($wxData);
                        }
                    }
                }


                //发送系统通知
                $sysmsgM = $this->MODEL('sysmsg');
                $sysmsgM -> addInfo(array('uid' => $uids,'usertype'=>2,'content'=>$msg));
            }


			$nid?$this -> ACT_layer_msg("视频面试审核(ID:".$_POST['pid'].")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this -> ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
		
		}else{
			
			$this -> ACT_layer_msg("非法操作！",8,$_SERVER['HTTP_REFERER']);
		
		}
	
	}
	function lockinfo_action(){

		$spviewM	=   $this -> MODEL('spview');

	    $info		=   $spviewM ->    getInfo(array('id' => intval($_POST['id'])), array('field'=>'`statusbody`'));

	    echo $info['statusbody'];die;

	}

	function del_action(){

		if($_GET['id']){

			$this -> check_token();

			$delID   =  intval($_GET['id']);

		}elseif($_POST['del']){

			$delID   =  $_POST['del'];
		}

		$spviewM  =  $this -> MODEL('spview');

		$return	  =  $spviewM -> delSpview($delID);

		$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	}

	function spresume_action(){
			
		$spviewM		=   $this -> MODEL('spview');

		$where['sid']	=	$_GET['sid'];
		
		if(!empty($_GET['keyword'])){
			
			$typeStr		=	$_GET['type'];
			$keyStr			=	$_GET['keyword'];
			
			if($typeStr == '2'){
				$jobM			=   $this -> MODEL('job');
                $jWhere['name']	=   array('like', $keyStr);
                $jobList		=   $jobM -> getList($jWhere, array('field'=>'`id`'));
                if (is_array($jobList)) {
                    $jobId		=	array();
                    foreach ($jobList['list'] as $v) {
                        $jobIds[]	=	$v['id'];
                    }
                }
                $where['jobid']	=	array('in', pylode(',', $jobIds));
			}else{

				$resumeM		=   $this -> MODEL('resume');
                $rWhere['name']	=   array('like', $keyStr);
                $resuemList		=   $resumeM -> getResumeList($rWhere, array('field'=>'`uid`,`name`'));

                if (is_array($resuemList)) {
                    $uids		=	array();
                    foreach ($resuemList as $v) {
                        $uids[]	=	$v['uid'];
                    }
                }
                $where['uid']	=	array('in', pylode(',', $uids));
			}
		}
		$urlarr        	=   $_GET;
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	'{{page}}';

		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM			=	$this -> MODEL('page');
		$pages			=	$pageM -> pageList('spview_subscribe',$where,$pageurl,$_GET['page']);

        //分页数大于0的情况下 执行列表查询
        if($pages['total'] > 0){
            
            //limit order 只有在列表查询时才需要
            if($_GET['order']){
                
                $where['orderby']  =  $_GET['t'].','.$_GET['order'];
                $urlarr['order']   =  $_GET['order'];
                $urlarr['t']	   =  $_GET['t'];
            }else{
                $where['orderby']  =  'ctime';
            }
            $where['limit']		   =  $pages['limit'];
            
            $rows                  =  $spviewM -> getSublist($where, array('resume'=>1)); 
        }
		$this -> yunset(array('list' => $rows));	

		$this->yuntpl(array('admin/admin_spresume'));
	}

	function delSub_action(){

		if($_GET['id']){

			$this -> check_token();

			$delID   =  intval($_GET['id']);

		}elseif($_GET['del']){

			$delID   =  $_GET['del'];
		}

		$spviewM  =  $this -> MODEL('spview');

		$return	  =  $spviewM -> delSub($delID, array(), 'admin');

		$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	}

}

?>