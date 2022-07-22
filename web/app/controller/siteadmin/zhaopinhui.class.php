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
class zhaopinhui_controller extends siteadmin_controller{
	//设置高级搜索功能
	function set_search(){
		
		$search_list[]	=	array("param" => "status","name" => '审核状态',"value" => array("3" => "未开始","1" => "已开始","2" => "已结束"));
		
		$this -> yunset("search_list",$search_list);
	
	}
	
	function index_action(){
		
		$this -> set_search();
		
		$ZphM	=	$this->MODEL('zph');
		
		if($_GET['news_search']){
			
			if ($_GET['type'] == '2'){
				
				$where['address']	=	array('like',trim($_GET['keyword']));
			
			}else{
				
				$where['title']		=	array('like',trim($_GET['keyword']));
			
			}
			
			$urlarr['type']			=	$_GET['type'];
			
			$urlarr['keyword']		=	$_GET['keyword'];
			
			$urlarr['news_search']	=	$_GET['news_search'];
		
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
		
		$urlarr['page']	=	"{{page}}";
		
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		
		$pageM			=	$this -> MODEL('page');
		
		$pages			=	$pageM -> pageList('zhaopinhui',$where,$pageurl,$_GET['page']);
		
		if($pages['total'] > 0){	        
			
			$where['orderby']		=	'id';                         
			
			$where['limit']			=	$pages['limit'];                  
			
			$rows  					=  $ZphM -> getList($where);           
		
		}

		$this -> yunset("get_type", $_GET);
		
		$this -> yunset("rows",$rows);
		
		$this -> siteadmin_tpl(array('admin_zhaopinhui_list'));
	
	}
	
	function add_action(){
		
		$ZphM	=	$this->MODEL('zph');
		
		if(intval($_GET['id'])){
			
			$info	=	$ZphM -> getInfo(array('id' => intval($_GET['id'])),array('pic'=>1,'banner'=>1));
			
			$this -> yunset("lasturl",$_SERVER['HTTP_REFERER']); 
		}
		
		$space	=	$ZphM -> getZphSpaceList(array('keyid'=>'0'));
		
		$this -> yunset("info",$info);
		
		$this -> yunset("space",$space);
		
		$this->siteadmin_tpl(array('admin_zhaopinhui_add'));
	}

	function save_action(){
		
		$ZphM	=	$this -> MODEL('zph');
		
		if($_FILES){
		    // pc端上传
		    if($_FILES['sl']['tmp_name']){
		    	$upArrsl    =  array(
			        'file'  =>  $_FILES['sl'],
			        'dir'   =>  'zhaopinhui'
			    );
		    }
		    if($_FILES['hf']['tmp_name']){
		    	$upArrhf    =  array(
			        'file'  =>  $_FILES['hf'],
			        'dir'   =>  'zhaopinhui'
			    );
		    }
		    
		    $uploadM  =  $this->MODEL('upload');
		    if(!empty($upArrsl)){
		    	$picsl      =  $uploadM->newUpload($upArrsl);
		    }
		    if(!empty($upArrhf)){
		    	$pichf      =  $uploadM->newUpload($upArrhf);
		    }
			
		    if ( ($picsl && !empty($picsl['msg'])) || ($pichf && !empty($pichf['msg'])) ){
		        
		        $return['msg']	    =  $picsl['msg'] ? $picsl['msg'] : $pichf['msg'];
		        
		        $this -> ACT_layer_msg($return['msg'],8);
		        
		    }else{
		    	if (!empty($picsl['picurl'])){
		        
			        $_POST['is_themb']  =  $picsl['picurl'];

			    }
			    if (!empty($pichf['picurl'])){
		        
			        $_POST['banner']  =  $pichf['picurl'];

			    }
		    }
		}
		
		
		if($_POST['time']){
			
			$times	=	@explode('~',$_POST['time']);
			
			$_POST['starttime']	=	$times[0];
			
			$_POST['endtime']	=	$times[1];
			
			unset($_POST['time']);
		
		}
		
		$_POST['body']			=	str_replace("&amp;","&",$_POST['body']);
		
		$_POST['media']			=	str_replace("&amp;","&",$_POST['media']);
		
		$_POST['packages']		=	str_replace("&amp;","&",$_POST['packages']);
		
		$_POST['booth']			=	str_replace("&amp;","&",$_POST['booth']);
		
		$_POST['participate']	=	str_replace("&amp;","&",$_POST['participate']);
		
		$_POST['did']			=	$this->config['did'];
		
		if(strtotime($_POST['starttime'])>strtotime($_POST['endtime'])){
			
			$this -> ACT_layer_msg('开始时间不得大于结束时间',8);
		
		}
		
		if($_POST['id']){
			
			$nbid	=	$ZphM -> upInfo(array('id'=>intval($_POST['id'])),$_POST);
			
			isset($nbid)?$this->ACT_layer_msg("招聘会(ID:".$_POST['id'].")修改成功！",9,"index.php?m=zhaopinhui",2,1):$this->ACT_layer_msg("招聘会(ID:".$_POST['id'].")修改失败！",8,"index.php?m=zhaopinhui");
		
		}else{
			
			$nbid	=	$ZphM -> addInfo($_POST);
			
			isset($nbid)?$this->ACT_layer_msg("招聘会(ID:$nbid)添加成功！",9,"index.php?m=zhaopinhui",2,1):$this->ACT_layer_msg("招聘会(ID:$nbid)添加失败！",8,"index.php?m=zhaopinhui");
		}
	
	}
	
	function del_action(){
		
		if($_GET['id']){
			
			$this -> check_token();
			
			$delID   =  intval($_GET['id']);
		
		}elseif($_POST['del']){
			 
			$delID   =  $_POST['del'];
		
		}
		
		$ZphM	=	$this -> MODEL('zph');
		
		$return	=	$ZphM -> delZph($delID);
		
		$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	}
	
	function upload_action(){
		
		$ZphM	=	$this->MODEL('zph');
		
		if($_GET['editid']){
			
			$editrow	=	$ZphM -> getZphPicInfo(array('id'=>$_GET['editid']));
			
			$this -> yunset("editrow",$editrow);
			
			$id	  =	 $editrow['zid'];
		
		}

		$row	=	$ZphM -> getInfo(array('id'=>$_GET['id']));
		
		$this -> yunset("row",$row);
		
		$where['zid']	=	$_GET['id'];
		
		$urlarr['c']	=	$_GET['c'];
		
		$urlarr['page']	=	"{{page}}";
		
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		
		$pageM	=	$this -> MODEL('page');
		
		$pages	=	$pageM -> pageList('zhaopinhui_pic',$where,$pageurl,$_GET['page']);
		
		if($pages['total'] > 0){	                 
			                       
			$where['limit']	=	$pages['limit'];                  
			
			$rows	=  $ZphM -> getZphPicList($where); 
		}
		
		$this -> yunset("rows",$rows);
		
		$this->siteadmin_tpl(array('admin_zhaopinhui_upload'));
	
	}

	function uploadsave_action(){
		
		$ZphM		=	$this->MODEL('zph');
		
		$_POST		=	$this->post_trim($_POST);
		
		$id			=	$_POST['id'];
		
		
		if($_FILES['file']['tmp_name']!=''){
			// pc端上传
			$upArr    =  array(
				'file'  =>  $_FILES['file'],
				'dir'   =>  'zhaopinhui'
			);

			$uploadM  =  $this->MODEL('upload');
			$pic      =  $uploadM->newUpload($upArr);

			if (!empty($pic['msg'])){

				$this -> ACT_layer_msg($pic['msg'],8);

			}elseif (!empty($pic['picurl'])){

				$_POST['pic']         =   $pic['picurl'];
			}
        }

		if($_POST['add']){
			
			
			
			$row	=	$ZphM -> getInfo(array('id'=>intval($_POST['zid'])),array('field'=>'`did`'));
			
			$_POST['did']	=	$row['did'];
			
			$nbid	=	$ZphM -> addZphPicInfo($_POST);
			
			isset($nbid)?$this->ACT_layer_msg("招聘会图片(ID:".$nbid.")添加成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("添加失败！",8,$_SERVER['HTTP_REFERER']);
		
		}
		
		if($_POST['update']){
			
			
			$nbid	=	$ZphM -> upZphPicInfo(array('id'=>$id),$_POST);
			
			isset($nbid)?$this->ACT_layer_msg("招聘会图片(ID:".$id.")修改成功！",9,"index.php?m=zhaopinhui&c=upload&id=".intval($_POST['zid'])."",2,1):$this->ACT_layer_msg("修改失败！",8,"index.php?m=zhaopinhui&c=upload&id=".intval($_POST['zid'])."");
		
		}
	
	}

	function setthemb_action(){
		
		$ZphM	=	$this -> MODEL('zph');
		
		$row	=	$ZphM -> getSetThembInfo(array('id'=>$_POST['id']));
		
		echo Url('zhaopinhui',array('c'=>'upload','id'=>$row['zid']),'admin');
	
	}
	
	function pic_action(){
		
		$ZphM	=	$this->MODEL('zph');
		
		$id		=	$_GET['delid'];
		
		if($id){
			
			$this -> check_token();
			
			$delid	=	$ZphM -> delZphPic(array('id'=>$id));
			
			$delid?$this->layer_msg("招聘会图片(ID:".$_GET['delid'].")删除成功！",9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
		
		}
	
	}
	
	//设置高级搜索功能
	function set_searchs(){	
		
		$search_list[]	=	array("param"=>"status","name"=>'审核状态',"value"=>array("3"=>"未审核","1"=>"已通过","2"=>"未通过"));
		
		$this -> yunset("search_list",$search_list);
	
	}
	
	function com_action(){
		
		$this->set_searchs();
		
		$ZphM	=	$this->MODEL('zph');
		
		$type	=	array('1'=>'招聘会名称','2'=>'企业名称');
		
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
		
		if ($_GET['type']){
			
			if($_GET['type']==1){
				
				if (trim($_GET['keyword'])){
					
					$zph	=	$ZphM -> getList(array('title'=>array('like',trim($_GET['keyword']))),array('field'=>'id'));
					
					if($zph){
						
						foreach($zph as $v){
							
							$zid[]	=	$v['id'];
						
						}
						
						$where['zid']	=	array('in',pylode(',', $zid));
					
					}
				
				}
			
			}elseif($_GET['type']==2){
				
				if (trim($_GET['keyword'])){
					
				    $companyM  =  $this->MODEL('company');
				    $company   =  $companyM->getChCompanyList(array('name'=>array('like',trim($_GET['keyword']))),array('field'=>'uid'));
					
					if($company){
						
						foreach($company as $v){
							
							$uid[]	=	$v['uid'];
						
						}
						
						$where['uid']	=	array('in',pylode(',', $uid));
					
					}
				
				}
			
			}
			
			$urlarr["keyword"]	=	$_GET["keyword"];
			
			$urlarr["type"]		=	$_GET["type"];
		
		}
		
		$urlarr['c']	=	$_GET['c'];
		
		$urlarr['page']	=	"{{page}}";
		
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		
		$pageM	=	$this  -> MODEL('page');
		
		$pages	=	$pageM -> pageList('zhaopinhui_com',$where,$pageurl,$_GET['page']);
		
		if($pages['total'] > 0){	                 
			
			$where['orderby']		=	array('status,asc','id,desc');                         
			
			$where['limit']			=	$pages['limit'];                  
			
			$rows   =  $ZphM -> getZphCompanyList($where);     
			
			if($rows){
				
				$space		=	$ZphM -> getZphSpaceList();
				
				$spacearr	=	array();
				
				foreach($space as $val){
					
					$spacearr[$val['id']]	=	$val['name'];
				
				}
			
			}
			
			session_start();
			
			$_SESSION['zphXLs']	=	$where;
		
		}
		
		$this -> yunset("spacearr",$spacearr);
		
		$this -> yunset("rows",$rows);
		
		$this->siteadmin_tpl(array('admin_zhaopinhui_com'));
	
	}
	
	function sbody_action(){
		
		$ZphM	=	$this -> MODEL('zph');
		
		$zhaopinhui_com		=		$ZphM->getZphComInfo(array('id'=>intval($_POST['id'])),array('field'=>'statusbody'));
		
		echo $zhaopinhui_com['statusbody'];die;
	
	}
	function status_action(){
		
		$ZphM	=	$this -> MODEL('zph');
		
		$data['status']		=	$_POST['status'];
		
		$data['statusbody']	=	trim($_POST['statusbody']);
		
		$id					=	 @explode(",",$_POST['pid']);
		
		$nid				=	 $ZphM -> upZphCom($id,$data);
		
		$nid?$this->ACT_layer_msg("招聘会(ID:".$_POST['pid'].")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
	}
	
	function comxls_action(){
		
		$ZphM			=	$this -> MODEL('zph');
		
		$CompanyM		=	$this -> MODEL('company');
		
		$JobM			=	$this -> MODEL('job');
		
		if($_POST['zid']&&$_POST['cid']){
			
			$space		=	$ZphM -> getZphSpaceList();
			
			$spacearr	=	array();
			
			foreach($space as $val){
				
				$spacearr[$val['id']]	=	$val['name'];
			
			}
			
			$this -> yunset("spacearr",$spacearr);
			
			include PLUS_PATH."/com.cache.php";
			
			include PLUS_PATH."/city.cache.php";
			
			$rows		=	$ZphM -> getZphCompanyList(array('id'=>array('in',$_POST['cid'])));
			
			if(!empty($rows)){
				
				foreach ($rows as $val){
					
					$comids[] 				= 	$val['uid'];
					
					$jobids[] 				= 	$val['jobid'];
					
					$jobcount[$val['uid']]  = 	count(array_filter(explode(',',$val['jobid'])));
					
					$comSpace[$val['uid']]	= 	array('sid'=>$val['sid'],'cid'=>$val['cid'],'bid'=>$val['bid']);		
				
				}
				
				asort($jobcount);

				$maxJobNum					=	end($jobcount)?end($jobcount):1;
				
				$companys					=	$CompanyM -> getChCompanyList(array('uid'=>array('in',@implode(",",$comids))));
				
				$jobsA						=	$JobM -> getList(array('id'=>array('in',@implode(",",$jobids)),'groupby'=>'id'));
				$jobs						=	$jobsA['list'];
				
				if(is_array($jobs)){

					foreach($jobs as $k1 => $v1){
						
						$jobs[$k1]['number']		=	$comclass_name[$v1['number']];
							
						if(!empty($v1['maxsalary'])){
							
							$jobs[$k1]['salary']	=	$v1['minsalary'].'-'.$v1['maxsalary'];
						
						}else if(!empty($v1['minsalary'])){
							
							$jobs[$k1]['salary']	=	$v1['minsalary'];
						
						}else{
							
							$jobs[$k1]['salary']	=	"面议";
						
						}
							
						$jobs[$k1]['exp'] 			=	$comclass_name[$v1['exp']];
						
						$jobs[$k1]['edu'] 			=	$comclass_name[$v1['edu']];

						if($v1['three_cityid']){
							
							$jobs[$k1]['citys']		=	$city_name[$v1['provinceid']].'-'.$city_name[$v1['cityid']].'-'.$city_name[$v1['three_cityid']];
						
						}else{
							
							$jobs[$k1]['citys']		=	$city_name[$v1['provinceid']].'-'.$city_name[$v1['cityid']];
						
						}
						
						$comJobs[$v1['uid']][] 		=	$jobs[$k1];
  						 
					}

					$this->yunset("jobs",$jobs);
				}

				foreach($companys as $k=>$va){

					$companys[$k]['content']	=	trim(strip_tags($va['content']));
					
					$companys[$k]['mun']		=	$comclass_name[$va['mun']];
					
					$companys[$k]['jobs']		=	$comJobs[$va['uid']];
					
					$companys[$k]['space']		=	$comSpace[$va['uid']];
				
				}
				
				$jobTr = $jobSonTr = '';

				for($i=1;$i<=$maxJobNum;$i++){
					
					$jobTr .= '<th colspan="6">岗位'.$i.'</th>';

					$jobSonTr .= '<th>招聘岗位</th><th>招聘人数</th><th>薪酬</th><th>经验要求</th><th>学历要求</th><th>工作地点</th>';
				}
				
				$this -> yunset("jobTr",$jobTr);
				
				$this -> yunset("jobSonTr",$jobSonTr);
 				
				$this -> yunset("list",$companys);
				
				$this -> MODEL('log') -> addAdminLog("导出报名招聘会信息");
				
				header("Content-Type: application/vnd.ms-excel");
				
				header("Content-Disposition: attachment; filename=zhaopinhuicom.xls");
				
				$this->siteadmin_tpl(array('admin_zhaopinhui_comxls'));
			
			}else{
				
				$this->ACT_layer_msg("没有可以导出的参会企业信息！",8,$_SERVER['HTTP_REFERER']);
			
			}
		
		}
	
	}
	//删除链接
	function delcom_action(){
		
		$ZphM	=	$this->MODEL('zph');
		
		if($_GET['delid']){
			
			$this -> check_token();
			
			$delID	=	intval($_GET['delid']);
		
		}elseif($_POST['del']){
			
			$delID	=	$_POST['del'];
		
		}
		
		$list	=	$ZphM -> getZphCompanyList(array('status'=>'0','price'=>array('>','0'),'id'=>array('in',$delID)));
		
		if(is_array($list)){
			
			foreach($list as $v){
				
				$IntegralM	=	$this->MODEL('integral');
				
				$IntegralM -> company_invtal($v['uid'],2,$v['price'],true,"删除招聘会",true,2,'integral');//积分操作记录
			
			}
		
		}
		
		$arr	=	$ZphM -> delZphCom($delID,array('utype'=>'admin'));
		
		$this -> layer_msg($arr['msg'], $arr['errcode'], $arr['layertype'],$_SERVER['HTTP_REFERER']);

	}
	
	//获取展位
	function getzhanwei_action(){
		
		$ZphM=$this->MODEL('zph');
		
		if($_POST['sid']){
			
			$com_bid	=	$ZphM -> getZphCompanyList(array('zid'=>intval($_POST['zid'])));
			
			foreach($com_bid as $v){
				
				$com_bid[]	=	$v['bid'];
			
			}
			
			$linkarr	=	$ZphM->getInfo(array('id'=>intval($_POST['zid'])));
			
			$reserved	=	@explode(',',$linkarr['reserved']);
			
			$list		=	$ZphM->getZphSpaceList(array('keyid'=>intval($_POST['sid'])));
			
			if(is_array($list)){
				
				$html   ='<div class="zph_zw_box"><table cellspacing="2" cellpadding="3" class="zp_zw_table">';
				
				foreach($list as $v){
					
					$html.='<tr class="zp_zw_title"><td colspan="6">'.$v[name].'</td></tr>';
					
					$html.='<tr>';
					
					$rows	=	$ZphM -> getZphSpaceList(array('keyid'=>$v['id'],'orderby'=>'sort,asc'));
					
					foreach($rows as $key=>$val){

						$ck=''; $dis='';

						if(in_array($val[id],$reserved)){
							
							$ck		=	' checked="checked"';
						
						}

						if(in_array($val[id],$com_bid)){
							
							$dis	=	'disabled';
						}

						$html.='<td><input type="checkbox" name="zhanwei" value="'.$val[id].'" '.$ck.' '.$dis.'>'.$val[name].'</td>';
						
						if(($key+1)%6==0){
							
							$html.='</tr><tr>';
						
						}

					}
					
					$html.='</tr>';
				}
				
				$html.='</table></div>';
				
				$html.='<div class="zph_zw_box_b">
						
						<input type="button" onClick="check_zhanwei();"  value="确认" class="submit_btn">
						
						&nbsp;&nbsp;<input type="button" onClick="layer.closeAll();" class="submit_btn_hjj" value="取消"></div>';
				
				echo $html;die;
			
			}
		
		}
	
	}
	
	//添加参会企业
	function comadd_action(){
		
		$ZphM	=	$this->MODEL('zph');
		
		$zph 	=	$ZphM->getInfo(array('id'=>intval($_GET['id'])));
		
		$keyid	=	$zph['sid'];//场地id
		
		$space_cid	=	$ZphM -> getZphSpaceList(array('keyid'=>$keyid));
		
		$this -> yunset('cid',$space_cid);
		
		$this -> yunset("zph",$zph);
		
		$this->siteadmin_tpl(array('admin_zhaopinhui_comadd'));
	
	}
	
	//获取招聘会展位
	function getspacelist_action(){
		
		$ZphM		=	 $this->MODEL('zph');
		
		$cid 		= 	 intval($_POST['cid']);
		
		$zphid 		=	 intval($_POST['zphid']);
		
		$space_bid	=	 $ZphM->getZphSpaceList(array('keyid'=>$cid));
		
		$bids	=	array();$spacename	=	array();
		
		foreach ($space_bid as $v){
	        
			$bids[]					=	$v['id'];
	        
			$spacename[$v['id']]	=	$v['name'];
	        
	    }
		
		$zphcom		=	$ZphM -> getZphCompanyList(array('zid'=>$zphid,'cid'=>$cid));
		
		$combids 	= 	array();
		
		foreach ($zphcom as $v){
	       
		   $combids[]	=	$v['bid'];
	    
		}
		
		// 取全部展位和已被报名展位的差集为可选展位，没有展位的进行提示
		
		$rows 	= 	array_diff($bids, $combids);
		
		if (!empty($rows)){
	        
			$html 	= 	'<option value="">请选择</option>';
	        
			foreach ($rows as $v){
	           
			   $html .= '<option value="'.$v.'">'.$spacename[$v].'</option>';
	        
			}
	       
			echo $html;
	    
		}else{
	        
			echo 1;
	    
		}
	
	}
	
	//根据企业名称搜索企业列表
	function getcomlist_action(){
		
	    $companyM  =  $this->MODEL('company');
	    
	    $comname   =  trim($_POST['comname']);
	    
	    $rows	=  $companyM -> getChCompanyList(array('name'=>array('like',$comname)));
		
		$html 	= '<option value="">请选择</option>';
			
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
		
		$ZphM	=	$this->MODEL('zph');
		
		$zphcom	=	$ZphM->getZphComInfo(array('uid'=>intval($_POST['comid']),'zid'=>intval($_POST['zphid'])));
		
		if ($zphcom){
			
			$this -> ACT_layer_msg("该企业已参加本次招聘会！",8,'index.php?m=zhaopinhui&c=com&id='.(int)$_POST['zphid']);
		
		}else{
			
			$_POST['uid']	=	intval($_POST['comid']);
			
			$_POST['zid']	=	intval($_POST['zphid']);
			
			$_POST['jobid']	=	pylode(',', $_POST['zphjob']);
			
			$_POST['sid']	=	intval($_POST['zphsid']);
			
			$_POST['cid']	=	intval($_POST['cid']);
			
			$_POST['bid']	=	intval($_POST['bid']);
			
			$nid	=	$ZphM -> addZCom($_POST);
			
			$nid?$this->ACT_layer_msg("招聘会企业(ID:".$nid.")添加成功！",9,'index.php?m=zhaopinhui&c=com&id='.$_POST['zid'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
		
		}
	
	}
	
}

?>