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
class admin_zphnet_controller extends adminCommon{
	//设置高级搜索功能
	function set_search(){

		$search_list[]	=	array('param' => 'status','name' => '状态','value' => array('3' => '未开始','1' => '已开始','2' => '已结束'));

		$this -> yunset('search_list',$search_list);

	}

	function index_action(){

		$this -> set_search();

		if($_GET['keyword']){

			$where['title']		    =  array('like',trim($_GET['keyword']));

			$urlarr['keyword']		=  $_GET['keyword'];
		}

		if($_GET['status'] == '3'){

			$where['starttime']		=	array('unixtime','>',time());

			$urlarr['status']		=	$_GET['status'];

		}elseif($_GET['status'] == '1'){

			$where['starttime']		=	array('unixtime','<',time());

			$where['endtime']		=	array('unixtime','>',time());

			$urlarr['status']=$_GET['status'];

		}elseif($_GET['status'] == '2'){

			$where['endtime']		=	array('unixtime','<',time());

			$urlarr['status']		=	$_GET['status'];

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

		$pages			=	$pageM -> pageList('zphnet',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){

			$where['limit']	   =  $pages['limit'];
			$zphnetM	       =  $this->MODEL('zphnet');
			$rows  			   =  $zphnetM -> getList($where,array('utype'=>'admin'));
			$class  =  $zphnetM->getClassList(array('keyid'=>0));
			foreach ($class as $v){
			    $area[$v['id']]  =  $v['name'];
			}
			$this->yunset('area',$area);
		}
		//提取分站内容
		$cacheM  =	$this -> MODEL('cache');
		$domain  =	$cacheM	-> GetCache('domain');

		$this -> yunset('Dname', $domain['Dname']);

		$this -> yunset('rows',$rows);

		$this -> yuntpl(array('admin/admin_zphnet_list'));
	}

	function add_action(){

		//提取分站内容
		$cacheM  =	$this -> MODEL('cache');
		$domain  =	$cacheM	-> GetCache('domain');

		$this -> yunset('Dname', $domain['Dname']);

		$zphnetM	=	$this->MODEL('zphnet');

		if(intval($_GET['id'])){

		    $info	=	$zphnetM -> getInfo(array('id' => intval($_GET['id'])));
            
		    $this -> yunset('info',$info);
			$this -> yunset('lasturl',$_SERVER['HTTP_REFERER']);
		}
		$class  =  $zphnetM->getClassList(array('keyid'=>0));
		$this->yunset('class',$class);

		$this -> yuntpl(array('admin/admin_zphnet_add'));
	}

	function save_action(){

		$zphnetM	=	$this -> MODEL('zphnet');

		if($_FILES){
		    $upData = [];
			foreach ($_FILES as $key => $value) {
				if ($value['tmp_name']) {
					$upData[$key]['file'] = $_FILES[$key];
					$upData[$key]['dir'] = 'zhaopinhui';
				}
			}

		    $arr = [
		    	'sl' 	=> 'pic',
		    	'hf' 	=> 'banner',
		    	'wapsl' => 'pic_wap',
		    	'waphf' => 'banner_wap',
		    ];
	
		    if ($upData) {
		    	$uploadM  =  $this->MODEL('upload');
		    	foreach ($upData as $key => $value) {
			    	$upRes = $uploadM->newUpload($value);
			    	if ($upRes && !empty($upRes['msg'])) {
			    		$return['msg']	    =  $upRes['msg'] ? $upRes['msg'] : $upRes['msg'];
			        	$this -> ACT_layer_msg($return['msg'],8);
			    	} else {
			    		$_POST[$arr[$key]] = $upRes['picurl'];
			    	}
			    }
		    }
		}

		if($_POST['time']){

			$times	=	@explode('~',$_POST['time']);

			$_POST['starttime']	=	trim($times[0]);

			$_POST['endtime']	=	trim($times[1]);

			if(strtotime($_POST['starttime'])>strtotime($_POST['endtime'])){

			    $this -> ACT_layer_msg('开始时间不得大于结束时间',8);
			}

			unset($_POST['time']);
		}
		$_POST['body']			=	str_replace("&amp;","&",$_POST['body']);

		if($_POST['id']){

		    $nbid	=	$zphnetM -> upInfo(array('id'=>intval($_POST['id'])),$_POST);

			isset($nbid)?$this->ACT_layer_msg("网络招聘会(ID:".$_POST['id'].")修改成功！",9,"index.php?m=admin_zphnet",2,1):$this->ACT_layer_msg("网络招聘会(ID:".$_POST['id'].")修改失败！",8,"index.php?m=admin_zphnet");

		}else{

		    $nbid	=	$zphnetM -> addInfo($_POST);

			isset($nbid)?$this->ACT_layer_msg("网络招聘会(ID:$nbid)添加成功！",9,"index.php?m=admin_zphnet",2,1):$this->ACT_layer_msg("网络招聘会(ID:$nbid)添加失败！",8,"index.php?m=admin_zphnet");
		}

	}

	function del_action(){

		if($_GET['id']){

			$this -> check_token();

			$delID   =  intval($_GET['id']);

		}elseif($_POST['del']){

			$delID   =  $_POST['del'];
		}

		$zphnetM  =  $this -> MODEL('zphnet');

		$return	  =  $zphnetM -> delZph($delID);

		$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	}

	/**
	 * @desc 报名企业，高级搜索功能
	 */
	function set_searchs(){

		$search_list[]	=	array("param"=>"status","name"=>'审核状态',"value"=>array("3"=>"未审核","1"=>"已通过","2"=>"未通过"));

		$this -> yunset("search_list",$search_list);

	}
    function user_action(){
        $zphnetM  =  $this->MODEL('zphnet');
        if($_GET['id']){

            $where['zid']	=	intval($_GET['id']);

            $urlarr['id']	=	$_GET['id'];

        }

        if (trim($_GET['keyword'])){

            $resumeM  =  $this->MODEL('resume');
            $resume   =  $resumeM->getResumeInfo(array('name'=>array('like',trim($_GET['keyword']))),array('field'=>'uid'));

            if($resume){

                foreach($resume as $v){

                    $uid[]	=	$v['uid'];
                }
                $where['uid']	=	array('in',pylode(',', $uid));
            }
            $urlarr["keyword"]	=	$_GET["keyword"];
        }

        $urlarr['c']	 =	$_GET['c'];
		$urlarr        	 =   $_GET;
        $urlarr['page']  =	"{{page}}";
        $where['usertype'] = 1;

        $pageurl  =  Url($_GET['m'],$urlarr,'admin');
        $pageM	  =	 $this  -> MODEL('page');

        $pages	  =	 $pageM -> pageList('zphnet_user',$where,$pageurl,$_GET['page']);
        if($pages['total'] > 0){
            $where['limit']	   =  $pages['limit'];

            $rows  =  $zphnetM -> getZphnetUser($where,array('resume'=>$where['limit'],'keyword'=>$urlarr['keyword'],'utype'=>'admin'));

            $this -> yunset("rows",$rows);
        }
        $this -> yuntpl(array('admin/admin_zphnet_user'));
    }
	function com_action(){

		$this->set_searchs();

		$zphnetM  =  $this->MODEL('zphnet');
		$type	  =	 array('1'=>'招聘会名称','2'=>'企业名称');

		$this -> yunset('type',$type);

		if($_GET['id']){

			$where['zid']	=	intval($_GET['id']);

			$urlarr['id']	=	$_GET['id'];

		}

		if($_GET['status']){

			if($_GET['status']=="3"){

				$where['status']	=	0;

			}elseif($_GET['status']=="1"){

				$where['status']	=	1;

			}elseif($_GET['status']=="2"){

				$where['status']	=	2;

			}
			$urlarr['status']	=	$_GET['status'];
		}

		if (trim($_GET['keyword'])){

		    $companyM  =  $this->MODEL('company');
		    $company   =  $companyM->getChCompanyList(array('name'=>array('like',trim($_GET['keyword']))),array('field'=>'uid'));

		    if($company){

		        foreach($company as $v){

		            $uid[]	=	$v['uid'];
		        }
		        $where['uid']	=	array('in',pylode(',', $uid));
		    }
		    $urlarr["keyword"]	=	$_GET["keyword"];
		}

		$urlarr['c']	 =	$_GET['c'];
		$urlarr        	 =   $_GET;
		$urlarr['page']  =	"{{page}}";

		$pageurl  =  Url($_GET['m'],$urlarr,'admin');
		$pageM	  =	 $this  -> MODEL('page');
		$pages	  =	 $pageM -> pageList('zphnet_com',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){

		    $where['orderby']  =  array('status,asc','id,desc');

		    $where['limit']	   =  $pages['limit'];

		    $rows  =  $zphnetM -> getZphnetComList($where,array('utype'=>'admin'));

		    session_start();

			$_SESSION['zphXLs']	=	$where;

			$zphnet  =  $zphnetM->getInfo(array('id'=>intval($_GET['id'])),array('field'=>'`zw`'));

			$noarea  =  0;
			if (!empty($zphnet['zw'])){
			    $class  =  $zphnetM->getClassList(array('keyid'=>$zphnet['zw']));
			    $area   =  array();
			    foreach ($class as $v){
			        $area[$v['id']]  =  $v['name'];
			    }
			    if(!empty($area)){
			        $this->yunset('area',$area);
			    }else{
			        $noarea  =  2;
			    }
			}else{
			    $noarea  =  1;
			}
			$this->yunset('noarea',$noarea);
		}

		$this -> yunset("rows",$rows);

		$this -> yuntpl(array('admin/admin_zphnet_com'));

	}

	function sbody_action(){

		$zphnetM  =	 $this -> MODEL('zphnet');
		$com	  =  $zphnetM->getZphnetCom(array('id'=>intval($_POST['id'])),array('field'=>'statusbody'));

		echo $com['statusbody'];die;

	}

	function status_action(){

	    $zphnetM  =	 $this -> MODEL('zphnet');

		$data['status']		=	$_POST['status'];

		$data['statusbody']	=	trim($_POST['statusbody']);

		$id					=	@explode(",",$_POST['pid']);

		$nid				=	$zphnetM -> zphnetComStatus($id,$data, array('utype' => 'admin'));

		$nid?$this->ACT_layer_msg("网络招聘会报名企业(ID:".$_POST['pid'].")审核设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
	}
    function userxls_action(){
        if($_POST['zid']&&$_POST['cid']) {
            $resumeM = $this->MODEL('resume');
            $where['usertype'] = 1;

            $rwhere = array('uid' => array('in', $_POST['cid']),'defaults' => 1);
            $rows = $resumeM->getList($rwhere,array('utype'=>'zphnet'));
            $this->yunset('list', $rows['list']);

            $this->MODEL('log')->addAdminLog('导出参与网络招聘会个人信息');

            header('Content-Type: application/vnd.ms-excel');

            header('Content-Disposition: attachment; filename=zphnetuser.xls');

            $this->yuntpl(array('admin/admin_zphnet_userxls'));
        }else{
            $this->ACT_layer_msg('没有可以导出的参会个人信息！',8,$_SERVER['HTTP_REFERER']);
        }
    }
	function comxls_action(){

		$zphnetM	    =	$this -> MODEL('zphnet');

		$CompanyM		=	$this -> MODEL('company');

		$JobM			=	$this -> MODEL('job');

		if($_POST['zid']){

			if($_POST['cid']){
				$zcwhere = array('id'=>array('in',$_POST['cid']));
			}else{
				$zcwhere = array('zid'=>$_POST['zid']);
			}
			
		    $rows		=	$zphnetM -> getZphnetComList($zcwhere);

			if(!empty($rows)){

			    $cacheM  =  $this->MODEL('cache');
			    $cache   =  $cacheM->getCache(array('com'));

			    $comclass_name  =  $cache['comclass_name'];

                $jobids = $jobuids = $comids = array();
				foreach ($rows as $key=>$val){

				    $comids[]       =   $val['uid'];

				    if ($val['jobid']){

				        $jobids[]   =   $val['jobid'];
                    }else{

                        $jobuids[]  =   $val['uid'];
                    }
				}

				$comField  =  '`uid`,`name`,`mun`,`content`,`address`,`linktel`,`linkman`,`linkphone`,`welfare`,`money`,`moneytype`';

				$companys  =  $CompanyM -> getChCompanyList(array('uid'=>array('in',@implode(',',$comids))),array('field'=>$comField));

				$jobField  =  '`id`,`uid`,`name`,`zp_num`,`minsalary`,`maxsalary`,`exp`,`edu`,`provinceid`,`cityid`,`three_cityid`';

                $jobWhere['state']          =   1;
                $jobWhere['status']         =   0;
                $jobWhere['r_status']       =   1;

                $jobWhere['PHPYUNBTWSTART'] =   '';
                $jobWhere['uid']	        =	array('in',pylode(',',$jobuids));
                $jobWhere['id']	            =	array('in',pylode(',',$jobids), 'OR');
                $jobWhere['PHPYUNBTWEND']   =   '';

				$jobsA	   =  $JobM -> getList($jobWhere,array('field'=>$jobField));
				$jobs	   =  $jobsA['list'];


				foreach($companys as $k=>$va){

					$companys[$k]['content']	=	trim(strip_tags($va['content']));

					$companys[$k]['mun']		=	$comclass_name[$va['mun']];

					foreach($jobs as $val){
					    if ($va['uid'] == $val['uid']){
					        $companys[$k]['jobs'][]  =  $val;
					    }
					}
				}
				$maxJobNum = 1;
				foreach ($companys as $v){
				    $jobnum  =  count($v['jobs']);
				    if ($jobnum > $maxJobNum){
				        $maxJobNum  =  $jobnum;
				    }
				}
				$jobTr = $jobSonTr = '';

				for($i=1;$i<=$maxJobNum;$i++){

					$jobTr .= '<th colspan="6">岗位'.$i.'</th>';

					$jobSonTr .= '<th>招聘岗位</th><th>招聘人数</th><th>薪酬</th><th>经验要求</th><th>学历要求</th><th>工作地点</th>';
				}

				$this -> yunset('jobTr',$jobTr);

				$this -> yunset('jobSonTr',$jobSonTr);

				$this -> yunset('list',$companys);

				$this -> MODEL('log') -> addAdminLog('导出报名网络招聘会信息');

				header('Content-Type: application/vnd.ms-excel');

				header('Content-Disposition: attachment; filename=zphnetcom.xls');

				$this->yuntpl(array('admin/admin_zphnet_comxls'));

			}else{

				$this->ACT_layer_msg('没有可以导出的参会企业信息！',8,$_SERVER['HTTP_REFERER']);
			}
		}
	}
    function deluser_action(){

        $zphnetM	=	$this->MODEL('zphnet');

        if($_GET['delid']){

            $this -> check_token();

            $delID	=  intval($_GET['delid']);
            $zid    =  intval($_GET['zid']);

        }elseif($_POST['del']){

            $delID	=	$_POST['del'];
            $zid    =  intval($_POST['zid']);
        }

        $arr	=	$zphnetM -> delZphnetUser($delID);

        $this -> layer_msg($arr['msg'], $arr['errcode'], $arr['layertype'],$_SERVER['HTTP_REFERER']);

    }
	//删除链接
	function delcom_action(){

		$zphnetM	=	$this->MODEL('zphnet');

		if($_GET['delid']){

			$this -> check_token();

			$delID	=  intval($_GET['delid']);
			$zid    =  intval($_GET['zid']);

		}elseif($_POST['del']){

			$delID	=	$_POST['del'];
			$zid    =  intval($_POST['zid']);
		}

		$arr	=	$zphnetM -> delZphnetCom($delID);

		$this -> layer_msg($arr['msg'], $arr['errcode'], $arr['layertype'],$_SERVER['HTTP_REFERER']);

	}

	function checksitedid_action(){

		if($_POST['uid']){

			$uids	=	@explode(',', $_POST['uid']);

			$uid	= 	pylode(',', $uids);

			if($uid){

				$siteDomain		=	$this -> MODEL('site');

				$siteDomain -> updDid(array('zphnet'), array('id' => array('in', $uid)), array('did' => $_POST['did']));

				$siteDomain -> updDid(array('zphnet_com'),  array('zid' => array('in', $uid)),array('did' => $_POST['did']));

				$this -> ACT_layer_msg('网络招聘会(ID:'.$_POST['uid'].')分配站点成功！', 9, $_SERVER['HTTP_REFERER']);

			}else{

				$this -> ACT_layer_msg('请正确选择需分配数据！', 8, $_SERVER['HTTP_REFERER']);

			}

		}else{

			$this -> ACT_layer_msg('参数不全请重试！', 8, $_SERVER['HTTP_REFERER']);
		}
	}

	//添加参会企业
	function comadd_action(){

		$zphnetM  =  $this->MODEL('zphnet');

		$zph 	  =  $zphnetM->getInfo(array('id'=>intval($_GET['id'])));

		$this -> yunset('zph',$zph);

		$this -> yuntpl(array('admin/admin_zphnet_comadd'));

	}

	//根据企业名称搜索企业列表
	function getcomlist_action(){

		$companyM  =  $this->MODEL('company');

		$comname   =  trim($_POST['comname']);

		$rows	=  $companyM -> getChCompanyList(array('name'=>array('like',$comname), 'shortname'=>array('like',$comname,'OR')));

		$html 	=  '<option value="">请选择</option>';

		foreach ($rows as $v){

			$html .= '<option value="'.$v['uid'].'">'.$v['name'].'</option>';

		}

		echo $html;
	}

	//根据选择的企业展示前台可以显示的职位列表
	function getjoblist_action(){

		$JobM	=	$this->MODEL('job');

		$comid 	= 	intval($_POST['comid']);

		$rows	=	$JobM -> getList(array('uid'=>$comid,'state'=>'1','r_status'=>array('<>','2'),'status'=>array('<>','1')));

		$html 	= '';

		foreach ($rows['list'] as $v){

			$html .= '<input type="checkbox" name="zphjob[]" value="'.$v['id'].'" title="'.$v['name'].'">';

		}
		echo $html;
	}

	//保存参会企业
	function comaddsave_action(){

		$zphnetM  =  $this->MODEL('zphnet');

		$_POST['uid']	=	intval($_POST['comid']);

		$_POST['zid']	=	intval($_POST['zphid']);

		$return  =  $zphnetM -> addZphnetCom($_POST);

		$this -> ACT_layer_msg($return['msg'],$return['errcode'],'index.php?m=admin_zphnet&c=com&id='.(int)$_POST['zphid'],2,1);
	}

	// 添加推荐企业分类
	function getClass_action(){

	    $zphnetM   =  $this->MODEL('zphnet');
	    $where     =  array('keyid'=>0,'orderby'=>'sort,desc');
	    $position  =  $zphnetM->getClassList($where);
	    $this -> yunset('position',$position);
	    $this -> yuntpl(array('admin/admin_zphnet_class'));
	}

	//分类管理
	function classManage_action()
	{
	    $zphnetM   =  $this->MODEL('zphnet');
	    //查询子类别
	    if($_GET['id']){
	        $id					 =	$_GET['id'];
	        $whereOne['id']		 =	$id;
	        $whereTwo['keyid']	 =	$id;
	        $whereTwo['orderby'] =	'sort,desc';
	        $onejob				 = 	$zphnetM->getClass($whereOne);
	        $twojob				 =	$zphnetM->getClassList($whereTwo);
	        $this->yunset('id',$id);
	        $this->yunset('onejob',$onejob);
	        $this->yunset('twojob',$twojob);
	    }
	    $position				=	$zphnetM->getClassList(array('keyid'=>'0'));
	    $this->yunset('position',$position);
	    $this->yuntpl(array('admin/admin_zphnet_class'));

	}

	//添加推荐类别保存
	function saveClass_action(){

	    $arr  =  array(
	        'ctype'  =>  $_POST['stype'],
	        'name'   =>  explode('-',$_POST['name']),
	        'keyid'  =>  $_POST['nid']
	    );

	    $zphnetM  =  $this->MODEL('zphnet');
	    $return   =  $zphnetM->addClass($arr);

	    echo $return['msg'];die;
	}

	// 推荐类别名称修改
	function ajax_action()
	{
	    if($_POST['id']){
	        $zphnetM  =  $this->MODEL('zphnet');

	        if (!empty($_POST['name'])){
	            $uparr['name']  =  $_POST['name'];
	        }
	        if (!empty($_POST['sort'])){
	            $uparr['sort']  =  $_POST['sort'];
	        }

	        $zphnetM->upClass(array('id'=>$_POST['id']),$uparr);
	        echo '1';
	        die;
	    }
	}

	// 删除推荐类别
	function delZphnetClass_action()
	{
	    $whereData	=	array();
	    if(isset($_GET['delid'])){
	        $this->check_token();
	        $delid  =  intval($_GET['delid']);
	    }
	    if($_POST['del']){

	        $delid  =  $_POST['del'];
	    }
	    $zphnetM  =  $this->MODEL('zphnet');
	    $return	  =	 $zphnetM->delClass($delid);

	    $this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	}

	// 参会企业分配展会区域
	function setComZw_action()
	{

	    $zphnetM  =  $this->MODEL('zphnet');
	    $return	  =	 $zphnetM->upZphnetCom(array('id'=>array('in',$_POST['zphcomid'])),array('zw'=>$_POST['zw']));

	    $this->layer_msg($return['msg'],$return['errcode'],1,$_SERVER['HTTP_REFERER']);
	}
    //招聘会前台显示情况修改
    function upisopen_action(){
        if($_POST['pid']) {
            $zphnetM = $this->MODEL('zphnet');
            $return = $zphnetM->upIsOpen($_POST['pid'], $_POST['is_open']);
            $this->ACT_layer_msg($return['msg'], $return['errcode'], "index.php?m=admin_zphnet", 2, 1);
        }
    }
	
	function ajaxsort_action(){
		if($_POST['id']){
			$zphnetM  =  $this->MODEL('zphnet');
			$uparr['sort']  =  intval($_POST['sort']);
			$zphnetM->upZphnetCom(array('id'=>$_POST['id']),$uparr);
			echo '1';die;
		}
	}
}

?>