<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:42:14
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\default\public_search\firm_search.htm" */ ?>
<?php /*%%SmartyHeaderCode:2865362c54ae60521e9-58301666%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b85fbf41d7af04c04eac1ad7f2ca0694a557b64e' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\default\\public_search\\firm_search.htm',
      1 => 1634883842,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2865362c54ae60521e9-58301666',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'getinfo' => 0,
    'comkeyword' => 0,
    'keylist' => 0,
    'city_name' => 0,
    'city_type' => 0,
    'tid' => 0,
    'city_index' => 0,
    'pid' => 0,
    'key' => 0,
    'cid' => 0,
    'industry_index' => 0,
    'v' => 0,
    'j' => 0,
    'industry_name' => 0,
    'comdata' => 0,
    'comclass_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c54ae61f8837_02247798',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c54ae61f8837_02247798')) {function content_62c54ae61f8837_02247798($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_function_listurl')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.listurl.php';
?><div class="firm_search_box">
	<div class="firm_search_boxbor">
		<form method="get" name="myform" onsubmit="return search_keyword(this,'请输入关键字');" action="<?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_companydir']) {?>index.php<?php } else {
echo smarty_function_url(array('m'=>'company'),$_smarty_tpl);
}?>"> 
			<input class="firm_search_text" id="ipt" type="text" placeholder='请输入关键字' value="<?php if ($_smarty_tpl->tpl_vars['getinfo']->value['keyword']!=" =") {
echo $_smarty_tpl->tpl_vars['getinfo']->value['keyword'];
} else { ?>请输入关键字<?php }?>" name="keyword" onclick="if(this.value=='请输入关键字'){this.value=''}" onblur="if(this.value==''){this.value='请输入关键字'}" />
			<input type="hidden" name="cityid" id="cityid" value="<?php if ($_GET['cityid']) {
echo $_GET['cityid'];
}?>"/>
			<input class="firm_search_submit yun_bg_color" type="submit" value="搜索 " />
			
		</form>
	</div>
	
	<?php if ($_smarty_tpl->tpl_vars['comkeyword']->value) {?>
		<div class="firm_hot_tags">
			热门搜索：	<?php  $_smarty_tpl->tpl_vars['keylist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['keylist']->_loop = false;
global $config;$paramer=array("limit"=>"12","type"=>"4","recom"=>"1","item"=>"'keylist'","nocache"=>"")
;$list=array();
        
        $ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		//是否推荐
		if($paramer[recom]){
			$tuijian = 1;
		}
		//类别
		if($paramer[type]){
			$type = $paramer[type];
		}
		//查询条数
		if($paramer[limit]){
			$limit=$paramer[limit];
		}else{
			$limit=5;
		}
		include PLUS_PATH."/keyword.cache.php";
		if($paramer[iswap]){
			$wap = "/wap";
		}else{
			$index =1;
		}
		if(is_array($keyword)){
			if($paramer[iswap]){
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v[tuijian]!=1){
						continue;
					}
					if($type && $v[type]!=$type){
						continue;
					}

					$i++;
					if($v[type]=="1"){
						$v[url] = Url("wap",array("c"=>"once","keyword"=>$v['key_name']));
						$v[type_name]='店铺招聘';
					}elseif($v['type']=="13"){
						$v['url'] = Url("wap",array("c"=>"tiny","keyword"=>$v['key_name']));
						$v['type_name']='普工简历';
					}elseif($v[type]=="3"){
						$v[url] = Url("wap",array("c"=>"job","keyword"=>$v['key_name']));
						$v[type_name]='职位';
					}elseif($v['type']=="4"){
						$v['url'] = Url("wap",array("c"=>"company","keyword"=>$v['key_name']));
						$v['type_name']='公司';
					}elseif($v['type']=="5"){
						$v['url'] = Url("wap",array("c"=>"resume","keyword"=>$v['key_name']));
						$v['type_name']='人才';
					}
					$v['key_title']=$v['key_name'];
					if($v['color']){
						$v['key_name']="<font color='".$v['color']."'>".$v['key_name']."</font>";
					}
					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}else{
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v['tuijian']!=1){
						continue;
					}
					if($type && $v['type']!=$type){
						continue;
					}
					$i++;
					if($v['type']=="1"){
						$v['url'] = Url("once",array("keyword"=>$v['key_name']));
						$v['type_name']='店铺招聘';
					}elseif($v['type']=="2"){
						$v['url'] = Url("part",array("keyword"=>$v['key_name']));
						$v['type_name']='兼职';
					}elseif($v['type']=="13"){
						$v['url'] = Url("tiny",array("keyword"=>$v['key_name']));
						$v['type_name']='普工简历';
					}elseif($v['type']=="3"){
						$v['url'] = Url("job",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='职位';
					}elseif($v['type']=="4"){
						$v['url'] = Url("company",array("keyword"=>$v['key_name']));
						$v['type_name']='公司';
					}elseif($v['type']=="5"){
						$v['url'] = Url("resume",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='人才';
					}elseif($v['type']=="6"){
						$v['url'] = Url("lietou",array("c"=>"service","keyword"=>$v['key_name']));
						$v['type_name']='猎头';
					}elseif($v['type']=="7"){
						$v['url'] = Url("lietou",array("c"=>"post","keyword"=>$v['key_name']));
						$v['type_name']='猎头职位';
					}else if($v['type']=="9"){
						$v['url'] = Url("train",array("c"=>"subject","keyword"=>$v['key_name']));
						$v['type_name']='培训课程';
					}else if($v['type']=="10"){
						$v['url'] = Url("train",array("c"=>"agency","keyword"=>$v['key_name']));
						$v['type_name']='培训机构';
					}else if($v['type']=="11"){
						$v['url'] = Url("train",array("c"=>"teacher","keyword"=>$v['key_name']));
						$v['type_name']='培训师';
					}else if($v['type']=="12"){
						$v['url'] = Url("ask",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='问答';
					}
					$v['key_title']=$v['key_name'];
					if($v['color']){
						$v['key_name']="<font color='".$v['color']."'>".$v['key_name']."</font>";
					}

					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}
		}$list = $list; if (!is_array($list) && !is_object($list)) { settype($list, 'array');}
foreach ($list as $_smarty_tpl->tpl_vars['keylist']->key => $_smarty_tpl->tpl_vars['keylist']->value) {
$_smarty_tpl->tpl_vars['keylist']->_loop = true;
?> 
		       		<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'keyword','v'=>$_smarty_tpl->tpl_vars['keylist']->value['key_title']),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['keylist']->value['key_name'];?>
</a> 
		       		<?php } ?>
		</div>
	<?php } else { ?>
		<div class="firm_hot-tags">&nbsp;</div>
	<?php }?>
	
</div>

<div class="fiem_seach_chlose">
	<?php if ($_smarty_tpl->tpl_vars['config']->value['sy_web_site']==1&&$_smarty_tpl->tpl_vars['config']->value['cityname']&&$_smarty_tpl->tpl_vars['config']->value['cityname']!=$_smarty_tpl->tpl_vars['config']->value['sy_indexcity']) {?>
		<div class="fiem_seach_chlose_list">
			<div class="Search_cityboxname"> 地区：</div>
			<div class="Search_citybox_right">
				<div class="Search_cityboxright">
					<div class="search_secondcity_list">
						<?php if (!$_GET['cityid']&&$_GET['three_cityid']) {?> 
							<a class="city_name city_name_active" style="text-decoration:none;cursor:pointer;">
								<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['three_cityid']];?>

							</a> 
						<?php } else { ?>
							<?php if ($_GET['cityid']) {?>
								<?php if (is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?> 
									<a href="<?php echo smarty_function_listurl(array('m'=>'company','untype'=>'three_cityid'),$_smarty_tpl);?>
" class="city_name <?php if (!$_GET['three_cityid']) {?>city_name_active<?php }?>">不限</a> 
									<?php  $_smarty_tpl->tpl_vars['tid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tid']->key => $_smarty_tpl->tpl_vars['tid']->value) {
$_smarty_tpl->tpl_vars['tid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tid']->key;
?> 
										<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'three_cityid','v'=>$_smarty_tpl->tpl_vars['tid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['three_cityid']==$_smarty_tpl->tpl_vars['tid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['tid']->value];?>
</a> 
									<?php } ?>
								<?php } else { ?> 
									<a class="city_name city_name_active" style="text-decoration:none;cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['cityid']];?>
</a>
								<?php }?>
							<?php } else { ?>
								<?php if (is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']])) {?> 
									<a href="<?php echo smarty_function_listurl(array('m'=>'company','untype'=>'cityid'),$_smarty_tpl);?>
" class="city_name <?php if (!$_GET['cityid']) {?>city_name_active<?php }?>">不限</a> 
									<?php  $_smarty_tpl->tpl_vars['tid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tid']->key => $_smarty_tpl->tpl_vars['tid']->value) {
$_smarty_tpl->tpl_vars['tid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tid']->key;
?> 
										<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'cityid','v'=>$_smarty_tpl->tpl_vars['tid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['cityid']==$_smarty_tpl->tpl_vars['tid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['tid']->value];?>
</a>
									<?php } ?>
								<?php } else { ?> 
									<a class="city_name city_name_active" style="text-decoration:none;cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['provinceid']];?>
</a>
								<?php }?>
							<?php }?>
						<?php }?> 
					</div>
				</div>
			</div>
		</div>
	<?php } elseif ($_smarty_tpl->tpl_vars['config']->value['sy_web_city_one']) {?>
		<div class="fiem_seach_chlose_list">
			<div class="Search_cityboxname"> 地区：</div>
			<div class="Search_citybox_right">
				<div class="Search_cityboxright">
					<div class="search_secondcity_list">
						<?php if (!$_GET['cityid']&&$_GET['three_cityid']) {?> 
							<a class="city_name city_name_active" style="text-decoration:none;cursor:pointer;">
								<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['three_cityid']];?>

							</a> 
						<?php } else { ?>
							<?php if ($_GET['cityid']) {?>
								<?php if (is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?> 
									<a href="<?php echo smarty_function_listurl(array('m'=>'company','untype'=>'three_cityid'),$_smarty_tpl);?>
" class="city_name <?php if (!$_GET['three_cityid']) {?>city_name_active<?php }?>">不限</a> 
									<?php  $_smarty_tpl->tpl_vars['tid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tid']->key => $_smarty_tpl->tpl_vars['tid']->value) {
$_smarty_tpl->tpl_vars['tid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tid']->key;
?> 
										<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'three_cityid','v'=>$_smarty_tpl->tpl_vars['tid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['three_cityid']==$_smarty_tpl->tpl_vars['tid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['tid']->value];?>
</a> 
									<?php } ?>
								<?php } else { ?> 
									<a class="city_name city_name_active" style="text-decoration:none;cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['cityid']];?>
</a>
								<?php }?>
							<?php } else { ?>
								<?php if (is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']])) {?> 
									<a href="<?php echo smarty_function_listurl(array('m'=>'company','untype'=>'cityid'),$_smarty_tpl);?>
" class="city_name <?php if (!$_GET['cityid']) {?>city_name_active<?php }?>">不限</a> 
									<?php  $_smarty_tpl->tpl_vars['tid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tid']->key => $_smarty_tpl->tpl_vars['tid']->value) {
$_smarty_tpl->tpl_vars['tid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tid']->key;
?> 
										<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'cityid','v'=>$_smarty_tpl->tpl_vars['tid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['cityid']==$_smarty_tpl->tpl_vars['tid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['tid']->value];?>
</a>
									<?php } ?>
								<?php } else { ?> 
									<a class="city_name city_name_active" style="text-decoration:none;cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['provinceid']];?>
</a>
								<?php }?>
							<?php }?>
						<?php }?> 
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="Search_citybox">
          	<div class="Search_cityboxname"> 地点：</div>
          	<div class="Search_citybox_right">
            	<div class="Search_cityall none"> 
            		<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'provinceid','v'=>0),$_smarty_tpl);?>
" class="city_name">全部</a> 
            		<?php  $_smarty_tpl->tpl_vars['pid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pid']->key => $_smarty_tpl->tpl_vars['pid']->value) {
$_smarty_tpl->tpl_vars['pid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['pid']->key;
?> 
            			<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'provinceid','v'=>$_smarty_tpl->tpl_vars['pid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['provinceid']==$_smarty_tpl->tpl_vars['pid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['pid']->value];?>
</a> 
            		<?php } ?> 
            	</div>
            	<div class="Search_cityboxright"> 
            		<a href="javascript:;" onclick="acityshow('1')" class="search_city_list_cur <?php if ($_GET['provinceid']&&!$_GET['cityid']||!is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?>search_city_active<?php }?> <?php if (!$_GET['provinceid']) {?>none<?php }?> acity_two" style="text-decoration:none;cursor:pointer;">
            			<span class="search_city_p"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['provinceid']];?>
</span>
            			<i class="search_city_p_jt"></i>
            			<i class="search_city_list_line"></i>
            		</a> 
            		<a href="javascript:;" <?php if ($_GET['cityid']) {?>onclick="acityshow('2')" <?php }?> class="search_city_list_cur <?php if ($_GET['cityid']&&is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?>search_city_active<?php }?> <?php if (!$_GET['provinceid']||!$_GET['cityid']||!is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?>none<?php }?> acity_three" style="text-decoration:none;cursor:pointer;">
            			<span class="search_city_p">
						<?php if (!$_GET['cityid']) {?>
							不限
						<?php } else { ?>
							<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['cityid']];?>

						<?php }?></span>
            			<i class="search_city_list_line"></i>
            		</a> 
            		<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'provinceid','v'=>0),$_smarty_tpl);?>
" class="search_city_list_all <?php if (!$_GET['provinceid']) {?>city_name_active<?php }?>">全部</a>
              		<div class="search_city_list"> 
              			<?php  $_smarty_tpl->tpl_vars['pid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pid']->key => $_smarty_tpl->tpl_vars['pid']->value) {
$_smarty_tpl->tpl_vars['pid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['pid']->key;
?> 
              				<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'provinceid','v'=>$_smarty_tpl->tpl_vars['pid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['provinceid']&&!$_GET['cityid']) {
if ($_smarty_tpl->tpl_vars['key']->value>13) {?>none<?php }
} elseif ($_GET['cityid']) {
if ($_smarty_tpl->tpl_vars['key']->value>12) {?>none<?php }
} else {
if ($_smarty_tpl->tpl_vars['key']->value>14) {?>none<?php }
}?> <?php if ($_GET['provinceid']==$_smarty_tpl->tpl_vars['pid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['pid']->value];?>
</a> 
              			<?php } ?> 
              		</div>
              		<a href="javascript:;" class="search_city_list_more" id="acity">更多</a> 
              	</div>
              	
            	<div class="Search_cityboxclose <?php if (!$_GET['provinceid']||($_GET['provinceid']&&$_GET['cityid']&&is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']]))) {?>none<?php }?>" id="acity_two"> 
					<a href="<?php echo smarty_function_listurl(array('untype'=>'cityid'),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['provinceid']&&!$_GET['cityid']&&!$_GET['three_cityid']) {?>city_name_active<?php }?>">不限</a> 
					<?php  $_smarty_tpl->tpl_vars['cid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cid']->key => $_smarty_tpl->tpl_vars['cid']->value) {
$_smarty_tpl->tpl_vars['cid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['cid']->key;
?> 
					<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'cityid','v'=>$_smarty_tpl->tpl_vars['cid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['cityid']==$_smarty_tpl->tpl_vars['cid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['cid']->value];?>
</a> 
					<?php } ?> 
				</div>
            	<div class="Search_cityboxclose <?php if (!$_GET['cityid']||!is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?>none<?php }?>" id="acity_three"> 
					<a href="<?php echo smarty_function_listurl(array('m'=>'company','untype'=>'three_cityid'),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['provinceid']&&$_GET['cityid']&&!$_GET['three_cityid']) {?>city_name_active<?php }?>">不限</a> 
					<?php  $_smarty_tpl->tpl_vars['tid'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tid']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tid']->key => $_smarty_tpl->tpl_vars['tid']->value) {
$_smarty_tpl->tpl_vars['tid']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tid']->key;
?> 
						<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'three_cityid','v'=>$_smarty_tpl->tpl_vars['tid']->value),$_smarty_tpl);?>
" class="city_name <?php if ($_GET['three_cityid']==$_smarty_tpl->tpl_vars['tid']->value) {?>city_name_active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['tid']->value];?>
</a> 
					<?php } ?> 
				</div>
          </div>
        </div>
	<?php }?> 

	<div class="fiem_seach_chlose_list">
		<div class="fiem_seach_chlosename">行业：</div>
		<div class="fiem_seach_chlose_list_r" style="width:1010px; float:left">
			<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'hy','v'=>0),$_smarty_tpl);?>
" class="fiem_seach_chlose_list_a <?php if (!$_GET['hy']) {?>fiem_seach_chlose_list_cur<?php }?>">全部</a>
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['industry_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
				<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'hy','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
" class="fiem_seach_chlose_list_a <?php if ($_GET['hy']==$_smarty_tpl->tpl_vars['v']->value) {?>fiem_seach_chlose_list_cur<?php }?> <?php if ($_smarty_tpl->tpl_vars['j']->value>6) {?>list_hy_more none<?php }?>"><?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a>
			<?php } ?>
		</div>
		<div class="zh_more">
			<a href="javascript:void(0);" onclick="hy_more_click(this)">更多</a> 
		</div>
	</div>
	
	<div class="fiem_seach_chlose_list"><div class="fiem_seach_chlosename">性质：</div>
		<div class="fiem_seach_chlose_list_r">
			<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'pr','v'=>0),$_smarty_tpl);?>
" class="fiem_seach_chlose_list_a <?php if (!$_GET['pr']) {?>fiem_seach_chlose_list_cur<?php }?>">全部</a>
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_pr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
				<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'pr','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
" class="fiem_seach_chlose_list_a <?php if ($_GET['pr']==$_smarty_tpl->tpl_vars['v']->value) {?>fiem_seach_chlose_list_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a>
			<?php } ?>
		</div>
	</div>

	<div class="fiem_seach_chlose_list"><div class="fiem_seach_chlosename">规模：</div>
		<div class="fiem_seach_chlose_list_r">
			<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'mun','v'=>0),$_smarty_tpl);?>
" class="fiem_seach_chlose_list_a <?php if (!$_GET['mun']) {?>fiem_seach_chlose_list_cur<?php }?>">全部</a>
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_mun']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
				<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'mun','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
" class="fiem_seach_chlose_list_a <?php if ($_GET['mun']==$_smarty_tpl->tpl_vars['v']->value) {?>fiem_seach_chlose_list_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a>
			<?php } ?>
		</div>
	</div>
	
	<div class="fiem_seach_chlose_list"><div class="fiem_seach_chlosename">福利：</div>
		<div class="fiem_seach_chlose_list_r">
			<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'welfare','v'=>0),$_smarty_tpl);?>
" class="fiem_seach_chlose_list_a <?php if (!$_GET['welfare']) {?>fiem_seach_chlose_list_cur<?php }?>">全部</a>
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_welfare']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
				<a href="<?php echo smarty_function_listurl(array('m'=>'company','type'=>'welfare','v'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
" class="fiem_seach_chlose_list_a <?php if ($_GET['welfare']==$_smarty_tpl->tpl_vars['v']->value) {?>fiem_seach_chlose_list_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a>
			<?php } ?>
		</div>
	</div>
	
	<?php if (($_GET['provinceid']&&!$_smarty_tpl->tpl_vars['config']->value['sy_web_city_one'])||($_GET['cityid']&&!$_smarty_tpl->tpl_vars['config']->value['sy_web_city_two'])||$_GET['three_cityid']||$_GET['hy']||$_GET['pr']||$_GET['mun']||$_GET['welfare']||$_GET['keyword']) {?>
		<div class="Search_close_box">
			
			<div>
				<div class="Search_clear"> <a href="<?php echo smarty_function_url(array('m'=>'company'),$_smarty_tpl);?>
"> 清除所选</a></div>
				<span class="Search_close_box_s">已选条件：</span>
			</div>
			
			<?php if ($_smarty_tpl->tpl_vars['config']->value['cityid']==''&&$_smarty_tpl->tpl_vars['config']->value['three_cityid']=='') {?> 
				<?php if ($_GET['provinceid']&&!$_smarty_tpl->tpl_vars['config']->value['sy_web_city_one']) {?><a href="<?php echo smarty_function_listurl(array('m'=>'company','untype'=>'provinceid'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">工作地点：<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['provinceid']];?>
</a> <?php }?> 
				<?php if ($_GET['cityid']&&!$_smarty_tpl->tpl_vars['config']->value['sy_web_city_two']) {?> <a href="<?php echo smarty_function_listurl(array('m'=>'company','untype'=>'cityid'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['cityid']];?>
</a> <?php }?> 
			<?php }?>
			
			<?php if ($_GET['three_cityid']) {?> <a href="<?php echo smarty_function_listurl(array('m'=>'company','untype'=>'three_cityid'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['three_cityid']];?>
</a> <?php }?>
			<?php if ($_smarty_tpl->tpl_vars['industry_name']->value[$_GET['hy']]) {?> <a href="<?php echo smarty_function_listurl(array('m'=>'company','untype'=>'hy'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">行业：<?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_GET['hy']];?>
</a> <?php }?>
			<?php if ($_GET['pr']) {?> <a href="<?php echo smarty_function_listurl(array('m'=>'company','untype'=>'pr'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">性质：<?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_GET['pr']];?>
</a> <?php }?>
			<?php if ($_GET['mun']) {?> <a href="<?php echo smarty_function_listurl(array('m'=>'company','untype'=>'mun'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">规模：<?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_GET['mun']];?>
</a> <?php }?>
			<?php if ($_GET['welfare']) {?> <a href="<?php echo smarty_function_listurl(array('m'=>'company','untype'=>'welfare'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">福利：<?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_GET['welfare']];?>
</a> <?php }?>
			<?php if ($_GET['keyword']) {?> <a href="<?php echo smarty_function_listurl(array('m'=>'company','untype'=>'keyword'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_GET['keyword'];?>
</a> <?php }?>
			
		</div>
	<?php }?>
	
</div><?php }} ?>
