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
class admin_news_controller extends siteadmin_controller{

	//时间区间
	public $timeSection		=	array(
		'1'		=>	'今天',
		'3'		=>	'最近三天',
		'7'		=>	'最近七天',
		'15'	=>	'最近半月',
		'30'	=>	'最近一个月'
	);
	
	//设置高级搜索功能
	public function set_search($groupList, $cateStr){

		//获取一级分类数据
		$newsarr			=	array();
		if(isset($groupList['one_class'])){
			foreach ($groupList['one_class'] as $oneV) {
				$newsarr[$oneV['id']]	=	$oneV['name'];
			}
		}
		//获取二级分类数据
		$newsarrs			=	$tmpTwo	=	array();
		$groupTwo			=	$groupList['two_class'];
		if(!empty($cateStr)){
			$tmpTwo			=	isset($groupTwo[$cateStr]) ? $groupTwo[$cateStr] : array();
			$this -> yunset("cateinfo", $groupList['list'][$cateStr]);
		}

		if(!empty($tmpTwo)){
			foreach ($tmpTwo as $twoV) {
				$newsarrs[$twoV['id']]	=	$twoV['name'];
			}
		}
		$search_list[]		=	array(
			'param'			=>	'publish',
			'name'			=>	'发布时间',
			'value'			=>	$this -> timeSection
		);
		$search_list[]		=	array(
			'param'			=>	'cate',
			'name'			=>	'新闻类别',
			'value'			=>	$newsarr
		);
		if(!empty($newsarrs) && !empty($cateStr)){
			$search_list[]	=	array(
				'param'		=>	'cates',
				'name'		=>	'新闻子类',
				'value'		=>	$newsarrs
			);
		}
		$this -> yunset('search_list', $search_list);
	}
	/**
	 * 内容 - 新闻 - 新闻管理
	 * 2019-06-06 hjy
	 */
	public function index_action(){

		//实例化新闻类
		$articleM		=	$this -> MODEL('article');

		//提取新闻分类		
		$listNew		=	$articleM -> getClass(array('isson' => 1));
		$newsGroup		=	$listNew['list'];

		$cateStr		=	intval($_GET['cate']);

		//设置搜索，传入新闻分类
		$this -> set_search($listNew, $cateStr);

		$two_class		=	$listNew['two_class'];
		$this -> yunset('one_class', $listNew['one_class']);
		$this -> yunset('two_class', $two_class);

        //搜索条件
		if (!empty($cateStr)){
			if(isset($two_class[$cateStr])){
				$ids				=	array_keys($two_class[$cateStr]);
			}
			$ids[]					=	$cateStr;

			$where['nid']			=	array('in', pylode(',',$ids));
			$urlarr['cate']			=	$cateStr;
		}

        if ($_GET['cates'] != '')
		{            
			$where['nid']			=	$_GET['cates'];

			$urlarr['cates']		=	$_GET['cates'];
		}
		if($_GET['adtime'])
		{
			if($_GET['adtime']=='1')
			{
				$where['datetime']	=	array('>',strtotime(date('Y-m-d 00:00:00')));
				
			}else{

				$where['datetime']	=	array('>',strtotime('-'.intval($_GET['adtime']).' day'));
			}

			$urlarr['adtime']		=	$_GET['adtime'];
		}
		if($_GET['publish'])
		{
			if($_GET['publish']=='1')
			{
				$where['datetime']	=	array('>=',strtotime(date('Y-m-d 00:00:00')));
				
			}else{

				$where['datetime']	=	array('>=',strtotime('-'.(int)$_GET['publish'].'day'));

			}
			$urlarr['publish']		=	$_GET['publish'];
		}
		$keywordStr					=	trim($_GET['keyword']);
		if($_GET['news_search'])
		{
			if ($_GET['type'] == 1)
			{
				$where['title']		=	array('like', $keywordStr);

			}elseif ($_GET['type'] == 2){
				
				$where['author']	=	array('like', $keywordStr);
			}

			$urlarr['type']			=	$_GET['type'];

			$urlarr['keyword']		=	$keywordStr;

			$urlarr['news_search']	=	$_GET['news_search'];
		}
	
		//分页链接
		$urlarr['page']	=	'{{page}}';
		
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('news_base',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){

			//limit order 只有在列表查询时才需要
			if($_GET['order'])
			{
				$where['orderby']	=	$_GET['t'].','.$_GET['order'];
				$urlarr['order']	=	$_GET['order'];
				$urlarr['t']		=	$_GET['t'];
			}else{
				$where['orderby']	=	'id';
			}
			$where['limit']			=	$pages['limit'];
		
			$List	=	$articleM -> getList($where,array('tlen'=>'20','group'=>$newsGroup,'property'=>'1'));
			$this -> yunset('adminnews', $List['list']);
			$this -> yunset('property', $List['property']);
			$this -> yunset('propertys', $List['property']);
		}
        $this -> yunset('get_type', $_GET);

		$this->siteadmin_tpl(array('admin_news_list'));
	}

	/**
	 * 内容 - 新闻 - 新闻管理
	 * 修改新闻
	 * 2019-06-10 hjy
	 */
	public function news_action(){

		$articleM			=	$this -> Model('article');

		if($_GET['nid'])
		{
			$news['nid']	=	$_GET['nid'];
			$this -> yunset('news', $news['nid']);
		}
		//提取新闻分类
		
		$listNew		=	$articleM -> getClass(array('isson' => 1));
		$newsGroup		=	$listNew['list'];
		
		$this -> yunset('one_class' , $listNew['one_class']);
		$this -> yunset('two_class' , $listNew['two_class']);
		
		//提取新闻属性标签
		$property		=	$articleM -> getProperty();

		$this -> yunset('property',$property);
		
		if($_GET['id']){
			$Info		=	$articleM -> getInfo(array('id'=>$_GET['id']),array('iscon'=>'1'));
 			$describe	=	@explode(',', $Info['describe']);
			$this -> yunset('describe', $describe);
			$this -> yunset('info', $Info);
			$this -> yunset('lasturl', $_SERVER['HTTP_REFERER']);
		}else{
			$Info['sort']	=	rand(1, 300 );
			$this -> yunset('info', $Info);
		}
		$this->siteadmin_tpl(array('admin_news_add'));
	}

	/**
	 * 内容 - 新闻 - 新闻管理
	 * 保存新闻
	 * 2019-06-10 hjy
	 */
	public function addnews_action()
	{
		$postData  			=	$this -> post_trim($_POST);
		$postData['did']	=	$this->config['did'];
		$articleM  			=	$this -> MODEL('article');
		
		if ($_FILES['file']) {
		    
		    $postData['file']  =  $_FILES['file'];
		}
		
		$return  =  $articleM -> addNews($postData);

		if($return['errcode'] == 9 && !empty($return['data'])){
		    $this -> articleshow($return['data']);
		    $this -> ACT_layer_msg($return['msg'], 9, Url('admin_news', null, 'admin'), 2, 1);
		}else{
		    $this -> ACT_layer_msg($return['msg'], 8, Url('admin_news', null, 'admin'));
		}
	}

	//通过smarty缓存直接生成静态文件
	public function articleshow($id){

		$articleM						=	$this -> MODEL('article');
		$news							=	$articleM -> getInfo(array('id'=>$id),array('iscon'=>'1'));
		if(empty($news)){
			return false;
		}

		$fieldArr						=	array('feild' => '`datetime`, `id`, `title`');
		//获取前一篇文章
		$news_last						=	$articleM -> getInfo(array('id' => array('<', $id), 'orderby' => 'id,des'), $fieldArr);
		if(!empty($news_last)){
			if($this -> config['sy_news_rewrite'] == 2){
				$news_last['url']		=	$this -> config['sy_weburl'].'/news/'.date('Ymd', $news_last['datetime']).'/'.$news_last['id'].'.html';
			}else{
				$news_last['url']		=	 Url('article', array('c' => 'show', 'id' => $news_last['id']), 1);
			}
		}
		//获取后一篇文章
		$news_next						=	$articleM -> getInfo(array('id' => array('>', $id), 'orderby' => 'id,asc'), $fieldArr);
		if(!empty($news_next)){
			if($this -> config['sy_news_rewrite'] == 2){
				$news_next['url']		=	$this->config['sy_weburl'].'/news/'.date('Ymd', $news_next['datetime']).'/'.$news_next['id'].'.html';
			}else{
				$news_next['url']		=	Url('article',array('c'=>'show', 'id' => $news_next['id']), 1);
			}
		}

		//相关文章,按照关键字获取
		if($news["keyword"]!=""){

			$keyarr = @explode(",",$news["keyword"]);
			if(is_array($keyarr) && !empty($keyarr)){
				$where['PHPYUNBTWSTART_A']	=	'' ;
				foreach($keyarr as $key=>$value){
					$where['keyword'][]		=	array('like',$value,'OR') ;
				}
				$where['PHPYUNBTWEND_A']	=	'' ;
				$where['id']				=	array('<>',$id);
				$where['orderby']			=	'id,desc';
				$where['limit']				=	6;
				
				$aboutlist	=	$articleM->getList($where);//相关文章
				$about		=	$aboutlist['list'];
				
				if(is_array($about)){
					foreach($about as $k=>$v){
						if($this->config['sy_news_rewrite']=="2"){
							
							$about[$k]["url"]	=	$this->config['sy_weburl']."/news/".date("Ymd",$v["datetime"])."/".$v['id'].".html";
							
						}else{
							$about[$k]["url"]	= 	Url('article',array('c'=>'show',"id"=>$v['id']),"1"); 
						}
					}
				}
			}
		}

		//新闻类别
		$class							=	$articleM -> getGroup(array('id' => $news['nid']));

		$info							=	$news;
	
		$data['news_title']				=	$news['title'];//新闻名称
		$data['news_keyword']			=	$news['keyword'];//描述
		$data['news_class']				=	$class['name'];//新闻类别
		$data['news_desc']				=	$this -> GET_content_desc($news['description']);//描述
		$this -> data					=	$data;
		$info['news_class']				=	$class['name'];
		$info['last']					=	$news_last;
		$info['next']					=	$news_next;
		$info['like']					=	$about;
		$this -> yunset('Info', $info);
		
		$this -> seo('news_article');
		global $phpyun;
		//必须传参数$cache_id,否则多个文件的内容会重复
		$contect						=	$phpyun -> fetch(TPL_PATH.'default/article/show.htm', $id);
		if(!file_exists(APP_PATH.'news/'.date("Ymd",$news["datetime"]))){
			mkdir(APP_PATH.'news/'.date('Ymd', $news['datetime']));
		}
		$fp								=	fopen(APP_PATH.'news/'.date("Ymd",$news["datetime"]).'/'.$id.'.html', 'w');
		fwrite($fp, $contect);
		fclose($fp);
	}
	/**
	 * 内容 - 新闻 - 新闻管理
	 * 删除新闻
	 */
	public function delnews_action(){
		$this -> check_token();

		$del		=	$_GET['del'];
		if(is_array($del)){
			$linkid			=	pylode(',', $del);
			$layer_type		=	1;
		}else{
			$linkid			=	$_GET['id'];
			$layer_type		=	0;
		}
		if(empty($linkid)){
			$this -> layer_msg('请选择您要删除的信息！', 8, $layer_type, $_SERVER['HTTP_REFERER']);
		}
		$articleM	=	$this -> MODEL('article');
		$articleM -> delNews(array('id' => array('in', $linkid)));
		
		$this -> layer_msg('新闻(ID:'.$linkid.')删除成功！', 9, $layer_type, $_SERVER['HTTP_REFERER']);
	}
	/**
	 * 内容 - 新闻 - 新闻管理
	 * 保存新闻属性 取消新闻属性
	 * 2019-06-06 hjy
	 */
	public function savepro_action(){
    
		$typeStr	=	trim($_POST['type']);
    
		$_POST		=	$this -> post_trim($_POST);
    
		if(empty($_POST['proid'])){
      
			$this -> ACT_layer_msg('参数错误！', 8, $_SERVER['HTTP_REFERER']);
		}
		//实例化新闻类
		$articleM			=	$this -> MODEL('article');

		$baseWhereData		=	array('id' => array('in', $_POST['proid']));
		$list				=	$articleM -> getList($baseWhereData, array('field' => '`id`, `describe`'));
		if(empty($list['list'])){
			$this -> ACT_layer_msg('数据错误！', 8, $_SERVER['HTTP_REFERER']);
		}
		//保存新闻属性
		if($typeStr == 'add'){
			$describe		=	pylode(',', $_POST['describe']);
			if(empty($describe)){
				$this -> ACT_layer_msg('请选择属性！', 8, $_SERVER['HTTP_REFERER']);
			}
			$articleM -> upBase($baseWhereData, array('describe' => $describe));
			$this -> ACT_layer_msg('新闻(ID:'.$_POST['proid'].')设置属性成功！', 9, $_SERVER['HTTP_REFERER'], 2, 1);
		}
		//删除新闻属性
		if($typeStr == 'del'){
			foreach($list['list'] as $key => $value){
				if(!empty($value['describe'])){
					$describe	=	@explode(',', $value['describe']);
					foreach($describe as $key => $v){
						if(in_array($v, $_POST['describe'])){
							unset($describe[$key]);
						}
					}
					$articleM -> upBase(array('id' => array('=', $value['id'])), array('describe' => pylode(',', $describe)));
				}
			}
			$this->ACT_layer_msg('新闻(ID:'.$_POST['proid'].')删除属性成功！', 9, $_SERVER['HTTP_REFERER'], 2, 1);
		}
	}
	/**
	 * 内容 - 新闻 - 新闻管理
	 * 转移分类 -> 类别搜索
	 */
	public function selclass_action(){
		$_POST		=	$this -> post_trim($_POST);
		$html		=	'';
		if(empty($_POST['keyword'])){
			$html	=	'<div class="yun_admin_select_box_list"> <a href="javascript:;">参数错误</a> </div>';
			echo  $html; die;
		}
		$articleM	=	$this -> MODEL('article');
		$group		=	$articleM -> getClass(array('name' => array('like', $_POST['keyword']), 'orderby' => 'keyid,asc'));
		if(!empty($group) && !empty($group['list'])){
			foreach($group['list'] as $value){
				if($value['keyid'] == 0){
					$html 	.=	'<div class="yun_admin_select_box_list"> <a href="javascript:;" onclick="select_new(\'nid\',\''.$value['id'].'\',\''.$value['name'].'\')">'.$value['name'].'</a> </div>';
				}else{
					$html 	.=	'<div class="yun_admin_select_box_list"> <a href="javascript:;" onclick="select_new(\'nid\',\''.$value['id'].'\',\''.$value['name'].'\')"> 　┗'.$value['name'].'</a> </div>';
				}
			}
		}else{
		   $html	=	'<div class="yun_admin_select_box_list"> <a href="javascript:;">未找到相关数据</a> </div>';
		}
		echo  $html; die;
	}
	/**
	 * 内容 - 新闻 - 新闻管理
	 * 转移分类 -> 保存数据
	 */
	public function changeClass_action(){
		$_POST		=	$this -> post_trim($_POST);
		if(empty($_POST['id'])){
			$this -> ACT_layer_msg('参数不全请重试！', 8, $_SERVER['HTTP_REFERER']);
		}
		$ids		=	@explode(',', $_POST['id']);
		$id			=	pylode(',', $ids);
		$nid		=	intval($_POST['nid']);
		if(!empty($id)){
			$articleM 	=	$this -> MODEL('article');
			$articleM -> upBase(array('id' => array('in', $id)), array('nid' => $nid));
			$this -> ACT_layer_msg('新闻转移类别成功！', 9, $_SERVER['HTTP_REFERER']);
		}else{
			$this -> ACT_layer_msg('请正确选择需转移的新闻！', 8, $_SERVER['HTTP_REFERER']);
		}
	}
}
?>