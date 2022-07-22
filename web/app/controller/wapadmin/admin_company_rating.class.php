<?php
/*
 * Created on 2012
 * Link for shyflc@qq.com
 */
class admin_company_rating_controller extends adminCommon{
	function index_action(){
		$CompanyM	=	$this -> MODEL('company');
		if(trim($_GET['keyword'])){
			$where['name']		=	array('like',trim($_GET['keyword']));
			$urlarr['keyword']	=	$_GET['keyword'];
		}
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM	=	$this  -> MODEL('page');
		$pages	=	$pageM -> pageList('company',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
			$where['orderby']	=	'uid';
			$where['limit']		=	$pages['limit'];
			$rows				=	$CompanyM -> getChCompanyList($where);
		}
        $this->yunset("rows",$rows);
		$this->yunset("headertitle","设置会员等级");
		$this->yunset('backurl','index.php');
		$this->yuntpl(array('wapadmin/admin_company_rating'));
	}

	function ratingshow_action(){
		$StatisM	=	$this -> MODEL('statis');
		$RatingM	=	$this -> MODEL('rating');
		$CompanyM	=	$this -> MODEL('company');
		$UserinfoM	=	$this -> MODEL('userinfo');
		$JobM		=	$this -> MODEL('job');
		if(intval($_GET['id'])){
			//会员等级
			$rating_list	=	$RatingM -> getList(array('category'=>'1','display'=>'1'));
			$statis			=	$StatisM -> getInfo(intval($_GET['id']),array('usertype'=>'2'));
			$row			=	$CompanyM -> getInfo(intval($_GET['id']));
			$com_info		=	$UserinfoM -> getInfo(array('uid'=>intval($_GET['id'])));
			$rating_info	=	$RatingM -> getInfo(array('id'=>intval($_GET['id'])));
			$this->yunset("statis",$statis);
			$this->yunset("rating_list",$rating_list);
			$this->yunset("row",$row);
			$this->yunset("com_info",$com_info);
		}
		if($_POST['com_update']){
			if($_POST['delaytime'] && $_POST['oldetime']){
				$_POST['vip_etime']	=	strtotime($_POST['delaytime']);
			}else{
				$_POST['vip_etime']	=	intval($_POST['oldetime']);
			}
			
			if($statis['rating'] == $_POST['ratingid']){
                
                 $_POST['vip_stime'] = intval($_POST['oldstime']);
                
            }else{
                
                $_POST['vip_stime'] = time();
                
            }

			$postData	=	array(
				'rating'			=>	$_POST['ratingid'],
				'integral'			=>	$_POST['integral'],
				'vip_etime'			=>	$_POST['vip_etime'],
				'vip_stime'			=>	$_POST['vip_stime'],
				'job_num'			=>	$_POST['job_num'],
				'down_resume'		=>	$_POST['down_resume'],
				'invite_resume'		=>	$_POST['invite_resume'],
				'breakjob_num'		=>	$_POST['breakjob_num'],
				'zph_num'			=>	$_POST['zph_num'],
				'top_num'			=>	$_POST['top_num'],
				'urgent_num'		=>	$_POST['urgent_num'],
				'rec_num'			=>	$_POST['rec_num'],
				'sons_num'			=>	$_POST['sons_num'],
				'rating_type'		=>	$_POST['rating_type'],
				'rating_name'		=>	$_POST['name'],
			);
			
			if($statis['rating'] != $_POST['rating'] || ($statis['rating'] == $_POST['rating'] && !isVip($statis['vip_etime']) && (int)$_POST['addday'] == 0)){
				$id	=	$StatisM -> upInfo($postData,array('uid'=>intval($_POST['uid']),'usertype'=>'2','adminedit'=>'1','info'=>$rating_info));
			}else{
				$id	=	$StatisM -> upInfo($postData,array('uid'=>intval($_POST['uid']),'usertype'=>'2'));
			}
			if($id){
				$data['msg']	=	"修改成功！";
			}else{
				$data['msg']	=	"修改失败！";
			}
			$data['url']		=	'index.php?c=admin_company_rating';
			$this->yunset("layer",$data);
		}
		$this->yunset('backurl','index.php?c=admin_company_rating');
		$this->yunset("headertitle","设置等级");
        $this->yuntpl(array('wapadmin/admin_rating_show'));
	}
	function getrating_action(){
		if($_POST['id']){
			$ratingM	=	$this -> MODEL('rating');
			$rating		=	$ratingM->getInfo(array('id'=>intval($_POST['id']),'category'=>'1'));
			if($rating['service_time']>0){
				$rating['oldetime'] = time()+$rating['service_time']*86400;
				$rating['vipetime'] = date("Y-m-d",(time()+$rating['service_time']*86400));
			}else{
				$rating['oldetime'] = 0;
				$rating['vipetime'] = '不限';
			}
			echo json_encode($rating);
		}
	}
}

?>