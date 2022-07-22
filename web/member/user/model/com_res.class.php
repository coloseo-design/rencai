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
class com_res_controller extends user{
	/*lgl  个人向网站委托简历  2014-04-24*/
	function index_action(){
		$resumeM	=	$this->MODEL('resume');
		
		$resume		=	$resumeM->getResumeInfo(array('uid'=>$this->uid),array('field'=>'`telphone`'));
		
		$expect		=	$resumeM->getSimpleList(array('uid'=>$this->uid),array('field'=>'`name`,`doc`,`lastupdate`,`defaults`,`id`,`is_entrust`'));

		if(is_array($expect)&& !empty($expect)){
			$html="";
			foreach($expect as $val){
				if($val['doc']){
					$doc_type		=	'快速简历';
				}else{
					$doc_type		=	'标准简历';
				}
				if($val['is_entrust']=='1'){
					
					$entrust		=	"<a href='javascript:void(0)' onclick=\"entrust('确定取消？','".$val['id']."')\">取消委托</a>";
					$status="已申请";
					
				}else if($val['is_entrust']=='2'){
					
					$entrust		=	"<a href='javascript:void(0)' onclick=\"entrust('委托已通过审核，取消将不退还金额，确定取消？','".$val['id']."')\">取消委托</a>";
					$status			=	"已通过";
					
				}else if($val['is_entrust']=='3'){
					
					if($this->config['pay_trust_resume']!=0){
						
						$entrust	=	"<a href='javascript:void(0)' onclick=\"entr_resume('".$val['id']."')\">委托</a>";
					}else{
						
						$entrust	=	"<a href='javascript:void(0)' onclick=\"entr_resume_free('".$val['id']."')\">委托</a>";
					}
					$status			=	"未通过";
				}else{
					if($this->config['pay_trust_resume']!=0){
						
						$entrust	=	"<a href='javascript:void(0)' onclick=\"entr_resume('".$val['id']."')\">委托</a>";
					}else{
						
						$entrust	=	"<a href='javascript:void(0)' onclick=\"entr_resume_free('".$val['id']."')\">委托</a>";
 					}
					
					$status			=	"未申请";
				}
				$html.="<tr class=\"result_class\"><td>".mb_substr($val['name'],0,8,"utf-8")."</td><td>".$resume['telphone']."</td><td><span>".$doc_type."</span></td><td>".$val['lastupdate']."</td><td>".$status."</td><td>".$entrust."</td></tr>";
			}
			echo $html;die;
		}else{
			echo 1;die;
		}
	}
	//个人pc取消委托简历
	function canceltrust_action(){
		$entrustM	=	$this->MODEL('userEntrust');
		
		$data		=	array(
			'uid'		=>	$this->uid,
			'id'		=>	intval($_POST['id']),
			'did'		=>	$this->userdid,
			'username'	=>	$this->username
		);
		
		$return		=	$entrustM->cancelEntrust($data);
		echo json_encode($return);die;
	}
}
?>