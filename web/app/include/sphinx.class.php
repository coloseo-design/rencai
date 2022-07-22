<?php

//require 'sphinxapi.php';
class sphinx{  
  /** 
    * @var SphinxClient  
  **/  
  protected $client;  
  
  /** 
    * @var string 
  **/  
  protected $keywords;

  //同义词搜索
  private $tyWordSearch;

  //判断sphinx的查询服务searchd进程是否运行中（未运行则强制不使用sphinx查询，仍然用原来的mysql查询）
  public static function isRun($host = 'localhost', $port = 9312)
  {
    $c = new SphinxClient();
    $c->setServer($host, $port);

    $c->SetConnectTimeout(0.01);
    if($c->Status() === false){
      return false;
    }
    return true;
  }

  /** 
    * Constructor 
  **/  
  public function __construct($options = array())
  {
    $defaults = array(
      'query_mode' => SPH_MATCH_EXTENDED2,
      // 'query_mode' => SPH_MATCH_ALL,
      'ranking_mode' => SPH_RANK_PROXIMITY_BM25,//keyword匹配相关度根据：文本相似度 + 关键词出现次数
      'sort_mode' => SPH_SORT_EXTENDED,  //排序模式：混合排序模式，需要结合排序子句
        
      'field_weights' => array(),  
      'snippet_enabled' => false
    );
    $this->options = array_merge($defaults, $options);
    $this->client = new SphinxClient();

    global $config;

    $host = $config['sphinxhost'] ? $config['sphinxhost'] : 'localhost';
    $host = isset($config['host']) ? $options['host'] : $host;
    $port = $config['sphinxport'] ? $config['sphinxport'] : 9312;
    $port = isset($options['port']) ? $options['port'] : $port;

    $this->client->setServer( $host, $port);

    //sy_indexpage : 前台页面列表最大展示数
    $this->options['max_matches'] = $config['sy_indexpage'] ? $config['sy_indexpage'] : 0;
    
    $this->client->setMatchMode($this->options['query_mode']);
    $this->client->setRankingMode($this->options['ranking_mode']);
    $this->client->setSortMode(SPH_SORT_EXTENDED, '@weight desc, @id desc');
    if ($this->options['field_weights'] !== array()) {
      $this->client->setFieldWeights($this->options['field_weights']);
    }

    $this->tyWordSearch = new ChineseTyWordSearch(APP_PATH . 'data/sphinx/dic_ty.txt', 60);
  }

  private function _getQueryString($where)
  {
    //setFilter
    //setFilterString
    //setFilterRange
    //setSelect
    //keywords
    //queryStr

    foreach($where as $v){
      if(is_array($v) && count($v) > 1){
        $k = $v[0];
        if($k == 'setFilter' || $k == 'setFilterString'){
          $exclude = isset($v[3]) ? $v[3] : false;
          $this->client->$k($v[1], $v[2], $exclude);
        }
        else if($k == 'setFilterRange'){
          $exclude = isset($v[4]) ? $v[4] : false;
          $this->client->setFilterRange($v[1], $v[2], $v[3], $exclude);
        }
        else if($k == 'setSelect'){
          $this->client->setSelect($v[1]);
        }
      }
    }

    $keywords = '';
    if(array_key_exists('keywords', $where)){
      $keywords = $this->wordSplit($where['keywords']);
      // var_dump($keywords);
    }

    $queryStr = '';
    if(array_key_exists('queryStr', $where)){
      $queryStr = implode(' & ', $where['queryStr'] );
    }

    if($keywords == '' && $queryStr == ''){
      return '';
    }
    else if($keywords == ''){
      return $queryStr;
    }
    else if($queryStr == ''){
      return $keywords;
    }
    else{
      return "($keywords) & " . $queryStr;
    }
  }

  private function _executeQuery($where, $offset = 0, $limit = 10, $index = '*', $type = 'getCount')
  {
    //分站
    global $SiteTable,$config;
    if(is_numeric($config['did']) && $config['did'] > 0 && in_array($index, $SiteTable) ){
      $where [] = array('setFilter', 'did', array($config['did']) );
    }
    $this->client->ResetFilters();//查询之前，清空setFilter等查询条件
    $queryStr = $this->_getQueryString($where);

    
    if($this->options['max_matches'] == 0){
      $this->options['max_matches'] = $config["{$index}_count"] + $config['sphinx_day_add_num'];
    }
    $max_matches = $limit > $this->options['max_matches'] ? $limit : $this->options['max_matches'];
    $this->client->setLimits($offset, $limit, $max_matches);

    //查询主索引 + 增量索引
    $index = "{$index},{$index}_add";
    $query_results = $this->client->query($queryStr, $index);  
    
    if ($query_results === false) {  
      $this->log('sphinx error:' . $this->client->getLastError());  
    }
    if($type == 'getCount'){//只查询满足条件的数据总数
      return empty($query_results['matches']) ? 0 : $query_results['total'];
    }
    else if($type == 'getFields'){//查询满足条件的数据的指定字段
      return empty($query_results['matches']) ? array() : $query_results['matches'];
    }
    else{//get id array 查询满足条件的数据的id
      return empty($query_results['matches']) ? array() : array_keys($query_results['matches']);
    }
  }

  public function getCount($where, $offset = 0, $limit = 10, $index = '*')
  {
    return $this->_executeQuery($where, $offset, $limit , $index , 'getCount');
  }

  public function getIds($where, $offset = 0, $limit = 10, $index = '*')
  {
    return $this->_executeQuery($where, $offset, $limit , $index , 'getIds');
  }

  public function getFields($where, $offset = 0, $limit = 10, $index = '*')
  {
    return $this->_executeQuery($where, $offset, $limit , $index , 'getFields');
  }

  /** 
  * Chinese words segmentation 
  * 
  **/  
  public function wordSplit($keywords) {
    global $config;

    $fpath = ini_get('scws.default.fpath');  
    $so = scws_new();  
    $so->set_charset('utf-8');  
    $so->add_dict($fpath . '/dict.utf8.xdb');  
    $so->add_dict($fpath .'/custom_dict.txt', SCWS_XDICT_TXT);  

    $so->set_rule($fpath . '/rules.utf8.ini');  
    $so->set_ignore(true);//设置分词结果是否忽略标点符号。

    /**
      说明：设定分词返回结果时是否复合分割，如“中国人”返回“中国＋人＋中国人”三个词。
      返回：无。
      参数：mode 设定值，1 ~ 15。
        按位异或的 1 | 2 | 4 | 8 分别表示: 短词 | 二元 | 主要单字 | 所有单字
    */
    // $so->set_multi(1);
    $so->set_multi(1);

    /**
      说明：设定是否将闲散文字自动以二字分词法聚合。
      返回：无。
      参数：yes 设定值，如果为 true 则结果中多个单字会自动按二分法聚分，如果为 false 则不处理，缺省为 false。
    */
    $so->set_duality(false);  

    $so->send_text($keywords);  

    
    //说明：根据 send_text 设定的文本内容，返回系统计算出来的最关键词汇列表。
    //返回：成功返回切好的词汇组成的数组， 若无更多词汇，返回 false。
    $tops = $so->get_tops(5);
    
    $words = array();
    $words[] = $keywords;
    foreach ($tops as $res) {
      if($keywords != $res['word']){
        $words[] = $res['word'];
      }
    }
    foreach($words as &$w){
      $w = '(' . $w . ')';
    }
    return join('|', $words);
  }

  // //判断字符串是否全部中文
  // private function _isAllChineseWord($str)
  // {
  //   return preg_match("/^[\x7f-\xff]+$/", $str);
  // }

  // private function _getChineseWord($str)
  // {
  //   preg_match_all("/[\x7f-\xff]+/", $str, $matches);
  //   if(isset($matches[0]) && count($matches[0]) > 1){
  //     return $matches[0];
  //   }
  //   return array();
  // }

  /** 
    * log error 
  **/  
  private function log($msg) {  
    // log errors here  
    trigger_error($msg);
  }

  /** 
    * magic methods 
  **/  
  public function __call($method, $args)
  {
    $rc = new ReflectionClass('SphinxClient');  
    if ( !$rc->hasMethod($method) ) {  
      throw new Exception('invalid method :' . $method);  
    }  
    return call_user_func_array(array($this->client, $method), $args);  
  }
}

/**
 * 中文同义词查询
 * 设计思路：
 * 把文件重新格式化为二进制文件，进行二分查找
 * 调取方法：
 *     $m = new FileSearch("test.log", 200);
       $resultArr = $m->search('司机'); //在文件中搜索
 * 说明：第一次使用会很慢，因为要生成缓存文件
 */
class ChineseTyWordSearch
{
    private $filename;   //源文件名
    private $maxLength;  //源文件中单行的最大长度(按字节算)
    private $sorted;     //源文件是否已经排好序
    private $formatFile; //重新格式化存储的文件名
    private $fd;
    
    /**
     * 初始化
     * @param  string $filename  需要检索的文件
     * @param  int $maxLength    单行的最大长度
     * @param  int $sorted       源文件是否已经排好序
     * @param  int $forceReForm  是否强制重新生成索引文件
     * @return [type]            [description]
     */
    public function __construct($filename, $maxLength, $sorted = 1, $forceReForm = 0)
    {
        $this->filename = $filename;
        $this->maxLength = $maxLength;
        $this->sorted = $sorted;
        $this->formatFile = rtrim(dirname($this->filename), '/') . '/' . md5($this->filename);
        if ($forceReForm || !file_exists($this->formatFile)) {
            $this->formatFile();
        }
    }

    //源文件排序
    public function sort($path, $outPath = '')
    {
      $file = fopen($path, "r");
      $content = array();
      $i=0;
      //输出文本中所有的行，直到文件结束为止。
      while(! feof($file))
      {
       $content[$i]= trim(fgets($file));//fgets()函数从文件指针中读取一行
       $i++;
      }
      fclose($file);

      $content = array_unique($content);


      usort($content,$this->mb_sort($prev, $next));

      $content = implode(PHP_EOL, $content);
      $outPath = $outPath == '' ? $path : $outPath;
      file_put_contents($outPath, $content);
    }
	function mb_sort($prev, $next){
        $p = explode('=', $prev);
        $n = explode('=', $next);
        if($p[0] == $n[0]) return 0;
        return $p[0] > $n[0] ? 1 : -1;//升序排序
      }
    /**
     * 格式化源文本文件为二进制文件
     */
    public function formatFile()
    {
        if ($this->sorted == 0) {
            //对源文件排序
        }
        //读源文件，写入到新的索引文件
        $readfd = fopen($this->filename, 'rb');
        $writefd = fopen($this->formatFile.'_tmp', 'wb+');
        if ($readfd === false || $writefd === false) {
            return false;
        }
        $i = 0;
        while (!feof($readfd)) {
            $line = fgets($readfd, 8192);
            fseek($writefd, $i * $this->maxLength);      
            fwrite($writefd, pack("a".$this->maxLength, $line));
            $i ++;
        }
        // echo "\n reformat ok\n";
        fclose($readfd);
        fclose($writefd);
        rename($this->formatFile.'_tmp', $this->formatFile);
    }
    /**
     * 在索引文件中进行二分查找
     * @param  int $id    进行二分查找的id
     * @return [type]     [description]
     */
    public function search($key)
    {
        $filesize = filesize($this->formatFile);
        $fd = fopen($this->formatFile, "rb");
        $left = 0; //行号
        $right = $total = ($filesize / $this->maxLength) - 1; //行号
        while ($left <= $right) {
            $middle = intval(($right + $left)/2);
            fseek($fd, ($middle) * $this->maxLength);
            $info = unpack("a*", fread($fd, $this->maxLength));
            $info = explode('=', current($info));

            if ($info[0] > $key) {
                $right = $middle - 1;
            } elseif ($info[0] < $key) {
                $left = $middle + 1;
            } else {
                $retval = $this->getResult($fd, $middle, $key, $info, $total);
                fclose($fd);
                return $retval;
            }
        }
        fclose($fd);
        return false;
    }

    private function getResult($fd, $index, $key, $info, $total)
    {
      $retval = array();
      $retval[] = trim($info[1]);

      $i = -1; $j = 1;

      while($index + $i >= 0){
        fseek($fd, ($index + $i) * $this->maxLength);
        $info = unpack("a*", fread($fd, $this->maxLength));
        $info = explode('=', current($info));
        if($info[0] == $key){
          $retval[] = trim($info[1]);
        }
        else{
          break;
        }
        $i --;
      }

      while($index + $j < $total){
        fseek($fd, ($index + $j) * $this->maxLength);
        $info = unpack("a*", fread($fd, $this->maxLength));
        $info = explode('=', current($info));
        if($info[0] == $key){
          $retval[] = $info[1];
        }
        else{
          break;
        }
        $j ++;
      }
      return $retval;
    }
}