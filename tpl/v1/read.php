<style type="text/css">

</style>
<script>
$(function()
{

}) ;
</script>
<?php
$out = '
  <div class="modal-dialog" style="width:100%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <span><h4>瀏覽</h4></span>
      </div>
      
      <div class="modal-body" style="max-height: 100%; height:100%;">
      <!-- 主體 -->
        <div id="crud_read" class="mode_zone">
          {0}
          <div id="crud_read_cont" class="mode_zone_cont">
            <table id="crud_read_cont_table" class="mode_zone_cont_table">
              <tbody>
              {1}
              </tbody>
              <tfoot>
                <tr>
                  <th></th>
                  <td>
                    <a class="btn btn-default '.$this->settings['crud_class']['update'].'" >進行修改</a>
                    <input type="hidden" name="pk" value="'.$this->settings['data'][ $this->settings['table_pk'] ].'">
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      
      </div>
    </div>
  </div>
' ;
    
/*

*/
    $tr_tpl = '
          <tr>
            <th {0}>{1}</th>
            <td {2}>
                {3}
            </td>
          </tr>
    ' ;
    
    $tr_container = '' ;
    foreach($this->settings['display_setting'] as $column => $setting)
    {
        //only for read 
        $this->settings['display_setting'][$column]['others'] .= ' disabled readonly' ;
        
        if (strstr($this->settings['display_setting'][$column]['hide'], 'read')) continue ;
        
        if (is_array($this->settings['display_setting'][$column]['th_prop']) && count($this->settings['display_setting'][$column]['th_prop']) > 0)
        {
            $thProp = '' ;
            foreach( $this->settings['display_setting'][$column]['th_prop'] as $prop => $value )
            {
                $thProp .= $prop.'="'.$value.'" ' ;
            }
        }
        
        $th_content = $this->settings['display_setting'][$column]['th_content'] ;
        
        if (is_array($this->settings['display_setting'][$column]['td_prop']) && count($this->settings['display_setting'][$column]['td_prop']) > 0)
        {
            $tdProp = '' ;
            foreach( $this->settings['display_setting'][$column]['td_prop'] as $prop => $value )
            {
                $tdProp .= $prop.'="'.$value.'" ' ;
            }
        }

        if (is_array($this->settings['display_setting'][$column]['unit_prop']) && count($this->settings['display_setting'][$column]['unit_prop']) > 0)
        {
            $unitProp = '' ;
            foreach( $this->settings['display_setting'][$column]['unit_prop'] as $prop => $value )
            {
                $unitProp .= $prop.'="'.$value.'" ' ;
            }
        }
                
        switch( ($this->settings['display_setting'][$column]['type'])? $this->settings['display_setting'][$column]['type'] : 'text' )
        {

            default :
            case 'text':
                $td_content  = $this->settings['display_setting'][$column]['pre_memo'] ;
                $td_content .= '<input type="text" name="'.$this->settings['prefix'].$column.'" '.$unitProp.' value="'.$this->settings['data'][$column].'" '.$this->settings['display_setting'][$column]['others'].'>' ;
                $td_content .= $this->settings['display_setting'][$column]['aft_memo'] ;
            break ;

            case 'select':
                
                $options = '<option value="">請選擇</option>' ;
                foreach($this->settings['display_setting'][$column]['select_options'] as $value => $show)
                {
                    if ($value == $this->settings['data'][$column])
                    {
                        $options .= '<option value="'.$value.'" selected>'.$show.'</option>' ;
                    }
                    else
                    {
                        $options .= '<option value="'.$value.'">'.$show.'</option>' ;
                    }
                }
                
                $td_content  = $this->settings['display_setting'][$column]['pre_memo'] ;
                $td_content .= '<select name="'.$this->settings['prefix'].$column.'" '.$unitProp.' '.$this->settings['display_setting'][$column]['others'].'>'.$options.'</select>' ;
                $td_content .= $this->settings['display_setting'][$column]['aft_memo'] ;
                
            break ;
            
            case 'textarea':
                $td_content  = $this->settings['display_setting'][$column]['pre_memo'] ;
                $td_content .= '<textarea name="'.$this->settings['prefix'].$column.'" '.$unitProp.' '.$this->settings['display_setting'][$column]['others'].'>'.$this->settings['data'][$column].'</textarea>' ;
                $td_content .= $this->settings['display_setting'][$column]['aft_memo'] ;
            break ;
            
            case 'file':

            break ;
        }

        
        $tr_container .= _format($tr_tpl, array(
              $thProp
            , $th_content
            , $tdProp
            , $td_content
        )) ;

    }
    
    $out = _format($out, array(
          '' //'<div id="crud_read_title" class="mode_zone_title">瀏覽</div>'
        , $tr_container
    )) ;


return $out ;
?>

