<?php
$ini = array() ;
//test settings
$settings['db']       = 'fk' ;
$settings['user']     = 'fk' ;
$settings['pass']     = '123456789' ;
$settings['table']    = 'myTable' ;  //資料表
$settings['table_pk'] = 'id' ;  //資料表 PK




//零碎
$settings['title']['text']      = 'Index標題' ;
$settings['subtitle']['text']   = '副標題' ;
$settings['table_pk_show'] = 'Y' ;  //N 就是不顯示
$settings['prefix']             = 'tv_' ;  //這是代表傳回來的參數是資料庫的欄位
$settings['showsql'] = 'N' ;  //N不顯示
$settings['showsession'] = 'N' ;  //N不顯示
$settings['showrequest'] = 'N' ;  //N不顯示
$settings['dblclick_on_tr'] = 'update' ;  //update / read




//各功能版面的位置設定
/*
$settings['tpl_head']  載入CSS JS
$settings['tpl_title']  標題版面
$settings['tpl_console']  進階選項版面
$settings['tpl_table']  資料表格版面
$settings['tpl_create']  新增資料版面
$settings['tpl_read']  閱讀資料版面
$settings['tpl_update']  修改資料版面
$settings['tpl_delete']  刪除資料版面
*/
$settings['tpl_head'] = $this->_dir."/tpl/v1/head.php" ;
$settings['tpl_title'] = $this->_dir."/tpl/v1/title.php" ;
$settings['tpl_console'] = $this->_dir."/tpl/v1/console.php" ;
$settings['tpl_table'] = $this->_dir."/tpl/v1/table.php" ;
$settings['tpl_create'] = $this->_dir."/tpl/v1/create.php" ;
$settings['tpl_read'] = $this->_dir."/tpl/v1/read.php" ;
$settings['tpl_update'] = $this->_dir."/tpl/v1/update.php" ;
$settings['tpl_delete'] = $this->_dir."/tpl/v1/delete.php" ;

//是否顯示各部分的開關
/*
$settings['block_switch']['title'] 是否顯示標題
$settings['block_switch']['console'] 是否顯示控制台
$settings['block_switch']['system_buttons'] 是否顯示系統按鈕
$settings['block_switch']['tbody_checkbox'] 是否顯示每一行的checkbox
$settings['block_switch']['tbody_fn'] 是否顯示修改、刪除的功能
*/
$settings['block_switch']['title'] = true ;  //N 就是不顯示
$settings['block_switch']['console'] = true ;  //N 就是不顯示
$settings['block_switch']['system_buttons'] = true ;  //N 就是不顯示
$settings['block_switch']['tbody_checkbox'] = 'N' ;  //N 就是不顯示
$settings['block_switch']['tbody_fn'] = true ;  //N 就是不顯示




//title
$settings['title']['text']      = '預設主標題' ;
$settings['subtitle']['text']   = '預設副標題' ;





//console
//各個功能的連結
/*

*/
$settings['function_settings'] = array(
      'listAll'   => array('href'=>'?msel=crud_listAll')  //clean session
    , 'listOrgi'      => array('href'=>'?msel=crud_listOrgi')
    , 'create'    => array('href'=>'?msel=crud_create')
    , 'read'      => array('href'=>'?msel=crud_read')
    , 'update'    => array('href'=>'?msel=crud_update')
    , 'delete'    => array('href'=>'?msel=crud_delete')
    
    , 'create_commit' => array('href'=>'?msel=crud_create_commit')
    , 'update_commit' => array('href'=>'?msel=crud_update_commit')
    , 'delete_commit' => array('href'=>'?msel=crud_delete_commit')
    , 'search_commit' => array('href'=>'?msel=crud_search_commit')
) ;

/*
畫面上各主要功能的class
*/
$settings['crud_class']['create'] = 'crud_modal_create' ;
$settings['crud_class']['read'] = 'crud_modal_read' ;
$settings['crud_class']['update'] = 'crud_modal_update' ;
$settings['crud_class']['delete'] = 'crud_modal_delete' ;
$settings['crud_class']['print'] = 'crud_print' ;

/*
預設系統按鈕 1 2 3 是第幾顆按鈕
icon_class 可以設定按鈕顯示的圖示，可以查閱
http://getbootstrap.com/components/
*/
$settings['system_buttons'][1] = array() ;
$settings['system_buttons'][1]['title'] = '新增' ;
$settings['system_buttons'][1]['href'] = '#' ;
$settings['system_buttons'][1]['title_class'] = 'btn btn-default '.$settings['crud_class']['create'] ;
$settings['system_buttons'][1]['icon_class'] = 'glyphicon glyphicon-asterisk' ;

$settings['system_buttons'][2] = array() ;
$settings['system_buttons'][2]['title'] = '回列表' ;
$settings['system_buttons'][2]['href'] = $settings['function_settings']['listOrgi']['href'] ;
$settings['system_buttons'][2]['title_class'] = 'btn btn-default' ;
$settings['system_buttons'][2]['icon_class'] = 'glyphicon glyphicon-align-justify' ;

$settings['system_buttons'][3] = array() ;
$settings['system_buttons'][3]['title'] = '列印' ;
$settings['system_buttons'][3]['href'] = '#' ;
$settings['system_buttons'][3]['title_class'] = 'btn btn-default '.$settings['crud_class']['print'] ;
$settings['system_buttons'][3]['icon_class'] = 'glyphicon glyphicon-print' ;

/*
$settings['advanced_inout'] = 'out' ; 可以開關是否預設顯示進階選項的區域
$settings['console_settings'] = "" ;  可以自定義一部份的進階選項
*/
$settings['advanced_inout'] = 'out' ;  //in 顯示 out 隱藏
$settings['console_settings'] = "" ;





//data table
/*
datatable_searching 可以開關列表畫面的搜尋功能
datatable_paging 可以開關列表畫面的頁次
datatable_ordering 可以開關列表畫面的排序
datatable_info 可以開關列表畫面的資訊
datatable_lengthMenu 第一個陣列可以設定顯示的筆數，-1是全部。第二個陣列是選擇時看到的選項
datatable_displayLength 預設的筆數 -1是全部
$settings['listAll_setting_table']['overflow'] = true ; 
要搭配$settings['listAll_setting_table']['width'] = '100%'; 通常會設定120% ~ 140% 左右
*/
$settings['datatable_searching'] = true ;
$settings['datatable_paging']    = true ;
$settings['datatable_ordering']  = true ;
$settings['datatable_info']      = true ;
$settings['datatable_lengthMenu'] = '[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]' ;
$settings['datatable_displayLength'] = '-1' ;  //預設顯示比數 -1 是全部
$settings['listAll_setting_table']['overflow'] = false ;  //會去控制外面div的大小
$settings['listAll_setting_table']['width'] = '100%' ;





return $settings ;