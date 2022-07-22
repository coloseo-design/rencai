<?php

/**
 * $Author ：PHPYUN开发团队
 *
 * 官网: http://www.phpyun.com
 *
 * 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
 *
 * 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
class   admin_hb_config_controller extends adminCommon
{

    function index_action()
    {
        $this->yuntpl(array('admin/admin_hb_setting'));
    }

    function job_action(){
        $WhbM       =   $this->MODEL('whb');

        $jobHbList  =   $WhbM->getWhbList(array('type' => 1, 'orderby' => 'sort,desc'));
        $this->yunset('jobHbList', $jobHbList);

        $this->yuntpl(array('admin/admin_hb_job'));
    }

    function com_action(){
        $WhbM       =   $this->MODEL('whb');

        $comHbList  =   $WhbM->getWhbList(array('type' => 2, 'orderby' => array('style,desc','sort,desc')));
        $this->yunset('comHbList', $comHbList);

        $this->yuntpl(array('admin/admin_hb_com'));
    }

    function inviteReg_action(){
        $WhbM       =   $this->MODEL('whb');

        $irHbList  =   $WhbM->getWhbList(array('type' => 3, 'orderby' => array('style,desc','sort,desc')));
        $this->yunset('irHbList', $irHbList);

        $this->yuntpl(array('admin/admin_hb_invite_reg'));
    }

    function gongzhao_action(){
        $WhbM       =   $this->MODEL('whb');

        $irHbList  =   $WhbM->getWhbList(array('type' => 4, 'orderby' => array('style,desc','sort,desc')));
        $this->yunset('irHbList', $irHbList);

        $this->yuntpl(array('admin/admin_hb_gongzhao'));
    }

    function saveWhbConfig_action()
    {
        if ($_POST["config"]) {
            unset($_POST["config"]);
            unset($_POST['pytoken']);

            // 海报设置
            if(isset($_POST['sy_haibao_isopen'])){
                $configM    =   $this->MODEL('config');

                $configData['sy_haibao_isopen'] =   $_POST['sy_haibao_isopen'];
                $configData['sy_haibao_web_type'] =   $_POST['sy_haibao_web_type'];
                $configData['sy_haibao_web_name'] =   $_POST['sy_haibao_web_name'];

                $configM->setConfig($configData);
            }else{
                $WhbM       =   $this->MODEL('whb');

                $hbIds      =   array();

                $openHbIds  =   array();
                $closeHbIds =   array();

                // 职位海报
                if (isset($_POST['sy_job_hb'])) {
                    $type = 1;
                    $hbIds   =   explode(',', $_POST['sy_job_hb']);
                }
                // 企业海报
                if (isset($_POST['sy_com_hb'])) {
                    $type = 2;
                    $hbIds   =   explode(',', $_POST['sy_com_hb']);
                }
                // 邀请注册海报
                if(isset($_POST['sy_invite_reg_hb'])) {
                    $type = 3;
                    $hbIds   =   explode(',', $_POST['sy_invite_reg_hb']);
                }
                $imgList    =   $WhbM->getWhbList(array('orderby' => 'sort,desc', 'type' => $type));

                foreach ($imgList as $k => $v) {
                    if (in_array($v['id'], $hbIds)) {
                        $openHbIds[]    =   $v['id'];
                    } else {
                        $closeHbIds[]   =   $v['id'];
                    }
                }

                if (!empty($openHbIds)) {
                    $WhbM->updateWhb(array('isopen' => 1), array('id' => array('in', pylode(',', $openHbIds))));
                }
                if (!empty($closeHbIds)) {
                    $WhbM->updateWhb(array('isopen' => 0), array('id' => array('in', pylode(',', $closeHbIds))));
                }
            }

            $this->web_config();

            $this->ACT_layer_msg("配置修改成功！", 9, 1, 2, 1);
        }
    }

    function delWhb_action()
    {

        if ($_POST['id']) {

            $WhbM   =   $this->MODEL('whb');

            $whb    =   $WhbM->getWhb(array('id' => $_POST['id']));

            if (!empty($whb)) {

                $WhbM->delWhb(array('id' => $whb['id']));

                $this->ACT_layer_msg('海报删除成功！', 9, 1, 2, 1);
            }
        } else {
            $this->ACT_layer_msg('参数错误请重试！', 8, 1);
        }
    }

    function saveWhb_action()
    {

        $WhbM   =   $this->MODEL('whb');

        $_POST  =   $this->post_trim($_POST);

        $id     =   $_POST['id'];

        $dataV  =   array(
            'type'      =>  $_POST['type'],
            'name'      =>  $_POST['wname'],
            'sort'      =>  $_POST['wsort'],
            'num'       =>  $_POST['num'],
            'style'       =>  $_POST['style'],
            'isopen'    =>  $_POST['wopen'] ? 1 : 0
        );

        if ($_FILES['file']['tmp_name']) {

            $upArr  =   array(
                'file'  =>  $_FILES['file'],
                'dir'   =>  'whb'
            );

            $uploadM    =   $this->MODEL('upload');

            $pic        =   $uploadM->newUpload($upArr);

            if (!empty($pic['msg'])) {

                $this->ACT_layer_msg($pic['msg'], 8);
            } elseif (!empty($pic['picurl'])) {

                $dataV['pic']   =   $pic['picurl'];
            }
        }

        $dataW          =   array();

        if ($id) {
            $dataW['id']=   $id;
        }

        $return         =   $WhbM->setWhb($dataV, $dataW);

        $this->ACT_layer_msg($return['msg'], $return['errcode'], $_SERVER['HTTP_REFERER'], 2, 1);
    }
}

?>