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
class article_controller extends wxapp_controller{
    /**
     * 职场资讯
     */
	function index_action()
    {
        $time = time();

        $articleM  =  $this->MODEL('article');
        $keyword   =  $this->stringfilter($_POST['keyword']);

        $page   =  $_POST['page'];
        $limit  =  $_POST['limit'];
        $limit  =  ! $limit ? 20 : $limit;
        if (!empty($_POST['nid'])) {
            
            $nidarr  =  array($_POST['nid']);
            
            $group  =  $articleM->getClass(array('keyid'=>$_POST['nid']));
            
            if (!empty($group['list'])){
                
                foreach ($group['list'] as $v){
                    
                    $nidarr[] = $v['id'];
                }
            }
            $where['nid']  =  array('in', pylode(',', $nidarr));
        }else{
            // 推荐
            $where['describe'] = array('findin', 'tj');
        }
        if ($_POST['keyword']) {
            $where['title']  =  array(
                'like',
                $_POST['keyword']
            );
        }

        //新闻资讯开始时间
        $where['PHPYUNBTWSTART_A'] = array();
        $where['starttime'][]  =  array('<=',$time,'OR');
        $where['starttime'][]  =  array('=',0,'OR');
        $where['starttime'][]  =  array('isnull','','OR');
        $where['PHPYUNBTWEND_A'] = array();
        //结束时间
        $where['PHPYUNBTWSTART_B'] = array();
        $where['endtime'][]  =  array('>',$time,'AND');
        $where['endtime'][]  =  array('=',0,'OR');
        $where['endtime'][]  =  array('isnull','','OR');
        $where['PHPYUNBTWEND_B'] = array();
        
        // 处理分站查询条件
        if (!empty($_POST['did'])){
            $where['PHPYUNBTWSTART_C'] = array();
            $where['did'][]  =  $_POST['did'];
            $where['did'][]  =  array('=','-1','OR');
            $where['PHPYUNBTWEND_C'] = array();
        }
        
        $where['orderby']  =  'starttime,desc';
        if ($page) {
            $pagenav  =  ($page - 1) * $limit;
            $where['limit']  =  array(
                $pagenav,
                $limit
            );
        } else {
            $where['limit']  =  array(
                '',
                $limit
            );
        }
        
        $data  =  array();
        $rows  =  $articleM->getList($where);
        $List  =  $rows['list'];
        if (is_array($List) && ! empty($List)) {
            $data['list']   =  count($List) ? $List : array();
            
            // 小程序用seo
            if (isset($_POST['provider'])){
                if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao'){
                    $seo            =  $this->seo('news','','','',false, true);
                    $data['seo']    =  $seo;
                }
            }
            
            $error  =  1;
        } else {
            $error  =  2;
        }

        $this->render_json($error, '', $data);
    }

    /**
     * 职场资讯-详情
     */
	function show_action()
	{
		$id			=	(int)$_POST['id'];
		if(!$id){
			$error	=	2;
			$msg	=	'参数错误';
		}else{
			$articleM	=	$this->MODEL('article');
			$info		= 	$articleM->getInfo(array('id'=>$id),array('iscon'=>1));
			
			if (isset($_POST['provider'])){
			    // app用分享数据
			    if ($_POST['provider'] == 'app'){

			        $data['shareData']  =  array(
			            'url'       =>  Url('wap',array('c'=>'article','a'=>'show','id'=>$id)),
			            'title'     =>  $info['title'],
			            'summary'   =>  mb_substr(strip_tags($info['content']), 0,30,'UTF8'),
			            'imageUrl'  =>  checkpic($info['newsphoto_n'],$this->config['sy_wx_sharelogo'])
			        );
			    }
			    // 小程序用seo
                if ($_POST['provider'] == 'baidu' || $_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao') {
                    // 将微信汉字替换，防止审核时被判断为诱导分享
                    $info['content']        =   str_ireplace(array('微信', '同号'), '', $info['content']);
                    // 过滤iframe标签，防止有视频链接
                    $info['content']        =   preg_replace("/<(i?frame.*?)>(.*?)<(\/i?frame.*?)>/si","",$info['content']);

                    $class                  =   $articleM->getGroup(array('id' => $info['nid']));

                    $seodata['news_class']  =   $class['name'];//新闻类别
                    $seodata['news_title']  =   $info['title'];//新闻名称
                    $seodata['news_keyword']=   $info['keyword'];//描述
                    $description            =   $info['description'] ? $info['description'] : $info['content'];
                    $seodata['news_desc']   =   $this->GET_content_desc($description);//描述
                    $this->data 			= 	$seodata;

                    $seo                    =   $this->seo('news_article', '', '', '', false, true);
                    $data['seo']            =   $seo;
                }
			}
			$error	=	1;
			$msg    =   '';
			
			$data['info']	=	!empty($info)?$info:array();
		}
		$this -> render_json($error,$msg,$data);
	}
	/**
	 * 职场资讯-详情-相关推荐
	 */
	function showOther_action(){
	    
	    $id			=	(int)$_POST['id'];
	    $articleM	=	$this->MODEL('article');
	    $info		= 	$articleM->getInfo(array('id'=>$id),array('field'=>'`keyword`'));
	    $articleM -> upBase(array('id'=>$id),array('hits'=>array('+',1)));
	    if($info['keyword']!=''){
	        //分割关键字
	        $keyarr 	= 	@explode(',',$info['keyword']);
	        if(is_array($keyarr) && !empty($keyarr)){
	            // 处理分站查询条件
	            if (!empty($_POST['did'])){
	                $where['did']  =  $_POST['did'];
	            }
	            $where['PHPYUNBTWSTART_A']	=	'' ;
	            foreach($keyarr as $key=>$value){
	                $where['keyword'][]		=	array('like',$value,'OR') ;
	            }
	            $where['PHPYUNBTWEND_A']	=	'' ;
	            $where['id']				=	array('<>',$id);
	            $where['orderby']			=	'id,desc';
	            $where['limit']				=	6;
	            
	            $aboutlist		=	$articleM->getList($where);//相关文章
	            $data['about']	=	count($aboutlist['list'])?$aboutlist['list']:array();
	        }
	    }
	    $this -> render_json(0,'',$data);
	}
}
?>