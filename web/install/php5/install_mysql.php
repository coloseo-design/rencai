<?php
/*
 * $Author ：维特网络技术支持
 *
 * 官网: http://www.weitenet.com
 *
 * 技术电话：18668215192 技术微信：18668215192
 *
 * 【主营业务】网站建设、源码模板、服务器空间租售、网站维护、网站托管、网站优化、百度推广、自媒体营销、微信公众号分销商城、如有意向-联系我们。
 */
class db_tool {
	var $querynum = 0;
	var $link;
	var $histories;
	var $time;
	var $tablepre;
	function connect($dbhost, $dbuser, $dbpw, $dbname = '', $dbcharset, $pconnect = 0, $tablepre='', $time = 0) {
		$this->time = $time;
		$this->tablepre = $tablepre;
		if($pconnect) {
			if(!$this->link = mysql_pconnect($dbhost, $dbuser, $dbpw)) {
				$this->halt('无法连接数据库!');
			}
		} else {
			if(!$this->link = mysql_connect($dbhost, $dbuser, $dbpw, 1)) {
				$this->halt('无法连接数据库!');
			}
		}
		if($this->version() > '4.1') {
			if($dbcharset) {
				mysql_query("SET character_set_connection=".$dbcharset.", character_set_results=".$dbcharset.", character_set_client=binary", $this->link);
			}

			if($this->version() > '5.0.1') {
				mysql_query("SET sql_mode=''", $this->link);
			}
		}
		if($dbname) {
			mysql_select_db($dbname, $this->link);
		}
	}
	function cache_gc() {
		$this->query("DELETE FROM {$this->tablepre}sqlcaches WHERE expiry<$this->time");
	}
	function query($sql, $type = '', $cachetime = FALSE) {
		$func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ? 'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql, $this->link)) && $type != 'SILENT') {
			$this->halt('SQL:', $sql);
		}
		$this->querynum++;
		$this->histories[] = $sql;
		return $query;
	}
	function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());
	}
	function errno() {
		return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());
	}
	function result($query, $row) {
		$query = @mysql_result($query, $row);
		return $query;
	}
	function version() {
		return mysql_get_server_info($this->link);
	}
	function close() {
		return mysql_close($this->link);
	}
	function halt($message = '', $sql = '') {
		show_msg('run_sql_error', $message.$sql.'<br /> Error:'.$this->error().'<br />Errno:'.$this->errno(), 0);
	}
}
?>