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
        <span><h4>修改</h4></span>
      </div>
      
      <div class="modal-body" style="max-height: 100%; height:100%;">
      <!-- 主體 -->
        <div id="crud_update" class="mode_zone">
          <form method="POST" enctype="multipart/form-data" action="'.$this->settings['function_settings']['update_commit']['href'].'">
          {0}
          <div id="crud_update_cont" class="mode_zone_cont">
            <table id="crud_update_cont_table" class="mode_zone_cont_table">
              <tbody>
              {1}
              </tbody>
              <tfoot>
                <tr>
                  <th></th>
                  <td>
                    <input type="submit" class="btn btn-primary" value="確定修改">
                    <button type="button" class="btn btn-default btn_crud_modal_hide">取消</button>
                    <input type="hidden" name="pk" value="'.$this->settings['data'][ $this->settings['table_pk'] ].'">
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
          </form>
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
        if (strstr($this->settings['display_setting'][$column]['hide'], 'update')) continue ;
        
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
        
        if (is_array($this->settings['display_setting'][$column]['unit_valid']) && count($this->settings['display_setting'][$column]['unit_valid']) > 0)
        {
            $unitValidArr = array() ;
            $unitValid = '' ;
            foreach( $this->settings['display_setting'][$column]['unit_valid'] as $prop => $value )
            {
                if (isset($value))
                {
                    $unitValidArr[] = array('type'=>$prop, 'args'=>$value) ;
                }
                $unitValid = json_encode($unitValidArr) ;
            }
        }
        
        switch( ($this->settings['display_setting'][$column]['type'])? $this->settings['display_setting'][$column]['type'] : 'text' )
        {

            default :
            case 'text':
                $td_content  = $this->settings['display_setting'][$column]['pre_memo'] ;
                $td_content .= '<input type="text" name="'.$this->settings['prefix'].$column.'" '.$unitProp.' data-valid=\''.$unitValid.'\' value="'.$this->settings['data'][$column].'" '.$this->settings['display_setting'][$column]['others'].'>' ;
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
          '' //'<div id="crud_update_title" class="mode_zone_title">修改</div>'
        , $tr_container
    )) ;



return $out ;
?>

