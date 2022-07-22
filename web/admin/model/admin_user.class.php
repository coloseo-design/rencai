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
class admin_user_controller extends adminCommon{

    function crm_class(){

        $cacheM     =   $this->MODEL('cache');

        $crmCache   =   $cacheM -> GetCache(array('crm'));

        $this->yunset(array('cache' => $crmCache, 'crmClassName' => $crmCache['crmclass_name'], 'crmDepart' => $crmCache['crmdata']['crm_depart']));

    }
    /**
     * @desc 管理员-管理员列表
     */
    function index_action(){

        //分页链接
        $urlarr        	=   $_GET;
        $urlarr['page']	=	'{{page}}';

        $pageurl		=	Url($_GET['m'],$urlarr,'admin');

        //提取分页
        $pageM			=	$this  -> MODEL('page');
        $pages			=	$pageM -> pageList('admin_user',array(),$pageurl,$_GET['page']);

        //分页数大于0的情况下 执行列表查询
        if($pages['total'] > 0){
            //limit order 只有在列表查询时才需要
            $where['orderby']  =  'uid';
            $where['limit']    =  $pages['limit'];

            $adminM            =  $this -> MODEL('admin');

            $List	           =  $adminM -> getList($where);

            $this -> yunset('rows',$List);
        }
        $this->yuntpl(array('admin/admin_user_list'));
    }
    /**
     * 管理员-添加管理员
     */
    function add_action()
    {

        $adminM     =   $this->MODEL('admin');

        if (isset($_GET['uid'])) {

            $adminuser              =   $adminM->getAdminUser(array('uid' => intval($_GET['uid'])));

            $adminuser['photo_n']   =   checkpic($adminuser['photo']);
            $adminuser['ewm_n']     =   checkpic($adminuser['ewm']);
            $adminuser['crm_duty']  =   @explode(',', $adminuser['crm_duty']);
            $adminuser['num']       =   (int)$adminuser['num'] == 0 ? '' : $adminuser['num'];

            $this->yunset('adminuser', $adminuser);
        }

        $group      =   $adminM->getAdminGroupList(array('did' => $this->config['did'], 'orderby' => 'id'));

        $this->yunset('user_group', $group);

        $this->crm_class();

        $week = array(
            '1' => '礼拜一',
            '2' => '礼拜二',
            '3' => '礼拜三',
            '4' => '礼拜四',
            '5' => '礼拜五',
            '6' => '礼拜六',
            '7' => '礼拜日'
        );
        $this->yunset('week', $week);

        $this->yuntpl(array('admin/admin_user_add'));
    }
    /**
     * 管理员-管理员类型
     */
    function group_action(){

        $adminM  =  $this -> MODEL('admin');

        $List    =  $adminM -> getAdminGroupList(array('did'=>$this->config['did'],'orderby'=>'id'),array('utype'=>'admin'));

        $this->yunset('adminusergroup',$List);

        $this->yuntpl(array('admin/admin_group_list'));
    }
    /**
     * 管理员-我的账号
     */
    function myuser_action(){

        $adminM  =  $this -> MODEL('admin');

        if ($_SESSION['auid']){

            $user    =  $adminM -> getAdminUser(array('uid'=>$_SESSION['auid']));

            if ($user){

                $group   =  $adminM -> getAdminGroup(array('id'=>$user['m_id'],'did'=>$this->config['did']));
            }

            $this->yunset(array('adminuser'=>$user,'user_group'=>$group));
        }
        $this->yuntpl(array('admin/admin_myuser'));
    }
    /**
     * 管理员-我的账号-修改密码
     */
    function pass_action(){
        $adminM  =  $this -> MODEL('admin');

        if ($_SESSION['auid']){

            $user    =  $adminM -> getAdminUser(array('uid'=>$_SESSION['auid']));

            if ($user){

                $group   =  $adminM -> getAdminGroup(array('id'=>$user['m_id'],'did'=>$this->config['did']));
            }

            $this->yunset(array('adminuser'=>$user,'user_group'=>$group));
        }
        $this->yunset('pass_div', '1');
        $this->yuntpl(array('admin/admin_myuser'));
    }
    /**
     * 管理员-我的账号-修改密码保存
     */
    function savePass_action(){

        if($_POST['useradd'] && $_SESSION['auid']){

            $_POST   =  $this -> post_trim($_POST);

            $adminM  =  $this -> MODEL('admin');

            $return  =  $adminM ->upAdminUser(array('password'=>$_POST['password']),array('uid'=>$_SESSION['auid']),array('oldpass'=>$_POST['oldpass'],'okpassword'=>$_POST['okpassword']));

            if ($return['id']){

                unset($_SESSION['authcode']);
                unset($_SESSION['auid']);
                unset($_SESSION['ausername']);
                unset($_SESSION['ashell']);
            }

            $this -> ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
        }
    }
    /**
     * 管理员-添加管理员类型
     */
    function addgroup_action(){
        //修改管理员类型
        if($_GET['id']){

            $adminM  =  $this -> MODEL('admin');

            $group   =  $adminM -> getAdminGroup(array('id'=>intval($_GET['id']),'did'=>$this->config['did']));

            $this->yunset('admin_group',$group);

            $this->yunset('power',unserialize($group['group_power']));
        }

        $navigationM  =  $this -> MODEL('navigation');

        $return       =  $navigationM -> getAdminNavList(array('display'=>array('<>','1'),'orderby'=>'sort,asc'),array('utype'=>'power'));

        $setarr  =  array(
            'one_menu'=>$return['one_menu'],
            'two_menu'=>$return['two_menu'],
            'three_menu'=>$return['three_menu'],
            'navigation'=>$return['navigation']
        );

        $this->yunset($setarr);

        $this->yuntpl(array('admin/admin_group'));
    }
    /**
     * 管理员-添加、修改保存
     */
    function save_action(){

        $adminM  =  $this -> MODEL('admin');

        if(isset($_POST['useradd'])){

            $_POST   =  $this -> post_trim($_POST);

            if(!empty($_FILES)){

                if($_FILES['photo']['tmp_name']){
                    $upArrphoto    =  array(
                        'file'  =>  $_FILES['photo'],
                        'dir'   =>  'adminuser'
                    );
                }

                if($_FILES['ewm']['tmp_name']){
                    $upArrewm    =  array(
                        'file'  =>  $_FILES['ewm'],
                        'dir'   =>  'adminuser'
                    );
                }

                $uploadM  =  $this->MODEL('upload');

                if(!empty($upArrphoto)){
                    $picphoto      =  $uploadM->newUpload($upArrphoto);
                }

                if(!empty($upArrewm )){
                    $picewm      =  $uploadM->newUpload($upArrewm );
                }

                if (!empty($picphoto['picurl'])){
                    $photo  =  $picphoto['picurl'];
                }

                if (!empty($picewm['picurl'])){
                    $ewm  =  $picewm['picurl'];
                }
            }

            if($_POST['is_crm'] == '1'){

                if (!empty($_POST['crm_duty'])) {
                    $crm_duty	=	pylode(',', $_POST['crm_duty']);
                }

                if (!empty($_POST['crm_city'])) {
                    $crm_city   =   $_POST['crm_city'];
                }
            }

            $post    =  array(
                'username'  =>  $_POST['username'],
                'name'      =>  $_POST['name'],
                'm_id'      =>  $_POST['m_id'],
                'moblie' 	=>  $_POST['moblie'],
                'weixin'  	=>  $_POST['weixin'],
                'qy_userid' =>  $_POST['qy_userid'],
                'qq'     	=>  $_POST['qq'],
                'is_crm'    =>  $_POST['is_crm'],
                'num'       =>  $_POST['num'],
                'crm_duty'	=>	$crm_duty,
                'crm_city'	=>	$crm_city,
                'r_status'  =>  $_POST['r_status'],
                'photo'		=>	$photo,
                'ewm'		=>	$ewm,
                'depart'	=>	$_POST['depart'],
                'control_login'=> trim($_POST['control_login']),
                'index_lookstatistc'=>$_POST['index_lookstatistc']
            );

            $adminuser  =  $adminM -> getAdminUser(array('uid'=>intval($_POST['uid'])));

            if($adminuser['photo'] && $photo==""){
                $post['photo']	=	$adminuser['photo'];
            }
            if($adminuser['ewm'] && $ewm==""){
                $post['ewm']	=	$adminuser['ewm'];
            }
            if($_POST['password']){
                $post['password']  =  $_POST['password'];
            }
            if($_POST['isdid']){
                $post['isdid']  =  intval($_POST['isdid']);
            }

            if (empty($_POST['uid'])){

                $return  =  $adminM-> addAdminUser($post);
            }else{
                $return  =  $adminM ->upAdminUser($post,array('uid'=>$_POST['uid']));

                if ($return['id'] && $_POST['uid']==$_SESSION['auid']){

                    unset($_SESSION['authcode']);
                    unset($_SESSION['auid']);
                    unset($_SESSION['ausername']);
                    unset($_SESSION['ashell']);

                    if($_POST['uid']==$_SESSION['auid']){

                        $this->ACT_layer_msg( '管理员(ID:'.$_POST['uid'].')修改成功,请重新登录！',9,$_SERVER['HTTP_REFERER'],2,1);
                    }
                }
            }
            $this->ACT_layer_msg($return['msg'],$return['errcode'],'index.php?m=admin_user',2,1);
        }
    }

    /**
     * 管理员-管理员列表-删除
     */
    function deluser_action(){

        $this->check_token();

        if ($_GET['uid']){

            $adminM  =  $this -> MODEL('admin');

            $return  =  $adminM -> delAdminUser(array('uid'=>addslashes($_GET['uid'])));

            $this->layer_msg($return['msg'],$return['errcode']);
        }
    }
    /**
     * 管理员-管理员类型-删除
     */
    function delgroup_action(){

        $this->check_token();

        if ($_GET['id']){

            $adminM  =  $this -> MODEL('admin');

            $return  =  $adminM -> delAdminGroup(array('id'=>intval($_GET['id'])));

            $this->layer_msg($return['msg'],$return['errcode']);
        }
    }
    /**
     * 管理员-管理员类型-添加、修改保存
     */
    function savagroup_action(){

        if(empty($_POST['group_name'])){

            $this -> ACT_layer_msg('请填写权限组名称',8);
        }

        $power = array_filter($_POST['power']);

        if(empty($power)){

            $this -> ACT_layer_msg('请至少选择一项权限',8);
        }

        $post    =  array(
            'group_name'   =>  $_POST['group_name'],
            'group_power'  =>  serialize(array_filter($power))
        );
        $adminM  =  $this -> MODEL('admin');

        if (empty($_POST['groupid'])){

            $post['group_type'] =   1;
            $post['did']        =   $this->config['did'];

            $return             =   $adminM -> addAdminGroup($post);
        }else {

            $return       =  $adminM -> upAdminGroup($post,array('id'=>intval($_POST['groupid'])));
        }
        if($return['errcode']==9){
            if($_POST['group_name']=='分站管理员'){
                $navigationM	=  $this -> MODEL('navigation');

                $navigationM->upAdminNav(array('dids'=>0),array('display'=>array('<>',1)));

                $navigationM->upAdminNav(array('dids'=>1),array('id'=>array('in',pylode(',',$power)),'display'=>array('<>',1)));

            }
        }
        $this->ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
    }

    //微信模板消息 管理员通知设置
    function wxMsgSet_action(){


        $adminM            	=  $this -> MODEL('admin');

        $twhere['orderby']  =  'id,asc';

        $wxmsgType	        =  $adminM -> getWmtype($twhere);

        $where['orderby']  	=  array('m_id,asc','uid,asc');

        $adminlist	        =  $adminM -> getList($where);

        $this->yunset('adminlist',$adminlist);

        $this->yunset('wxmsgType',$wxmsgType);

        $this->yuntpl(array('admin/admin_wxmsgset'));
    }
    function wmTypeSet_action(){

        if($_POST['msgconfig']){
            $_POST      =   $this->post_trim($_POST);
            //实例化
            $configM	=	$this->MODEL('config');

            unset($_POST['msgconfig']);

            $configM->setConfig($_POST);

            $this->web_config();

            $this->ACT_layer_msg('通知方式配置更新成功！',9,$_SERVER['HTTP_REFERER'],2,1);
        }
    }
    function wxMsgSave_action(){

        if($_POST['wmid']){
            $type		=	$_POST['wmid'];//要通知的类型

            $tkey		=	'wmtype_'.$_POST['wmid'];

            $adminArr	=	!empty($_POST[$tkey]) ? $_POST[$tkey] : array();//确认通知的管理员uid



            $adminM     = 	$this -> MODEL('admin');

            $where['orderby']  	=  'uid,asc';
            $adminlist	=  $adminM -> getList($where);

            $uids		=	array();
            $yuids		=	array();
            foreach($adminlist as $k=>$v){//所有管理员
                $uids[]	=	$v['uid'];
            }
            //验证提交的管理员uid是否真的存在
            $yuids		=	array();
            if(!empty($adminArr)){
                foreach($uids as $uk=>$uv){
                    if(in_array($uv,$adminArr)){
                        $yuids[] = $uv;
                    }
                }
            }

            //if(!empty($yuids)){//通知的管理员 更新

            $ywhere = array('type'=>$type);

            $mbuid 	= !empty($yuids) ? pylode(',',$yuids) : '';

            $post 	= array('uid'=>$mbuid);

            $return = $adminM ->upWmtype($post,$ywhere);

            //}

        }
        if($return){
            $this->ACT_layer_msg('设置成功',9,$_SERVER['HTTP_REFERER'],2,1);
        }else{
            $this->ACT_layer_msg('设置失败请重试',8,$_SERVER['HTTP_REFERER']);
        }

    }
}

?>