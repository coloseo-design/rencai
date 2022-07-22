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
class info_controller extends company{
	function index_action(){

		$companyM	=	$this->MODEL('company');
	
		//获取1-基本信息、 2-手机认证、 3-证书认证 
		$row		=	$companyM->getInfo($this->uid,array('info'=>'1', 'edit'=>'1','logo'=>'1','utype'=>'user'));
		if(!$row['uid']){

			//获取注册信息
			$userinfoM	=   $this->MODEL("userinfo");
			$row		=	$userinfoM -> getInfo(array('uid'=>$this -> uid),array('field'=>'`moblie` as linktel,`email` as linkmail,`moblie_status`,`email_status`'));
			
		}
		$this->yunset("row",$row);
		
		$this->yunset("cert",$row['cert']);
		
		$this->public_action();
		$this->company_satic();
		$this->yunset($this->MODEL('cache')->GetCache(array('com','city','job','hy')));
 
		$this->com_tpl('info');
	}
	
	function side_action(){
		$companyM	=	$this->MODEL('company');
		
		//获取1-基本信息、 2-手机认证、 3-证书认证 
		$row		=	$companyM->getInfo($this->uid,array('info'=>'1', 'edit'=>'1','logo'=>'1','utype'=>'user'));

		if(!$row['uid']){
			//获取注册信息
			$userinfoM	=   $this->MODEL("userinfo");
			$row		=	$userinfoM -> getInfo(array('uid'=>$this -> uid),array('field'=>'`moblie` as linktel,`email` as linkmail,`moblie_status`,`email_status`'));
			
		}
		$this->yunset("row",$row);
		
		$this->yunset("cert",$row['cert']);
		if (!$this->comInfo['name']) {
			$this->yunset('isremind', 1);
			$remindInfo['url']          =   'index.php?c=info';
            $remindInfo['msg']          =   '完善企业信息有助于帮您快速招聘人才！';
            $remindInfo['title']        =   '企业基本信息尚未完善！';

            $this->yunset('remindInfo', $remindInfo);
		}
		$this->public_action();
		$this->company_satic();
		$this->yunset($this->MODEL('cache')->GetCache(array('com','city','job','hy')));
 
		$this->com_tpl('side_info');
		
	}
	function save_action(){
		$companyM  =  $this->MODEL('company');
		$company    =   $this -> comInfo['info'];
		 
		if($company){
			$rstaus     =   $company['r_status'];
		}else{
			$rstaus		=	$this->config['com_status'];
		}


		$mData     =  array(
		    'moblie'        =>  $_POST['linktel'],
		    'email'         =>  $_POST['linkmail']
		);
		
		$setData   =  array(
			'name' 			=> 	$_POST['name'], 
			'shortname' 	=> 	$_POST['shortname'], 
			'hy' 			=> 	$_POST['hy'], 
			'pr' 			=> 	$_POST['pr'], 
			'mun' 			=> 	$_POST['mun'], 
			'provinceid' 	=>	$_POST['provinceid'], 
			'cityid' 		=> 	$_POST['cityid'],
			'three_cityid' 	=> 	$_POST['three_cityid'], 
		    'address' 		=>	$_POST['address'],
		    'x' 		    =>	$_POST['x'],
		    'y' 		    =>	$_POST['y'],
		    'linkman'		=> 	$_POST['linkman'], 
			'linktel'		=>	$_POST['linktel'], 
			'linkphone' 	=> 	$_POST['linkphone'], 
			'linkmail' 		=> 	$_POST['linkmail'], 
			'sdate' 		=> 	$_POST['sdate'], 
			'moneytype' 	=> 	$_POST['moneytype'], 
			'money' 		=>	$_POST['money'], 
			'linkjob' 		=> 	$_POST['linkjob'], 
			'linkqq' 		=> 	$_POST['linkqq'], 
			'website' 		=> 	$_POST['website'], 
			'busstops' 		=> 	$_POST['busstops'], 
			'infostatus' 	=> 	$_POST['infostatus'], 
			'welfare' 		=> 	$_POST['welfare'], 
			'r_status' 		=> 	$rstaus,
			'rating'		=>	$company['rating'],
			'lastupdate'	=>  time(),
			'content'		=> 	str_replace(array('&amp;','background-color:#ffffff','background-color:#fff','white-space:nowrap;'),array('&','background-color:','background-color:','white-space:'),$_POST['content'])
		);

		$userinfoM    =   $this->MODEL("userinfo");

		if(!$this -> comInfo['info']['uid']){
			
			$userinfoM -> activUser($this -> uid,2);
		}
		 
		$return   =   $companyM -> setCompany(array('uid' => $this -> uid), array('mData' => $mData, 'comData' => $setData, 'utype' => 'user'));  
		
		//根据后台设置 修改企业资料重新审核
		if($this -> config['com_revise_status'] == '0'){

			
			$userinfoM -> status(array('uid' => $this -> uid,'usertype'=>2), array('post' => array('status' => 0)));
		
		}
		if($return['errcode'] == '9' && $_SESSION['auid'] == $this->comInfo['info']['crm_uid']){	// 绑定CRM 修改企业资料进行记录
            
			$crmM     =   $this->MODEL('crm');
			$lContent	=	"";
			
			$lKey	=	array('name','address','linkman','linktel');
			$kName	=	array('name' => '企业名称', 'hy' => '从事行业', 'pr' => '企业性质', 'mun' => '企业规模', 'address' => '详细地址', 'linkman' => '联系人', 'linktel' => '联系手机');
			
			$cacheM    	=  	$this -> MODEL('cache');
			$cache		=	$cacheM->GetCache(array('com', 'hy'));
			
			foreach($this->comInfo['info'] as $k => $v){
				if(trim($v) != trim($_POST[$k])){	
					if(in_array($k, $lKey)){
						$lContent	.=	$kName[$k]."：".$v." -> ".$_POST[$k]."；";			
					}else if(in_array($k, array('pr', 'mun'))){
						$lContent	.=	$kName[$k]."：".$cache['comclass_name'][$v]." -> ".$cache['comclass_name'][$_POST[$k]]."；";		
					}else if(in_array($k, array('hy'))){
						$lContent	.=	$kName[$k]."：".$cache['industry_name'][$v]." -> ".$cache['industry_name'][$_POST[$k]]."；";		
					}
				}
			}
			if($lContent!= ''){
				$lContent	=	'登录企业（UID：'.$this->uid.'）后台，修改基本信息资料；'.$lContent;	
				$crmM -> addCrmLog($lContent, 2, $this->uid, $_SESSION['auid']);
				
				$value    =   array(
		          
					'auid'    =>  $_SESSION['auid'],
					'uid'     =>  $this->uid,
					'type'    =>  5,  // 修改企业资料
					'content' =>  '【修改客户资料】',
					'remark'  =>  $lContent,
					'ctime'   =>  time()
				);
				$crmM -> addCrmComLog($value);
			}
		}
		
		echo json_encode($return);die;
	}
	
	/**
	* 更新公司补充信息
	*/
	function saveside_action(){
		$companyM  =  $this->MODEL('company');
		$company    =   $this -> comInfo['info'];
		if($company){
			$rstaus     =   $company['r_status'];
		}else{
			$rstaus		=	$this->config['com_status'];
		}
		$mData     =  array(
		    'moblie'        =>  $_POST['linktel'],
		    'email'         =>  $_POST['linkmail']
		);
		
		$setData   =  array(
			'shortname' 	=> 	$_POST['shortname'], 
			'sdate' 		=> 	$_POST['sdate'], 
			'moneytype' 	=> 	$_POST['moneytype'], 
			'money' 		=>	$_POST['money'], 
			'linkjob' 		=> 	$_POST['linkjob'], 
			'linkqq' 		=> 	$_POST['linkqq'], 
			'website' 		=> 	$_POST['website'], 
			'busstops' 		=> 	$_POST['busstops'], 
			'infostatus' 	=> 	$_POST['infostatus'], 
			'welfare' 		=> 	$_POST['welfare'], 
			'r_status' 		=> 	$rstaus,
			'rating'		=>	$company['rating'],
			'lastupdate'	=>  time()
		);

		$userinfoM    =   $this->MODEL("userinfo");
		if(!$this -> comInfo['info']['uid']){
			$userinfoM -> activUser($this -> uid,2);
		}
		$return   =   $companyM -> setCompanySideInfo(array('uid' => $this -> uid), array('comData' => $setData, 'utype' => 'user'));  
		
		//根据后台设置 修改企业资料重新审核
		if($this -> config['com_revise_status'] == '0'){
			$userinfoM -> status(array('uid' => $this -> uid,'usertype'=>2), array('post' => array('status' => 0)));
		}

		echo json_encode($return);die;
	}
	/**
	 * @desc 查询企业名称和手机号码是否使用
	 */
	function ajaxCheck_action(){
	    if($_POST){
	        
	        $comM      =   $this->MODEL('company');
	        
	        $typeStr   =   trim($_POST['typeStr']);
	        $checkStr  =   trim($_POST['checkStr']);
	        
	        $return    =   $comM -> getCheckUsed($this->uid, array('typeStr' => $typeStr, 'checkStr' => $checkStr));
	        
	        echo json_encode($return);die;
	    }
	}
}
?>