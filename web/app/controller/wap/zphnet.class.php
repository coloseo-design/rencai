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
class zphnet_controller extends common{
    
    function index_action(){
        $this->yunset('backurl',Url('wap'));
        $this->yunset('headertitle','网络招聘会');
        $this->seo('zph');
        $this->yuntpl(array('wap/zphnet'));
    }
    
    function show_action(){

        $zid      =  intval($_GET['id']);
        $zphnetM  =  $this->MODEL('zphnet');
        // 网络招聘会信息
        $row      =  $zphnetM->getInfo(array('id'=>$zid));
        $this->yunset('row',$row);
        //用户进入记录
        if ($this->uid && $this->usertype){
            
            //招聘会未结束记录用户进入记录
            if ($row['etime'] > 0){
                
                $zphnetM->addZphnetUser(array('zid'=>$zid,'uid'=>$this->uid,'usertype'=>$this->usertype));
            }
            
            if ($this->usertype == 1){
                
                $resumeM  =  $this->MODEL('resume');
                $enum     =  $resumeM->getExpectNum(array('uid'=>$this->uid));
                
                $this->yunset('enum',$enum);
                $this->yunset('addresumeurl',Url('wap',array('c'=>'addresume'), 'member'));
            }
        }

        $jkeyword  =  $rkeyword  =  '';
        if ($_GET['ztype'] == 'job'){
            
            $jkeyword  =  trim($_GET['keyword']);
            
        }elseif ($_GET['ztype'] == 'resume'){
            
            $rkeyword  =  trim($_GET['keyword']);
        }
        //进入大厅滚动展示
        $horn    =  $zphnetM->getZphnetUser(array('zid'=>$zid,'orderby'=>'ctime','limit'=>10));
        $this->yunset('horn',$horn);
        // 数量统计
        $allnum  =  $zphnetM->getZphnetAllNum(array('zid'=>$zid, 'status'=>1));
        $this->yunset('allnum',$allnum);
        // 查看职位记录
        $look    =  $zphnetM->getZphnetLook(array('zid'=>$zid,'orderby'=>'ctime','limit'=>15));
        $this->yunset('look',$look);
        // 企业列表展示，招聘会绑定了展示区域，按区分分类查
        if(!empty($row['zw'])){
            
            $zphArea  =  $zphnetM->getClass(array('id'=>$row['zw']));
            $this->yunset('zphArea',$zphArea);
            
            $area   =  $zphnetM->getClassList(array('keyid'=>$row['zw'],'orderby'=>'sort,asc'));
            $this->yunset('area',$area);
        }
        
        if ($_GET['zw']){
            $zw  =  intval($_GET['zw']);
        }elseif ($_GET['zw'] == 'other'){
            $zw  =  0;
        }
        
        $areaCom    =   $zphnetM->getAreaComList(array('zid'=>$row['id'],'limit'=>'20'),array('zw'=>$zw,'keyword'=>$jkeyword));
        $this->yunset('areaCom',$areaCom);
        
        if($_GET['boxtype']){
            
            $this->yunset('boxtype', $_GET['boxtype']);
        }
		if($_GET['form']=='list' && $_GET['type']=='wlzph') {
            $this->yunset('backurl', Url('wap', array('c' => 'zph','type'=>'wlzph')));
        }elseif($_GET['form']=='list'){
            $this->yunset('backurl', Url('wap', array('c' => 'zphnet')));
        }
        $this->yunset('headertitle','网络招聘会详情');
        
        $CacheM		=	$this -> MODEL('cache');
        $CacheList	=	$CacheM -> GetCache(array('hy','com'));
        $this->yunset($CacheList);
        
        $data['zph_title']	=	$row['title'];
        $data['zph_desc']	=	$this->GET_content_desc($row['body']);
        $this->data			=	$data;
        $this->seo('zph_show');
        $this->yuntpl(array('wap/zphnet_show'));
    }
    // 加载企业列表
    function getComList_action()
    {
        $zid      =  intval($_POST['zid']);
        $zphnetM  =  $this->MODEL('zphnet');
        $row      =  $zphnetM->getInfo(array('id'=>$zid));
        // 关键词搜索/已分配展位时，一页全部加载，不需要分页
        if ($_POST['keyword'] == ''){
            $page     =  intval($_POST['page']);
            $limit    =  20;
            
            $where['zid']      =  $zid;
            if($page > 0){
                
                $pagenav  =  ($page - 1) * $limit;
                $where['limit']  =  array($pagenav,$limit);
                
            }else{
                
                $where['limit']  =  $limit;
            }
            if ($_POST['zw']){
                $zw  =  intval($_POST['zw']);
            }elseif ($_POST['zw'] == 'other'){
                $zw  =  0;
            }
            $areaCom  =  $zphnetM->getAreaComList($where,array('zw'=>$zw,'utype'=>'wap'));
            
            $areaCom['spOpen']     =  $this->config['sy_spview_web'];
            $areaCom['usertype']   =  $this->usertype;
            
            echo json_encode($areaCom);
        }
    }
    /**
     * 保存查看企业、职位记录
     */
    function setLook_action()
    {
        
        $zid    =  intval($_POST['id']);
        $jobid  =  intval($_POST['jobid']);
        $comid  =  intval($_POST['comid']);
        
        $zphnetM  =  $this->MODEL('zphnet');
        $row      =  $zphnetM->getInfo(array('id'=>$zid));
        
        //招聘会进行中才保存
        if ($row['etime'] > 0){
            
            $data   =  array(
                'uid'       =>  $this->uid,
                'usertype'  =>  $this->usertype,
                'zid'       =>  $zid,
                'jobid'     =>  $jobid,
                'comid'     =>  $comid,
                'ctime'     =>  time()
            );
            
            $zphnetM->addZphnetLook($data);
        }
    }
    /**
     * 企业报名网络招聘会
     */
    function ajaxZphnet_action(){
        $data	=	array(
            'usertype'	=>	$this->usertype,
            'uid'		=>	$this->uid,
            'spid'		=>	$this->spid,
			'jobid'		=>	$_POST['jobid'],
            'zid'		=>	intval($_POST['zid']),
        );
        $zphnetM  =  $this->MODEL('zphnet');
        $arr	  =  $zphnetM->ajaxZphnet($data);
        
        if ($arr['status'] == 2 && !empty($_POST['jobid'])){
            // 套餐不足，记录jobid的cookie来备用
            $this->cookie->setcookie('zphjobid', $_POST['jobid'], time()+86400);
        }
        
        echo json_encode($arr);die;
    }
    /**
     * 检查参会情况
     */
    function isJoin_action(){
        
        if ($this->uid){
            
            $zphnetM  =  $this->MODEL('zphnet');
            
            $row      =  $zphnetM->getZphnetCom(array('uid'=>$this->uid,'zid'=>$_POST['zid']),array('field'=>'`status`'));
            if(!empty($row)) {
                
                $row['code'] = 1;
                
            }else{
                $row['code'] = 2;
            }
            
            echo json_encode($row);
        }
    }

    function GetHits_action()
    {
        $id = intval($_GET['id']);
        if (empty($id)) {
            echo 'document.write(0)';
            die();
        }

        $zphnetM   =   $this->MODEL('zphnet');

        $zphnetM->addZphnetHits($id);

        $hits   =   $zphnetM->getInfo(array('id' => $id), array('field' => '`hits`'));
        echo 'document.write('.$hits['hits'].')';
        die();
    }
}
?>