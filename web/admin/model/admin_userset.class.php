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
class admin_userset_controller extends adminCommon{
    /**
     * 会员-个人-个人设置: 个人设置
     */
	function index_action(){
	    $this -> yunset($this->MODEL('cache')-> GetCache(array('user')));
		$this -> yuntpl(array('admin/admin_user_config'));
	}
	function save_action(){
		if($_POST['config']){

		    $post  =  array(
		        'user_number'                =>  $_POST['user_number'],
		        'user_finder'                =>  $_POST['user_finder'],
		        'sy_rname_num'               =>  $_POST['sy_rname_num'] ? $_POST['sy_rname_num'] : 10,
		        'user_work_regiser'          =>  $_POST['user_work_regiser'],
		        'user_edu_regiser'           =>  $_POST['user_edu_regiser'],
		        'user_project_regiser'       =>  $_POST['user_project_regiser'],
		        'user_integrity_eighty'      =>  $_POST['user_integrity_eighty'],
		        'user_trust_number'          =>  $_POST['user_trust_number'],
		        'user_state'                 =>  $_POST['user_state'],
                'user_revise_state'          =>  $_POST['user_revise_state'],
		        'resume_status'              =>  $_POST['resume_status'],
				'resume_open_check'          =>  $_POST['resume_open_check'],
		        'user_resume_status'         =>  $_POST['user_resume_status'],
		        'user_height_resume'         =>  $_POST['user_height_resume'],
		        'user_idcard_status'         =>  $_POST['user_idcard_status'],
		        'user_msg_status'		 	 =>	 $_POST['user_msg_status'],
		        'com_resume_partapply'       =>  $_POST['com_resume_partapply'],
		        'resume_sx'                  =>  $_POST['resume_sx'],
		        'user_trust_status'          =>  $_POST['user_trust_status'],
		        'user_photo_status'          =>  $_POST['user_photo_status'],
		        'rshow_photo_status'         =>  $_POST['rshow_photo_status'],
		        'user_name'                  =>  $_POST['user_name'],
		        'user_pic'                   =>  $_POST['user_pic'],
		        'user_sqintegrity'           =>  $_POST['user_sqintegrity'],
		        'resume_create_edu'          =>  $_POST['resume_create_edu'],
		        'resume_create_exp'          =>  $_POST['resume_create_exp'],
		        'resume_create_project'      =>  $_POST['resume_create_project'],
		        'educreate'                  =>  $_POST['educreate'],
		        'expcreate'                  =>  $_POST['expcreate'],
		        'sy_user_visit_resume'       =>  $_POST['sy_user_visit_resume'],
		        'sy_shresume_applyjob'		 =>	 $_POST['sy_shresume_applyjob'],
		        'sy_resumename_num'		 	 =>	 $_POST['sy_resumename_num'],
		    );
		    $configM  =  $this -> MODEL('config');

		    $configM -> setConfig($post);
		    
		    $this -> web_config();
		    
	        $this -> ACT_layer_msg('配置修改成功！',9,1,2,1);
		}
	}
	/**
	 * 会员-个人-个人设置: 头像设置
	 */
	function logo_action(){
		$this -> yuntpl(array('admin/admin_userlogo'));
	}
	/**
	 * 会员-个人-个人设置: 保存头像
	 */
	function saveLogo_action(){


	    if($_POST['submit']){
	        
	        $return = array();
            
            $man_addpicArr	=	array();

            $manicon_sys = !empty($_POST['manicon_sys']) ? $_POST['manicon_sys']:array();

            $woman_addpicArr	=	array();

            $womanicon_sys = !empty($_POST['womanicon_sys']) ? $_POST['womanicon_sys']:array();

            if(is_array($_POST['preview_man'])){
                
                $preview_manArr		=	$_POST['preview_man'];
                
                $UploadM  =  $this->MODEL('upload');

                foreach($preview_manArr as $pk=>$pv){
                    
                    if (!empty($pv)){
                        
                        $upArr   =  array(
                            'dir'      =>  'logo',
                            'base'	   =>  $pv
                        );
                        
                        $result  =  $UploadM -> newUpload($upArr);
                        
                        if (!empty($result['msg'])){
                            
                            $return['msg']      =  $result['msg'];
                            $return['errcode']  =  '8';
                            
                            

                        }else if(!empty($result['picurl'])){
                            
                            $man_addpicArr[]  =  $result['picurl'];
                        }
                    }
                }
            }
            if(is_array($_POST['preview_woman'])){
                
                $preview_womanArr	=	$_POST['preview_woman'];
                
                $UploadM  =  $this->MODEL('upload');

                foreach($preview_womanArr as $pwk=>$pwv){
                    
                    if (!empty($pwv)){
                        
                        $upArr   =  array(
                            'dir'      =>  'logo',
                            'base'	   =>  $pwv
                        );
                        
                        $result  =  $UploadM -> newUpload($upArr);
                        
                        if (!empty($result['msg'])){
                            
                            $return['msg']      =  $result['msg'];
                            $return['errcode']  =  '8';
                            
                        }else if(!empty($result['picurl'])){
                            
                            $woman_addpicArr[]  =  $result['picurl'];
                        }
                    }
                }

            }

            if(!empty($return)){
            	$this -> ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
            }

			$manicon 	= 	array_merge($manicon_sys,$man_addpicArr);
			$manicon 	= 	array_slice($manicon,0,6);
            if (empty($manicon)){
                $this -> ACT_layer_msg('至少保留一份默认头像',8,$_SERVER['HTTP_REFERER'],2,1);
            }
            $womanicon 	= 	array_merge($womanicon_sys,$woman_addpicArr);
            $womanicon 	= 	array_slice($womanicon,0,6);
            if (empty($womanicon)){
                $this -> ACT_layer_msg('至少保留一份默认头像',8,$_SERVER['HTTP_REFERER'],2,1);
            }
            $memberlogo =	array(
                'sy_member_icon_arr'	=>	!empty($manicon) ? serialize($manicon) : '',
            	'sy_member_icon' 		=>	!empty($manicon[0])?$manicon[0]:'',
                'sy_member_iconv_arr'	=>	!empty($womanicon) ? serialize($womanicon) : '',
            	'sy_member_iconv' 		=>	!empty($womanicon[0])?$womanicon[0]:'',
            );
            
            $configM    =   $this->MODEL("config");

            $configM -> setConfig($memberlogo);

            $this -> web_config();
	        
	        $this -> ACT_layer_msg('会员头像配置设置成功！',9,$_SERVER['HTTP_REFERER'],2,1);
	    }
	}
 
	/**
	 * 会员-个人-个人设置: 积分设置
	 */
	function saveSet_action(){
	    
	    if($_POST['config']){
	        
	        $post  =  array(
	            'integral_add_resume'       =>  $_POST['integral_add_resume'],
	            'integral_identity'         =>  $_POST['integral_identity']
	        );
	        $configM  =  $this -> MODEL('config');
	        
	        $configM -> setConfig($post);
	        
	        $this -> web_config();
	        
	        $this -> ACT_layer_msg('配置修改成功！',9,1,2,1);
	    }
	}
	/**
	 * 会员-个人-个人设置: 消费设置
	 */
	function userspend_action(){
		$this -> yuntpl(array('admin/admin_integral_spend'));
	}
	/**
	 * 会员-个人-个人设置: 消费设置保存
	 */
	function saveSpend_action(){
	    
	    if($_POST['config']){
	        
	        $post  =  array(
	            'integral_resume_top_type'  =>  $_POST['integral_resume_top_type'],
	            'integral_resume_top'       =>  $_POST['integral_resume_top'],
	            'pay_trust_resume'          =>  $_POST['pay_trust_resume'],
	        );
	        $configM  =  $this -> MODEL('config');
	        
	        $configM -> setConfig($post);
	        
	        $this -> web_config();
	        
	        $this -> ACT_layer_msg('配置修改成功！',9,1,2,1);
	    }
	}
}
?>