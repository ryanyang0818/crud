<style>
.mode_zone
{
    border: 0px solid red ;
}

.mode_zone_title
{
    border: 0px solid orage ;
  font-size:120%;
  font-weight:bold;
  text-align:center;
}

.mode_zone_cont
{
    border: 0px solid yellow ;
    
}

.mode_zone_cont_table
{
    border: 1px solid gray ;
    width: 95% ;
    margin:0 auto ;
}

.mode_zone_cont_table th
{
    border: 1px solid gray ;
    width: 20% ;
    background: #D9EDF7 ;
    padding:5px 15px;
}

.mode_zone_cont_table td
{
    border: 1px solid gray ;
    padding:3px;
}

/* 讓表格更緊湊 */
#crud_data_table td {
    padding-top: 0px !important;
    padding-bottom: 0px !important;
}
/* 列印模式 */
@media print 
{
    #crud_title, #crud_console, #crud_data_table_length, #crud_data_table_filter, .tbody_fn, #crud_data_table_info, #crud_data_table_paginate
    {
        display: none ;
    }
}

</style>
<script>
$(function()
{
    $(document)
        .on('click', '.<?=$this->settings['crud_class']['print']?>', function()
        {
            window.print() ;
        })
        
        .on('click', '.<?=$this->settings['crud_class']['create']?>', function()
        {
            $('#crud_modal').load('<?=$this->settings['function_settings']['create']['href']?>', function()
            {
                $('#crud_modal').modal('show') ;
            }) ;
            
        })

        .on('click', '.<?=$this->settings['crud_class']['read']?>', function()
        {
            var pk = $(this).parents('td').find("input[name='pk']").val() ;
            $('#crud_modal').load('<?=$this->settings['function_settings']['read']['href']?>' + '&pk='+pk, function()
            {
                $('#crud_modal').modal('show') ;
            }) ;
        })
        
        .on('click', '.<?=$this->settings['crud_class']['update']?>', function()
        {
            var pk = $(this).parents('td').find("input[name='pk']").val() ;
            $('#crud_modal').load('<?=$this->settings['function_settings']['update']['href']?>' + '&pk='+pk, function()
            {
                $('#crud_modal').modal('show') ;
            }) ;
        })
        
        .on('click', '.<?=$this->settings['crud_class']['delete']?>', function()
        {
            var pk = $(this).parents('td').find("input[name='pk']").val() ;
            $('#crud_modal').load('<?=$this->settings['function_settings']['delete']['href']?>' + '&pk='+pk, function()
            {
                $('#crud_modal').modal('show') ;
            }) ;
        })
        
        .on('click', '#tbody_checkbox_leader', function()
        {
            $('.tbody_checkbox_crew').prop("checked", $(this).prop("checked"));
        })

        .on('click', '#crud_modal .btn_crud_modal_hide', function()
        {
            $('#crud_modal').modal('hide') ;
        })
        
        .on('click', '#crud_modal :submit', function(e)
        {
            var flag = true ;

            $("[name^='<?=$this->settings['prefix']?>']")
                .each(function()
                {
                    var _this = $(this) ;
                    var _val = '' ;

                    if (_this[0]['tagName'] === 'INPUT')
                    {
                        _val = _this.val() ;
                    }
                    else if (_this[0]['tagName'] === 'SELECT')
                    {
                        _val = _this.find(':selected').val() ;
                    }
                    else if (_this[0]['tagName'] === 'TEXTAREA')
                    {
                        _val = _this.text() ;
                    }
                    
                    if (_this.attr('data-valid'))
                    {
                        var validArr = JSON.parse(_this.attr('data-valid')) ;
                        $.each(validArr, function(idx, item)
                        {
                            //如果不是檢查 required，欄位空白不進行檢查。
                            if ('required' !== item.type && _val === '') return true ;
                            var tmp_args = String(item.args).split() ;
                            if (tmp_args.length == 0)
                            {
                                if( ! $.common.valid[item.type](_val) ) flag = false ;
                            }
                            else if(tmp_args.length == 1)
                            {
                                if( ! $.common.valid[item.type](_val, tmp_args[0]) ) flag = false ;
                            }
                            else if(tmp_args.length == 2)
                            {
                                if( ! $.common.valid[item.type](_val, tmp_args[0], tmp_args[1]) ) flag = false ;
                            }
                            
                            if ( ! flag ) 
                            {
                                _this.focus() ;
                                
                                alert($.common.valid_false_msg[item.type]) ;
                            }
                        }) ;
                    }
                    
                    if ( ! flag ) 
                    {
                        return false ;
                    }
                    
                }) ;
                
            if ( flag ) 
            {
                return true ;
            }
            else
            {
                e.preventDefault() ;
            }
        })
        
        .on('dblclick', '#crud_data_table tbody tr', function(e)
        {
            var pk = $(this).attr('data-pk') ;
            $('#crud_modal').load('<?=$this->settings['function_settings'][$this->settings['dblclick_on_tr']]['href']?>' + '&pk='+pk, function()
            {
                $('#crud_modal').modal('show') ;
            }) ;
        })
        ;
        
    //立即函式
    (function()
    {
            if ('<?=$this->settings['table_pk_show']?>' === 'N')
            {
                $("[data-column='<?=$this->settings['table_pk']?>']").hide() ;
            }
            
            var oLanguage =  
            {
                "sProcessing":"處理中...",
                "sLengthMenu":"顯示 _MENU_ 項結果",
                "sZeroRecords":"沒有匹配結果",
                "sInfo":"顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                "sInfoEmpty":"顯示第 0 至 0 項結果，共 0 項",
                "sInfoFiltered":"(從 _MAX_ 項結果過濾)",
                "sSearch":"搜索:",
                "oPaginate":
                {
                "sFirst":"首頁",
                "sPrevious":"上頁",
                "sNext":"下頁",
                "sLast":"尾頁"
                }
            }
        
            $('#crud_data_table').dataTable(
            {
                "searching": <?=$this->settings['datatable_searching']?>
              , "paging":   <?=$this->settings['datatable_paging']?>
              , "ordering": <?=$this->settings['datatable_ordering']?>
              , "info":     <?=$this->settings['datatable_info']?>
              , "stateSave": true
              , "oLanguage": oLanguage
              , "aLengthMenu": 
                [
                    <?=$this->settings['datatable_lengthMenu']?>
                ]
              , "iDisplayLength" : <?=$this->settings['datatable_displayLength']?>
              
              , "order": []
              , "aoColumns": [
<?php
//設定不能排序的部分
if ( ! ($this->settings['block_switch']['tbody_checkbox'] === 'N') ) 
{
    echo '{ "orderSequence": [ "" ] },' ;
}


if ( is_array($this->settings['listAll_setting']) && count($this->settings['listAll_setting']) > 0 ) 
{
    foreach ($this->settings['listAll_setting'] as $column => $arr)
    {
        echo 'null,' ;
    }
}

if ( ! ($this->settings['block_switch']['tbody_fn'] === 'N') ) 
{
    echo '{ "orderSequence": [ "" ] },' ;
}
?>
                ]
            });
    }()) ;
    
        
}) ;
</script>
<?php
$tpl = '
<div id="crud_data" class="table-responsive" style="padding:5px;{0}width:{1};">
<table id="crud_data_table" class="table table-bordered table-striped table-hover table-condensed" style="border: 1px solid gray ;" >
    <thead>
    <tr class="info">
{2}
    </tr>
    </thead>

    <tbody>
{3}
    </tbody>
</table>
</div>

<div id="crud_modal" class="modal fade"></div>
' ;

$container_0 ;
$container_1 = $this->settings['listAll_setting_table']['width'] ;
$container_2 ;
$container_3 ;

if ($this->settings['listAll_setting_table']['overflow'])
{
    $container_0 = 'border:1px solid gray;overflow:scroll;width:99%;height:450px;margin:0 auto;' ;
}

if (true)  //作thead
{
    if (is_array($this->settings['listAll_setting']) && count($this->settings['listAll_setting']) > 0)
    {
        $thead = '' ;
        if ( ! ($this->settings['block_switch']['tbody_checkbox'] === 'N')) 
        {
            $thead .= '
    <th style="width:20px;">
      <input type="checkbox" id="tbody_checkbox_leader">
    </th>' ;
        }

        foreach ($this->settings['listAll_setting'] as $column => $arr)
        {
            $th_tpl = '<th {0} {1}>{2}</th>' ;
            $thProp = '' ;
            $thProp .= 'data-column="'.$column.'" ' ;
            if (is_array($arr['th_prop']) && count($arr['th_prop']) > 0)
            {
                foreach($arr['th_prop'] as $prop => $value)
                {
                    $thProp .= $prop.'="'.$value.'" ' ;
                }
            }
            
            $thead .= _format($th_tpl, array($thProp, $arr['th_others'], $this->settings['listAll_setting'][$column]['th_content'])) ;
        
        }
        
        if ( ! ($this->settings['block_switch']['tbody_fn'] === 'N') ) 
        {
            $thead .= '<th width="100px" nowrap class="tbody_fn"></th>' ;
        }
        
        $container_2 = $thead ;
    }
}
    
//  作tbody
if ( is_array($this->settings['data']) && count($this->settings['data']) > 0 )
{
    $tbody = '' ;

    // foreach ($this->settings['data'] as $idx => $arr)
    foreach ($this->settings['data'] as $idx => $arr)
    {
        $td = '' ;

        if ( ! ($this->settings['block_switch']['tbody_checkbox'] === 'N') ) 
        {
            $td .= '
<td style="text-align:center ;" class="tbody_checkbox_td">
                        <input type="checkbox" class="tbody_checkbox_crew" data-pk="'.$arr[ $this->settings['table_pk'] ].'">
</td>' ;

        }
        foreach ($arr as $column => $td_content)
        {
            $td_tpl = '<td {0} {1}>{2}</td>' ;
            $tdProp = '' ;
            $tdProp .= 'data-column="'.$column.'" ' ;
            $tdProp .= 'data-pkey="'.$arr[$this->settings['table_pk']].'" ' ;
            if (is_array($this->settings['listAll_setting'][$column]['td_prop']) && count($this->settings['listAll_setting'][$column]['td_prop']) > 0)
            {
                foreach($this->settings['listAll_setting'][$column]['td_prop'] as $prop => $value)
                {
                    $tdProp .= $prop.'="'.$value.'" ' ;
                }
            }
            
            //有callback 就叫callback
            if (is_callable($this->settings['listAll_setting'][$column]['callback']))
            {
                $td_content = call_user_func($this->settings['listAll_setting'][$column]['callback'], $arr) ;
            }
            
            $td .= _format($td_tpl, array($tdProp, $this->settings['listAll_setting'][$column]['td_others'], $td_content)) ;
        }

        if ( ! ($this->settings['block_switch']['tbody_fn'] === 'N') ) 
        {
            $td .= '<td class="tbody_fn" style="">
<a class="btn btn-success btn-sm '.$this->settings['crud_class']['read'].'" href="#">
    <span class="glyphicon glyphicon-list"></span>
</a>
<input type="hidden" name="pk" value="'.$arr[ $this->settings['table_pk'] ].'">
            
<a class="btn btn-warning btn-sm '.$this->settings['crud_class']['update'].'" href="#">
    <span class="glyphicon glyphicon-pencil"></span>
</a>
<input type="hidden" name="pk" value="'.$arr[ $this->settings['table_pk'] ].'">

<a class="btn btn-danger btn-sm '.$this->settings['crud_class']['delete'].'" href="#">
    <span class="glyphicon glyphicon-trash"></span>
</a>
<input type="hidden" name="pk" value="'.$arr[ $this->settings['table_pk'] ].'">

            </td>' ;
        }

        $tbody .= '<tr data-pk="'.$arr[ $this->settings['table_pk'] ].'">'.$td.'</tr>' ;
        $container_3 = $tbody ;
    }
}

echo _format($tpl, array($container_0, $container_1, $container_2, $container_3)) ;