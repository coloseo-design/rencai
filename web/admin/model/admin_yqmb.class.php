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

class admin_yqmb_controller extends adminCommon
{

    function index_action()
    {

        $search_list[] = array('param' => 'status', 'name' => '审核状态', 'value' => array('0' => '未审核', '1' => '已审核', '2' => '未通过'));

        $this->yunset('search_list', $search_list);


        $typeStr    =   intval($_GET['type']);
        $keywordStr =   trim($_GET['keyword']);

        if (!empty($keywordStr)) {
            if ($typeStr == 1) {

                $comM   =   $this->MODEL('company');
                $com    =   $comM->getList(array('name' => array('like', $keywordStr)), array('field' => '`uid`'));
                $cuids  =   array();
                if (is_array($com['list'])) {
                    foreach ($com['list'] as $v) {

                        $cuids[]    =   $v['uid'];
                    }
                }
                $where['uid']   =   array('in', pylode(',', $cuids));

            } elseif ($typeStr == 2) {

                $where['uid']   =   intval($keywordStr);

            }
            $urlarr['type']     =   $typeStr;
            $urlarr['keyword']  =   $keywordStr;
        }

        if (isset($_GET['status'])) {

            $where['status']    =   intval($_GET['status']);
            $urlarr['status']   =   $_GET['status'];
        }
		$urlarr        	=   $_GET;
        $urlarr['page'] =   '{{page}}';
        $pageurl        =   Url($_GET['m'], $urlarr, 'admin');

        $pageM  =   $this->MODEL('page');
        $pages  =   $pageM->pageList('yqmb', $where, $pageurl, $_GET['page']);

        if ($pages['total'] > 0) {
            if (isset($_GET['order'])) {

                $where['orderby']   =   $_GET['t'] . ',' . $_GET['order'];
                $urlarr['order']    =   $_GET['order'];
                $urlarr['t']        =   $_GET['t'];
            } else {

                $where['orderby']   =   array('id,desc');
            }

            $where['limit']         =   $pages['limit'];

            $yqmbM                  =   $this->MODEL('yqmb');
            $mbList                 =   $yqmbM->getList($where, array('utype' => 'admin'));

            $this->yunset('rows', $mbList);

        }
        $this->yuntpl(array('admin/admin_yqmb'));
    }


    /**
     * @desc 删除分享职位
     */
    function delYqmb_action()
    {

        if ($_GET['del']) {

            $this->check_token();

            $yqmbM  =   $this->MODEL('yqmb');

            $return =   $yqmbM->delYqmb($_GET['del']);

            $this->layer_msg($return['msg'], $return['errcode'], $return['layertype'], $_SERVER['HTTP_REFERER']);
        } else {

            $this->layer_msg('请选择要删除的内容！', 8);
        }
    }

    function save_action()
    {

        $yqmbM  =   $this->MODEL('yqmb');

        if ($_POST['id']) {

            $where['id']    =   $_POST['id'];
        }
        $data   =   array(
            'uid'   =>  $_POST['uid']
        );
        $setdata    =   array(

            'name'      =>  $_POST['name'],
            'linkman'   =>  $_POST['linkman'],
            'linktel'   =>  $_POST['linktel'],
            'content'   =>  $_POST['content'],
            'intertime' =>  $_POST['intertime'],
            'address'   =>  $_POST['address'],
            'status'    =>  1
        );
        $return     =   $yqmbM->addInfo($setdata, $data, $where);

        if ($return['errcode'] == '9') {

            $this->ACT_layer_msg($return['msg'], $return['errcode'], $_SERVER['HTTP_REFERER'], 2, 1);
        } else {

            $this->ACT_layer_msg($return['msg'], $return['errcode']);
        }
    }

    /**
     * 返回审核原因
     */
    function lockinfo_action()
    {

        $yqmbM  =   $this->MODEL('yqmb');

        $info   =   $yqmbM->getInfo(array('id' => intval($_POST['id'])), array('field' => '`statusbody`'));

        echo $info['statusbody'];
        die;
    }

    /**
     * 审核
     */
    function status_action()
    {
        $yqmbM      =   $this->MODEL('yqmb');

        $statusData =   array(

            'status'        =>  intval($_POST['status']),
            'statusbody'    =>  trim($_POST['statusbody'])
        );

        $return     =   $yqmbM->statusYqmb($_POST['pid'], $statusData);

        $this->ACT_layer_msg($return['msg'], $return['errcode'], "index.php?m=admin_yqmb", 2, 1);
    }

}
