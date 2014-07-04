<style type="text/css">

</style>
<script>
$(function()
{

}) ;
</script>
<?php
$out = '
  <div class="modal-dialog" style="width:25%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <span><h4>刪除</h4></span>
      </div>
      
      <div class="modal-body" style="max-height: 100%; height:100%;">
      <!-- 主體 -->
        <div id="crud_delete" class="mode_zone">
          <form method="POST" enctype="multipart/form-data" action="'.$this->settings['function_settings']['delete_commit']['href'].'">

          <div id="crud_delete_cont" class="mode_zone_cont">
            <input class="btn btn-danger" type="submit" value="確定刪除">
            <button type="button" class="btn btn-default btn_crud_modal_hide">取消</button>
            <input type="hidden" name="pk" value="'.$this->settings['data'][ $this->settings['table_pk'] ].'">
          </div>
          </form>
        </div>
      
      </div>
    </div>
  </div>
' ;
    
    $out = _format($out, array(
          '刪除'
    )) ;

return $out ;
?>

