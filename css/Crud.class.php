<?
class Crud
{
    private static $_UniqueInstance = null ;  //獨生子物件
    public $_dir = null ;  //當前目錄
    private $_dbh = null ;  //db
    private $_default = null ;  //預設值
    private $_req = null ;  //$_REQUEST
    public $_session_key = null ;  //$_REQUEST

    public static function getInstance($args=array())
    {
        if (self::$_UniqueInstance == null)
        {
            self::$_UniqueInstance = new self($args) ;
        }
        return self::$_UniqueInstance ;
    }
    
    public function __construct($args='') 
    {
        session_start() ;
        
        $this->_dir = dirname(dirname(__file__)) ;
        $caller_info = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) ;
        $this->_session_key = $caller_info[0]['file'] ;

        include_once $this->_dir."/class/MySQL.class.php" ;
        include_once $this->_dir."/class/DBH.class.php" ;
        include_once $this->_dir."/class/Validate.class.php" ;
        include_once $this->_dir."/helpers/common.helper.php" ;
 
        $this->_req = $_REQUEST ;
        
        if (isset($args['ini']) && $args['ini']) 
        {
            $this->_loadINI($args['ini']) ;
        }
        else if(is_array($args['settings']) && count($args['settings'])>0 )
        {
            $this->settings = $args['settings'] ;
        }

        $this->_loadINI($this->_dir.'/conf/Crud.ini.php', 'default') ;
        $this->_mergeSettings() ;
        
        //You can set db info in crud.ini.php once for all.
        $this->_dbh = DBH::getInstance(array('db'=>$this->settings['db'], 'user'=>$this->settings['user'], 'pass'=>$this->settings['pass'])) ;
        
        $this->_prepare_tableinfo() ;
        
        if ($this->settings['showrequest'] !== 'N') echo sprintf('<pre>%s</pre>', var_export($_REQUEST, true)) ;
    }
    
    //載入設定檔
    private function _loadINI($ini, $prop='settings')
    {
        if (is_file($ini))
        {
           $ini_arr = include_once $ini ;  //load php
        }
        //else echo $ini ;
        
        $this->{$prop} = $ini_arr ;
    }
    
    //配合預設值
    private function _mergeSettings()
    {
        //如果沒設定到的特性，用預設的特性來補上
        foreach ($this->default as $key => $value)
        {
            if ( ! isset($this->settings[$key]))
            {
                $this->settings[$key] = $value ;
            }
        }
    }
    
    public function listOrgi()
    {
        unset($_SESSION[ $this->_session_key ]['search']) ;
        
        $this->listAll() ;
    }
    
    //顯示畫面
    public function listAll($opt='')
    {
        //直接給資料
        if (isset($opt['data']) && is_array($opt['data']) && count($opt['data']) > 0)
        {
            //自定義
            $this->settings['data'] = $opt['data'] ;
        }
        else
        {
            $this->settings['data'] = $this->_prepare_listAll_data($opt) ;
        }
        
        $this->_prepare_auto_cate() ;
        $this->_prepare_list_th_content() ;
        
        $out = '' ;
        $out .= $this->view($this->settings['tpl_head'], true, $this) ;
        
        if ($this->settings['block_switch']['title'] !=='N')
        {
            $out .= $this->view($this->settings['tpl_title'], true, $this) ;
        }
        
        if ($this->settings['block_switch']['console'] !== 'N')
        {
            $out .= $this->view($this->settings['tpl_console'], true, $this) ;
        }
        $out .= $this->view($this->settings['tpl_table'], true, $this) ;
        echo $out ;
    }
    
    //顯示新增畫面
    public function create()
    {
        $this->_prepare_tableinfo() ;
        $this->_prepare_display_th_content() ;
        
        $out = '' ;
        
        $out .= $this->view($this->settings['tpl_create'], true, $this) ;
        echo $out ;
    }
    
    //顯示瀏覽畫面
    public function read()
    {
        $this->_prepare_tableinfo() ;
        $this->_prepare_display_th_content() ;
        
        $columns = $this->_prepare_columns() ;
        
        $sql = "select {$columns} from {$this->settings['table']} where {$this->settings['table_pk']} = '{$this->_req['pk']}'" ;
        
        $rs = $this->_dbh->ExecuteSQL($sql) ;
        
        $this->settings['data'] = $rs[0] ;

        $out = '' ;

        $out .= $this->view($this->settings['tpl_read'], true, $this) ;
        echo $out ;
    }
    
    //顯示修改畫面
    public function update()
    {
        $this->_prepare_tableinfo() ;
        $this->_prepare_display_th_content() ;
        
        $columns = $this->_prepare_columns() ;
        
        $sql = "select {$columns} from {$this->settings['table']} where {$this->settings['table_pk']} = '{$this->_req['pk']}'" ;
        
        $rs = $this->_dbh->ExecuteSQL($sql) ;
        
        $this->settings['data'] = $rs[0] ;
        
        $out = '' ;

        $out .= $this->view($this->settings['tpl_update'], true, $this) ;
        echo $out ;
    }
    
    //顯示刪除畫面
    public function delete()
    {
        $this->_prepare_tableinfo() ;
        //$this->_prepare_display_th_content() ;
        
        $columns = $this->_prepare_columns() ;
        
        $sql = "select {$columns} from {$this->settings['table']} where {$this->settings['table_pk']} = '{$this->_req['pk']}'" ;
        
        $rs = $this->_dbh->ExecuteSQL($sql) ;
        
        $this->settings['data'] = $rs[0] ;

        $out = '' ;

        $out .= $this->view($this->settings['tpl_delete'], true, $this) ;
        echo $out ;
    }
    
    //執行新增動作
    public function create_commit()
    {
        if ( is_array($this->_req) && count($this->_req) > 0 )
        {
            $prefixlen = strlen($this->settings['prefix']) ;
        
            foreach($this->_req as $key => $value)
            {
                $column = '' ;
                
                if (substr($key, 0, $prefixlen) == $this->settings['prefix'] )
                {
                    $column = substr($key, $prefixlen) ;
                    
                    $this->_prepare_validate($column, $value) ;
                    
                    $mcreate .= " ".$column." = '".$value."',";
                }
            }
        }
        $mcreate = substr($mcreate,0,-1);

        $sql = " INSERT INTO {$this->settings['table']} SET {$mcreate} " ;
        if ($this->_dbh->ExecuteSQL($sql))
        {
            _alert('新增成功') ;
            _href($this->settings['function_settings']['listAll']['href']) ;
        }
    }
    
    //執行更新
    public function update_commit()
    {
        
        if ( is_array($this->_req) && count($this->_req) > 0 )
        {
            $prefixlen = strlen($this->settings['prefix']) ;
        
            foreach($this->_req as $key => $value)
            {
                $column = '' ;
                
                if (substr($key, 0, $prefixlen) == $this->settings['prefix'] )
                {
                    $column = substr($key, $prefixlen) ;
                    
                    $this->_prepare_validate($column, $value) ;
                    
                    $mupd .= " ".$column." = '".$value."',";
                }
            }
        }
        $mupd = substr($mupd,0,-1);
        
        $sql = " UPDATE {$this->settings['table']} SET {$mupd} WHERE {$this->settings['table_pk']} = '{$this->_req['pk']}' " ;
        if ($this->_dbh->ExecuteSQL($sql))
        {
            _href($this->settings['function_settings']['listAll']['href']) ;
        }
    }
    
    //執行刪除
    public function delete_commit()
    {
        $sql = "DELETE FROM {$this->settings['table']} where {$this->settings['table_pk']} = '{$this->_req['pk']}'" ;
        
        if ($this->_dbh->ExecuteSQL($sql))
        {
            _href($this->settings['function_settings']['listAll']['href']) ;
        }
    }
    
    //執行搜尋
    public function search_commit()
    {
        $this->settings['advanced_inout'] = 'in' ;

        $this->listAll() ;
    }
    
    //設定自動分類的選項
    private function _prepare_auto_cate()
    {
        if (is_array($this->settings['auto_cate']) && count($this->settings['auto_cate']) > 0)
        {
            foreach ($this->settings['auto_cate'] as $idx => $arr)
            {
                $rs = $this->_dbh->Select("distinct(".$arr['column'].")", $this->settings['table']) ;
                if (count($rs) > 0)
                {
                    foreach($rs as $idx2 => $arr2)
                    {
                        $this->settings['auto_cate'][$idx]['options'][] = $arr2[$arr['column']] ;
                    }
                }
            }
            
        }
    }
    
    //設定th
    private function _prepare_list_th_content()
    {
        $row = @reset($this->settings['data']) ;
        $tmpArr = array() ;
        
        if (!is_array($row) || count($row) < 1) return ;
        
        $this->settings['listAll_setting'] = ( $this->settings['listAll_setting'] )? $this->settings['listAll_setting'] : array() ;
        
        foreach($row as $column => $value)
        {
            if ( ! isset($this->settings['listAll_setting'][$column]['th_content']) )
            {
                $this->settings['listAll_setting'][$column]['th_content'] = ($this->settings['tableinfo'][$column]['Comment'])? $this->settings['tableinfo'][$column]['Comment'] : $column ;
            }
        }
    }
    
    //console部分的sql
    public function _prepare_console_sql()
    {
        if (is_array($this->_req) && count($this->_req) > 0)
        {
            foreach($this->_req as $k => $v)
            {
                if (isset($this->_req[$k]) && $v)
                {
                    $_SESSION[ $this->_session_key ]['search'][$k] = $v ;
                }
                
                if (isset($this->_req[$k]) && !$v)
                {
                    $_SESSION[ $this->_session_key ]['search'][$k] = null ;
                }
            }
        }
        
        $mwhere = '' ;
        
        if (is_array($this->settings['auto_cate']) && count($this->settings['auto_cate'])>0)
        {
            foreach($this->settings['auto_cate'] as $idx => $set)
            {
                if (isset($_SESSION[ $this->_session_key ]['search']['auto_cate_'.$idx]) && $_SESSION[ $this->_session_key ]['search']['auto_cate_'.$idx])
                {
                    $mwhere .= " and {$set['column']} =  '{$_SESSION[ $this->_session_key ]['search']['auto_cate_'.$idx]}' " ;
                }
            }
        }
        
        if (is_array($this->settings['set_cate']) && count($this->settings['set_cate'])>0)
        {
            foreach($this->settings['set_cate'] as $idx => $set)
            {
                if (isset($_SESSION[ $this->_session_key ]['search']['set_cate_'.$idx]) && $_SESSION[ $this->_session_key ]['search']['set_cate_'.$idx])
                {
                    $sign = '=' ;
                    
                    if (strstr($this->settings['set_cate'][$idx]['options'][$_SESSION[ $this->_session_key ]['search']['set_cate_'.$idx]], '%')) $sign = 'like' ;
                    
                    $mwhere .= " and {$set['column']} {$sign} '{$this->settings['set_cate'][$idx]['options'][$_SESSION[ $this->_session_key ]['search']['set_cate_'.$idx]]}' " ;
                }
            }
        }
        
        if (is_array($this->settings['set_condition']) && count($this->settings['set_condition'])>0)
        {
            foreach($this->settings['set_condition'] as $idx => $set)
            {
                if (isset($_SESSION[ $this->_session_key ]['search']['set_condition_'.$idx]) && $_SESSION[ $this->_session_key ]['search']['set_condition_'.$idx])
                {
                    $sign = '=' ;
                    
                    if (strstr($_SESSION[ $this->_session_key ]['search']['set_condition_'.$idx], '%')) $sign = 'like' ;
                    
                    $mwhere .= " and {$set['column']} {$sign} '{$_SESSION[ $this->_session_key ]['search']['set_condition_'.$idx]}' " ;
                }
            }
        }
        
        return $mwhere ;
    }
    //準備sql
    private function _prepare_listAll_sql($opt)
    {

        
        $mwhere = $this->_prepare_console_sql() ;

        
        //if ($mwhere !== '') $this->settings['advanced_inout'] = 'in' ;
        
        $sql = '' ;
        if (isset($this->settings['sql']) && $this->settings['sql'])
        {
            $sql = " select {$this->settings['sql']['columns']} from {$this->settings['sql']['table']} where 1=1 {$this->settings['sql']['where']} {$mwhere} {$this->settings['sql']['others']}" ;
        }
        //沒SQL，依賴table name撈全部
        else
        {
            $columns = $this->_prepare_columns() ;
            $sql = " select {$columns} from ".$this->settings['table'].' where 1=1 '.$mwhere ;
            
        }

        return $sql ;
    }
    
    //準備listAll的資料
    private function _prepare_listAll_data($opt)
    {
        $rtn_data = array() ;
        
        if (isset($opt['sql']) && $opt['sql'])
        {
            $sql =  $opt['sql'] ;
        }
        else
        {
            $sql = $this->_prepare_listAll_sql($opt) ;
        }
        
        $rtn_data = $this->_dbh->ExecuteSQL($sql) ;

        if ($this->settings['showsql'] !== 'N') echo $sql ;
        if ($this->settings['showsession'] !== 'N') echo sprintf('<pre>%s</pre>', var_export($_SESSION, true)) ;
        return $rtn_data ;
    }
    
    //撈取資料表資訊
    private function _prepare_tableinfo()
    {
        $sql = " show full columns from ".$this->settings['table'] ;
        $rs = $this->_dbh->ExecuteSQL($sql) ;
        if (is_array($rs) && count($rs)>0)
        {
            foreach($rs as $arr) 
            {
                $this->settings['tableinfo'][$arr['Field']] = $arr ;
            }
        }
    }
    
    //準備新增/修改/刪除的模式的th
    private function _prepare_display_th_content()
    {
        if ( ! is_array($this->settings['display_setting']) )
        {
            foreach($this->settings['tableinfo'] as $column => $info)
            {
                $this->settings['display_setting'][$column] = array() ;
                if ( ! $this->settings['display_setting'][$column]['th_content'] )
                {
                    $this->settings['display_setting'][$column]['th_content'] = ($info['Comment'])? $info['Comment'] : $info['Field'] ;
                }
            }
        }
        else
        {
            foreach($this->settings['display_setting'] as $column => $setting)
            {
                if ( ! $this->settings['display_setting'][$column]['th_content'] )
                {
                    $this->settings['display_setting'][$column]['th_content'] = ($this->settings['tableinfo'][$column]['Comment'])? $this->settings['tableinfo'][$column]['Comment'] : $this->settings['tableinfo'][$column]['Field'] ;
                }
            }
        }
    }
    
    //準備要撈的欄位
    private function _prepare_columns()
    {
        //如果沒給資料，會去撈設定的欄位。
        $columns = ' * ' ;
        if (is_array($this->settings['listAll_setting']) && count($this->settings['listAll_setting']) >0)
        {
            // 如果listAll沒有設定PK，就強制加入(畫面需要PK)，但是顯示要關閉。
            if ( ! array_key_exists($this->settings['table_pk'], $this->settings['listAll_setting']))
            {
               $this->settings['listAll_setting']  = array($this->settings['table_pk']=>array()) + $this->settings['listAll_setting'] ;
               $this->settings['table_pk_show'] = 'N' ;  //N 就是不顯示
            }
            $columns = '' ;
            foreach( $this->settings['listAll_setting'] as $column => $arr )
            {
                $columns .= $column.',' ;
            }
            $columns = substr($columns, 0, -1) ;
        }
        
        return $columns ;
    }
    
    //檢驗規則
    private function _prepare_validate($column, $value)
    {
        if (is_array( $this->settings['display_setting'][$column]['unit_valid'] ))
        {
            foreach( $this->settings['display_setting'][$column]['unit_valid'] as $k => $v )
            {
                if ( isset($this->settings['display_setting'][$column]['unit_valid'][$k]) )
                {
                    if ('required' !== $k && $value === '') continue ;
                    
                    $args = explode(',', $v) ;
                    
                    if ( ! call_user_func('Validate'.'::v_'.$k, $value, $args[0], $args[1]) )
                    {
                       _alert('欄位檢查失敗') ;
                       _href($this->settings['function_settings']['listAll']['href']) ;
                       exit() ;
                    }
                }
            }
        }
    }
    
    //吐版
    public function view($file, $flag=false)
    {
        if (!is_file($file)) return false ;

        ob_start() ;
        
        include $file ;
        
        while (ob_get_level() > 0) {
            $out .= ob_get_clean() ;
        }
        
        if ($flag) return $out ;
        echo $out ;
    }
    
    //利用request 自動判斷要執行的function
    public function reqHandler()
    {
        $whiteList = array('listAll','listOrgi', 'create', 'create_commit', 'read','update', 'update_commit', 'delete', 'delete_commit', 'search_commit') ;
        
        $msel = str_replace('crud_', '', $this->_req['msel']) ;
        
        if ( ! $msel) $msel = 'listAll' ;
        
        if (! in_array($msel, $whiteList) ) return false ;
        
        if (method_exists($this, $msel))
        {
            $this->{$msel}() ;
        }
        
    }
    
    
    
    
    
    
    
    
    
}