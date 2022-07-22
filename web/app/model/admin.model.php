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
class admin_model extends model{

    //微信模板通知类型及通知管理员
    function getWmtype($whereData,$data=array('field'=>'*')){

        $List  =  $this -> select_all('admin_wmtype',$whereData,$data['field']);

        if(!empty($List)){

            foreach($List as $k=>$v){
               $List[$k]['uid_arr']  = $v['uid'] ? @explode(',',$v['uid']) : array();
            }

        }
        
        return $List;
    }

    public function upWmtype($upData=array(),$whereData=array(),$data=array()){
        
        $return['id']  =  $this -> update_once('admin_wmtype',$upData,$whereData);

        return  $return;
    }
    /**
     * 获取管理员列表
     * @param array $whereData
     * @param array $data
     */
    public function getList($whereData,$data=array('field'=>'*')){
        
        $List  =  $this -> select_all('admin_user',$whereData,$data['field']);

        if (!empty($List)){
            
            $uids   =   $gid    =   $dids   =   array();
            
            foreach ($List as $v){
                
                if ($v['m_id']) {
                    $gid[]  =  $v['m_id'];
                }
                
                if($v['uid']){
                    $uids[] =  $v['uid'];
                }
            
                if($v['did']>0){
                    $dids[] =   $v['did'];
                }
            }

            if($data['utype']=='crm'){  //更多 =》 crm管理

                $comwhere   =   $conwhere = array();

                $comwhere['crm_uid']    =   array('in',pylode(',',$uids));
                $connwhere['crm_uid']   =   array('in',pylode(',',$uids));
                $conwhere['crm_uid']    =   array('in',pylode(',',$uids));

                if($data['crmstatis']){ //更多 =》 业务统计

                    if(!empty($data['timeBegin'])){

                        $comwhere['PHPYUNBTWSTART_A']   =   '';
                        $comwhere['crm_time'][]         =   array('>=', $data['timeBegin']);
                        $comwhere['crm_time'][]         =   array('<=', $data['timeEnd']);
                        $comwhere['PHPYUNBTWEND_A']     =   '';

                        $conwhere['PHPYUNBTWSTART_A']   =   '';
                        $conwhere['f_time'][]           =   array('>=', $data['timeBegin']);
                        $conwhere['f_time'][]           =   array('<=', $data['timeEnd']);
                        $conwhere['PHPYUNBTWEND_A']     =   '';
                    }
                }

                $company    =   $this -> select_all('company',$comwhere, '`uid`,`crm_uid`,`crm_status`');
                $conncom    =   $this -> select_all('company',$connwhere, '`uid`,`crm_uid`,`isfollow`,`f_time`');
                $concom     =   $this -> select_all('company',$conwhere, '`uid`,`crm_uid`,`isfollow`');

                // 待跟进客户
                $vitWhere   =   array();
                $vitWhere['auid']   =   array('in', pylode(',', $uids));
                $vitWhere['type']   =   22;
                $vitWhere['status'] =   1;

                if($data['crmstatis']){ // 更多 =》 业务统计

                    if($data['timeBegin']){
                        $vitWhere['PHPYUNBTWSTART_A']   =   '';
                        $vitWhere['stime'][]    =   array('>=',$data['timeBegin']);
                        $vitWhere['stime'][]    =   array('<=',$data['timeEnd']);
                        $vitWhere['PHPYUNBTWEND_A']     =   '';
                    }
                }

                $returnVisit   =   $this->select_all('crm_work_plan', $vitWhere);

                // 签单数/签单金额
                $orderwhere =   array();

                $orderwhere['crm_uid']          =   array('in',pylode(',',$uids));
                $orderwhere['order_state']      =   2;

                if($data['crmstatis']){ // 更多 =》 业务统计

                    if($data['timeBegin']){
                        $orderwhere['PHPYUNBTWSTART_A']   =   '';
                        $orderwhere['order_time'][]   =   array('>=',$data['timeBegin']);
                        $orderwhere['order_time'][]   =   array('<=',$data['timeEnd']);
                        $orderwhere['PHPYUNBTWEND_A']   =   '';
                    }
                }

                $order  =   $this -> select_all('company_order',$orderwhere,'`crm_uid`,`order_price`');

                //所属部门
                $org  =   $this -> select_all('crmorg');
                if(!empty($org)){
                    foreach($org as $key=>$value){

                        $orgList[$value['id']]	=	$value['name'];
                    }
                }
            }
            
            $group  =  $this -> select_all('admin_user_group',array('id'=>array('in',pylode(',', $gid))));
            
            $domain	=  $this -> select_all('domain',array('id'=>array('in',pylode(",",$dids))),"`id`,`title`");
            
            foreach ($List as $k => $v){
                
                
                foreach ($group as $val){
                    
                    if ($v['m_id'] == $val['id']){
                        
                        $List[$k]['group_name']  =  $val['group_name'];
                    }
                }
                if(!empty($dids)){
                    foreach ($domain as $val){
                        
                        if($v['did']==$val['id']){
                            
                            $List[$k]['group_name']=$val['title'];
                        }
                    }
                }
				$List[$k]['departname']=$orgList[$v['org']];
                if(!empty($uids)){

                    $List[$k]['cNum']           =   0;//客户
                    $List[$k]['concernNum']     =   0;//未跟进
                    $List[$k]['concernedNum']   =   0;//已跟进

                    $List[$k]['returnVisitNum'] =   0;//待回访客户

                    $List[$k]['orderNum']       =   0;//签单数
                    $List[$k]['orderPrice']     =   0;//签单金额

                    foreach ($company as $cmk => $cmv){

                        if ($v['uid'] == $cmv['crm_uid']){

                            $List[$k]['cNum']++;
                        }
                    }
                    foreach ($conncom as $cnnk => $cnnv){

                        if ($v['uid'] == $cnnv['crm_uid']){

                            if($cnnv['isfollow'] == '0'){

                                $List[$k]['concernNum'] ++;//未跟进
                            }
                        }
                    }
                    foreach ($concom as $cnk => $cnv){

                        if ($v['uid'] == $cnv['crm_uid']){

                            if($cnv['isfollow'] == '1'){

                                $List[$k]['concernedNum'] ++;//已跟进
                            }
                        }
                    }
                    foreach ($returnVisit as $val){
                    
                        if ($v['uid'] == $val['auid']){
                            $List[$k]['returnVisitNum'] ++;//待回访客户
                        }
                    }
                    foreach ($order as $val){
                    
                        if ($v['uid'] == $val['crm_uid']){
                            $List[$k]['orderNum'] ++;//签单数
                            $List[$k]['orderPrice'] +=$val['order_price'];//签单金额
                        }
                    }
                }
            }
        }
        return $List;
    }
    /**
     * 获取管理员权限
     * @param array $whereData
     * @param array $data
     */
    public function getPower($whereData=array(),$isnouser=0){
        
        $return  =  null;
        
        if (!empty($whereData)){
            
            if ($whereData['uid']){

				//不是所有的都需要查询
                if($isnouser!=1){
					 $adminUser        =  $this -> select_once('admin_user',array('uid'=>$whereData['uid']));
				}

               
                
                $adminGroup       =  $this -> select_once('admin_user_group',array('id'=>$adminUser['m_id']));


            }elseif ($whereData['id']){
                
                $adminGroup       =  $this -> select_once('admin_user_group',array('id'=>$whereData['id']));
                
				if($isnouser!=1){
					$adminUser        =  $this -> select_once('admin_user',array('m_id'=>$adminGroup['id']));
				}
            }
            
            if($isnouser!=1){
				$return['name']        =  $adminUser['name'];
				$return['username']    =  $adminUser['username'];
				$return['password']    =  $adminUser['password'];
			}
            $return['group_name']  =  $adminGroup['group_name'];
            $return['power']       =  unserialize($adminGroup['group_power']);
        }
        return $return;
    }

	
    /**
     * 添加管理员
     * @param array $addData
     * @param array $data
     */
    public function addAdminUser($addData=array(),$data=array()){
        //检测用户名重复性
        if (!empty($addData['username'])){
            
            $check  =  $this -> checkUsername($addData['username']);
            
            if ($check['msg']){
                
                return $check;
            }
        }
        if ($addData['password']){
            
            $addData['password']    =   $this -> makePass($addData['password']);
        }

        if (!isset($addData['did'])){
            $addData['did']         =   0;
        }
        $return['id']  =  $this -> insert_into('admin_user',$addData);
        
        if ($return['id']){
            
            $return['msg']      =  '管理员添加成功';
            $return['errcode']  =  '9';
            
        }else{
            $return['msg']      =  '管理员添加失败';
            $return['errcode']  =  '8';
        }
        
        return	$return;
    }
    /**
     * 获取管理员信息
     * @param array $whereData
     * @param array $data
     */
    public function getAdminUser($whereData = array(),$data = array()){
        
        $field      =  $data['field'] ? $data['field'] : '*';
        
        $adminUser  =  $this -> select_once('admin_user',$whereData, $field);
        
        return $adminUser;
    }
    /**
     * 修改管理员
     * @param array $addData
     * @param array $whereData
     * @param array $data
     */
    public function upInfo($upData=array(),$whereData=array(),$data=array()){
        
        $return['id']  =  $this -> update_once('admin_user',$upData,$whereData);
        return	$return;
    }
    /**
     * 修改管理员操作
     * @param array $addData
     * @param array $whereData
     * @param array $data
     */
    public function upAdminUser($upData=array(),$whereData=array(),$data=array()){
        
        $msg  =  '';
        //检测用户名重复性
        if (!empty($upData['username'])){
            
            $check  =  $this -> checkUsername($upData['username'],$whereData['uid']);
            
            if ($check['msg']){
                
                return $check;
            }
        }
        //修改密码
        if (isset($upData['password'])){
            if (!empty($upData['password'])){
                
                $return  =  array();
                
                if (isset($data['oldpass'])){
                    if(empty($data['oldpass'])){
                        
                        $return['msg']      =  '原始密码不能为空！';
                        $return['errcode']  =  '8';
                        return $return;
                        
                    }elseif($data['oldpass'] == $upData['password']){
                        
                        $return['msg']      =  '新密码和原始密码一致，不需要修改！';
                        $return['errcode']  =  '8';
                        return $return;
                        
                    }elseif($upData['password'] != $data['okpassword']){
                        
                        $return['msg']      =  '新密码两次输入不一致！';
                        $return['errcode']  =  '8';
                        return $return;
                    }
                    $user    =  $this->select_once('admin_user',array('uid'=>$whereData['uid']));
                    $verify  =  $this->verifyPass($data['oldpass'], $user['password']);
                    
                    if ($verify == false){
                        
                        $return['msg']      =  '原始密码不正确！';
                        $return['errcode']  =  '8';
                        return $return;
                    }
                    if (!empty($return)){
                        
                        return $return;
                    }
                }
                
                $msg                 =  '密码';
                
                $upData['password']  =  $this->makePass($upData['password']);
            }else{
                $return['msg']      =  '新密码不能为空！';
                $return['errcode']  =  '8';
                return $return;
            }
        }
        $return['id']  =  $this -> update_once('admin_user',$upData,$whereData);
        
        if ($return['id']){
            
            $return['msg']      =  '管理员'.$msg.'(ID:'.$whereData['uid'].')修改成功';
            $return['errcode']  =  '9';
            
        }else{
            $return['msg']      =  '管理员'.$msg.'(ID:'.$whereData['uid'].')修改失败';
            $return['errcode']  =  '8';
        }
        return	$return;
    }
    /**
     * 检测管理员用户名重复性
     * @param string $username
     */
    private function checkUsername($username, $uid = ''){
        
        $user    =  $this -> select_once('admin_user',array('username'=>$username));
        
        $return  =  array();
        
        if ($user && ($uid == '' || ($uid !='' && $uid != $user['uid']))){
            $return['msg']      =  '管理员用户名已存在';
            $return['errcode']  =  '8';
        }
        
        return $return;
    }
    /**
     * 删除管理员
     * @param array $whereData
     * @param array $data
     */
    public function delAdminUser($whereData=array(),$data=array())
	{
		
        $return['id']  =  $this -> delete_all('admin_user',$whereData, '');
        
        if ($return['id']){
            //如果是业务员，同时删除跟进记录、回访提醒，清除企业表crm_uid字段
            $this->delete_all('crmnew_concern', array('uid'=>$whereData['uid']), '');
            $this->update_once('company', array('crm_uid'=>0,'crm_status'=>0), array('crm_uid'=>$whereData['uid']));
            $this->update_once('company_order', array('crm_uid'=>0), array('crm_uid'=>$whereData['uid']));
            
            $return['msg']      =  '管理员(ID:'.$whereData['uid'].')删除成功';
            $return['errcode']  =  '9';
            
        }else{
            $return['msg']      =  '管理员(ID:'.$whereData['uid'].')删除失败';
            $return['errcode']  =  '8';
        }
        return	$return;
    }
    /**
     * 添加管理员类型
     * @param array $addData
     * @param array $data
     */
    public function addAdminGroup($addData=array(),$data=array()){
        
        $return['id']  =  $this -> insert_into('admin_user_group',$addData);
        
        if ($return['id']){
            
            $return['msg']      =  '管理员类型添加成功';
            $return['errcode']  =  '9';
            
        }else{
            $return['msg']      =  '管理员类型添加失败';
            $return['errcode']  =  '8';
        }
        
        return	$return;
    }
    /**
     * 获取管理员类型信息
     * @param array $whereData
     * @param array $data
     */
    public function getAdminGroup($whereData=array(),$data=array('field'=>'*')){
        
        //处理分站
        if (empty($whereData['did'])){
            
            unset($whereData['did']);
        }
        
        $return  =  $this -> select_once('admin_user_group',$whereData,$data['field']);
        
        return	$return;
    }
    /**
     * 获取管理员类型列表
     * @param array $whereData
     * @param array $data
     */
    public function getAdminGroupList($whereData=array(),$data=array('field'=>null,'utype'=>null)){
        
        $field  =  $data['field'] ? $data['field'] : '*';
        
        //处理分站
        if (empty($whereData['did'])){
            
            unset($whereData['did']);
        }
        
        $List  =  $this -> select_all('admin_user_group',$whereData,$field);
        
        if ($data['utype'] == 'admin'){
            if(empty($data['uwhere'])){
                $user  =  $this -> select_all('admin_user',array('did'=>0,'isdid'=>array('=',1,'OR'),'groupby'=>'m_id'),'`m_id`,count(`uid`) as num');
			}else{
				$user  =  $this -> select_all('admin_user',$data['uwhere'],'`m_id`,count(`uid`) as num');
			}
			
            foreach($List as $k=>$v){
                
                $List[$k]['num']  =  0;
                
                foreach($user as $val){
                    
                    if($v['id'] == $val['m_id']){
                        
                        $List[$k]['num']  =  $val['num'];
                    }
                }
            }
        }
        return	$List;
    }
    /**
     * 修改管理员类型
     * @param array $addData
     * @param array $whereData
     * @param array $data
     */
    public function upAdminGroup($upData=array(),$whereData=array(),$data=array()){
        
        $return['id']  =  $this -> update_once('admin_user_group',$upData,$whereData);
        
        if ($return['id']){
            
            $return['msg']      =  '管理员类型(ID:'.$whereData['id'].')修改成功';
            $return['errcode']  =  '9';
            
        }else{
            $return['msg']      =  '管理员类型(ID:'.$whereData['id'].')修改失败';
            $return['errcode']  =  '8';
        }
        
        return	$return;
    }
    /**
     * 删除管理员类型
     * @param array $whereData
     * @param array $data
     */
    public function delAdminGroup($whereData=array(),$data=array()){
        
        if (!empty($whereData['id'])){
            $num  =  $this->select_num('admin_user',array('m_id'=>$whereData['id']));
            
            if ($num>0){
                $return['msg']      =  '该管理员类型下有管理员，请先删除相关管理员';
                $return['errcode']  =  '8';
            }else{
				 
                $return['id']  =  $this -> delete_all('admin_user_group',$whereData, '');
                
                if ($return['id']){
                    $return['msg']      =  '管理员类型(ID:'.$whereData['id'].')删除成功';
                    $return['errcode']  =  '9';
                    
                }else{
                    $return['msg']      =  '管理员类型(ID:'.$whereData['id'].')删除失败';
                    $return['errcode']  =  '8';
                }
            }
        }else{
            $return['msg']      =  '请选择需要删除的管理员类型';
            $return['errcode']  =  '8';
        }
        return	$return;
    }
    /**
     * 后台生成密码
     */
    public function makePass($pw){
        
        $adminpw  =  md5(md5($pw));
        
        return $adminpw;
    }
    /**
     * 后台验证密码
     */
    public function verifyPass($postPass, $userPass){
        
        $pw  =  $this->makePass($postPass);
        
        if ($pw == $userPass){
            
            return true;
            
        }else {
            
            return false;
        }
    }
    /**
     * @desc 通知管理员
	 * @desc $this -> MODEL('admin')->sendAdminMsg(array('first'=>'有新的职位需要审核'));
     */
    public function sendAdminMsg($data=array('type'=>'','first'=>'','title'=>''))
    {
        if ($data['first']) {
            
            //$user   =   $this->select_all('admin_user', array('m_id' => 1), '`uid`,`name`,`moblie`,`r_status`,`weixin`,`wxid`');
            if($data['type']){
                $wmtype     =   $this->select_once('admin_wmtype', array('type' =>$data['type']), '`uid`');
            }
           
            if($wmtype['uid']){
                $user       =   $this->select_all('admin_user', array('uid' => array('in',$wmtype['uid'])), '`uid`,`name`,`moblie`,`r_status`,`weixin`,`wxid`,`qy_userid`');
            }

            if (! empty($user)) {

                require_once ('weixin.model.php');
                $weixinM = new weixin_model($this->db, $this->def);

                if($this->config["sy_admin_wmtype"]==1){

                    foreach ($user as $v) {
                        
                        if ($v['wxid']) {

                            $weixinM->sendWxAdmin(array(
                                'uid'   =>  $v['uid'],
                                'type'  =>  $data['type'],
                                'first' =>  $data['first'],
                                'wxid'  =>  $v['wxid'],
                                'title' =>  $data['title'],
                            ));
                        }
                        
                    }
                }else if($this->config["sy_admin_wmtype"]==2){
                    
                    $uids = $userids = array();

                    foreach ($user as $v) {
                    
                        if ($v['qy_userid']) {
                            $uids[]    = $v['uid'];
                            $userids[] = $v['qy_userid'];

                        }
                    }

                    $weixinM->sendWxQyAdmin(array(
                        'type'  =>  $data['type'],     
                        'first' =>  $data['first'],
                        'uids'  =>  $uids,
                        'userids'  =>  $userids,
                        'title' =>  $data['title'],
                    ));
                }
            }
        }
    }
    
}
?>