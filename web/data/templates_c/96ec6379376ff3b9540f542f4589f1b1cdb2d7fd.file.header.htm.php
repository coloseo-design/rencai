<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 17:25:51
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\lietou\header.htm" */ ?>
<?php /*%%SmartyHeaderCode:1207262d91b9f84b6d7-28818485%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '96ec6379376ff3b9540f542f4589f1b1cdb2d7fd' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\lietou\\header.htm',
      1 => 1634883835,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1207262d91b9f84b6d7-28818485',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'keywords' => 0,
    'description' => 0,
    'lietou_style' => 0,
    'config' => 0,
    'maplist' => 0,
    'navlist_app' => 0,
    'uid' => 0,
    'navlist' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d91b9f9c7971_10456644',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d91b9f9c7971_10456644')) {function content_62d91b9f9c7971_10456644($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
	<meta name=keywords content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
">
	<meta name=description content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<link href="<?php echo $_smarty_tpl->tpl_vars['lietou_style']->value;?>
/css/style.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css" rel="stylesheet" />
	<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	<?php if ($_GET['c']) {?>
		<link href="<?php echo $_smarty_tpl->tpl_vars['lietou_style']->value;?>
/css/css.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css" rel="stylesheet" />
	<?php }?>
	<?php echo '<script'; ?>
>
		var weburl = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
",
			integral_pricename='<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
',
			pricename='<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
',
			code_web='<?php echo $_smarty_tpl->tpl_vars['config']->value['code_web'];?>
',
			code_kind='<?php echo $_smarty_tpl->tpl_vars['config']->value['code_kind'];?>
';
	<?php echo '</script'; ?>
>
</head>

<body>

	<div class="top_lietou">
  		<div class="top_cot">
    		<div class="top_cot_content">
      			<div class="top_left fl">
        			<div class="yun_welcome fl">欢迎来到<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
！</div>
      			</div>
      			<div class="top_right_re fr">
        			<div class="top_right" id="login_head_div">
          				<div class="yun_topNav fr"> 
		  					<a class="yun_navMore" href="javascript:;">网站导航</a>
				            <div class="yun_webMoredown none">
				              	<div class="yun_top_nav_box"> 
							  		<ul class="yun_top_nav_box_l">
				              			<?php  $_smarty_tpl->tpl_vars['maplist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['maplist']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
global $db,$db_config,$config;$paramer=array("key"=>"'key'","item"=>"'maplist'","nocache"=>"")
;
		include(PLUS_PATH."/navmap.cache.php");$Navlist=array();
		if(is_array($navmap)){
			$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
			$paramer = $ParamerArr[arr];
			$Purl =  $ParamerArr[purl];
		}
		//默认调用头部导航
		$Navlist =$navmap[0];
		if(is_array($navmap)){
			foreach($navmap as $k=>$v){
				foreach($Navlist as $key=>$val){
					if($k==$val[id]){
						foreach($v as $kk=>$value){
							if($value[type]=='1'){
								if($config[sy_seo_rewrite]=="1" && $value[furl]!=''){
									$v[$kk][url] = $config[sy_weburl]."/".$value[furl];
								}else{
									$v[$kk][url] = $config[sy_weburl]."/".$value[url];
								}
							}
						}
						$Navlist[$key]['list'][]=$v;
					}
				}
			}
			foreach($Navlist as $key=>$value){
				if($value[type]=='1'){
					if($config[sy_seo_rewrite]=="1" && $value[furl]!=''){
						$Navlist[$key][url] = $config[sy_weburl]."/".$value[furl];
					}else{
						$Navlist[$key][url] = $config[sy_weburl]."/".$value[url];
					}
				}
			}
		}$Navlist = $Navlist; if (!is_array($Navlist) && !is_object($Navlist)) { settype($Navlist, 'array');}
foreach ($Navlist as $_smarty_tpl->tpl_vars['maplist']->key => $_smarty_tpl->tpl_vars['maplist']->value) {
$_smarty_tpl->tpl_vars['maplist']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['maplist']->key;
?>
				                  		<li><a href="<?php echo $_smarty_tpl->tpl_vars['maplist']->value['url'];?>
" <?php if ($_smarty_tpl->tpl_vars['maplist']->value['eject']) {?> target="_blank"<?php }?>><?php echo $_smarty_tpl->tpl_vars['maplist']->value['name'];?>
</a></li>
				                		<?php } ?> 
				                 	</ul>
				                	<ul class="yun_top_nav_box_wx">
				               			<?php  $_smarty_tpl->tpl_vars['navlist_app'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['navlist_app']->_loop = false;
global $db,$db_config,$config;include(PLUS_PATH."/menu.cache.php");$Navlist=array();
		if(is_array($menu_name)){
            $paramer=array("item"=>"'navlist_app'","hovclass"=>"'nav_list_hover'","nid"=>"11","nocache"=>"")
;
			$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
			$paramer = $ParamerArr[arr];
			$Purl =  $ParamerArr[purl];

			foreach($menu_name[12] as $key=>$val){
				
				if($val['type']=='2'){
					if($config['sy_seo_rewrite']=="1" && $val[furl]!=''){
						$menu_name[12][$key]['url'] = $val[furl];
					}else{
						$menu_name[12][$key]['url'] = $val['url'];
					}
					$menu_name[12][$key][navclass] = navcalss($val,$paramer[hovclass]);
				}
			}
			foreach($menu_name[1] as $key=>$value){
				if($value['url']=="/"){
					$value['url']="";
				}
				if($value['type']=='1'){
					if($config['sy_seo_rewrite']=="1" && $value['furl']!=''){
						$menu_name[1][$key]['url'] = $config[sy_weburl]."/".$value['furl'];
					}else{
						$menu_name[1][$key]['url'] = $config[sy_weburl]."/".$value['url'];
					}
					$menu_name[1][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
			foreach($menu_name[2] as $key=>$value){
                if($value['url']=="/"){
					$value['url']="";
				}
				if($value['type']=='1'){
					if($config['sy_seo_rewrite']=="1" && $value['furl']!=''){
						$menu_name[2][$key]['url'] = $config[sy_weburl]."/".$value['furl'];
					}else{
						$menu_name[2][$key]['url'] = $config[sy_weburl]."/".$value['url'];
					}
					$menu_name[2][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
            $isCurrentFind=false;
			foreach($menu_name[4] as $key=>$value){
                if($value['url']=="/"){
					$value['url']="";
				}
				if($value['type']=='1' && $value['furl']!=''){
					if($config['sy_seo_rewrite']=="1"){
						$menu_name[4][$key]['url'] = $config[sy_weburl]."/".$value['furl'];
					}else{
						$menu_name[4][$key]['url'] = $config[sy_weburl]."/".$value['url'];
					}
				}
                if($isCurrentFind==false){
				    $menu_name[4][$key][navclass] = navcalss($value,$paramer[hovclass]);
                }
                if($menu_name[4][$key][navclass]){
                    $isCurrentFind=true;
                }
			}
			foreach($menu_name[5] as $key=>$value){
                if($value['url']=="/"){
					$value['url']="";
				}
				if($value['type']=='1'){
					if($config['sy_seo_rewrite']=="1" && $value['furl']!=''){
						$menu_name[5][$key]['url'] = $config[sy_weburl]."/".$value['furl'];
					}else{
						$menu_name[5][$key]['url'] = $config[sy_weburl]."/".$value['url'];
					}
					$menu_name[5][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
		}
		//默认调用头部导航
		if($paramer[nid]){
			$Navlist =$menu_name[$paramer[nid]];
		}else{
			$Navlist =$menu_name[1];
		}$Navlist = $Navlist; if (!is_array($Navlist) && !is_object($Navlist)) { settype($Navlist, 'array');}
foreach ($Navlist as $_smarty_tpl->tpl_vars['navlist_app']->key => $_smarty_tpl->tpl_vars['navlist_app']->value) {
$_smarty_tpl->tpl_vars['navlist_app']->_loop = true;
?>          
							            <li> <a class="move_0<?php echo $_smarty_tpl->tpl_vars['navlist_app']->value['sort'];?>
"<?php if ($_smarty_tpl->tpl_vars['navlist_app']->value['eject']) {?> target="_blank"<?php }?> href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['navlist_app']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['navlist_app']->value['name'];?>
</a> </li>
							          	<?php } ?>
				                	</ul>
				                </div>
				            </div>
          				</div> 
           				<?php echo '<script'; ?>
 language='JavaScript' src='<?php echo smarty_function_url(array('m'=>'ajax','c'=>'RedLoginHead'),$_smarty_tpl);?>
'><?php echo '</script'; ?>
> 
        			</div>
      			</div>
    		</div>
  		</div>
	</div>	

	<div class="lt_header">
		<div class="top_con">
			<div class="lt_header_logo">
				<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
">
					<img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_lt_logo'];?>
" />
				</a>
			</div>
        
        	<div class="header_login">
        		<?php if ($_smarty_tpl->tpl_vars['uid']->value=='') {?>
       			<a href="<?php echo smarty_function_url(array('m'=>'login'),$_smarty_tpl);?>
" class="header_login_a">登录<i class="header_login_a_icon">HOT</i></a>
       			<a href="<?php echo smarty_function_url(array('m'=>'register'),$_smarty_tpl);?>
" class="header_reg_a">注册</a>
       			<?php }?>
       		</div>
			<ul class="header_nav">
				<?php  $_smarty_tpl->tpl_vars['navlist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['navlist']->_loop = false;
global $db,$db_config,$config;include(PLUS_PATH."/menu.cache.php");$Navlist=array();
		if(is_array($menu_name)){
            $paramer=array("item"=>"'navlist'","hovclass"=>"'a_hover'","nid"=>"4","nocache"=>"")
;
			$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
			$paramer = $ParamerArr[arr];
			$Purl =  $ParamerArr[purl];

			foreach($menu_name[12] as $key=>$val){
				
				if($val['type']=='2'){
					if($config['sy_seo_rewrite']=="1" && $val[furl]!=''){
						$menu_name[12][$key]['url'] = $val[furl];
					}else{
						$menu_name[12][$key]['url'] = $val['url'];
					}
					$menu_name[12][$key][navclass] = navcalss($val,$paramer[hovclass]);
				}
			}
			foreach($menu_name[1] as $key=>$value){
				if($value['url']=="/"){
					$value['url']="";
				}
				if($value['type']=='1'){
					if($config['sy_seo_rewrite']=="1" && $value['furl']!=''){
						$menu_name[1][$key]['url'] = $config[sy_weburl]."/".$value['furl'];
					}else{
						$menu_name[1][$key]['url'] = $config[sy_weburl]."/".$value['url'];
					}
					$menu_name[1][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
			foreach($menu_name[2] as $key=>$value){
                if($value['url']=="/"){
					$value['url']="";
				}
				if($value['type']=='1'){
					if($config['sy_seo_rewrite']=="1" && $value['furl']!=''){
						$menu_name[2][$key]['url'] = $config[sy_weburl]."/".$value['furl'];
					}else{
						$menu_name[2][$key]['url'] = $config[sy_weburl]."/".$value['url'];
					}
					$menu_name[2][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
            $isCurrentFind=false;
			foreach($menu_name[4] as $key=>$value){
                if($value['url']=="/"){
					$value['url']="";
				}
				if($value['type']=='1' && $value['furl']!=''){
					if($config['sy_seo_rewrite']=="1"){
						$menu_name[4][$key]['url'] = $config[sy_weburl]."/".$value['furl'];
					}else{
						$menu_name[4][$key]['url'] = $config[sy_weburl]."/".$value['url'];
					}
				}
                if($isCurrentFind==false){
				    $menu_name[4][$key][navclass] = navcalss($value,$paramer[hovclass]);
                }
                if($menu_name[4][$key][navclass]){
                    $isCurrentFind=true;
                }
			}
			foreach($menu_name[5] as $key=>$value){
                if($value['url']=="/"){
					$value['url']="";
				}
				if($value['type']=='1'){
					if($config['sy_seo_rewrite']=="1" && $value['furl']!=''){
						$menu_name[5][$key]['url'] = $config[sy_weburl]."/".$value['furl'];
					}else{
						$menu_name[5][$key]['url'] = $config[sy_weburl]."/".$value['url'];
					}
					$menu_name[5][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
		}
		//默认调用头部导航
		if($paramer[nid]){
			$Navlist =$menu_name[$paramer[nid]];
		}else{
			$Navlist =$menu_name[1];
		}$Navlist = $Navlist; if (!is_array($Navlist) && !is_object($Navlist)) { settype($Navlist, 'array');}
foreach ($Navlist as $_smarty_tpl->tpl_vars['navlist']->key => $_smarty_tpl->tpl_vars['navlist']->value) {
$_smarty_tpl->tpl_vars['navlist']->_loop = true;
?>
				<li>
					<a href="<?php echo $_smarty_tpl->tpl_vars['navlist']->value['url'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['navlist']->value['navclass'];?>
" style="<?php if ($_smarty_tpl->tpl_vars['navlist']->value['color']) {?>color:<?php echo $_smarty_tpl->tpl_vars['navlist']->value['color'];?>
;<?php }?> <?php if ($_smarty_tpl->tpl_vars['navlist']->value['bold']==1) {?>font-weight:bolder;<?php }?>">
					<?php echo $_smarty_tpl->tpl_vars['navlist']->value['name'];?>

					</a>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div><?php }} ?>
