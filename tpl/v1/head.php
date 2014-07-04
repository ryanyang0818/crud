<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<!-- <link rel="stylesheet" href="/min/g=systemCss"> -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
<style>
<?php
// echo file_get_contents($this->_include_dir.'/css/bootstrap.css') ;
// echo file_get_contents($this->_include_dir.'/css/bootstrap-theme.css') ;
echo file_get_contents($this->_dir.'/css/common.css') ;
?>
</style>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<!-- <script src="/min/g=systemJs"></script> -->
<script>
<?php
//echo file_get_contents($this->_include_dir.'/js/bootstrap.min.js') ;
echo file_get_contents($this->_dir.'/js/common.js') ;
?>
</script>
<script src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
</head>

