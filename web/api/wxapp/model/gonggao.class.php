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
class gonggao_controller extends wxapp_controller{

    /**
     * 公告列表
     */
    function getgonggao_action()
    {
		$AnnouncementM		=	$this->MODEL('announcement');

		$time = time();
		//公告开始时间条件
		$where['PHPYUNBTWSTART_A'] = array();
		$where['startime'][]  = array('<=',$time,'OR');
		$where['startime'][]  = array('=',0,'OR');
		$where['startime'][]  = array('isnull','','OR');
		$where['PHPYUNBTWEND_A'] = array();


		$where['PHPYUNBTWSTART_B'] = array();
		$where['endtime'][]  =  array('>',$time,'AND');
		$where['endtime'][]  =  array('=',0,'OR');
		$where['endtime'][]  =  array('isnull','','OR');
		$where['PHPYUNBTWEND_B'] = array();
		// 处理分站查询条件
		if (!empty($_POST['did'])){
		    $where['did']  =  $_POST['did'];
		}

		$page		=	$_POST['page'];
		$limit		=	$_POST['limit'];
		$limit		=	!$limit?10:$limit;

		$where['orderby']	=	"startime,desc";
		if($page){
			$pagenav		=	($page-1)*$limit;
			$where['limit']	=	array($pagenav,$limit);
		}else{
			$where['limit']	=	array('',$limit);
		}


	    $rows	=	$AnnouncementM->getList($where,array('field'=>'`id`,`title`,`startime`','utype'=>'wxapp'));

        if(is_array($rows)&&$rows){
	        $data['list']	=	count($rows['list']) > 0 ? $rows['list'] : array();
	        // 小程序用seo
	        if (isset($_POST['provider'])){
	            if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
	                $seo            =  $this->seo('gonggao','','','',false, true);
	                $data['seo']    =  $seo;
	            }
	        }
			$data['error']	=	1;
		}else{
			$data['error']	=	2;
		}
		// 判断版本，向上兼容，误删
		if (isset($_POST['v']) && $_POST['v'] == '6.1'){
		    $this->render_json($data['error'],'',$data);
		}else{
		    $this->render_json($data['error'],'',$data['list']);
		}
	}


    /**
     * 公告详情
     */
    function gonggaoshow_action()
    {
	    $id = (int)$_POST['id'];
	    if(!$id){
	        $data['error']=3;
	    }else{
			$announcementM	=	$this->MODEL('announcement');
			$row			=	$announcementM->getInfo(array('id'=>$id));
			if(is_array($row)){

			    $content  =  str_replace(array('&quot;','&nbsp;','<>'), array('','',''), $row['content']);

			    $content  =  htmlspecialchars_decode($content);

			    preg_match_all('/<img(.*?)src=("|\'|\s)?(.*?)(?="|\'|\s)/',$content,$res);

			    if(!empty($res[3])){
			        foreach($res[3] as $v){
			            if(strpos($v,'http:')===false && strpos($v,'https:')===false){

			                $content  =  str_replace($v,$this->config['sy_ossurl'].$v,$content);
			            }
			        }
			    }
			    $row['content']  =  $content;

			    if (isset($_POST['provider'])) {
			        // app用分享数据
			        if ($_POST['provider'] == 'app'){
			            
			            $data['shareData']  =  array(
			                'url'       =>  Url('wap',array('c'=>'announcement','id'=>$id)),
			                'title'     =>  $row['title'],
			                'summary'   =>  mb_substr(strip_tags($row['content']), 0,30,'UTF8'),
			                'imageUrl'  =>  $this->config['sy_wx_sharelogo']
			            );
			        }
			        // 小程序用seo
			        if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao') {
			            // 将微信汉字替换，防止审核时被判断为诱导分享
			            $row['content']        =   str_ireplace(array('微信', '同号'), '', $row['content']);
			            // 过滤iframe标签，防止有视频链接
			            $row['content']        =   preg_replace("/<(i?frame.*?)>(.*?)<(\/i?frame.*?)>/si","",$row['content']);
			            
			            $seodata['gg_title']    =   $row['title'];//名称
			            $seodata['gg_keyword']  =   $row['keyword'];//关键词
			            $seodata['gg_desc']     =   $this->GET_content_desc($row['content']);//描述
			            $this->data             =   $seodata;
			            
			            $seo                    =   $this->seo('gonggao_show', '', '', '', false, true);
			            $data['seo']            =   $seo;
			        }
			        
			    }
			    $data['list']	=	$row;
				$data['error']	=	1;
			}else{
				$data['error']	=	2;
			}
		}
		// 判断版本，向上兼容，误删
		if (isset($_POST['v']) && $_POST['v'] == '6.1'){
		    $this->render_json($data['error'],'',$data);
		}else{
		    $this->render_json($data['error'],'',$data['list']);
		}
	}
}
?>