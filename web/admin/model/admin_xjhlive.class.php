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
class admin_xjhlive_controller extends adminCommon
{

    function set_search()
    {
        
        $search_list    =   array();

        $search_list[]  =   array(
            
            'param'     =>  'end',
            'name'      =>  '创建时间',
            'value'     =>  array(
                
                '1'     =>  '今天',
                '3'     =>  '最近三天',
                '7'     =>  '最近七天',
                '15'    =>  '最近半月',
                '30'    =>  '最近一个月'
            )
        );
        $search_list[]  =   array(
            
            'param'     =>  'livestatus',
            'name'      =>  '直播状态',
            'value'     =>  array(
                
                '1'     =>  '未开始',
                '3'     =>  '直播中',
                '2'     =>  '已结束'
            )
        );

        $this->yunset('search_list', $search_list);
    }

    /**
     * @desc 后台  - 宣讲会列表
     */
    function index_action() {
        
        $this->set_search();
        $where  =  array();
        
        if ($_GET['status']) {

            $status             =   intval($_GET['status']);

            $where['status']    =   $status;

            $urlarr['status']   =   $status;
        }

        if ($_GET['keyword']) {

            $keyword            =   trim($_GET['keyword']);

            $where['name']     =   array('like', $keyword);

            $urlarr['keyword']  =   $keyword;
        }

        if ($_GET['end']) {

            if ($_GET['end'] == '1') {

                $where['ctime'] =   array('>=', strtotime('today'));
                
            } else {

                $where['ctime'] =   array('>=', strtotime('-'.intval($_GET['end']).' day'));
            }
            
            $urlarr['end']      =   $_GET['end'];
        }
        if (isset($_GET['livestatus'])) {
            
            $livestatus             =   intval($_GET['livestatus']);
            
            $where['livestatus']    =   $livestatus;
            
            $urlarr['livestatus']   =   $livestatus;
        }
		$urlarr        	=   $_GET;
        $urlarr['page'] = '{{page}}';

        $pageurl = Url($_GET['m'], $urlarr, 'admin');

        // 提取分页
        $pageM = $this->MODEL('page');
        $xjhM  = $this->MODEL('xjhlive');

        $pages = $pageM->pageList('xjhlive', $where, $pageurl, $_GET['page']);

        // 分页数大于0的情况下 执行列表查询

        if ($pages['total'] > 0) {
            // limit order 只有在列表查询时才需要
            if ($_GET['order']) {

                $where['orderby']   =   $_GET['t'] . ',' . $_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
                
            } else {

                $where['orderby']   =   array('status,asc','id,desc');
                
            }
            
            $where['limit']         =   $pages['limit'];
            
            $rows   =   $xjhM -> getList($where,array('utype'=>'admin', 'shortlen' => 16,'num'=>1));
            $picarr =   array();
            foreach($rows as $k=>$v){
                if(!empty($v['picarr'])){
                    $picarr[$v['id']]=$v['picarr'];
                }
            }
            
            $this   ->  yunset('picarr',$picarr);
            $this   ->  yunset('rows', $rows);
            
            //提取分站内容
            $cacheM  =	$this -> MODEL('cache');
            $domain  =	$cacheM	-> GetCache('domain');
            
            $this -> yunset('Dname', $domain['Dname']);
        }
        
        $this->yuntpl(array('admin/admin_xjhlive'));
        
    }
    /**
     * 列表切换分站
     */
    function checksitedid_action(){
        
        if($_POST['uid']){
            
            $uids	=	@explode(',', $_POST['uid']);
            
            $uid	= 	pylode(',', $uids);
            
            if($uid){
                
                $siteDomain  =  $this -> MODEL('site');
                
                $siteDomain -> updDid(array('xjhlive'), array('id' => array('in', $uid)), array('did' => $_POST['did']));
                
                $this -> ACT_layer_msg('直播宣讲会(ID:'.$_POST['uid'].')分配站点成功！', 9, $_SERVER['HTTP_REFERER']);
                
            }else{
                
                $this -> ACT_layer_msg('请正确选择需分配数据！', 8, $_SERVER['HTTP_REFERER']);
                
            }
            
        }else{
            
            $this -> ACT_layer_msg('参数不全请重试！', 8, $_SERVER['HTTP_REFERER']);
        }
    }
    function add_action(){

        if($_GET['id']){
            $xjhM  =  $this->MODEL('xjhlive');
            $info  =  $xjhM -> getInfo(array('id'=>intval($_GET['id'])));
            $this -> yunset('info',$info);
        }
        $cacheM  =  $this->MODEL('cache');
        
        $cache   =  $cacheM -> GetCache(array('city'));
        $domain  =	$cacheM	-> GetCache('domain');
        
        $this -> yunset('Dname', $domain['Dname']);
        
        if(empty($cache['city_type'])){
            $this->yunset('cionly',1);
        }

        $this->yunset('playtime',array(1=>'1小时',2=>'2小时',4=>'4小时'));
        
        $this->yunset($cache);
        $this->yunset('now',date('Y-m-d H:i:s',time()));
        $this->yuntpl(array('admin/admin_xjhlive_add'));
    }
    /**
     * 直播宣讲会保存
     */
    function save_action(){
        
        $_POST  =  $this->post_trim($_POST);
        
        $post  =  array(
            'name'        =>  $_POST['name'],
            'pic'         =>  $_POST['preview'],
            'body'        =>  $_POST['body'],
            'ctime'       =>  time(),
            'stime'       =>  strtotime($_POST['stime']),
            'playtime'    =>  $_POST['playtime'],
            'state'       =>  $_POST['state'],
            'statetime'   =>  strtotime($_POST['statetime']),
            'playback'    =>  $_POST['playback'],
            'did'         =>  $_POST['did'],
            'status'      =>  1
        );
        
        $data  =  array(
            'post'   =>  $post,
            'id'     =>  intval($_POST['id'])
        );
        $xjhM   =  $this->MODEL('xjhlive');
        $return =  $xjhM->addXjh($data);
        
        $this->ACT_layer_msg($return['msg'], $return['errcode'], 'index.php?m=admin_xjhlive');
    }
    /**
     * 搜索按名称参会企业
     */
    function getZcom_action(){
        
        $result    =   array();

        if (!empty($_GET['keyword'])) {
            
            $where['r_status']     =   1;

            $where['name']  =   array('like', trim($_GET['keyword']));
        
            $where['limit']     =   10;
            
            $comM      =   $this->MODEL('company');
            
            $comArr    =   $comM -> getList($where, array('field' => '`uid`,`name`'));
            
            
            
            if (!empty($comArr)) {
                
                $comList   =   $comArr['list'];
                foreach ($comList as $k => $v){
                    $result[$k]['name']    =   $v['name'];
                    $result[$k]['value']   =   $v['uid'];
                }
            }
        }
        echo json_encode($result);die;
    }

    function com_action(){
        
        $xjhM  =  $this->MODEL('xjhlive');
        
        if($_GET['id']){
            
            $where['xid']   =   intval($_GET['id']);
            
            $urlarr['xid']  =   $_GET['id'];

            $info       =   $xjhM -> getInfo(array('id'=>$_GET['id']));
            $this -> yunset('info',$info);
        }
        
        if (trim($_GET['keyword'])){
            
            $companyM  =  $this->MODEL('company');
            $company   =  $companyM->getChCompanyList(array('name'=>array('like',trim($_GET['keyword']))),array('field'=>'uid'));
            
            if($company){
                
                foreach($company as $v){
                    
                    $uid[]  =   $v['uid'];
                }
                $where['uid']   =   array('in',pylode(',', $uid));
            }
            $urlarr["keyword"]  =   $_GET["keyword"];
        }

        $urlarr['c']     =  $_GET['c'];
		$urlarr          =   $_GET;
        $urlarr['page']  =  "{{page}}";
        
        $pageurl  =  Url($_GET['m'],$urlarr,'admin');
        $pageM    =  $this  -> MODEL('page');
        $pages    =  $pageM -> pageList('xjhlive_com',$where,$pageurl,$_GET['page']);

        if($pages['total'] > 0){                     
            
            $where['orderby']  =  array('id,desc');
            
            $where['limit']    =  $pages['limit'];
            
            $rows  =  $xjhM -> getXjhComList($where,array('utype'=>'admin'));
            
        }
        
        $this -> yunset("rows",$rows);
        
        $this -> yuntpl(array('admin/admin_xjhlive_com'));
    
    }
    function del_action(){
        
        if($_POST['del']){
            
            $delID   =  $_POST['del'];
            
        }elseif($_GET['xjhid']){
            
            $this->check_token();
            $delID   =  $_GET['xjhid'];
        }
        
        $xjhM  =  $this -> MODEL('xjhlive');
        
        $return   =  $xjhM -> delXjh($delID);
        
        $this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
    }
    /**
     * 添加参会企业
     */
    function comadd_action(){
        
        $xjhM  =  $this->MODEL('xjhlive');
        
        $xjh      =  $xjhM->getInfo(array('id'=>intval($_GET['id'])),array('field'=>'`id`,`name`'));
        
        $this -> yunset('info',$xjh);
        
        $this -> yuntpl(array('admin/admin_xjhlive_comadd'));
    }
    /**
     * 保存参会企业
     */
    function comaddsave_action(){
        
        $xjhM    =  $this->MODEL('xjhlive');
        $return  =  $xjhM->addXjhCom($_POST);
        
        $this -> ACT_layer_msg($return['msg'],$return['errcode'],'index.php?m=admin_xjhlive&c=com&id='.(int)$_POST['xid'],2,1);
    }
    /**
     * 删除参会企业
     */
    function delcom_action(){
        
        $xjhM    =   $this->MODEL('xjhlive');
        
        if($_GET['delid']){
            
            $this -> check_token();
            
            $delID  =  intval($_GET['delid']);
            $xid    =  intval($_GET['xid']);
            
        }elseif($_POST['del']){
            
            $delID  =   $_POST['del'];
            $xid    =  intval($_POST['xid']);
        }
        
        $arr    =   $xjhM -> delXjhCom($delID, $xid);
        
        $this -> layer_msg($arr['msg'], $arr['errcode'], $arr['layertype'],$_SERVER['HTTP_REFERER']);
        
    }
    function xjhchat_action()
    {
        if (intval($_GET['uid']) > 0) {
            
            $where['uid']  = intval($_GET['uid']);
            
            $urlarr['uid'] = intval($_GET['uid']);
        }
        
        if (intval($_GET['xid']) > 0) {
            
            $where['xid']  = intval($_GET['xid']);
            
            $urlarr['xid'] = intval($_GET['xid']);
        }
        
        if ($_GET['keyword']) {
            
            $keyword = trim($_GET['keyword']);
            
            $type    = intval($_GET['type']);
            
            if ($type == '1') {
                
                $where['fuid'] = array('=',$keyword);
                
            } else if ($type == '2') {
                
                $userinfoM  =  $this->MODEL('userinfo');
                
                $member     =  $userinfoM->getList(array('username'=>array('like',$keyword)),array('field'=>'`uid`'));
                
                if (!empty($member)){
                    
                    foreach ($member as $v){
                        $fuid[]  =  $v['uid'];
                    }
                    $where['fuid']  =  array('in',pylode(',', $fuid));
                }
            }
            
            $urlarr['type']    = "" . $type . "";
            
            $urlarr['keyword'] = "" . $keyword . "";
        }
        
        $urlarr['c'] = 'xjhchat';
        $urlarr        	=   $_GET;
        $urlarr['page'] = "{{page}}";
        
        $pageurl = Url($_GET['m'], $urlarr, 'admin');
        
        // 提取分页
        $pageM = $this->MODEL('page');
        
        $pages = $pageM->pageList('xjhlive_chat', $where, $pageurl, $_GET['page']);
        
        // 分页数大于0的情况下 执行列表查询
        if ($pages['total'] > 0) {
            
            // limit order 只有在列表查询时才需要
            if ($_GET['order']) {
                
                $where['orderby']  =  $_GET['t'] . ',' . $_GET['order'];
                
                $urlarr['order']   =  $_GET['order'];
                
                $urlarr['t']       =  $_GET['t'];
            } else {
                
                $where['orderby'] = array('sendTime,desc');
            }
            
            $where['limit'] = $pages['limit'];
            
            $chatM = $this->MODEL('chat');
            
            $List = $chatM->getChatList($where,array('fdata'=>1,'utype'=>'admin'));
            
            $this->yunset(array('rows' => $List));
        }
        $this->yuntpl(array('admin/admin_xjhlive_chat'));
    }
    /**
     * 删除宣讲会聊天
     */
    function msgdel_action()
    {
        $this->check_token();

        $chatM  =   $this -> Model('chat');

        if($_GET['del']){
            $del=$_GET['del'];

            if($_GET['del']){
                $return =   $chatM -> delXjhchat($_GET['del']);
                
                $this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
            }else{
                $this->layer_msg("请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
            }
        }
    }
    /**
     * 禁言
     */
	function forbidden_action()
    {
        $this->check_token();
		
		if($_GET['del']){
			
			$chatM  =  	$this->MODEL('chat');
			$row	=	$chatM->getXjhChat(array('id'=>$_GET['del']));

			$data	=	array(
                'fuid' 	    =>	$row['fuid'],
			    'usertype'  =>  $row['fusertype'],
				'xjhid'	    =>	$row['xid']
			);
			
			$return  =  $chatM->addXjhchatBlack($data);
			
			$this->layer_msg($return['msg'],$return['errcode'],0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg("请选择您要禁言的用户！",8,0,$_SERVER['HTTP_REFERER']);
		}
    }
	/**
	 * 解除禁言
	 */
	function delblack_action()
    {
        $this->check_token();
		
		if($_GET['del']){
			
			$chatM  =  	$this->MODEL('chat');
			
			$xjhM  =  	$this->MODEL('xjhlive');
			
			$row	=	$chatM->getXjhChat(array('id'=>$_GET['del']));
			
			$where	=	array(
			    'xid'	    =>	$row['xid'],
				'uid' 	    =>	$row['fuid'],
			    'usertype'  =>  $row['fusertype']
			);
			
			$return  =  $chatM->delXjhchatBlack('',array('where'=>$where));
			
			$this->layer_msg($return['msg'],$return['errcode'],0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg("请选择您要解禁的用户！",8,0,$_SERVER['HTTP_REFERER']);
		}
    }
    /**
     * 删除封面图片
     */
	function delPic_action(){
        
	    $delID   =  $_POST['pid'];
        $xjhM    =  $this->MODEL('xjhlive');
        $return  =  $xjhM->delXjhPic($delID,array('utype'=>'admin'));
        
        echo $return['errcode'] == 9 ? 1 :2;
    }
    /**
     * 获取直播二维码地址
     */
    function getLive_action(){
        
        $xjhM    =  $this->MODEL('xjhlive');
        $return  =  $xjhM->getLiveQrcode(array('id'=>$_POST['id']));
        
        echo json_encode($return);
    }
	/**
	 * 关闭宣讲会直播
	 */
    function liveEnd_action(){
        
        $xjhM    =  $this->MODEL('xjhlive');
        $xjh     =  $xjhM->getInfo(array('id'=>intval($_GET['id'])),array('field'=>'`id`,`livestatus`'));
        
        if (!empty($xjh)){
            
            $return  =  $xjhM->liveEnd(array('id'=>$xjh['id']));
            
            $this->layer_msg($return['msg'],$return['errcode'],0,$_SERVER['HTTP_REFERER']);
            
        }else{
            
            $this->layer_msg("宣讲会不存在",8,0,$_SERVER['HTTP_REFERER']);
        }
    }
    /**
     * 导播服务
     */
    function caster_action(){
        
        $xid     =  $_GET['id'];
        $xjhM    =  $this->MODEL('xjhlive');
        // 查询导播播放地址
        $xjh     =  $xjhM->getInfo(array('id'=>$xid));
        // 查询导播台素材
        $list	=	$xjhM->getMaterials(array('xid'=>$xid, 'orderby'=>'id,asc'));
        
        $this->yunset(array('xjh'=>$xjh,'pgmurl'=>$xjh['hls'],'list'=>$list));
        
        $this->yuntpl(array('admin/admin_xjhlive_caster'));
    }
    /**
     * 导播素材
     */
    function material_action(){
        
        $xjhM  =  $this->MODEL('xjhlive');
        $list  =  $xjhM->getMaterials(array('xid'=>$_GET['id'], 'orderby'=>'id'));
        
        $this->yunset('list', $list);
        
        $this->yuntpl(array('admin/admin_xjhlive_material'));
    }
    function addMaterial_action(){
        
        $xjhM  =  $this->MODEL('xjhlive');
        $row   =  $xjhM->getMaterial(array('id'=>$_GET['mid']));
        $this->yunset('row', $row);
        
        $this->yuntpl(array('admin/admin_xjhlive_material_add'));
    }
    function saveMaterial_action(){
        
        $_POST  =  $this->post_trim($_POST);
        
        $xid   =  $_POST['xid'];
        $xjhM  =  $this->MODEL('xjhlive');
        $list  =  $xjhM->getMaterials(array('xid'=>$xid));
        
        if (count($list) >= 8){
            
            $this->ACT_layer_msg('单个导播台最多可上传8份素材', 8, 'index.php?m=admin_xjhlive&c=material&id='. $xid);
        }
        $arr    =  array(
            'xid'     =>  $xid,
            'name'    =>  $_POST['name'],
            'ctime'   =>  time()
        );
        
        if (!empty($_FILES['file']['tmp_name'])){
            
            $result  =  $xjhM->uploadMaterial($_FILES['file'], $arr);
            
            if (!empty($result['msg'])){
                
                $this->ACT_layer_msg($result['msg'], 8, $_SERVER['HTTP_REFERER']);
            }
            
            $arr['url']     =  $result['url'];
            $arr['syncid']  =  $result['id'];
        }else{
            if (empty($_POST['id'])){
                
                $this->ACT_layer_msg('请上传文件', 8);
            }
        }
        
        if (!empty($_POST['id'])){
            
            $xjhM->upMaterial(array('id'=>$_POST['id']),$arr);
            
        }else{
            
            $xjhM->addMaterial($arr);
        }
        
        $this->ACT_layer_msg('上传成功', 9, 'index.php?m=admin_xjhlive&c=material&id='. $xid);
    }
    /**
     * 设置暖场视频
     */
    function setVideo_action(){
        
        $data  =  array(
            'state'   =>  $_POST['state']
        );
        
        $xjhM    =  $this->MODEL('xjhlive');
        $return  =  $xjhM->setCasterVideo(array('id'=>$_POST['id'],'xid'=>$_POST['xid']),$data);
        
        $this->layer_msg($return['msg'], $return['errcode']);
    }
    /**
     * 创建导播台
     */
    function createCaster_action(){
        
        $data  =  array(
            'xid'   =>  $_POST['id']
        );
        
        $xjhM    =  $this->MODEL('xjhlive');
        $return  =  $xjhM->createCaster($data);
        
        $this->layer_msg($return['msg'], $return['errcode']);
    }
    /**
     * 开启导播台
     */
    function openCaster_action(){
        
        $data  =  array(
            'xid'   =>  $_POST['id']
        );
        
        $xjhM    =  $this->MODEL('xjhlive');
        $return  =  $xjhM->openCaster($data);
        
        $this->layer_msg($return['msg'], $return['errcode']);
    }
    /**
     * 导播台切换监视器画面，并切换布局
     */
    function upMonitor_action(){
        
        $data  =  array(
            'xid'     =>  $_POST['xid'],
            'mid'     =>  $_POST['mid'],
            'layout'  =>  $_POST['layout']
        );
        
        $xjhM    =  $this->MODEL('xjhlive');
        $return  =  $xjhM->upMonitor($data);
        
        $this->layer_msg($return['msg'], $return['errcode']);
    }
    /**
     * 导播台把画面切换为正常直播画面
     */
    function liveCaster_action(){
        
        $data  =  array(
            'xid'     =>  $_POST['xid']
        );
        
        $xjhM    =  $this->MODEL('xjhlive');
        $return  =  $xjhM->liveCaster($data);
        
        $this->layer_msg($return['msg'], $return['errcode']);
    }
    /**
     * 查询是否可以创建宣讲会
     */
    function canAdd_action(){
        
        $xjhM    =  $this->MODEL('xjhlive');
        $return  =  $xjhM->xjhCanAdd();
        
        echo json_encode($return);die;
    }
    /**
     * 删除导播台素材
     */
    function delMaterial_action(){
        
        if($_POST['del']){
            
            $delID   =  $_POST['del'];
            $layer_type = 1;
            
        }elseif($_GET['id']){
            
            $this->check_token();
            $delID   =  $_GET['id'];
            $layer_type = 0;
        }
        
        $xjhM    =  $this->MODEL('xjhlive');
        $return  =  $xjhM->delMaterial($delID);
        
        $this->layer_msg($return['msg'], $return['errcode'], $layer_type, 1);
    }
    /**
     * 查询导播台状态
     */
    function getCaster_action(){
        
        $xjhM    =  $this->MODEL('xjhlive');
        $return  =  $xjhM->getInfo(array('id'=>$_POST['xid']));
        
        echo json_encode($return);die;
    }
    // 查询推流地址
    function getPushurl_action(){
        
        $xjhM    =  $this->MODEL('xjhlive');
        $return  =  $xjhM->getPushUrl(array('id'=>$_POST['id']));
        
        echo json_encode($return);die;
    }
}

?>