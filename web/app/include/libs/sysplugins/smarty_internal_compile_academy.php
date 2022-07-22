<?php
class Smarty_Internal_Compile_Academy extends Smarty_Internal_CompileBase{
	
    public $required_attributes = array('item');
	public $optional_attributes = array('name', 'key','comlen','urgent', 'ispage', 'namelen', 'post_len', 'limit','keyword', 'school_department', 'categty','level','schooltag','provinceid', 'cityid', 'three_cityid','schoolname','noids');
	public $shorttag_order = array('from', 'item', 'key', 'name');
	public function compile($args, $compiler, $parameter){
		$_attr = $this->getAttributes($compiler, $args);
        
		$from = $_attr['from'];
		$item = $_attr['item'];
		$name = $_attr['item'];
		$name=str_replace('\'','',$name);
		$name=$name?$name:'list';$name='$'.$name;
		if (!strncmp("\$_smarty_tpl->tpl_vars[$item]", $from, strlen($item) + 24)) {
			$compiler->trigger_template_error("item variable {$item} may not be the same variable as at 'from'", $compiler->lex->taglineno);
		}
		        //自定义标签 START
        $OutputStr='global $db,$db_config,$config;
		$time = time();
		
		
		//可以做缓存
        $paramer='.ArrayToString($_attr,true).';
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
        $Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
   
		$cache_array = $db->cacheget();
		$city_name= $cache_array["city_name"];
		$schoolclass_name= $cache_array["schoolclass_name"];
		$where=\'1\';
		if($config[\'sy_web_site\']=="1"){
			if($config[provinceid]>0 && $config[provinceid]!=""){
				$paramer[provinceid] = $config[provinceid];
			}
			if($config[\'cityid\']>0 && $config[\'cityid\']!=""){
				$paramer[\'cityid\']=$config[\'cityid\'];
			}
			if($config[\'three_cityid\']>0 && $config[\'three_cityid\']!=""){
				$paramer[\'three_cityid\']=$config[\'three_cityid\'];
			}

		}
        //关键字
        if($paramer[keyword]){
			$where.=" AND `schoolname` LIKE \'%".$paramer[\'keyword\']."%\'";
		}
		if($paramer[provinceid]){
			$where .= " AND provinceid = $paramer[provinceid]";
		}
		
		if($paramer[cityid]){
			$where .= " AND (`cityid` IN ($paramer[cityid]))";
		}
        if($paramer[three_cityid]){
			$where .= " AND (`three_cityid` IN ($paramer[three_cityid]))";
		}
		
		if($paramer[school_department]){
            $where .= " AND `school_department` = $paramer[school_department]";

		}
		if($paramer[level]){
            $where .= " AND `school_level` = $paramer[level]";
		}
        if($paramer[categty]){
            $where .= " AND `school_categty` = $paramer[categty]";
		}
        if($paramer[schoolinternet]){
            $where .= " AND `schoolinternet` = $paramer[schoolinternet]";
		}

		if($paramer[order]){
			$order = " ORDER BY `".$paramer[order]."`";
		}else{
			$order = " ORDER BY lastupdate ";
		}
		$sort = $paramer[sort]?$paramer[sort]:\'DESC\';
		if($paramer[limit]){
			$limit=" LIMIT ".$paramer[limit];
		}
		if($paramer[where]){
			$where = $paramer[where];
		}

        if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"school_academy",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"6",$_smarty_tpl);
          
		} 
		$where.=$order.$sort;
		'.$name.'=$db->select_all("school_academy",$where.$limit);	
		if('.$name.' && is_array('.$name.')){
			foreach('.$name.' as $k=>$v){
                '.$name.'[$k][\'id\']=$v[\'id\'];
                '.$name.'[$k][\'schoolname\']=$v[\'schoolname\'];
				'.$name.'[$k][\'provinceid\']=$city_name[$v[\'provinceid\']];
				'.$name.'[$k][\'cityid\']=$city_name[$v[\'cityid\']];
				'.$name.'[$k][\'three_cityid\']=$city_name[$v[\'three_cityid\']];
				'.$name.'[$k][\'school_department\']=$schoolclass_name[$v[\'school_department\']];
                '.$name.'[$k][\'school_level\']=$schoolclass_name[$v[\'school_level\']];
				'.$name.'[$k][\'school_categty\']=$schoolclass_name[$v[\'school_categty\']];
				'.$name.'[$k][\'schooltag\']=$schoolclass_name[$v[\'schooltag\']];
				'.$name.'[$k][\'address\']=$v[\'address\'];
				'.$name.'[$k][\'schoolemail\']=$v[\'schoolemail\'];
				'.$name.'[$k][\'schoolinternet\']=$v[\'schoolinternet\'];
				'.$name.'[$k][\'photo\']=$v[\'photo\'];
				'.$name.'[$k][\'diploma_url\']=Url("talent",array("c"=>"show","id"=>$v[\'id\']),"1");
				'.$name.'[$k][\'lastupdate\'] = date("Y-m-d",$v[\'lastupdate\']);
				'.$name.'[$k][\'downtime\'] = date("Y-m-d H:i",$v[\'downtime\']);
				}
			}
			foreach('.$name.' as $k=>$v){
               if($paramer[\'keyword\']){					
                    '.$name.'[$k][\'provinceid\']=str_replace($paramer[\'keyword\'],"<font color=#FF6600 >".$paramer[\'keyword\']."</font>",'.$name.'[$k][\'provinceid\']);
					'.$name.'[$k][\'cityid\']=str_replace($paramer[\'keyword\'],"<font color=#FF6600 >".$paramer[\'keyword\']."</font>",'.$name.'[$k][\'cityid\']);
					'.$name.'[$k][\'three_cityid\']=str_replace($paramer[\'keyword\'],"<font color=#FF6600 >".$paramer[\'keyword\']."</font>",'.$name.'[$k][\'three_cityid\']);
					'.$name.'[$k][\'school_department\']=str_replace($paramer[\'keyword\'],"<font color=#FF6600 >".$paramer[\'keyword\']."</font>",'.$name.'[$k][\'school_department\']);
                    '.$name.'[$k][\'school_level\']=str_replace($paramer[\'keyword\'],"<font color=#FF6600 >".$paramer[\'keyword\']."</font>",'.$name.'[$k][\'school_level\']);
					'.$name.'[$k][\'school_categty\']=str_replace($paramer[\'keyword\'],"<font color=#FF6600 >".$paramer[\'keyword\']."</font>",'.$name.'[$k][\'school_categty\']);
					'.$name.'[$k][\'schooltag\']=str_replace($paramer[\'keyword\'],"<font color=#FF6600 >".$paramer[\'keyword\']."</font>",'.$name.'[$k][\'schooltag\']);

                    
                    
                    '.$name.'[$k][\'address\']=str_replace($paramer[\'keyword\'],"<font color=#FF6600 >".$paramer[\'keyword\']."</font>",'.$name.'[$k][\'address\']);
					'.$name.'[$k][\'schoolemail\']=str_replace($paramer[\'keyword\'],"<font color=#FF6600 >".$paramer[\'keyword\']."</font>",'.$name.'[$k][\'schoolemail\']);
					'.$name.'[$k][\'schoolinternet\']=str_replace($paramer[\'keyword\'],"<font color=#FF6600 >".$paramer[\'keyword\']."</font>",'.$name.'[$k][\'schoolinternet\']);
					'.$name.'[$k][\'schoolname\']=str_replace($paramer[\'keyword\'],"<font color=#FF6600 >".$paramer[\'keyword\']."</font>",'.$name.'[$k][\'schoolname\']);

				}
            }';
	
		//global $DiyTagOutputStr;
		//$DiyTagOutputStr[]=$OutputStr;
		return SmartyOutputStr($this,$compiler,$_attr,'academy',$name,$OutputStr,$name);
	}
}
class Smarty_Internal_Compile_Academyelse extends Smarty_Internal_CompileBase{
	public function compile($args, $compiler, $parameter){
		$_attr = $this->getAttributes($compiler, $args);

		list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('academy'));
		$this->openTag($compiler, 'academyelse', array('academyelse', $nocache, $item, $key));

		return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
	}
}
class Smarty_Internal_Compile_Academyclose extends Smarty_Internal_CompileBase{
	public function compile($args, $compiler, $parameter){
		$_attr = $this->getAttributes($compiler, $args);
		if ($compiler->nocache) {
			$compiler->tag_nocache = true;
		}

		list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('academy','academyelse'));

		return "<?php } ?>";
	}
}
