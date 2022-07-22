<?php
class Smarty_Internal_Compile_Xjh extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'limit', 'order','t_len', 'hyclass', 'jobone', 'jobtwo','adtime', 'provinceid', 'cityid', 'three_cityid', 'keyword', 'uid', 'order', 'jobtwo', 'rec','hyid','jobid','ispage','tp','comlen','level','sid','islt');
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
        $OutputStr='global $db,$db_config,$config;$paramer='.ArrayToString($_attr,true).';'.$name.'=array();
		//处理传入参数，并且构造分页参数
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		$where = "`status`=1";
		//是否属于分站下
		if($config[sy_web_site]=="1"){
			if($config[province]>0 && $config[province]!=""){
				$paramer[provinceid] = $config[province];
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$paramer[cityid]=$config[cityid];
			}
		}
		//关键字
		if($paramer["keyword"]){
			$com=$db->select_all("company","`name` like \'%".$paramer["keyword"]."%\'","uid");
			foreach($com as $v){
				$cuids[]=$v[uid];
			}
			$where.=" AND `uid` in (".@implode(",",$cuids).")";
		}
		//城市
		if($paramer["provinceid"]){
			$where.=" AND `provinceid`=\'".$paramer["provinceid"]."\'";
		}
		if($paramer["cityid"]){
			$where.=" AND `cityid`=\'".$paramer["cityid"]."\'";
		}
		if($paramer["three_cityid"]){
			$where.=" AND `three_cityid`=\'".$paramer["three_cityid"]."\'";
		}
		//所属行业：
		if($paramer["level"]){
			$sch=$db->select_all("school_academy","`school_level`=\'".$paramer["level"]."\'","id");
			foreach($sch as $v){
				$sids[]=$v[id];
			}
			$where.=" AND `schoolid` in (".@implode(",",$sids).")";
		}
		//用户uid
		if($paramer["uid"]){
			$where.=" AND `uid`=\'".$paramer["uid"]."\'";
		}
		//院校uid
		if($paramer["sid"]){
			$where.=" AND `schoolid`=\'".$paramer["sid"]."\'";
		}
		//近期，往期
		if($paramer["tp"]){
			$where.=" AND `etime`<\'".time()."\'";
		}else{
			$where.=" AND `etime`>\'".time()."\'";
		}
		if($paramer[adtime]){
			if($paramer[adtime]==1){
				$beginToday=mktime(0,0,0,date(\'m\'),date(\'d\'),date(\'Y\'));
    			if($paramer["tp"]){
					$where.=" AND stime>$beginToday";
				}else{
					$where.=" AND stime<$beginToday";
				}
    		}else{
    			$time=time();
				if($paramer["tp"]){
					$adtime = $time-($paramer[adtime]*86400);
					$where.=" AND stime>$adtime";
				}else{
					$adtime = $time+($paramer[adtime]*86400);
					$where.=" AND stime<$adtime";
				}
    		}
		}
		if($paramer["limit"]){
			$limit= " limit $paramer[limit]";
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"school_xjh",$where,$Purl,"",$paramer[islt]?$paramer[islt]:"0",$_smarty_tpl);
         
		}
		//排序字段（默认按照uid排序）
		if($paramer[order]){
			$where .= " ORDER BY $paramer[order]";
		}else{
			$where .= " ORDER BY  `ctime`  ";
		}
		//排序规则（默认按照开始时间排序倒序）
		if($paramer["sort"]){
			$where .= " $paramer[sort]";
		}else{
			$where .= " DESC ";
		}
		'.$name.'=$db->select_all("school_xjh",$where.$limit);
		if(is_array('.$name.')){
			$cache_array = $db->cacheget();
			foreach('.$name.' as $v){
                $xjhid[]=$v[\'id\'];
				$comuid[]=$v[\'uid\'];
				$suid[]=$v[\'schoolid\'];
    		}
            $atnlist=$db->select_all("atn","`xjhid` IN (".pylode(\',\',$xjhid).") and `uid`=\'".$_COOKIE[\'uid\']."\'");
			$comlist=$db->select_all("company","`uid` IN (".pylode(\',\',$comuid).")","`uid`,`name`,`logo`");
			$academy=$db->select_all("school_academy","`id` IN (".pylode(\',\',$suid).")","`id`,`schoolname`");
			$week=array("周日","周一","周二","周三","周四","周五","周六");
			foreach('.$name.' as $k=>$v){
				'.$name.'[$k]["city_two"] = $cache_array[\'city_name\'][$v["cityid"]];
				'.$name.'[$k]["xjh_url"] = Url("school",array("c"=>"xjhshow","id"=>$v[\'id\']));
				'.$name.'[$k]["com_url"] = Url("company",array("c"=>"show","id"=>$v[\'uid\']));
				'.$name.'[$k]["sch_url"] = Url("school",array("c"=>"academyshow","id"=>$v[\'schoolid\']));
				'.$name.'[$k]["ctime"] = date("Y-m-d",$v["ctime"]);
				'.$name.'[$k]["xjh_date"] = date("Y-m-d",$v["stime"]);
				'.$name.'[$k]["xjh_shour"] = date("H:i",$v["stime"]);
				'.$name.'[$k]["xjh_ehour"] = date("H:i",$v["etime"]);
				'.$name.'[$k]["xjh_week"] = $week[date("w",$v["stime"])];
				foreach($comlist as $val){
					if($v[\'uid\']==$val[\'uid\']&&$val[\'name\']){
						if($paramer[comlen]){
							'.$name.'[$k]["com_name"]=mb_substr($val[\'name\'],0,$paramer[comlen],"utf-8");
						}else{
							'.$name.'[$k]["com_name"]=$val[\'name\'];
						}
						'.$name.'[$k][\'pic\'] =	checkpic($val[\'logo\'],$config[\'sy_unit_icon\']);
    				}
				}
				foreach($academy as $val){
					if($v[\'schoolid\']==$val[\'id\']&&$val[\'schoolname\']){
    					'.$name.'[$k]["sch_name"]=$val[\'schoolname\'];
    				}
				}
                foreach($atnlist as $val){
					if($v[\'id\']==$val[\'xjhid\']){
    					'.$name.'[$k]["atnid"]=$val[\'id\'];
    				}
				}
			}
		}';
        //自定义标签 END
       // global $DiyTagOutputStr;
      //  $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'xjh',$name,$OutputStr,$name);
    }
}
class Smarty_Internal_Compile_Xjhelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('xjh'));
        $this->openTag($compiler, 'xjhelse', array('xjhelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Xjhclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('xjh', 'xjhelse'));

        return "<?php } ?>";
    }
}
