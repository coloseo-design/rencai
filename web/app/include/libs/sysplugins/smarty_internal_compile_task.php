<?php
class Smarty_Internal_Compile_Task extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'ispage', 'limit', 'keyword','islt','sort');
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
        //自定义标签START
        $OutputStr=''.$name.'=array();global $db,$db_config,$config;$paramer='.ArrayToString($_attr,true).';
		//处理传入参数，并且构造分页参数
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		$where = "`status`=\'1\' and `r_status`=1 and `pay` <> 1";
		//关键字
		if($paramer[keyword]){
			$where.=" AND `name` LIKE \'%".$paramer[keyword]."%\'";
		}
		//排序字段默认为更新时间
		if($paramer[order]){
			$order = " ORDER BY `".str_replace("\'","",$paramer[order])."`";
		}else{
			$order = " ORDER BY ctime ";
		}
		//排序规则 默认为倒序
		if($paramer[sort]){
			$sort = $paramer[sort];
		}else{
			$sort = " DESC";
		}
		//查询条数
		if($paramer[limit]){
			$limit=" LIMIT ".$paramer[limit];
		}else{
			$limit=" LIMIT 20";
		}
		//自定义查询条件，默认取代上面任何参数直接使用该语句
		if($paramer[where]){
			$where = $paramer[where];
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"gq_task",$where,$Purl,\'\',\'0\',$_smarty_tpl);
		}
		$where.=$order.$sort.$limit;
		'.$name.'=$db->select_all("gq_task",$where);
		if(is_array('.$name.')){
			foreach('.$name.' as $val){
				$uids[]=$val[uid];
			}
			$gqlist=$db->select_all("gq_info","`uid` in (".implode(\',\',$uids).")");
			foreach('.$name.' as $key=>$value){
				'.$name.'[$key][\'ctime\'] = date("Y-m-d",$value[\'ctime\']);
				'.$name.'[$key][\'content\'] = strip_tags($value[\'content\']);
				foreach($gqlist as $val){
					if($val[uid]==$value[uid] && $val[photo_status]==0){
						'.$name.'[$key][\'photo_n\']= checkpic($val[\'photo\'],$config[gq_photo]);
					}
				}
			}
			if($paramer[keyword]!=""&&!empty('.$name.')){
				addkeywords(\'1\',$paramer[keyword]);
			}
		}';
        //自定义标签 END
        //global $DiyTagOutputStr;
       // $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'task',$name,$OutputStr,$name);
    }
}
class Smarty_Internal_Compile_Taskelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('task'));
        $this->openTag($compiler, 'taskelse', array('taskelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Taskclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('task', 'taskelse'));

        return "<?php } ?>";
    }
}
