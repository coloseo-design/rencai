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
class friendhelp_controller extends company
{

	function index_action()
    {
		
		if($this -> config['sy_help_open'] !='1'){

			$this->ACT_msg('index.php', '好友助力已关闭！',8);
		}

        $this->public_action();

		$helpM			=   $this -> MODEL('friendhelp');
		
		$uid			=	$this -> uid;
		$where['comid']	=	$uid;
		$where['etime']	=	array('<',time());

		 //分页链接
		$urlarr['c']	=	$_GET['c'];
        $urlarr['page']	=	'{{page}}';
        
        $pageurl		=	Url('wap',$urlarr,'member');
        
        //提取分页
        $pageM			=	$this  -> MODEL('page');
        $pages			=	$pageM -> pageList('friend_help',$where,$pageurl,$_GET['page']);
        
        //分页数大于0的情况下 执行列表查询
        if($pages['total'] > 0){
            
			$where['orderby']		=	array('etime,desc');
			
            $where['limit']			=	$pages['limit'];
            
            $rows	    =	$helpM -> getList($where);
			$this->yunset('rows',$rows['list']);
        }
		//获取当前执行中的任务
		$helpinfo	    =	$helpM -> getInfo(array('comid'=>$this -> uid,'etime'=>array('>=',time())));
		if(!empty($helpinfo)){

			$loglist	=	$helpM -> getLogList(array('pid' => $helpinfo['id'],'orderby'=>'id,desc','limit'=>'5'));
			$this->yunset("loglist",$loglist);
			$this->yunset('helpinfo',$helpinfo);
		}
		$nowpackage		=	$helpM -> getPackageInfo($this -> uid);
		$this->yunset("nowpackage",$nowpackage);
		$this -> com_tpl('friendhelp');
	}

    function nowpackage_action()
    {

        $helpM      =   $this->MODEL('friendhelp');

        $package    =   $helpM->getPackageInfo($this->uid);

        if ($package) {
            echo json_encode($package);
        }
    }

    function addhelp_action()
    {

        if ($this->config['sy_help_open'] != '1') {

            $this->layer_msg('暂未开启好友助力！', 8, 0);
        }

        $helpM      =   $this->MODEL('friendhelp');
        $return     =   $helpM->addHelp($this->uid);
        echo json_encode($return);
    }

    function gethelpcode_action()
    {

        if ($_GET['id'] && $_GET['token']) {

            $url    =   Url('wap') . 'index.php?c=friendhelp&a=show&id=' . intval($_GET['id']) . '&token=' . rawurlencode($_GET['token']);
            include_once LIB_PATH . "yunqrcode.class.php";
            YunQrcode::generatePng2($url, 4);
        }
    }

    function getlog_action()
    {

        if ($_POST['id']) {

            $helpM      =   $this->MODEL('friendhelp');
            $logList    =   $helpM->getLogList(array('pid' => intval($_POST['id']), 'comid' => $this->uid, 'orderby' => 'id'), array('field' => '`wxpic`'));
            if (!empty($logList)) {
                echo json_encode($logList);
            }
        }
    }

	//领取权益
    function getpackage_action()
    {

        if ($this->config['sy_help_open'] != '1') {
            $this->layer_msg('好友助力已关闭！', 9, 0);
        }

        if ($_POST['id']) {

            $helpM = $this->MODEL('friendhelp');
            $return = $helpM->givePackage($_POST['id'], $this->uid);
            echo json_encode($return);
        }
    }
    //查看助力好友记录
    function loglist_action()
    {
        if ($_POST['id']) {

            $helpM      =   $this->MODEL('friendhelp');
            $logList    =   $helpM->getLogList(array('pid' => intval($_POST['id'])));
            if (!empty($logList)) {
                echo json_encode($logList);
            }
        }
    }
}
?>