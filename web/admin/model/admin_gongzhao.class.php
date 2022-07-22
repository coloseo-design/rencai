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

class admin_gongzhao_controller extends adminCommon
{
    function set_search()
    {
        $ad_time       = array('1' => '今天', '3' => '最近三天', '7' => '最近七天', '15' => '最近半月', '30' => '最近一个月');
        $search_list[] = array("param" => "end", "name" => '发布时间', "value" => $ad_time);
        $this->yunset("search_list", $search_list);
    }

    function index_action()
    {
        $this->set_search();
        $gongzhaoM = $this->MODEL('gongzhao');
        if (trim($_GET['keyword'])) {
            $where['title']    = array('like', trim($_GET['keyword']));
            $urlarr['keyword'] = $_GET['keyword'];
        }

        if ($_GET['end']) {
            if ($_GET['end'] == 1) {
                $where['datetime'] = array('>=', strtotime(date("Y-m-d 00:00:00")));
            } else {
                $where['datetime'] = array('>=', strtotime('-' . intval($_GET['end']) . ' day'));
            }

            $urlarr['end'] = $_GET['end'];
        }
        $urlarr         = $_GET;
        $urlarr['page'] = "{{page}}";
        $pageurl        = Url($_GET['m'], $urlarr, 'admin');
        $pageM          = $this->MODEL('page');
        $pages          = $pageM->pageList('gongzhao', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {
            if ($_GET['order']) {
                $where['orderby'] = $_GET['t'] . ',' . $_GET['order'];
                $urlarr['order']  = $_GET['order'];
                $urlarr['t']      = $_GET['t'];
            } else {
                $where['orderby'] = 'id';
            }

            $where['limit'] = $pages['limit'];
            $Listgongzhao   = $gongzhaoM->getList($where);
            $this->yunset("gongzhao", $Listgongzhao['list']);
        }

        //提取分站内容
        $cacheM = $this->MODEL('cache');
        $domain = $cacheM->GetCache('domain', $Options = array('needreturn' => true, 'needassign' => true, 'needall' => true));
        $this->yunset('Dname', $domain['Dname']);
        $this->yunset("get_type", $_GET);
        $this->yuntpl(array('admin/admin_gongzhao_list'));

    }

    function add_action()
    {
        $gongzhaoM = $this->MODEL('gongzhao');
        if ($_GET['id']) {
            $id   = intval($_GET['id']);
            $info = $gongzhaoM->getInfo(array('id' => $id));
            $this->yunset("info", $info);
            $this->yunset('lasturl', $_SERVER['HTTP_REFERER']);
        }

        //提取分站内容
        $cacheM = $this->MODEL('cache');
        $domain = $cacheM->GetCache('domain', $Options = array('needreturn' => true, 'needassign' => true, 'needall' => true));
        $this->yunset('Dname', $domain['Dname']);
        $this->yuntpl(array('admin/admin_gongzhao_add'));

    }

    function save_action()
    {
        $_POST             = $this->post_trim($_POST);
        $gongzhaoM         = $this->MODEL('gongzhao');

        $_POST['startime'] = $_POST['startime'] ? $_POST['startime'] : date('Y-m-d H:i:s', time());

        // pc端上传
        if($_FILES['file']['tmp_name']){
            $upArrsl    =  array(
                'file'  =>  $_FILES['file'],
                'dir'   =>  'gongzhao'
            );
            $uploadM  =  $this->MODEL('upload');
            if(!empty($upArrsl)){
                $picsl      =  $uploadM->newUpload($upArrsl);
            }
            

            if ($picsl && !empty($picsl['msg'])){

                $return['msg']      =  $picsl['msg'] ? $picsl['msg'] : $pichf['msg'];

                $this -> ACT_layer_msg($return['msg'],8);

            }else{
                if (!empty($picsl['picurl'])){

                    $_POST['pic']  =  $picsl['picurl'];

                }
            }
        }
        
        
       
        if ($_POST['update']) {
            $lasturl = str_replace("&amp;", "&", $_POST['lasturl']);
            unset($_POST['lasturl']);
            $nid = $gongzhaoM->upInfo(array('id' => intval($_POST['id'])), $_POST);
            $nid ? $this->ACT_layer_msg("公招(ID:" . $_POST['id'] . ")更新成功！", 9, $lasturl, 2, 1) : $this->ACT_layer_msg("公招(ID:" . $_POST['id'] . ")更新失败！", 8, $lasturl, 2, 1);
        }

        if ($_POST['add']) {
            $nid = $gongzhaoM->addInfo($_POST);
            $nid ? $this->ACT_layer_msg("公招添加成功！", 9, "index.php?m=admin_gongzhao", 2, 1) : $this->ACT_layer_msg("公招添加失败！", 8, "index.php?m=admin_gongzhao", 2, 1);
        }
    }

    function del_action()
    {
        $this->check_token();
        $gongzhaoM = $this->Model('gongzhao');
        $delID     = $_GET['id'] ? intval($_GET['id']) : $_GET['del'];
        $addArr    = $gongzhaoM->delgongzhao($delID);
        $this->layer_msg($addArr['msg'], $addArr['errcode'], $addArr['layertype'], $_SERVER['HTTP_REFERER'], 2, 1);
    }

    function checksitedid_action()
    {
        if ($_POST['uid']) {
            $uids = @explode(',', $_POST['uid']);
            $uid  = pylode(',', $uids);
            if ($uid) {
                $siteDomain = $this->MODEL('site');
                $siteDomain->updDid(array('admin_gongzhao'), array('id' => array('in', $uid)), array('did' => $_POST['did']));
                $this->ACT_layer_msg('公招(ID:' . $_POST['uid'] . ')分配站点成功！', 9, $_SERVER['HTTP_REFERER']);
            } else {
                $this->ACT_layer_msg('请正确选择需分配数据！', 8, $_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->ACT_layer_msg('参数不全请重试！', 8, $_SERVER['HTTP_REFERER']);
        }
    }
    function whb_action()
    {
        $WhbM       =   $this->MODEL('whb');
        $gzHb      =   $WhbM->getWhbList(array('type' => 4, 'isopen' => '1','orderby' => 'sort,desc'));
        $this->yunset('gzHb', $gzHb);

        $gzid  =   intval($_GET['id']);
        $this->yunset('gzid', $gzid);
        $this->yuntpl(array('wap/hb/gongzhao_whb'));
    }
    // 设置和取消推荐
    function setRec_action(){
        
        $id  = intval($_POST['id']);
        if (intval($_POST['rec'] == 1)){
            $rec = 1;
            $msg = '设置推荐';
        }else{
            $rec = 0;
            $msg = '取消推荐';
        }
        
        $gongzhaoM = $this->Model('gongzhao');
        $nid = $gongzhaoM->upInfo(array('id' => intval($_POST['id'])), array('rec'=>$rec));
        $nid ? $this->layer_msg($msg."成功(ID:" . $id . ")", 9) : $this->layer_msg($msg."失败(ID:" . $id . ")", 8);
    }
}

?>