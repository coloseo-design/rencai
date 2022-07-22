<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:30:00
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_tpl_moblies.htm" */ ?>
<?php /*%%SmartyHeaderCode:1902362d90078bcd328-97549541%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4bba15f87328ba6a72e2e4e1e003fbce285201ed' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_tpl_moblies.htm',
      1 => 1645280358,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1902362d90078bcd328-97549541',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'tplmoblie' => 0,
    'pytoken' => 0,
    'sort' => 0,
    'v' => 0,
    'hd' => 0,
    'searchurl' => 0,
    'vv' => 0,
    'nav' => 0,
    'navigation' => 0,
    'indexnav1' => 0,
    'indexnav2' => 0,
    'indexnav3' => 0,
    'adlist' => 0,
    'pv' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d9007941fc63_25734045',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d9007941fc63_25734045')) {function content_62d9007941fc63_25734045($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\wwwroot\\rencai_lygki7\\web\\app\\include\\libs\\plugins\\function.url.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	
	<link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	<link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	<link href="images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	<link href="images/diy.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
	
	<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet">

	<title>后台管理</title>
</head>

<body class="body_ifm">
			<div class="admin_indextip">根据自己的需求和喜好自定义属于自己的风格模板</div>
	<div class="infoboxp">

  		<iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
  		<div  class=" admin_add_box_c" style="border:none;">

    		<div class="couponadd_list_tit" style="width:580px;"> 
    			
    			<span class="couponadd_list_tit_s">设置手机自定义模板</span>
				
				<form class="layui-form" action="" >
					<div class="layui-form-item" style="display:inline-block;width:44px; position:absolute;right:0px;top:0px;">
				    	<div class="layui-input-block">
				      		<input type="checkbox" name="wapdiy" value="1" lay-skin="switch" lay-text="开|关" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['wapdiy']==1) {?> checked="" <?php }?> lay-filter="wapdiy">
				    	</div>
				  	</div>
				</form>
				
				
    			
    			<div class="comapply_sq_r_cy" style="display:none;"id="getwapurl">
    				
    				<div class="comapply_sq_r_cont">
    					<i class="comapply_sq_r_cont_icon"></i>
    					<img src="<?php echo smarty_function_url(array('m'=>'ajax','c'=>'wappubqrcode','type'=>1),$_smarty_tpl);?>
" width="210" height="210"/> 
    				</div>
    				
             		<div class="sj_sm"> 扫码手机预览</div>
             		
             		<div class="sj_ts_box">
						<div class="sj_ts">温馨提示</div>
						<p>手机扫描二维码，即可在手机进行观看页面效果</p>
          			</div>  
          			    
          		</div>
          
    	
     		
     		</div>
     		
    		<input type="hidden" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
    		
    		<div class="layui-collapse" lay-filter="test" style="border:none;" >
			<div style="border:1px solid #e9ebed;width:580px;">
    			<table class="table">
    				<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sort']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
        				<?php if ($_smarty_tpl->tpl_vars['v']->value=='hearder') {?>
        					<tr id="togglecolor">
          						<td>
          							<div class="layui-colla-item">
              							<form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form" target="supportiframe">
              								
              								<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
              								<input type="hidden" name="type" value="hearder">
                							<h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb;border-top:none;"> 头部 </h2>
                							
							                <div class="layui-colla-content">
							                  	<div class="wap_mb_list">
							                    	<div class="wap_mb_list_right">
							                      		<ul class="color-list m-l-n-xl">
									                     	<li class="bg1 js_change_color <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']=='1') {?>selected<?php }?>" onclick="getcolor(1)"></li>
									                        <li class="bg2 js_change_color <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']=='2') {?>selected<?php }?>" onclick="getcolor(2)"></li>
									                        <li class="bg3 js_change_color <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']=='3') {?>selected<?php }?>" onclick="getcolor(3)"></li>
									                        <li class="bg4 js_change_color <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']=='4') {?>selected<?php }?>" onclick="getcolor(4)"></li>
									                        <li class="bg5 js_change_color <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']=='5') {?>selected<?php }?>" onclick="getcolor(5)"></li>
									                        <li class="bg6 js_change_color <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']=='6') {?>selected<?php }?>" onclick="getcolor(6)"></li>
									                        <li class="bg7 js_change_color <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']=='7') {?>selected<?php }?>" onclick="getcolor(7)"></li>
									                        <li class="bg8 js_change_color <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']=='8') {?>selected<?php }?>" onclick="getcolor(8)"></li>
									                        <li class="bg9 js_change_color <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']=='9') {?>selected<?php }?>" onclick="getcolor(9)"></li>
									                        <li class="bg10 js_change_color <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']=='10') {?>selected<?php }?>" onclick="getcolor(10)"></li>
							                      		</ul>
							                      		
							                      		<input type="hidden" id="color" name="color" value="<?php echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];?>
">
							                      		
							                      		<li class="wap_mb_list_hd_list">
								                          	<div class="wap_mb_list_hd_c mt5"> 
								                          		
								                          		<span class="wap_mb_list_hd_s">分站：</span>
								                          		
								                            	<div class="layui-input-block" >
								                              		<input type="radio" name="site" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['site']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['site']=='') {?> checked="" <?php }?>lay-filter="site">
								                              		<input type="radio" name="site" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['site']==2) {?> checked="" <?php }?> lay-filter="site">
								                            	</div>
								                          	</div>
								                        </li>
								                        
							                        	<li class="wap_mb_list_hd_list">
							                          		<div class="wap_mb_list_hd_c mt5"> 
							                          			
							                          			<span class="wap_mb_list_hd_s">Logo：</span>
							                          			
							                            		<div class="layui-input-block" >
									                              	<input type="radio" name="logo" value="1" title="LOGO" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['logo']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['logo']=='') {?> checked="" <?php }?>lay-filter="logo">
									                              	<input type="radio" name="logo" value="2" title="文字" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['logo']==2) {?> checked="" <?php }?> lay-filter="logo">
							                            		</div>
							                            		
							                          		</div>
							                         	</li>
							                         	
							                         	<li class="wap_mb_list_hd_list">
							                          		<div class="wap_mb_list_hd_c mt5"> 
							                          		
							                          			<span class="wap_mb_list_hd_s">栏目：</span>
							                          			
							                          			<div class="layui-input-block" >
							                              			<input type="radio" name="heardercss" value="1" title="样式1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> checked="" <?php }?> lay-filter="heardercss">
						                              				<input type="radio" name="heardercss" value="2" title="样式2" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2) {?> checked="" <?php }?> lay-filter="heardercss">
						                               				<input type="radio" name="heardercss" value="3" title="样式3" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3) {?> checked="" <?php }?> lay-filter="heardercss">
						                                			<input type="radio" name="heardercss" value="4" title="样式4" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4) {?> checked="" <?php }?> lay-filter="heardercss">
						                                 			<input type="radio" name="heardercss" value="5" title="样式5" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5) {?> checked="" <?php }?> lay-filter="heardercss">
							                            		</div>
							                            		
							                          		</div>
							                        	</li>
							                        	
									                 	<li class="wap_mb_list_hd_list">
									                   		<div class="wap_mb_list">
									                        	<input type="hidden"  name="sort[]" value="hearder">
									                          	<input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
									                        </div>
									                 	</li>
							                    	</div>
							                  	</div>
							                </div>
							         	
							         	</form>
            						</div>
            					</td>
          						<td></td>
        					</tr>
        				<?php }?>
        
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='hd') {?>
        <tr id="togglehd">
          <td><div class="layui-colla-item">
              <form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form" enctype="multipart/form-data" target="supportiframe">
                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input type="hidden" name="type" value="hd">
                <h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">幻灯片
                  <div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('hd')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down   move down_move" onclick="downsort('hd')">下移</a> </div>
                </h2>
                <div class="layui-colla-content">
                  <div class="wap_mb_list">
                    <div class="wap_mb_list_hd">
                      <ul>
                        <ul  id="addhd">
						<li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">显示：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="hdshow" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hdshow']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['hdshow']=='') {?> checked="" <?php }?>lay-filter="hdshow">
                              <input type="radio" name="hdshow" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hdshow']==2) {?> checked="" <?php }?> lay-filter="hdshow">
                            </div>
                          </div>
                        </li>
                          <?php if ($_smarty_tpl->tpl_vars['hd']->value) {?>
                          <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['hd']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                          <li class="wap_mb_list_hd_list" id="h<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
                            <input type="hidden" name="hdid[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
                            <div class="wap_mb_list_hd_c"> <span class="wap_mb_list_hd_s">图标：</span>
                              <div class="layui-upload">
                                <div class="wap_mb_list_hd_file_box">
                                  <input type="file" name="hdpic[]" multiple id="nav<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"  class="wap_mb_list_hd_file_text" onchange="showpic(this,'imgh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','pimgh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" />
                                  + 添加图标 </div>
                              </div>
                            </div>
                            <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">标题：</span>
                              <input name="hdname[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" type="text" class="wap_mb_list_text" autocomplete="off">
                            </div>
                            <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">链接：</span>
                              <input name="hdurl[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
" type="text" class="wap_mb_list_text" autocomplete="off">
                            </div>
                            <div class="wap_mb_list_hd_tbimg layui-upload-list"> <img <?php if ($_smarty_tpl->tpl_vars['v']->value['pic']) {?>src="<?php echo $_smarty_tpl->tpl_vars['v']->value['pic'];?>
"<?php } else { ?>src="images/wap_show_img1.png"<?php }?> width="40" height="40" class="layui-upload-img" id="imgh<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"> </div>
                            <div class="wap_mb_list_tip"> 建议图标尺寸：不小于640*280像素</div>
                            <input type="button"  value="删除"  onclick="deleteupbox('h<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','hd')" class="wap_mb_list_hd_sc">
                          </li>
                          <?php } ?>
                          <?php }?>
                        </ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_new"><a href="javascript:;" onclick="addHd();" class="wap_mb_list_hd_new_a">+ 新增一个</a></div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="hd">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='search') {?>
        <tr id="togglesearch">
          <td><div class="layui-colla-item">
              <form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form"  target="supportiframe">
                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input type="hidden" name="type" value="search">
                <h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">搜索
                  <div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('search')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down   move down_move" onclick="downsort('search')">下移</a> </div>
                </h2>
                <div class="layui-colla-content">
                  <div class="wap_mb_list">
                    <div class="wap_mb_list_hd">
                      <ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">显示：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="searchshow" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['searchshow']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['searchshow']=='') {?> checked="" <?php }?>lay-filter="searchshow">
                              <input type="radio" name="searchshow" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['searchshow']==2) {?> checked="" <?php }?> lay-filter="searchshow">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">标题：</span>
                            <input  name="search" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['search']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['search'];
} else { ?>请输入职位关键字，如：会计...<?php }?>" id="search" type="text" class="wap_mb_list_text" autocomplete="off"  placeholder="请输入职位关键字，如：会计...">
                          </div>
                        </li>
                        <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">类型：</span>
                              <div class="layui-inline">
                                <div class="layui-input-inline" >
                                  <select name="searchurl"  lay-verify="" class="wap_mb_list_text">
                                    <option value="" >请选择</option>
        							<?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['searchurl']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value) {
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['vv']->value['id'];?>
"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['searchurl']==$_smarty_tpl->tpl_vars['vv']->value['id']) {?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['vv']->value['name'];?>
</option>
         			 				<?php } ?>
       				 
                                  </select>
                                </div>
                              </div>
                            </div>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="search">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='nav') {?>
        	<tr id="togglenav">
          		<td>
          			<div class="layui-colla-item">
          				<form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form" enctype="multipart/form-data" target="supportiframe">
          					
          					<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
          					<input type="hidden" name="type" value="nav">
                			
                			<h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">导航
                  				<div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('nav')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down  move down_move" onclick="downsort('nav')">下移</a></div>
                			</h2>
                			
                			<div class="layui-colla-content">
                  				<div class="wap_mb_list">
                    				<div class="wap_mb_list_hd">
                      					<ul>
                        					<ul  id="addnav">
                          						<?php if ($_smarty_tpl->tpl_vars['nav']->value) {?>
                          							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['nav']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                          								<li class="wap_mb_list_hd_list" id="n<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
                            								<input type="hidden" name="navid[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
                            								<div class="wap_mb_list_hd_c"> 
                            									<span class="wap_mb_list_hd_s">图标：</span>
                            									<div class="layui-upload">
                            									 	<div class="wap_mb_list_hd_file_box">
                            									 		<input type="file" name="navpic[]" multiple id="nav<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"  class="wap_mb_list_hd_file_text" onchange="showpic(this,'imgn<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','pimgn<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" /> + 添加图标 
                            									 	</div>
                              									</div>
                            								</div>
                            								
								                            <div class="wap_mb_list_hd_c mt5"> 
								                            	<span class="wap_mb_list_hd_s">标题：</span>
								                              	<input  name="navname[]" id="navname<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" type="text" class="wap_mb_list_text" autocomplete="off">
								                            </div>
								                            
								                            <div class="wap_mb_list_hd_c mt5"> 
								                            	
								                            	<span class="wap_mb_list_hd_s">链接：</span>
								                            	
								                            	<div class="layui-inline">
								                                	<div class="layui-input-inline" >
								                                  		<select name="navurl[]"  lay-verify="" class="wap_mb_list_text">
								                                    		<option value="" >请选择</option>
								        									<?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['navigation']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value) {
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
								                                    			<option value="<?php echo $_smarty_tpl->tpl_vars['vv']->value['id'];?>
"  <?php if ($_smarty_tpl->tpl_vars['v']->value['url']==$_smarty_tpl->tpl_vars['vv']->value['id']) {?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['vv']->value['name'];?>
</option>
								         			 						<?php } ?>
								                                  		</select>
								                                	</div>
								                              	</div>
								                              	
								                            </div>
								                            
								                            <div class="wap_mb_list_hd_c mt5"> 
								                            	<span class="wap_mb_list_hd_s">排序：</span>
								                              	<input  name="navsort[]" id="navsort<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['sort'];?>
" type="text" class="wap_mb_list_text" autocomplete="off">
								                            </div>
								                            
                            								<div class="wap_mb_list_hd_tbimg layui-upload-list"> <img <?php if ($_smarty_tpl->tpl_vars['v']->value['pic']) {?>src="<?php echo $_smarty_tpl->tpl_vars['v']->value['pic'];?>
"<?php } else { ?>src="images/wap_show_img1.png"<?php }?> width="40" height="40" id="imgn<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"> </div>
                            								<div class="wap_mb_list_tip"> 排序规则：小前大后</div>
                            								<div class="wap_mb_list_tip"> 建议图标尺寸：不小于64*64像素</div>
                            								<input type="button"  value="删除"  onclick="deleteupbox('n<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','nav')"class="wap_mb_list_hd_sc">
                          								</li>
                          							<?php } ?>
                          						<?php }?>
                        </ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_new"><a  href="javascript:;" onclick="addNav();" class="wap_mb_list_hd_new_a">+ 新增一个</a></div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="nav">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='indexnav') {?>
        <tr id="toggleindexnav">
          <td><div class="layui-colla-item">
              <form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form" enctype="multipart/form-data" target="supportiframe">
                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input type="hidden" name="type" value="indexnav">
                <h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">图片导航
                  <div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('indexnav')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down  move down_move" onclick="downsort('indexnav')">下移</a> </div>
                </h2>
                <div class="layui-colla-content">
                  <div class="wap_mb_list">
                    <div class="wap_mb_list_hd">
                      <ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">显示：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="indexnav" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['indexnav']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['indexnav']=='') {?> checked="" <?php }?> lay-filter="indexnav">
                              <input type="radio" name="indexnav" value="2" title="隐藏"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['indexnav']==2) {?> checked="" <?php }?>lay-filter="indexnav">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list ">
                          <div class="wap_mb_list_tw_p">左侧显示内容：</div>
                          <input type="hidden" name="indexnavid[]" value="<?php echo $_smarty_tpl->tpl_vars['indexnav1']->value['id'];?>
">
                          <div class="wap_mb_list_hd_c"> <span class="wap_mb_list_hd_s">图标：</span>
                            <div class="wap_mb_list_hd_file_box">
                              <input type="file" name="indexnavpic[]" multiple class="wap_mb_list_hd_file_text" onchange="showpic(this,'indeximg1','pindeximg1')"/>
                              + 添加图标 </div>
                          </div>
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">标题：</span>
                            <input name="indexnavname[]" id="indexnavname1" type="text" value="<?php if ($_smarty_tpl->tpl_vars['indexnav1']->value['name']) {
echo $_smarty_tpl->tpl_vars['indexnav1']->value['name'];
} else { ?>周边工作<?php }?>" class="wap_mb_list_text"  placeholder="周边工作"autocomplete="off">
                          </div>
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">标语：</span>
                            <input name="indexnavdesc[]" id="indexnavdesc1" type="text" value="<?php if ($_smarty_tpl->tpl_vars['indexnav1']->value['desc']) {
echo $_smarty_tpl->tpl_vars['indexnav1']->value['desc'];
} else { ?>好工作其实就在你身边<?php }?>" class="wap_mb_list_text"  placeholder="好工作其实就在你身边"autocomplete="off">
                          </div>
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">链接：</span>
                            <div class="layui-inline">
                              <div class="layui-input-inline" >
                                <select name="indexnavurl[]" class="wap_mb_list_text">
                                  <option value="" >请选择</option>
                                  
        			<?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['navigation']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value) {
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
          			
                                  <option value="<?php echo $_smarty_tpl->tpl_vars['vv']->value['id'];?>
"  <?php if ($_smarty_tpl->tpl_vars['indexnav1']->value['url']==$_smarty_tpl->tpl_vars['vv']->value['id']) {?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['vv']->value['name'];?>
</option>
                                  
         			 <?php } ?>
       				 
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="wap_mb_list_hd_tbimg" style="top:30px;"> <img src="<?php if ($_smarty_tpl->tpl_vars['indexnav1']->value['pic']) {
echo $_smarty_tpl->tpl_vars['indexnav1']->value['pic'];
} else { ?>images/wap_show_img1.png<?php }?>" width="40" height="40" id="indeximg1"></div>
                        </li>
                        <li class="wap_mb_list_hd_list ">
                          <div class="wap_mb_list_tw_p">右上侧显示内容：</div>
                          <input type="hidden" name="indexnavid[]" value="<?php echo $_smarty_tpl->tpl_vars['indexnav2']->value['id'];?>
">
                          <div class="wap_mb_list_hd_c"> <span class="wap_mb_list_hd_s">图标：</span>
                            <div class="wap_mb_list_hd_file_box">
                              <input type="file" name="indexnavpic[]" multiple class="wap_mb_list_hd_file_text" onchange="showpic(this,'indeximg2','pindeximg2')"/>
                              + 添加图标 </div>
                          </div>
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">标题：</span>
                            <input name="indexnavname[]"  id="indexnavname2" type="text" value="<?php if ($_smarty_tpl->tpl_vars['indexnav2']->value['name']) {
echo $_smarty_tpl->tpl_vars['indexnav2']->value['name'];
} else { ?>普工专区<?php }?>" class="wap_mb_list_text"  placeholder="普工专区" autocomplete="off">
                          </div>
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">标语：</span>
                            <input name="indexnavdesc[]"id="indexnavdesc2" type="text" value="<?php if ($_smarty_tpl->tpl_vars['indexnav2']->value['desc']) {
echo $_smarty_tpl->tpl_vars['indexnav2']->value['desc'];
} else { ?>普工.技工.一线员工<?php }?>" class="wap_mb_list_text"  placeholder="普工.技工.一线员工" autocomplete="off">
                          </div>
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">链接：</span>
                            <div class="layui-inline">
                              <div class="layui-input-inline" >
                                <select name="indexnavurl[]" class="wap_mb_list_text">
                                  <option value="" >请选择</option>
                                  
        			<?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['navigation']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value) {
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
          			
                                  <option value="<?php echo $_smarty_tpl->tpl_vars['vv']->value['id'];?>
"  <?php if ($_smarty_tpl->tpl_vars['indexnav2']->value['url']==$_smarty_tpl->tpl_vars['vv']->value['id']) {?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['vv']->value['name'];?>
</option>
                                  
         			 <?php } ?>
       				 
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="wap_mb_list_hd_tbimg" style="top:30px;"> <img src="<?php if ($_smarty_tpl->tpl_vars['indexnav2']->value['pic']) {
echo $_smarty_tpl->tpl_vars['indexnav2']->value['pic'];
} else { ?>images/wap_show_img1.png<?php }?>" width="40" height="40" id="indeximg2"></div>
                        </li>
                        <li class="wap_mb_list_hd_list ">
                          <div class="wap_mb_list_tw_p">右下侧显示内容：</div>
                          <input type="hidden" name="indexnavid[]" value="<?php echo $_smarty_tpl->tpl_vars['indexnav3']->value['id'];?>
">
                          <div class="wap_mb_list_hd_c"> <span class="wap_mb_list_hd_s">图标：</span>
                            <div class="wap_mb_list_hd_file_box">
                              <input type="file" name="indexnavpic[]" multiple class="wap_mb_list_hd_file_text" onchange="showpic(this,'indeximg3','pindeximg3')"/>
                              + 添加图标 </div>
                          </div>
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">标题：</span>
                            <input name="indexnavname[]"  id="indexnavname3" type="text" value="<?php if ($_smarty_tpl->tpl_vars['indexnav3']->value['name']) {
echo $_smarty_tpl->tpl_vars['indexnav3']->value['name'];
} else { ?>店铺招聘<?php }?>" class="wap_mb_list_text"  placeholder="店铺招聘" autocomplete="off">
                          </div>
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">标语：</span>
                            <input  name="indexnavdesc[]"  id="indexnavdesc3" type="text" value="<?php if ($_smarty_tpl->tpl_vars['indexnav3']->value['desc']) {
echo $_smarty_tpl->tpl_vars['indexnav3']->value['desc'];
} else { ?>钱多事少火速入职<?php }?>" class="wap_mb_list_text"  placeholder="钱多事少火速入职" autocomplete="off">
                          </div>
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">链接：</span>
                            <div class="layui-inline">
                              <div class="layui-input-inline" >
                                <select name="indexnavurl[]" class="wap_mb_list_text">
                                  <option value="" >请选择</option>
                                  
        			<?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['navigation']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value) {
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
          			
                                  <option value="<?php echo $_smarty_tpl->tpl_vars['vv']->value['id'];?>
"  <?php if ($_smarty_tpl->tpl_vars['indexnav3']->value['url']==$_smarty_tpl->tpl_vars['vv']->value['id']) {?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['vv']->value['name'];?>
</option>
                                  
         			 <?php } ?>
       				 
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="wap_mb_list_hd_tbimg" style="top:30px;"> <img src="<?php if ($_smarty_tpl->tpl_vars['indexnav3']->value['pic']) {
echo $_smarty_tpl->tpl_vars['indexnav3']->value['pic'];
} else { ?>images/wap_show_img1.png<?php }?>" width="40" height="40" id="indeximg3"></div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="indexnav">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='notice') {?>
        <tr id="togglenotice">
          <td><div class="layui-colla-item">
              <form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form" target="supportiframe">
                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input type="hidden" name="type" value="notice">
                <h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">公告
                  <div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('notice')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down  move down_move" onclick="downsort('notice')">下移</a></div>
                </h2>
                <div class="layui-colla-content">
                  <div class="wap_mb_list">
                    <div class="wap_mb_list_hd">
                      <ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">显示：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="notice" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['notice']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['notice']=='') {?> checked="" <?php }?> lay-filter="notice">
                              <input type="radio" name="notice" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['notice']==2) {?> checked="" <?php }?> lay-filter="notice">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="notice">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='reglogin') {?>
        <tr id="togglereglogin">
          <td><div class="layui-colla-item">
              <form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form"  target="supportiframe">
                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input type="hidden" name="type" value="reglogin">
                <h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">登录注册
                  <div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('reglogin')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down  move down_move" onclick="downsort('reglogin')">下移</a></div>
                </h2>
                <div class="layui-colla-content">
                  <div class="wap_mb_list">
                    <div class="wap_mb_list_hd">
                      <ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">显示：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="reglogin" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['reglogin']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['reglogin']=='') {?> checked="" <?php }?>lay-filter="reglogin">
                              <input type="radio" name="reglogin" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['reglogin']==2) {?> checked="" <?php }?> lay-filter="reglogin">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_tw_p">上侧描述：</div>
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">描述：</span>
                            <input  name="reglogindesc" id="reglogindesc" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['reglogindesc']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['reglogindesc'];
} else { ?>您尚未登录，马上登录轻松管理信息<?php }?>" type="text" class="wap_mb_list_text" autocomplete="off">
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_tw_p">左侧按钮：</div>
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">名称：</span>
                           <input  name="login" id="login" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['login']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['login'];
} else { ?>登录<?php }?>" type="text" class="wap_mb_list_text" autocomplete="off">
                          </div>
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">颜色：</span>
                            <input  name="logincolor" id="logincolor" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['logincolor']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['logincolor'];
} else { ?>#1c99ef<?php }?>" type="text" class="wap_mb_list_text" autocomplete="off">
                          <input type="color" id="getlogincolor" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['logincolor']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['logincolor'];
} else { ?>#1c99ef<?php }?>">
                           </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_tw_p">右侧按钮：</div>
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">名称：</span>
                            <input  name="reg" id="reg" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['reg']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['reg'];
} else { ?>注册<?php }?>" type="text" class="wap_mb_list_text" autocomplete="off">
                          </div>
                           <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">颜色：</span>
                            <input  name="regcolor" id="regcolor" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['regcolor']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['regcolor'];
} else { ?>#ff6a6a<?php }?>" type="text" class="wap_mb_list_text" autocomplete="off">
                          <input type="color" id="getregcolor" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['regcolor']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['regcolor'];
} else { ?>#ff6a6a<?php }?>">
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="reglogin">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='ad') {?>
        <tr id="togglead">
          <td><div class="layui-colla-item">
              <form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form" enctype="multipart/form-data" target="supportiframe">
                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input type="hidden" name="type" value="ad">
                <h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">广告
                  <div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('ad')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down  move down_move" onclick="downsort('ad')">下移</a></div>
                </h2>
                <div class="layui-colla-content">
                  <div class="wap_mb_list">
                    <div class="wap_mb_list_hd">
                      <ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">显示：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="ad" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['ad']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['ad']=='') {?> checked="" <?php }?> lay-filter="ad">
                              <input type="radio" name="ad" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['ad']==2) {?> checked="" <?php }?> lay-filter="ad">
                            </div>
                          </div>
                        </li>
                        <ul  id="addadlist">
                          <?php if ($_smarty_tpl->tpl_vars['adlist']->value) {?>
                          <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['adlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                          <li class="wap_mb_list_hd_list" id="ad<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
                            <input type="hidden" name="adlistid[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
                            <div class="wap_mb_list_hd_c"> <span class="wap_mb_list_hd_s">图标：</span>
                              <div class="layui-upload">
                                <div class="wap_mb_list_hd_file_box">
                                  <input type="file" name="adlistpic[]" multiple id="nav<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"  class="wap_mb_list_hd_file_text" onchange="showpic(this,'imgad<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','pimgad<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')" />
                                  + 添加图标 </div>
                              </div>
                            </div>
                            <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">标题：</span>
                              <input name="adlistname[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" type="text" class="wap_mb_list_text" autocomplete="off">
                            </div>
                            <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">链接：</span>
                              <input name="adlisturl[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
" type="text" class="wap_mb_list_text" autocomplete="off">
                            </div>
                            <div class="wap_mb_list_hd_tbimg layui-upload-list"> <img <?php if ($_smarty_tpl->tpl_vars['v']->value['pic']) {?>src="<?php echo $_smarty_tpl->tpl_vars['v']->value['pic'];?>
"<?php } else { ?>src="images/wap_show_img1.png"<?php }?> width="40" height="40" class="layui-upload-img" id="imgad<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"> </div>
                            <div class="wap_mb_list_tip"> 建议图标尺寸：不小于300*180像素</div>
                            <input type="button"  value="删除"  onclick="deleteupbox('ad<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
','adlist')"class="wap_mb_list_hd_sc">
                          </li>
                          <?php } ?>
                          <?php }?>
                        </ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_new"><a href="javascript:;" onclick="addAdlist();" class="wap_mb_list_hd_new_a">+ 新增一个</a></div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="ad">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='rewardjob') {?>
        <tr id="togglerewardjob">
          <td><div class="layui-colla-item">
              <form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form" enctype="multipart/form-data" target="supportiframe">
                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input type="hidden" name="type" value="rewardjob">
                <h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">赏金职位
                  <div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('rewardjob')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down  move down_move" onclick="downsort('rewardjob')">下移</a></div>
                </h2>
                <div class="layui-colla-content">
                  <div class="wap_mb_list">
                    <div class="wap_mb_list_hd">
                      <ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">显示：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="rewardjob" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjob']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjob']=='') {?> checked="" <?php }?> lay-filter="rewardjob">
                              <input type="radio" name="rewardjob" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjob']==2) {?> checked="" <?php }?> lay-filter="rewardjob">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">类型：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="rewardjobcss" value="1" title="列表" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobcss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobcss']=='') {?> checked="" <?php }?> lay-filter="rewardjobcss">
                              <input type="radio" name="rewardjobcss" value="2" title="缩略图" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobcss']==2) {?> checked="" <?php }?> lay-filter="rewardjobcss">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5">
                          <span class="wap_mb_list_hd_s">标签：</span>
                          <div class="layui-input-block">
                            <input type="checkbox" name="rewardjobcom" lay-filter="rewardjobcom"  value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobcom']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobcom']=='') {?> checked="" <?php }?> lay-skin="primary" title="企业" >
                            <input type="checkbox" name="rewardjobsalary" lay-filter="rewardjobsalary" value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobsalary']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobsalary']=='') {?> checked="" <?php }?>  lay-skin="primary" title="薪资">
                            <input type="checkbox" name="rewardjobreward" lay-filter="rewardjobreward"  value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobreward']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobreward']=='') {?> checked="" <?php }?> lay-skin="primary" title="赏金" >
                            <input type="checkbox" name="rewardjobdate" lay-filter="rewardjobdate" value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobdate']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobdate']=='') {?> checked="" <?php }?> lay-skin="primary" title="时间" >
                          </div>
                        </li>
                         <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">更多：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="rewardjobmore" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobmore']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobmore']=='') {?> checked="" <?php }?> lay-filter="rewardjobmore">
                              <input type="radio" name="rewardjobmore" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobmore']==2) {?> checked="" <?php }?> lay-filter="rewardjobmore">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">数量：</span>
                            <input  name="rewardjobnum" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobnum']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobnum'];
} else { ?>5<?php }?>" type="text" class="wap_mb_list_text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" autocomplete="off">
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="rewardjob">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='hotjob') {?>
        <tr id="togglehotjob">
          <td><div class="layui-colla-item">
              <form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form" enctype="multipart/form-data" target="supportiframe">
                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input type="hidden" name="type" value="hotjob">
                <h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">热门职位
                  <div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('hotjob')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down  move down_move" onclick="downsort('hotjob')">下移</a></div>
                </h2>
                <div class="layui-colla-content">
                  <div class="wap_mb_list">
                    <div class="wap_mb_list_hd">
                      <ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">显示：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="hotjob" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotjob']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['hotjob']=='') {?> checked="" <?php }?> lay-filter="hotjob">
                              <input type="radio" name="hotjob" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotjob']==2) {?> checked="" <?php }?> lay-filter="hotjob">
                            </div>
                          </div>
                        </li>
                        
                      <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">更多：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="hotjobmore" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotjobmore']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['hotjobmore']=='') {?> checked="" <?php }?> lay-filter="hotjobmore">
                              <input type="radio" name="hotjobmore" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotjobmore']==2) {?> checked="" <?php }?> lay-filter="hotjobmore">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">数量：</span>
                            <input  name="hotjobnum" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotjobnum']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['hotjobnum'];
} else { ?>8<?php }?>" type="text" class="wap_mb_list_text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" autocomplete="off">
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="hotjob">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='newjob') {?>
        <tr id="togglenewjob">
          <td><div class="layui-colla-item">
              <form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form" enctype="multipart/form-data" target="supportiframe">
                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input type="hidden" name="type" value="newjob">
                <h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">最新职位
                  <div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('newjob')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down  move down_move" onclick="downsort('newjob')">下移</a> </div>
                </h2>
                <div class="layui-colla-content">
                  <div class="wap_mb_list">
                    <div class="wap_mb_list_hd">
                      <ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">显示：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="newjob" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjob']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['newjob']=='') {?> checked="" <?php }?> lay-filter="newjob">
                              <input type="radio" name="newjob" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjob']==2) {?> checked="" <?php }?> lay-filter="newjob">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5">
                          <span class="wap_mb_list_hd_s">标签：</span>
                          <div class="layui-input-block">
                            <input type="checkbox" name="newjobcom" lay-filter="newjobcom" value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobcom']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['newjobcom']=='') {?> checked="" <?php }?> lay-skin="primary" title="企业" >
                            <input type="checkbox" name="newjobsalary" lay-filter="newjobsalary" value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobsalary']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['newjobsalary']=='') {?> checked="" <?php }?> lay-skin="primary" title="薪资">
                            <input type="checkbox" name="newjobcity" lay-filter="newjobcity" value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobcity']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['newjobcity']=='') {?> checked="" <?php }?> lay-skin="primary" title="地区" >
                            <input type="checkbox" name="newjobdate" lay-filter="newjobdate" value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobdate']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['newjobdate']=='') {?> checked="" <?php }?> lay-skin="primary" title="时间" >
                          <input type="checkbox" name="newjobwelfare" lay-filter="newjobwelfare" value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobwelfare']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['newjobwelfare']=='') {?> checked="" <?php }?> lay-skin="primary" title="福利待遇" >
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">更多：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="newjobmore" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobmore']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['newjobmore']=='') {?> checked="" <?php }?> lay-filter="newjobmore">
                              <input type="radio" name="newjobmore" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobmore']==2) {?> checked="" <?php }?> lay-filter="newjobmore">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">数量：</span>
                            <input  name="newjobnum" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobnum']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['newjobnum'];
} else { ?>5<?php }?>" type="text" class="wap_mb_list_text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" autocomplete="off">
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="newjob">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='hotcom') {?>
        <tr id="togglehotcom">
          <td><div class="layui-colla-item">
              <form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form" enctype="multipart/form-data" target="supportiframe">
                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input type="hidden" name="type" value="hotcom">
                <h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">名企展示
                  <div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('hotcom')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down  move down_move" onclick="downsort('hotcom')">下移</a></div>
                </h2>
                <div class="layui-colla-content">
                  <div class="wap_mb_list">
                    <div class="wap_mb_list_hd">
                      <ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">显示：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="hotcom" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcom']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['hotcom']=='') {?> checked="" <?php }?> lay-filter="hotcom">
                              <input type="radio" name="hotcom" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcom']==2) {?> checked="" <?php }?> lay-filter="hotcom">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5">
                          <span class="wap_mb_list_hd_s">标签：</span>
                          <div class="layui-input-block">
                            <input type="checkbox" name="hotcomlogo" lay-filter="hotcomlogo" value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcomlogo']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['hotcomlogo']=='') {?> checked="" <?php }?> lay-skin="primary" title="LOGO" >
                            <input type="checkbox" name="hotcomhy" lay-filter="hotcomhy" value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcomhy']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['hotcomhy']=='') {?> checked="" <?php }?> lay-skin="primary" title="行业">
                            <input type="checkbox" name="hotcomcity" lay-filter="hotcomcity" value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcomcity']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['hotcomcity']=='') {?> checked="" <?php }?> lay-skin="primary" title="地区" >
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">更多：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="hotcommore" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcommore']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['hotcommore']=='') {?> checked="" <?php }?> lay-filter="hotcommore">
                              <input type="radio" name="hotcommore" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcommore']==2) {?> checked="" <?php }?> lay-filter="hotcommore">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">数量：</span>
                            <input  name="hotcomnum" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcomnum']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['hotcomnum'];
} else { ?>5<?php }?>" type="text" class="wap_mb_list_text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" autocomplete="off">
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="hotcom">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='recjob') {?>
        <tr id="togglerecjob">
          <td><div class="layui-colla-item">
              <form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form" enctype="multipart/form-data" target="supportiframe">
                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input type="hidden" name="type" value="recjob">
                <h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">推荐职位
                  <div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('recjob')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down  move down_move" onclick="downsort('recjob')">下移</a></div>
                </h2>
                <div class="layui-colla-content">
                  <div class="wap_mb_list">
                    <div class="wap_mb_list_hd">
                      <ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">显示：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="recjob" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjob']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['recjob']=='') {?> checked="" <?php }?> lay-filter="recjob">
                              <input type="radio" name="recjob" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjob']==2) {?> checked="" <?php }?> lay-filter="recjob">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5">
                          <span class="wap_mb_list_hd_s">标签：</span>
                          <div class="layui-input-block">
                            <input type="checkbox" name="recjobcom" lay-filter="recjobcom"  value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobcom']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['recjobcom']=='') {?> checked="" <?php }?> lay-skin="primary" title="企业" >
                            <input type="checkbox" name="recjobsalary" lay-filter="recjobsalary"  value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobsalary']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['recjobsalary']=='') {?> checked="" <?php }?> lay-skin="primary" title="薪资">
                            <input type="checkbox" name="recjobcity" lay-filter="recjobcity"  value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobcity']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['recjobcity']=='') {?> checked="" <?php }?> lay-skin="primary" title="地区" >
                            <input type="checkbox" name="recjobdate" lay-filter="recjobdate"  value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobdate']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['recjobdate']=='') {?> checked="" <?php }?> lay-skin="primary" title="时间" >
                         <input type="checkbox" name="recjobwelfare" lay-filter="recjobwelfare" value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobwelfare']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['recjobwelfare']=='') {?> checked="" <?php }?> lay-skin="primary" title="福利待遇" >
                          </div>
                        </li>
                       <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">更多：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="recjobmore" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobmore']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['recjobmore']=='') {?> checked="" <?php }?> lay-filter="recjobmore">
                              <input type="radio" name="recjobmore" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobmore']==2) {?> checked="" <?php }?> lay-filter="recjobmore">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">数量：</span>
                            <input  name="recjobnum" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobnum']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['recjobnum'];
} else { ?>5<?php }?>" type="text" class="wap_mb_list_text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" autocomplete="off">
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="recjob">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='urgentjob') {?>
        <tr id="toggleurgentjob">
          <td><div class="layui-colla-item">
              <form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form" enctype="multipart/form-data" target="supportiframe">
                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input type="hidden" name="type" value="urgentjob">
                <h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">紧急职位
                  <div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('urgentjob')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down  move down_move" onclick="downsort('urgentjob')">下移</a></div>
                </h2>
                <div class="layui-colla-content">
                  <div class="wap_mb_list">
                    <div class="wap_mb_list_hd">
                      <ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">显示：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="urgentjob" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjob']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjob']=='') {?> checked="" <?php }?> lay-filter="urgentjob">
                              <input type="radio" name="urgentjob" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjob']==2) {?> checked="" <?php }?> lay-filter="urgentjob">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5">
                          <span class="wap_mb_list_hd_s">标签：</span>
                          <div class="layui-input-block">
                            <input type="checkbox" name="urgentjobcom" lay-filter="urgentjobcom"  value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobcom']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobcom']=='') {?> checked="" <?php }?>  lay-skin="primary" title="企业" >
                            <input type="checkbox" name="urgentjobsalary" lay-filter="urgentjobsalary"  value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobsalary']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobsalary']=='') {?> checked="" <?php }?>  lay-skin="primary" title="薪资">
                            <input type="checkbox" name="urgentjobcity" lay-filter="urgentjobcity"  value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobcity']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobcity']=='') {?> checked="" <?php }?>  lay-skin="primary" title="地区" >
                            <input type="checkbox" name="urgentjobdate" lay-filter="urgentjobdate"  value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobdate']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobdate']=='') {?> checked="" <?php }?>  lay-skin="primary" title="时间" >
                         <input type="checkbox" name="urgentjobwelfare" lay-filter="urgentjobwelfare" value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobwelfare']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobwelfare']=='') {?> checked="" <?php }?> lay-skin="primary" title="福利待遇" >
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">更多：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="urgentjobmore" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobmore']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobmore']=='') {?> checked="" <?php }?> lay-filter="urgentjobmore">
                              <input type="radio" name="urgentjobmore" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobmore']==2) {?> checked="" <?php }?> lay-filter="urgentjobmore">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">数量：</span>
                            <input  name="urgentjobnum" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobnum']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobnum'];
} else { ?>5<?php }?>" type="text" class="wap_mb_list_text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" autocomplete="off">
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="urgentjob">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='resume') {?>
        <tr id="toggleresume">
          <td><div class="layui-colla-item">
              <form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form" enctype="multipart/form-data" target="supportiframe">
                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input type="hidden" name="type" value="resume">
                <h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">最新简历
                  <div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('resume')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down  move down_move" onclick="downsort('resume')">下移</a> </div>
                </h2>
                <div class="layui-colla-content">
                  <div class="wap_mb_list">
                    <div class="wap_mb_list_hd">
                      <ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">显示：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="resume" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resume']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['resume']=='') {?> checked="" <?php }?> lay-filter="resume">
                              <input type="radio" name="resume" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resume']==2) {?> checked="" <?php }?> lay-filter="resume">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">方式：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="resumepic" value="1" title="文字" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumepic']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['resumepic']=='') {?> checked="" <?php }?> lay-filter="resumepic">
                              <input type="radio" name="resumepic" value="2" title="图文" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumepic']==2) {?> checked="" <?php }?> lay-filter="resumepic">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list" id="resumelabel" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumepic']==2) {?> style="display:none" <?php }?>>
                          <div class="wap_mb_list_hd_c mt5">
                          <span class="wap_mb_list_hd_s">标签：</span>
                          <div class="layui-input-block">
                            <input type="checkbox" name="resumeexp" value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumeexp']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['resumeexp']=='') {?> checked="" <?php }?> lay-skin="primary" title="经验" lay-filter="resumeexp">
                            <input type="checkbox" name="resumecity" value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumecity']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['resumecity']=='') {?> checked="" <?php }?> lay-skin="primary" title="地区"  lay-filter="resumecity">
                            <input type="checkbox" name="resumeedu"  value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumeedu']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['resumeedu']=='') {?> checked="" <?php }?> lay-skin="primary" title="学历"  lay-filter="resumeedu">
                            <input type="checkbox" name="resumeexpect" value="1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumeexpect']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['resumeexpect']=='') {?> checked="" <?php }?> lay-skin="primary" title="意向职位"  lay-filter="resumeexpect">
                          </div>
                        </li>
                       <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">更多：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="resumemore" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumemore']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['resumemore']=='') {?> checked="" <?php }?> lay-filter="resumemore">
                              <input type="radio" name="resumemore" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumemore']==2) {?> checked="" <?php }?> lay-filter="resumemore">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">数量：</span>
                            <input  name="resumenum" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumenum']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['resumenum'];
} else { ?>5<?php }?>" type="text" class="wap_mb_list_text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" autocomplete="off">
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="resume">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='article') {?>
        <tr id="togglearticle">
          <td><div class="layui-colla-item">
              <form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form" enctype="multipart/form-data" target="supportiframe">
                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input type="hidden" name="type" value="article">
                <h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">职场资讯
                  <div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('article')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down  move down_move" onclick="downsort('article')">下移</a></div>
                </h2>
                <div class="layui-colla-content">
                  <div class="wap_mb_list">
                    <div class="wap_mb_list_hd">
                      <ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">显示：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="article" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['article']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['article']=='') {?> checked="" <?php }?> lay-filter="article">
                              <input type="radio" name="article" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['article']==2) {?> checked="" <?php }?> lay-filter="article">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">类型：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="articleclass" value="1" title="最新" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articleclass']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['articleclass']=='') {?> checked="" <?php }?> lay-filter="articleclass">
                              <input type="radio" name="articleclass" value="2" title="推荐" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articleclass']==2) {?> checked="" <?php }?> lay-filter="articleclass">
                              <input type="radio" name="articleclass" value="3" title="热门" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articleclass']==3) {?> checked="" <?php }?> lay-filter="articleclass">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">样式：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="articlecss" value="1" title="缩略图" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articlecss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['articlecss']=='') {?> checked="" <?php }?> lay-filter="articlecss">
                              <input type="radio" name="articlecss" value="2" title="图片列表" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articlecss']==2) {?> checked="" <?php }?> lay-filter="articlecss">
                              <input type="radio" name="articlecss" value="3" title="列表" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articlecss']==3) {?> checked="" <?php }?> lay-filter="articlecss">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">更多：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="articlemore" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articlemore']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['articlemore']=='') {?> checked="" <?php }?> lay-filter="articlemore">
                              <input type="radio" name="articlemore" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articlemore']==2) {?> checked="" <?php }?> lay-filter="articlemore">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">数量：</span>
                            <input  name="articlenum" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articlenum']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['articlenum'];
} else { ?>5<?php }?>" type="text" class="wap_mb_list_text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" autocomplete="off">
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="article">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='zph') {?>
        <tr id="togglezph">
          <td><div class="layui-colla-item">
              <form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form"  target="supportiframe">
                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input type="hidden" name="type" value="zph">
                <h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">招聘会
                  <div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('zph')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down  move down_move" onclick="downsort('zph')">下移</a></div>
                </h2>
                <div class="layui-colla-content">
                  <div class="wap_mb_list">
                    <div class="wap_mb_list_hd">
                      <ul>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">显示：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="zph" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['zph']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['zph']=='') {?> checked="" <?php }?> lay-filter="zph">
                              <input type="radio" name="zph" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['zph']==2) {?> checked="" <?php }?> lay-filter="zph">
                            </div>
                          </div>
                        </li>
                      <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">更多：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="zphmore" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['zphmore']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['zphmore']=='') {?> checked="" <?php }?> lay-filter="zphmore">
                              <input type="radio" name="zphmore" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['zphmore']==2) {?> checked="" <?php }?> lay-filter="zphmore">
                            </div>
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">数量：</span>
                            <input  name="zphnum" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['zphnum']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['zphnum'];
} else { ?>5<?php }?>" type="text" class="wap_mb_list_text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" autocomplete="off">
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="zph">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value=='jobclass') {?>
        <tr id="togglejobclass">
          <td><div class="layui-colla-item">
              <form action="index.php?m=admin_tpl_moblies&c=save" method="post" class="layui-form" target="supportiframe">
                <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input type="hidden" name="type" value="jobclass">
                <h2 class="layui-colla-title moblies_tit" style=" background:#f9fbfb">职位类别
                  <div class="move_box"> <a href="javascript:void(0)"  onclick="upsort('jobclass')" class="move up_move">上移</a> <a href="javascript:void(0)" class="down  move down_move" onclick="downsort('jobclass')">下移</a></div>
                </h2>
                <div class="layui-colla-content">
                  <div class="wap_mb_list">
                    <div class="wap_mb_list_hd">
                      <ul>
                        <li class="wap_mb_list_hd_list">
                        <div class="wap_mb_list_tw_p">一级类别：</div>
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">一级：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="jobclassone" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassone']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassone']=='') {?> checked="" <?php }?> lay-filter="jobclassone">
                              <input type="radio" name="jobclassone" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassone']==2) {?> checked="" <?php }?> lay-filter="jobclassone">
                            </div>
                          </div>
                        </li>
                         <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">数量：</span>
                            <input  name="jobclassonenum" id="jobclassonenum" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassonenum']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassonenum'];
}?>" type="text" class="wap_mb_list_text"<?php if (($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassonenumall']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassonenumall']=='')&&$_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassonenum']=='') {?> disabled <?php }?> onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" autocomplete="off">
                            <input type="checkbox" name="jobclassonenumall" value="1" lay-skin="primary" title="全部" <?php if (($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassonenumall']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassonenumall']=='')&&$_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassonenum']=='') {?> checked="" <?php }?> lay-filter="jobclassonenumall">
                          </div>
                        </li>
                        <li class="wap_mb_list_hd_list"  id="twojobshow" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassone']==2) {?> style="display:none;" <?php }?>>
                        <div class="wap_mb_list_tw_p">二级类别：</div>
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">二级：</span>
                            <div class="layui-input-block" >
                              <input type="radio" name="jobclasstwo" value="1" title="显示" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclasstwo']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['jobclasstwo']=='') {?> checked="" <?php }?> lay-filter="jobclasstwo">
                              <input type="radio" name="jobclasstwo" value="2" title="隐藏" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclasstwo']==2) {?> checked="" <?php }?> lay-filter="jobclasstwo">
                            </div>
                          </div>
                        </li>
                         <li class="wap_mb_list_hd_list"  id="twojobnum" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassone']==2) {?> style="display:none;" <?php }?>>
                          <div class="wap_mb_list_hd_c mt5"> <span class="wap_mb_list_hd_s">数量：</span>
                            <input  name="jobclasstwonum" id="jobclasstwonum" value="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclasstwonum']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['jobclasstwonum'];
}?>" type="text" <?php if (($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclasstwonumall']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['jobclasstwonumall']=='')&&$_smarty_tpl->tpl_vars['tplmoblie']->value['jobclasstwonum']=='') {?> disabled <?php }?> class="wap_mb_list_text"onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" autocomplete="off">
                          <input type="checkbox" name="jobclasstwonumall" value="1" lay-skin="primary" title="全部" <?php if (($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclasstwonumall']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['jobclasstwonumall']=='')&&$_smarty_tpl->tpl_vars['tplmoblie']->value['jobclasstwonum']=='') {?> checked="" <?php }?> lay-filter="jobclasstwonumall">
                           </div>
                        </li>
                        <li class="wap_mb_list_hd_list">
                          <div class="wap_mb_list">
                            <input type="hidden"  name="sort[]" value="jobclass">
                            <input type="submit" value=" 提交 " name="submit" class="layui-btn layui-btn-normal">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div></td>
        </tr>
        <?php }?>
        <?php } ?>
      </table>
    </div>
  </div></div>
  
  <div class="wap_mb_show">
  	<div class="wxpubtool_sj_tit"><div class="wxpubtool_sj_tit_c"></div></div>
    <div class="wap_mb_show_box">
	
      <div class="wap_mb_show_content">
        <div class="wap_mb_show_content_c"> 
          
          <table style="width:100%;background-color: #f0f2f5;">
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sort']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='hearder') {?>
            <tr  id="ptogglecolor">
              <td>
             <div class="wap_header_box">
              <div class="wap_header <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {?>bg<?php echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?>" >
        <div class="logo" id="logo1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['logo']==2) {?> style="display:none" <?php }?>><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_wap_logo'];?>
"></div>
        <div class="header_p_z" id="logo2" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['logo']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['logo']=='') {?> style="display:none" <?php }?>> 维特人才网</div>
    
        <a href="" id="site" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['site']==2) {?> style="display:none" <?php }?>><span class="search_con_l fl" ><i class="city_icon iconfont"  ></i>全国</span></a> 
			    </div>
	</div>
        </td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='hd') {?>
            <tr id="ptogglehd">
              <td> 
                
                <div class="wap_mb_show_hdp" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hdshow']==2) {?> style="display:none" <?php }?>>
                  <div class="layui-carousel" id="hdpicshow">
                    <div carousel-item="" id="paddhd"> <?php  $_smarty_tpl->tpl_vars['pv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['hd']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pv']->key => $_smarty_tpl->tpl_vars['pv']->value) {
$_smarty_tpl->tpl_vars['pv']->_loop = true;
?>
                      <div id="prh<?php echo $_smarty_tpl->tpl_vars['pv']->value['id'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['pv']->value['pic'];?>
"  width="100%"  height="130" id="pimgh<?php echo $_smarty_tpl->tpl_vars['pv']->value['id'];?>
"></div>
                      <?php } ?> </div>
                  </div>
                </div></td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='search') {?>
            <tr id="ptogglesearch">
              <td> 
              <div class="wap_mb_show_search " <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['searchshow']==2) {?> style="display:none" <?php }?>>
                  <div class="index_search_cont">
                    <div class="index_formFiled">
                      <input type="text" value="" name="keyword" class="index_input_search" id="pkeyword" placeholder="<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['search']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['search'];
} else { ?>请输入职位关键字，如：会计...<?php }?>">
                      <input type="submit" value="搜职位" class="index_input_btn">
                      <i class="index_input_btn_icon iconfont_index_search"></i> </div>
                  </div>
                </div></td>
            </tr>
            <?php }?>
            
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='nav') {?>
            	<tr id="ptogglenav">
              		<td>
                		<div class="wap_mb_show_nav">
                  			<ul class="wap_mb_show_nav_list" id="paddnav">
                    			<?php if ($_smarty_tpl->tpl_vars['nav']->value) {?>
                    				<?php  $_smarty_tpl->tpl_vars['pv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['nav']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pv']->key => $_smarty_tpl->tpl_vars['pv']->value) {
$_smarty_tpl->tpl_vars['pv']->_loop = true;
?>
                    					<li id="prn<?php echo $_smarty_tpl->tpl_vars['pv']->value['id'];?>
">
                    						<img src="<?php if ($_smarty_tpl->tpl_vars['pv']->value['pic']) {
echo $_smarty_tpl->tpl_vars['pv']->value['pic'];
} else { ?>images/wap_show_img1.png<?php }?>" width="40"height="40" id="pimgn<?php echo $_smarty_tpl->tpl_vars['pv']->value['id'];?>
">
                    						<div class="wap_mb_show_nav_list_p" id="pnavname<?php echo $_smarty_tpl->tpl_vars['pv']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['pv']->value['name'];?>
</div>
                    					</li>
                                    <?php } ?>
                    			<?php }?>
                  			</ul>
                		</div>
                	</td>
            	</tr>
            <?php }?>
            
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='indexnav') {?>
            	<tr id="ptoggleindexnav">
              		<td>
                		<div class="wap_mb_show_imgnav mbt10" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['indexnav']==2) {?> style="display:none" <?php }?>>
		                  	<div class="index_nav_yd">
		                    	<div class="index_nav_yd_left">
		                      		<div class="index_nav_yd_left_tit" id="pindexnavname1">
		                      			<?php if ($_smarty_tpl->tpl_vars['indexnav1']->value['name']) {
echo $_smarty_tpl->tpl_vars['indexnav1']->value['name'];
} else { ?>周边工作<?php }?>
		                      		</div>
		                      		<img  class="index_nav_yd_left_icon" src="<?php if ($_smarty_tpl->tpl_vars['indexnav1']->value['pic']) {
echo $_smarty_tpl->tpl_vars['indexnav1']->value['pic'];
} else { ?>images/nav_icon_wz.png<?php }?>"  id="pindeximg1">
		                      		<div class="index_nav_yd_left_job" id="pindexnavdesc1"><?php if ($_smarty_tpl->tpl_vars['indexnav1']->value['desc']) {
echo $_smarty_tpl->tpl_vars['indexnav1']->value['desc'];
} else { ?>好工作，其实就在你身边<?php }?></div>
		                    	</div>
		                    	
		                    	<div class="index_nav_yd_right">
		                      		<div class="index_nav_yd_right_t">
		                        		<div class="index_nav_yd_right_t_name" id="pindexnavname2">
		                        			<?php if ($_smarty_tpl->tpl_vars['indexnav2']->value['name']) {
echo $_smarty_tpl->tpl_vars['indexnav2']->value['name'];
} else { ?>普工专区<?php }?>
		                        		</div>
		                        		<div class="index_nav_yd_right_t_p" id="pindexnavdesc2"><?php if ($_smarty_tpl->tpl_vars['indexnav2']->value['desc']) {
echo $_smarty_tpl->tpl_vars['indexnav2']->value['desc'];
} else { ?>普工.技工.一线员工<?php }?></div>
		                        		<img class="index_nav_yd_right_icon" src="<?php if ($_smarty_tpl->tpl_vars['indexnav2']->value['pic']) {
echo $_smarty_tpl->tpl_vars['indexnav2']->value['pic'];
} else { ?>images/nav_icon_dp.png<?php }?>" id="pindeximg2"> 
		                        	</div>
		                        	<div class="index_nav_yd_right_b">
		                        		<div class="index_nav_yd_right_bname" id="pindexnavname3"><?php if ($_smarty_tpl->tpl_vars['indexnav3']->value['name']) {
echo $_smarty_tpl->tpl_vars['indexnav3']->value['name'];
} else { ?>店铺招聘<?php }?></div>
		                        		<div class="index_nav_yd_right_bp" id="pindexnavdesc3"><?php if ($_smarty_tpl->tpl_vars['indexnav3']->value['desc']) {
echo $_smarty_tpl->tpl_vars['indexnav3']->value['desc'];
} else { ?>钱多事少，火速入职<?php }?></div>
		                        		<img class="index_nav_yd_right_bicon" src="<?php if ($_smarty_tpl->tpl_vars['indexnav3']->value['pic']) {
echo $_smarty_tpl->tpl_vars['indexnav3']->value['pic'];
} else { ?>images/nav_icon_jz.png<?php }?>" id="pindeximg3"> 
		                        	</div>
		                  		</div>
		                  	</div>
		               	</div>
		         	</td>
            	</tr>
            <?php }?>
            
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='notice') {?>
            <tr id="ptogglenotice">
              <td><div class="clear"></div>
                
                
                <div class="yun_wap_notice sxl mbt10" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['notice']==2) {?> style="display:none" <?php }?>> <span class="yun_wap_notice_tit"><i class="yun_wap_notice_tit_s"></i></span>
                  <ul class="yun_wap_notice_list sxlist">
                    <li>PHPyun宿迁站，正式开通！</li>
                  </ul>
                </div></td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='reglogin') {?>
            <tr id="ptogglereglogin">
              <td><div class="clear"></div>
                
                
                <section id="reglogin" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['reglogin']==2) {?> style="display:none" <?php }?>>
                  <div class="index_warp_content mt10">
                    <div class="index_login">
                      <div class="index_login_p" id="preglogindesc"><?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['reglogindesc']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['reglogindesc'];
} else { ?>您尚未登录，马上登录轻松管理信息<?php }?></div>
                      <div class="index_logoin_sub"><a href="###" class="index_logoin_bth" id="plogin"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['logincolor']) {?>style="background:<?php echo $_smarty_tpl->tpl_vars['tplmoblie']->value['logincolor'];?>
;"<?php }?>><?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['login']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['login'];
} else { ?>登录<?php }?></a> 
                      <a href="###" class="index_logoin_bth index_reg_bth" id="preg" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['regcolor']) {?>style="background: <?php echo $_smarty_tpl->tpl_vars['tplmoblie']->value['regcolor'];?>
;"<?php }?>><?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['reg']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['reg'];
} else { ?>注册<?php }?></a> </div>
                    </div>
                  </div>
                </section></td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='ad') {?>
            <tr id="ptogglead">
              <td> 
                
                <div class="clear"></div>
                <section id="ad" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['ad']==2) {?> style="display:none" <?php }?>>
                  <div class="yun_companyList">
                    <ul class="clearfix" id="paddadlist">
                      <?php if ($_smarty_tpl->tpl_vars['adlist']->value) {?>
                      <?php  $_smarty_tpl->tpl_vars['pv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['adlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pv']->key => $_smarty_tpl->tpl_vars['pv']->value) {
$_smarty_tpl->tpl_vars['pv']->_loop = true;
?>
                      <li id="prad<?php echo $_smarty_tpl->tpl_vars['pv']->value['id'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['pv']->value['pic'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['pv']->value['name'];?>
"  id="pimgad<?php echo $_smarty_tpl->tpl_vars['pv']->value['id'];?>
"></li>
                      <?php } ?>
                      
                      <?php }?>
                    </ul>
                  </div>
                </section></td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='rewardjob') {?>
            <tr id="ptogglerewardjob">
              <td>
                <div class="clear"></div>
               
                <div class="clear"></div>
                <div class="wap_mb_show_sj " id="rewardjob" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjob']==2) {?> style="display:none" <?php }?> >
                 
                   <div class="wap_tit heardercssnone heardercss1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5) {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit1"><span class="wap_tit1_bg"><i class="wap_titsj"></i>赏金职位</span><span class="rewardjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss2"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit2"><span class="wap_tit2_bg">赏金职位</span><span class="rewardjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss3"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit3"><span class="wap_tit3_bg"><i class="wap_titsj"></i>赏金职位</span><span class="rewardjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss4"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit4"><span class="wap_tit4_bg" ><i class=" wap_tit4_icon_sj"></i><font color="#666">赏金职位</font></span><span class="rewardjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
                <div class="wap_tit heardercssnone heardercss5"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit5"><span class="wap_tit5_bg">赏金职位</span><span class="rewardjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>

                <div class="wap_diy_sjcont"  id="rewardjobcss2" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobcss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobcss']=='') {?> style="display:none" <?php }?> > 

				<div class="wap_diy_sjlist">
				<a href="###" class="wap_diy_sjlist_a">
					<div class="wap_diy_sj_n"><span class="wap_diy_sj_n_s"><i class="wap_diy_sj_n_dw">￥</i>30.00</span>
					<span class="wap_diy_sj_n_time rewardjobdate">2017-09-09</span></div>
					<div class="wap_diy_sjbox">
					<div class="wap_diy_sj_jobname">部门经理 </div> 
					<div class="wap_diy_sj_xz rewardjobsalary">3000~5000元</div> 
					<div class="wap_diy_sj_comname rewardjobcom">蓝思科技信息技术有限公司沭阳分公司 </div> 
					<div class="wap_diy_sj_tj rewardjobreward" >
						<span class="wap_diy_sj_tj_s"><i class="wap_diy_sj_tj_s_n">￥3</i>投递</span>
						<span class="wap_diy_sj_tj_s"><i class="wap_diy_sj_tj_s_n">￥17</i>面试</span>
						<span class="wap_diy_sj_tj_s wap_diy_sj_tj_send"><i class="wap_diy_sj_tj_s_n">￥10</i>入职</span>
					</div> 
					</div> 
				</a>
				</div> 
				<div class="wap_diy_sjlist">
				<a href="###" class="wap_diy_sjlist_a">
					<div class="wap_diy_sj_n"><span class="wap_diy_sj_n_s"><i class="wap_diy_sj_n_dw">￥</i>30.00</span>
					<span class="wap_diy_sj_n_time rewardjobdate">2017-09-09</span></div>
					<div class="wap_diy_sjbox">
					<div class="wap_diy_sj_jobname">部门经理 </div> 
					<div class="wap_diy_sj_xz rewardjobsalary">3000~5000元</div> 
					<div class="wap_diy_sj_comname rewardjobcom">蓝思科技信息技术有限公司沭阳分公司 </div> 
					<div class="wap_diy_sj_tj rewardjobreward" >
						<span class="wap_diy_sj_tj_s"><i class="wap_diy_sj_tj_s_n">￥3</i>投递</span>
						<span class="wap_diy_sj_tj_s"><i class="wap_diy_sj_tj_s_n">￥17</i>面试</span>
						<span class="wap_diy_sj_tj_s wap_diy_sj_tj_send"><i class="wap_diy_sj_tj_s_n">￥10</i>入职</span>
					</div> 
					</div> 
				</a>
				</div> 
				</div>

 				<div class="clear"></div>
                <div class="index_sj_job_list_box"  id="rewardjobcss1"  style="min-height:70px;<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobcss']==2) {?>display:none;<?php }?>" >
                  <div class="index_sj_job_list_box_pd">
                  
              
   
   
     
        
      
      <div class="index_rewardjobs_money rewardjobreward">
                            <span class="index_rewardjobs_money_n">￥200</span>
                            <div class="index_rewardjobs_list_fs"> <span class="index_rewardjobs_list_fs_name">投递:￥50</span><span class="index_rewardjobs_list_fs_name">面试:￥50</span><span class="index_rewardjobs_list_fs_name">入职:￥100</span></div><span class="index_rewardjobs_list_ls">领赏</span>
                        </div>
    
      
     
     <div class="index_rewardjobs_name">人事专员  </div>
     
     
  <div class="index_sj_comname rewardjobcom" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobcom']==2) {?> style="display:none" <?php }?>>苏州缘爱商务咨询</div> 
    
  <div class="index_rewardjobs_info rewardjobsalary"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobsalary']==2) {?> style="display:none" <?php }?>>  
    		￥2500-5000
        <span class="index_rewardjob_line">|</span>上海                 <span class="index_rewardjob_line">|</span>不限经验
                                <span class="index_rewardjob_line">|</span>大专学历
                                            </div>
                            
  
    	 <div class="index_rewardjobs_name_time rewardjobdate" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['rewardjobdate']==2) {?> style="display:none" <?php }?>> 一周内更新</div>
         
     
    
         
            
            
                   
                  
                  </div>
                </div> 
                
                </div></td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='hotjob') {?>
            <tr id="ptogglehotjob">
              <td>
              <div class="wap_mb_show_sj" id="hotjob"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotjob']==2) {?> style="display:none" <?php }?>>
              
                <div class="wap_tit heardercssnone heardercss1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5) {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit1"><span class="wap_tit1_bg"><i class="wap_tithot"></i>热门职位</span><span class="hotjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss2"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit2"><span class="wap_tit2_bg">热门职位</span><span class="hotjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss3"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit3"><span class="wap_tit3_bg"><i class="wap_tithot"></i>热门职位</span><span class="hotjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss4"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit4"><span class="wap_tit4_bg" ><i class="wap_tit4_icon_hot"></i><font color="#d81e06">热门职位</font></span><span class="hotjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
                <div class="wap_tit heardercssnone heardercss5"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit5"><span class="wap_tit5_bg">热门职位</span><span class="hotjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               
              
                <div class="index_wap_hotjob ">
                  <div class="clear"></div>
                  <ul class="index_hotlist">
                    <li> <a href=""><span><font color="#808080">经理</font></span></a></li>
                     <li> <a href=""><span><font color="#808080">会计</font></span></a></li>
                    <li> <a href=""><span><font color="#808080">客服</font></span></a></li>
                     <li> <a href=""><span><font color="#808080">程序员</font></span></a></li>
                      <li> <a href=""><span><font color="#808080">编辑</font></span></a></li>
                     <li> <a href=""><span><font color="#808080">技工</font></span></a></li>
                    <li> <a href=""><span><font color="#808080">销售</font></span></a></li>
                     <li> <a href=""><span><font color="#808080">JAVA</font></span></a></li>
                      <li> <a href=""><span><font color="#808080">美工</font></span></a></li>
                     <li> <a href=""><span><font color="#808080">理财</font></span></a></li>
                    <li> <a href=""><span><font color="#808080">司机</font></span></a></li>
                     <li> <a href=""><span><font color="#808080">施工员</font></span></a></li>
                      <li> <a href=""><span><font color="#808080">设计师</font></span></a></li>
                     <li> <a href=""><span><font color="#808080">CAD</font></span></a></li>
                    <li> <a href=""><span><font color="#808080">店长</font></span></a></li>
                     <li> <a href=""><span><font color="#808080">顾问</font></span></a></li>
                  </ul>
                  <div class="clear"></div>
                </div>
                  </div>
                </td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='newjob') {?>
            <tr id="ptogglenewjob">
              <td><div class="wap_mb_show_sj" id="newjob"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjob']==2) {?> style="display:none" <?php }?>>
               <div class="wap_tit heardercssnone heardercss1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5) {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit1"><span class="wap_tit1_bg"><i class="wap_titzw"></i>最新职位  </span><span class="newjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss2"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit2"><span class="wap_tit2_bg">最新职位  </span><span class="newjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss3"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit3"><span class="wap_tit3_bg"><i class="wap_titzw"></i>最新职位  </span><span class="newjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss4"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit4"><span class="wap_tit4_bg" ><i class="wap_tit4_icon_zw"></i><font color="#2383f0">最新职位</font>  </span><span class="newjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
                <div class="wap_tit heardercssnone heardercss5"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit5"><span class="wap_tit5_bg">最新职位  </span><span class="newjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>

                <div class="index_wap_joblist">
                  <h3> 收银员 </h3>
                  <div class="index_wap_joblist_comname"  > 
                  <span class="index_wap_joblist_comname_p" id="newjobcity" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobcity']==2) {?> style="display:none" <?php }?>> 山西吕梁</span> 
                  <span  class="index_wap_joblist_comname_p" id="newjobcom" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobcom']==2) {?> style="display:none" <?php }?>>广西聚宏房地产开发有限公司1</span> </div>
                  
                   <div class="index_wap_joblist_comcity"  id="newjobwelfare" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobwelfare']==2) {?> style="display:none" <?php }?>>
   					<span class="index_wap_joblist_fl">五险一金</span>
   					<span class="index_wap_joblist_fl">三险一金</span>
  					 <span class="index_wap_joblist_fl">包吃住</span>
   					</div>
                  <div class="index_wap_joblist_xz" id="newjobsalary" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobsalary']==2) {?> style="display:none" <?php }?>> 面议 </div>
                  <div class="index_wap_joblist_time" id="newjobdate" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['newjobdate']==2) {?> style="display:none" <?php }?>> 2017-05-10 </div>
                </div>
                 </div></td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='hotcom') {?>
            <tr id="ptogglehotcom">
              <td><div class="wap_mb_show_sj" id="hotcom"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcom']==2) {?> style="display:none" <?php }?>>
             <div class="wap_tit heardercssnone heardercss1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5) {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit1"><span class="wap_tit1_bg"><i class="wap_titmq"></i>名企展示  </span><span class="hotcommore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcommore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss2"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit2"><span class="wap_tit2_bg">名企展示</span><span class="hotcommore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcommore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss3"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit3"><span class="wap_tit3_bg"><i class="wap_titmq"></i>名企展示</span><span class="hotcommore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcommore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss4"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit4"><span class="wap_tit4_bg" ><i class="wap_tit4_icon_mq"></i><font color="#ff9c00">名企展示</font> </span><span class="hotcommore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcommore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
                <div class="wap_tit heardercssnone heardercss5"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit5"><span class="wap_tit5_bg">名企展示</span><span class="hotcommore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcommore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>

                <div class="indexcom_list_box">
                  <div class="indexcom_list_t_box">
                    <div class="indexcom_list_logo_box" id="hotcomlogo" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcomlogo']==2) {?> style="display:none" <?php }?>><img src="images/wap_diy_hotcom.png"></div>
                    <div class="indexcom_list_box_c">
                      <h3>陶然阁装饰有限公司 </h3>
                    </div>
                    <div class="indexcom_list_box_js"> <span class="indexcom_list_box_js_s indexcom_list_box_js_s_hy"  id="hotcomhy" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcomhy']==2) {?> style="display:none" <?php }?>><i class="indexcom_list_box_js_icon indexcom_list_box_js_icon_hy"></i>广告/市场/媒体/艺术</span> 
                    <span class="indexcom_list_box_js_s"  id="hotcomcity" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['hotcomcity']==2) {?> style="display:none" <?php }?>><i class="indexcom_list_box_js_icon indexcom_list_box_js_icon_map"></i>江苏-宿迁</span> </div>
                  </div>
                </div>
                </div></td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='recjob') {?>
            <tr id="ptogglerecjob">
              <td><div class="wap_mb_show_sj" id="recjob" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjob']==2) {?> style="display:none" <?php }?>>
             <div class="wap_tit heardercssnone heardercss1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5) {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit1"><span class="wap_tit1_bg"><i class="wap_tittj"></i>推荐职位 </span><span class="recjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss2"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit2"><span class="wap_tit2_bg">推荐职位</span><span class="recjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss3"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit3"><span class="wap_tit3_bg"><i class="wap_tittj"></i>推荐职位</span><span class="recjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss4"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit4"><span class="wap_tit4_bg" ><i class="wap_tit4_icon_tj"></i><font color="#42a30d">推荐职位</font></span><span class="recjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
                <div class="wap_tit heardercssnone heardercss5"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit5"><span class="wap_tit5_bg">推荐职位</span><span class="recjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>

              <div class="index_wap_joblist">
                  <h3> 收银员 </h3>
                  <div class="index_wap_joblist_comname"  > 
                  <span class="index_wap_joblist_comname_p" id="recjobcity" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobcity']==2) {?> style="display:none" <?php }?>> 山西吕梁</span>  
                  <span  class="index_wap_joblist_comname_p" id="recjobcom" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobcom']==2) {?> style="display:none" <?php }?>>广西聚宏房地产开发有限公司1</span> </div>
                  
                  <div class="index_wap_joblist_comcity"  id="recjobwelfare" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobwelfare']==2) {?> style="display:none" <?php }?>>
   					<span class="index_wap_joblist_fl">五险一金</span>
   					<span class="index_wap_joblist_fl">三险一金</span>
  					 <span class="index_wap_joblist_fl">包吃住</span>
   					</div>
                  <div class="index_wap_joblist_xz" id="recjobsalary" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobsalary']==2) {?> style="display:none" <?php }?>> 面议 </div>
                  <div class="index_wap_joblist_time" id="recjobdate" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['recjobdate']==2) {?> style="display:none" <?php }?>> 2017-05-10 </div>
                </div>
                 </div></td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='urgentjob') {?>
            <tr id="ptoggleurgentjob">
              <td><div class="wap_mb_show_sj" id="urgentjob" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjob']==2) {?> style="display:none" <?php }?>>
         		<div class="wap_tit heardercssnone heardercss1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5) {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit1"><span class="wap_tit1_bg"><i class="wap_titjp"></i>紧急职位</span><span class="urgentjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss2"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit2"><span class="wap_tit2_bg">紧急职位</span><span class="urgentjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss3"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit3"><span class="wap_tit3_bg"><i class="wap_titjp"></i>紧急职位</span><span class="urgentjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss4"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit4"><span class="wap_tit4_bg" ><i class="wap_tit4_icon_jp"></i><font color="#e61717">紧急职位</font> </span><span class="urgentjobmore wap_titmore" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
                <div class="wap_tit heardercssnone heardercss5"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit5"><span class="wap_tit5_bg">紧急职位</span><span class="urgentjobmore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
                
                <div class="index_wap_joblist">
                  <h3> 收银员 </h3>
                  <div class="index_wap_joblist_comname"  > <span class="index_wap_joblist_comname_p" id="urgentjobcity" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobcity']==2) {?> style="display:none" <?php }?>> 山西吕梁</span>  
                  <span  class="index_wap_joblist_comname_p" id="urgentjobcom" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobcom']==2) {?> style="display:none" <?php }?>>广西聚宏房地产开发有限公司1</span> </div>
                  <div class="index_wap_joblist_comcity"  id="urgentjobwelfare" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobwelfare']==2) {?> style="display:none" <?php }?>>
   					<span class="index_wap_joblist_fl">五险一金</span>
   					<span class="index_wap_joblist_fl">三险一金</span>
  					 <span class="index_wap_joblist_fl">包吃住</span>
   					</div>
                  <div class="index_wap_joblist_xz" id="urgentjobsalary" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobsalary']==2) {?> style="display:none" <?php }?>> 面议 </div>
                  <div class="index_wap_joblist_time" id="urgentjobdate" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['urgentjobdate']==2) {?> style="display:none" <?php }?>> 2017-05-10 </div>
                </div>
                 </div>
                </td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='resume') {?>
            <tr id="ptoggleresume">
              <td>
              <div class="wap_mb_show_sj" id="resume" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resume']==2) {?> style="display:none" <?php }?>>
               <div class="wap_tit heardercssnone heardercss1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5) {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit1"><span class="wap_tit1_bg"><i class="wap_tituser"></i>最新简历</span><span class="resumemore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumemore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss2"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit2"><span class="wap_tit2_bg">最新简历</span><span class="resumemore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumemore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss3"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit3"><span class="wap_tit3_bg"><i class="wap_tituser"></i>最新简历</span><span class="resumemore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumemore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss4"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit4"><span class="wap_tit4_bg" ><i class="wap_tit4_icon_user"></i><font color="#0090ff">最新简历</font> </span><span class="resumemore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumemore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
                <div class="wap_tit heardercssnone heardercss5"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit5"><span class="wap_tit5_bg">最新简历</span><span class="resumemore wap_titmore"<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumemore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>

                <div class="user_list_cont">
                  <div class="user_list" id="resumepic1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumepic']==2) {?> style="display:none" <?php }?>>
                 
                    <h3><span class="c288">陈小云</span> <span class="resume_t_date"> 2017-09-19 </span> </h3>
                    <aside class="user_list_p"> 
                    
                    <span class="user_city_n" id="resumecity" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumecity']==2) {?> style="display:none" <?php }?>>天津-天津</span>
                     <i class="user_list_p_line"></i> 
                     <span class="user_list_jy_p" id="resumeexp" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumeexp']==2) {?> style="display:none" <?php }?>>3年以上经验</span> 
                     <i class="user_list_p_line"></i>
                     <span class="user_list_jy_p" id="resumeedu" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumeedu']==2) {?> style="display:none" <?php }?>>	 本科学历 </span> 
                     		 </aside>
                    <aside class="user_list_pyxjob" id="resumeexpect" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumeexpect']==2) {?> style="display:none" <?php }?>> <em class="user_p_ov"><span class="user_list_j">意向职位：</span><span class="user_list_yxjob">贸易</span></em> </aside>
                  </div>
                  

                <div class="user_img_box"  id="resumepic2" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['resumepic']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['resumepic']=='') {?> style="display:none" <?php }?>>
                 <div class="user_img_list"><div class="user_img"><img src="images/wap_diy_resume.png"></div><div class="user_imgname">胡晓辉</div></div>
                 <div class="user_img_list"><div class="user_img"><img src="images/wap_diy_resume.png"></div><div class="user_imgname">胡晓辉</div></div>
                 <div class="user_img_list"><div class="user_img"><img src="images/wap_diy_resume.png"></div><div class="user_imgname">胡晓辉</div></div>
                 <div class="user_img_list"><div class="user_img"><img src="images/wap_diy_resume.png"></div><div class="user_imgname">胡晓辉</div></div>
                 <div class="user_img_list"><div class="user_img"><img src="images/wap_diy_resume.png"></div><div class="user_imgname">胡晓辉</div></div>
                 <div class="user_img_list"><div class="user_img"><img src="images/wap_diy_resume.png"></div><div class="user_imgname">胡晓辉</div></div>
                 <div class="user_img_list"><div class="user_img"><img src="images/wap_diy_resume.png"></div><div class="user_imgname">胡晓辉</div></div>
                 <div class="user_img_list"><div class="user_img"><img src="images/wap_diy_resume.png"></div><div class="user_imgname">胡晓辉</div></div>
                </div>
                
                </div>
               
                 </div>
                 
                </td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='article') {?>
            <tr id="ptogglearticle">
              <td>
              <div class="wap_mb_show_sj" id="article" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['article']==2) {?> style="display:none" <?php }?>>
             <div class="wap_tit heardercssnone heardercss1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5) {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit1"><span class="wap_tit1_bg"><i class="wap_titnews"></i>职场资讯</span> <span class="articlemore wap_titmore" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articlemore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss2"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit2"><span class="wap_tit2_bg">职场资讯</span><span class="articlemore wap_titmore" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articlemore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss3"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit3"><span class="wap_tit3_bg"><i class="wap_titnews"></i>职场资讯</span><span class="articlemore wap_titmore" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articlemore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss4"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit4"><span class="wap_tit4_bg" ><i class="wap_tit4_icon_news"></i><font color="#d5870d">职场资讯</font></span><span class="articlemore wap_titmore" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articlemore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
                <div class="wap_tit heardercssnone heardercss5"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit5"><span class="wap_tit5_bg">职场资讯</span><span class="articlemore wap_titmore" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articlemore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>

               <ul class="news_in_imglist"  id="articlecss1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articlecss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['articlecss']==3) {?> style="display:none" <?php }?>>
               <li>
               <img src="images/wap_diy_article.png" width="120" height="80">
              <div class="news_in_imglist_p"> 小米的互联网手机神话几乎接近破灭乎接近破灭</div>
               </li>
                <li>
               <img src="images/wap_diy_article.png" width="120" height="80">
                 <div class="news_in_imglist_p"> 小米的互联网手机神话几乎接近破灭乎接近破灭</div>
               </li>
               <li>
               <img src="images/wap_diy_article.png" width="120" height="80">
              <div class="news_in_imglist_p"> 小米的互联网手机神话几乎接近破灭乎接近破灭</div>
               </li>
                <li>
               <img src="images/wap_diy_article.png" width="120" height="80">
                 <div class="news_in_imglist_p"> 小米的互联网手机神话几乎接近破灭乎接近破灭</div>
               </li>
               </ul>   
                 <ul class="news_in_plist" id="articlecss3" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articlecss']!=3) {?> style="display:none" <?php }?>>
                 <li><span class="news_in_plist_p">小米的互联网手机神话几乎接近破灭</span><span>2017-12-22</span></li>
                 <li><span class="news_in_plist_p">小米的互联网手机神话几乎接近破灭</span><span>2017-12-22</span></li>
                <li><span class="news_in_plist_p">小米的互联网手机神话几乎接近破灭</span><span>2017-12-22</span></li>
                 <li><span class="news_in_plist_p">小米的互联网手机神话几乎接近破灭</span><span>2017-12-22</span></li> 
                 <li><span class="news_in_plist_p">小米的互联网手机神话几乎接近破灭</span><span>2017-12-22</span></li>
                 <li><span class="news_in_plist_p">小米的互联网手机神话几乎接近破灭</span><span>2017-12-22</span></li> 
                 <li><span class="news_in_plist_p">小米的互联网手机神话几乎接近破灭</span><span>2017-12-22</span></li>
                 <li><span class="news_in_plist_p">小米的互联网手机神话几乎接近破灭</span><span>2017-12-22</span></li> 
                 <li><span class="news_in_plist_p">小米的互联网手机神话几乎接近破灭</span><span>2017-12-22</span></li>
                 <li><span class="news_in_plist_p">小米的互联网手机神话几乎接近破灭</span><span>2017-12-22</span></li>
                 </ul>
                <div class="news_in_list"  id="articlecss2" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['articlecss']!=2) {?> style="display:none" <?php }?>>
  				 <div class="news_in_list_box">
   					<div class="news_in_list_box_left">
   					 <h2>小米的互联网手机神话几乎接近破灭乎接近破灭</h2>
    					<div class="news_in_list_w65">
   						<div class="news_in_list_p"> 我因脾气不好和主管吵了一架，经理让我回家休息一段时间，说要我上班时会给我打电话。我离开了半个月</div>
   						<div class="news_in_list_date">
   						<span class="news_in_eye_n"><i class="news_in_eye"></i>112</span>
   						<span class="news_in_eye_n"><i class="news_in_date"></i>2016-07-16</span></div>
   						</div>
        				<div class="news_in_cont_img"><img src="images/wap_diy_article.png" width="120" height="80"></div>   </div>
        				</div>
        				 <div class="news_in_list_box">
   					<div class="news_in_list_box_left">
   					 <h2>小米的互联网手机神话几乎接近破灭乎接近破灭</h2>
    					<div class="news_in_list_w65">
   						<div class="news_in_list_p"> 我因脾气不好和主管吵了一架，经理让我回家休息一段时间，说要我上班时会给我打电话。我离开了半个月</div>
   						<div class="news_in_list_date">
   						<span class="news_in_eye_n"><i class="news_in_eye"></i>112</span>
   						<span class="news_in_eye_n"><i class="news_in_date"></i>2016-07-16</span></div>
   						</div>
        				<div class="news_in_cont_img"><img src="images/wap_diy_article.png" width="120" height="80"></div>   </div>
        				</div>
        				 <div class="news_in_list_box">
   					<div class="news_in_list_box_left">
   					 <h2>小米的互联网手机神话几乎接近破灭乎接近破灭</h2>
    					<div class="news_in_list_w65">
   						<div class="news_in_list_p"> 我因脾气不好和主管吵了一架，经理让我回家休息一段时间，说要我上班时会给我打电话。我离开了半个月</div>
   						<div class="news_in_list_date">
   						<span class="news_in_eye_n"><i class="news_in_eye"></i>112</span>
   						<span class="news_in_eye_n"><i class="news_in_date"></i>2016-07-16</span></div>
   						</div>
        				<div class="news_in_cont_img"><img src="images/wap_diy_article.png" width="120" height="80"></div>   </div>
        				</div>
         			</div>
         			 </div>
                </td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='zph') {?>
            <tr id="ptogglerecjob">
              <td><div class="wap_mb_show_sj" id="zph" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['zph']==2) {?> style="display:none" <?php }?>>
             <div class="wap_tit heardercssnone heardercss1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5) {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit1"><span class="wap_tit1_bg"><i class="wap_titzph"></i>招聘会 </span><span class="zphmore wap_titmore" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['zphmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss2"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit2"><span class="wap_tit2_bg">招聘会</span><span class="zphmore wap_titmore" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['zphmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss3"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit3"><span class="wap_tit3_bg"><i class="wap_titzph"></i>招聘会</span><span class="zphmore wap_titmore" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['zphmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
               <div class="wap_tit heardercssnone heardercss4"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit4"><span class="wap_tit4_bg" ><i class="wap_tit4_icon_zph"></i><font color="#6bbb16">招聘会</font> </span><span class="zphmore wap_titmore" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['zphmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
                <div class="wap_tit heardercssnone heardercss5"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit5"><span class="wap_tit5_bg">招聘会</span><span class="zphmore wap_titmore" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['zphmore']==2) {?>style="display: none;"<?php }?>>更多>></span></div></div></div>
              
              <div class="index_wap_joblist">
                <div class="job_list_box job_fair_state_ov" style="padding:15px 10px;"> 
                 <div class="job_fair_state ">已开始</div>
                <div class="zphname">沭阳2017第一届招聘会</div>
         		<div class="zphtime"><i class="zphtime_icon"></i>2017-11-29 至 2017-12-31</div>
        		 <div class="zphadd"><i class="zphadd_icon"></i>蓝天市场</div>
        
         			</div>  
                 </div></div>
                 </td>
            </tr>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value=='jobclass') {?>
            <tr id="ptogglerecjob">
              <td><div class="wap_mb_show_sj jobclassone" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassone']==2) {?> style="display:none" <?php }?>>
             <div class="wap_tit heardercssnone heardercss1" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5) {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit1"><span class="wap_tit1_bg"><i class="wap_titlb"></i>职位类别 </span></div></div></div>
               <div class="wap_tit heardercssnone heardercss2"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit2"><span class="wap_tit2_bg">职位类别 </span></div></div></div>
               <div class="wap_tit heardercssnone heardercss3"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit3"><span class="wap_tit3_bg"><i class="wap_titlb"></i>职位类别 </span></div></div></div>
               <div class="wap_tit heardercssnone heardercss4"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==5||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit4"><span class="wap_tit4_bg" ><i class="wap_tit4_icon_lb"></i><font color="#2383f0">职位类别</font>  </span></div></div></div>
                <div class="wap_tit heardercssnone heardercss5"  <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==1||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==3||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==4||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']==2||$_smarty_tpl->tpl_vars['tplmoblie']->value['heardercss']=='') {?> style="display:none" <?php }?>><div class="bg<?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['color']) {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
} else {
echo $_smarty_tpl->tpl_vars['tplmoblie']->value['color'];
}?> heardercss"><div class="wap_tit5"><span class="wap_tit5_bg">职位类别 </span></div></div></div>
               
            
              <div class="wap_category_list jobclassone" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassone']==2) {?> style="display:none" <?php }?>> 
               <div class="wap_category_name" >销售/客服/技术支持</div>
         		<div class="wap_category_p jobclasstwo" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclasstwo']==2) {?> style="display:none" <?php }?>>
               <span class="wap_category_a"> 销售人员 </span>
               <span class="wap_category_a">销售管理</span> 
               <span class="wap_category_a">客服/售后 </span>
               <span class="wap_category_a">市场/营销</span> 
               <span class="wap_category_a">公关/媒介</span>
                </div> 
         		</div>
         		
                 <div class="wap_category_list jobclassone" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassone']==2) {?> style="display:none" <?php }?>> 
               <div class="wap_category_name" >人资/行政/财务/管理</div>
         		<div class="wap_category_p jobclasstwo" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclasstwo']==2) {?> style="display:none" <?php }?>>
                 <span class="wap_category_a"> 人力资源  </span>
                  <span class="wap_category_a"> 行政后勤 </span> 
                   <span class="wap_category_a"> 财务/审计/税务  </span>
                    <span class="wap_category_a"> 律师/法务  </span>
                     <span class="wap_category_a"> 高级管理 </span>
                </div> 
         		</div>
                 <div class="wap_category_list jobclassone" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclassone']==2) {?> style="display:none" <?php }?>> 
               <div class="wap_category_name" >生产/工人/质控</div>
         		<div class="wap_category_p jobclasstwo" <?php if ($_smarty_tpl->tpl_vars['tplmoblie']->value['jobclasstwo']==2) {?> style="display:none" <?php }?>>
                 <span class="wap_category_a">生产/营运  </span>
                 <span class="wap_category_a"> 普工/技工  </span>
                  <span class="wap_category_a"> 质控/安防  </span>
                </div> 
         		</div>
                </td>
            </tr>
            <?php }?>
            <?php } ?>
          </table>
        </div>
      </div>
    </div>
	<div class="diywap_CZ"><a href="javascript:void(0)" onclick="wapdiypreview()"  class="diywap_CZbth" style="display:inline-block;width:120px;">手机扫码预览</a>			<a href="javascript:void(0)" onclick="layer_del('确定要清空？','index.php?m=admin_tpl_moblies&c=clean')" class="diywap_CZbth"style="display:inline-block;width:90px; margin-left:10px; background:#f60">重置样式</a><div>
  </div>
</div>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/layui.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/phpyun_layer.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 src="js/diy.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
$(function(){
	//图片导航
	 <?php if ($_smarty_tpl->tpl_vars['nav']->value) {?>
     <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['nav']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
	$("#navname<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
").on('input propertychange',function(){
		var result = $(this).val();
		$("#pnavname<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
").html(result);
	});
	 <?php } ?>
     <?php }?>
     
     //登录注册按钮颜色
     document.getElementById('getlogincolor').onchange = function(){
		 $("#logincolor").val(this.value);
		 $("#plogin").css('background',this.value);
	};
	document.getElementById('getregcolor').onchange = function(){
		 $("#regcolor").val(this.value);
		 $("#preg").css('background',this.value);
	};
	
	layui.use(['layer', 'form'], function(){});
});
function addNav(){
	var randnum='n'+parseInt(Math.random()*1000); 
	$("#addnav").append(function(){
		var html="<li class='wap_mb_list_hd_list' id='"+randnum+"'>" +
				"<div class='wap_mb_list_hd_c'> <span class='wap_mb_list_hd_s'>图标：</span>" +
				"<input type='hidden' name='navid[]' value=''/>" +
				"<div class='layui-upload'>" +
				"<div class='wap_mb_list_hd_file_box'>" +
				"<input type='file' name='navpic[]'  id='nav"+randnum+"'  class='wap_mb_list_hd_file_text' onchange=\"showpic(this,'img"+randnum+"','pimg"+randnum+"')\" /> + 添加图标" +
				" </div>" +
				"</div>  " +
				"</div>" +
				"<div class='wap_mb_list_hd_c mt5'> <span class='wap_mb_list_hd_s'>标题：</span>" +
				"<input name='navname[]' id='navname"+randnum+"'   type='text' class='wap_mb_list_text'  autocomplete='off'>" +
				"</div>" +
				"<div class='wap_mb_list_hd_c mt5'> <span class='wap_mb_list_hd_s'>链接：</span>" +
				"<div class='layui-inline'><div class='layui-input-inline' ><select name='navurl[]'  lay-verify='' class='wap_mb_list_text'><option value='' >请选择</option><?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['navigation']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value) {
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?><option value='<?php echo $_smarty_tpl->tpl_vars['vv']->value['id'];?>
'><?php echo $_smarty_tpl->tpl_vars['vv']->value['name'];?>
</option><?php } ?></select></div></div>" +
				
				"</div>" +
				"<div class='wap_mb_list_hd_c mt5'> <span class='wap_mb_list_hd_s'>排序：</span>" +
				"<input name='navsort[]' id='navsort"+randnum+"'   type='text' class='wap_mb_list_text'  autocomplete='off'>" +
				"</div>" +
				"<div class='wap_mb_list_hd_tbimg layui-upload-list'> " +
				"<img src='images/wap_show_img1.png' width='40' height='40' class='layui-upload-img' id='img"+randnum+"'>" +
				"</div>" +
				"<div class='wap_mb_list_tip'> 建议图标尺寸：不小于64*64像素</div>" +
				"<input type='button' value='删除'class='wap_mb_list_hd_sc'  onclick=\"deleteupbox('"+randnum+"','nav')\" >" +
				"</li>";
				
        return html;
       
    });
	 
	$("#paddnav").append(function(){
		var html="<li id='pr"+randnum+"'><img src='images/wap_show_img1.png' width='50' height='50' id='pimg"+randnum+"'>" +
				"<div class='wap_mb_show_nav_list_p' id='pnavname"+randnum+"'>[标题]</div>" +
				"</li>";
		
        return html;
    });
	$("#navname"+randnum).on('input propertychange',function(){
		var result = $(this).val();
		$("#pnavname"+randnum).html(result);
	});
	layui.use(['layer', 'form'], function(){
	    var layer = layui.layer
	    ,form = layui.form
	    ,$ = layui.$;
	    form.render('select');
	});
	
}

<?php echo '</script'; ?>
>
</body>
</html>
<?php }} ?>
