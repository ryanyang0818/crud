<?php
//{0}:系統按鈕  {1}:自定義按鈕  {2}:進階選項的字串  {3}:auto下拉選單  {4}:set下拉選單  {5}:自定義區域
$tpl = '
<div id="crud_console" class="panel panel-default">
  <div class="panel-heading">
    {0}
    
    {1}
    
    {2}
  </div>
  <div id="tool_condition" class="panel-collapse collapse '.$this->settings['advanced_inout'].'">
  <div class="panel-body">
    <form method="POST" enctype="multipart/form-data" action="'.$this->settings['function_settings']['search_commit']['href'].'">
  {3}
  
  {4}
  
  {5}
    <input type="submit" class="btn btn-default" value="確定">
    </form>
  </div>
  </div>
</div>
' ;

$container_0 ;
$container_1 ;
$container_2 ;
$container_3 ;
$container_4 ;
$container_5 ;

if ($this->settings['block_switch']['system_buttons'] === 'N')
{
    
}
else
{
    if ( is_array($this->settings['system_buttons']) && count($this->settings['system_buttons']) > 0 ) 
    {
        $container_0 = '' ;
        foreach($this->settings['system_buttons'] as $idx => $arr)
        {
            $container_0 .= '
<a href="'.$arr['href'].'" class="'.$arr['title_class'].'" title="'.$arr['title'].'">
    <span class="'.$arr['icon_class'].'"></span> '.$arr['title'].'
</a>' ;
        }
        
    }
}

    if ( is_array($this->settings['buttons']) && count($this->settings['buttons']) > 0 ) 
    {
        $container_1 = '' ;
        foreach($this->settings['buttons'] as $idx => $arr)
        {
            $container_1 .= '
<a href="'.$arr['href'].'" class="'.$arr['title_class'].'" title="'.$arr['title'].'">
    <span class="'.$arr['icon_class'].'"></span> '.$arr['title'].'
</a>' ;
        }
        
    }
    
    if ( is_array($this->settings['auto_cate']) && count($this->settings['auto_cate']) > 0 ) 
    {
        $container_3 = '' ;
        foreach ($this->settings['auto_cate'] as $idx => $arr)
        {
            if ( ! is_array($arr['options'])) continue ;
            $options = '' ;
            foreach ($arr['options'] as $option => $value)
            {
                if ($value === $_SESSION[ $this->_session_key ]['search']['auto_cate_'.$idx])
                {
                    $options .= '
                    <option value="'.$value.'" selected>'.$value.'</option>' ;
                }
                else
                {
                    $options .= '
                    <option value="'.$value.'">'.$value.'</option>' ;
                }
            }
            $container_3 .= $arr['text'].' : <select name="auto_cate_'.$idx.'"><option value=""></option>'.$options.'</select>　' ;
        }
    }
    
    $container_4 = '' ;
    if ( is_array($this->settings['set_cate']) && count($this->settings['set_cate']) > 0 ) 
    {
        foreach ($this->settings['set_cate'] as $idx => $arr)
        {
            $options = '' ;
            foreach ($arr['options'] as $option => $value)
            {
                if ($option === $_SESSION[ $this->_session_key ]['search']['set_cate_'.$idx])
                {
                    $options .= '
                    <option value="'.$option.'" selected>'.$option.'</option>' ;
                }
                else
                {
                    $options .= '
                    <option value="'.$option.'">'.$option.'</option>' ;
                }
            }
            $container_4 .= $arr['text'].' : <select name="set_cate_'.$idx.'"><option value=""></option>'.$options.'</select>　' ;
        }
    }
    
    if ( is_array($this->settings['set_condition']) && count($this->settings['set_condition']) > 0 ) 
    {
        foreach ($this->settings['set_condition'] as $idx => $arr)
        {
            $container_4 .= $arr['text'].' : <input type="text" name="set_condition_'.$idx.'" value="'.$_SESSION[ $this->_session_key ]['search']['set_condition_'.$idx].'">　' ;
        }
    }
    
    $container_5 = $this->settings['console_settings'] ;
    if ( ! $container_5 && ! $container_4 && ! $container_3)
    {
        $container_2 = '' ;
    }
    else
    {
        $container_2 = '
<a class="btn btn-warning" data-toggle="collapse" data-parent="#accordion" href="#tool_condition">
進階選項
</a>
         ' ;
    }
    
    echo _format($tpl, array($container_0, $container_1, $container_2, $container_3, $container_4, $container_5)) ;
    
?>