Date.prototype.Format = function (fmt) { //author: meizz 
    var o = {
        "M+": this.getMonth() + 1, //月份 
        "d+": this.getDate(), //日 
        "h+": this.getHours(), //小时 
        "m+": this.getMinutes(), //分 
        "s+": this.getSeconds(), //秒 
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
        "S": this.getMilliseconds() //毫秒 
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}

function chineseCount(word){
    return word.split(/[\u4e00-\u9a05]/).length -1;
}

String.prototype.format = function()
{
    var args = arguments ;
    return this.replace(/{(\d+)}/g, function(match, number)
    {
        return typeof (args[number] != 'undefined') ? args[number] : match ;
    }) ;
};

//
var helperV1 =
{
      showLoader: function()
    {
        $('<div id="__loading"><p> Loading... </p></div>')
            .css(
            {
                  position:   'fixed'
                , 'z-index':    1000
                , top:        0
                , left:       0
                , height:     '25px'
                , background: 'red'
                , padding: '3px'
                , color: 'white'
            })
            .appendTo('body') ;
    }
    , hideLoader: function()
    {
        $('#__loading').remove() ;
    }
}


var valid = {} ;

valid.required = function(value)
{
    return $.trim(value).length > 0;
}

valid.string = function(value)
{
    return /^\w+$/.test(value) ;
}

valid.special = function(value)
{ 
    return /[.!#$%&'*+\/=?^`{|}~-]+/.test(value) ;
}

valid.email = function(value)
{
    return /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(value);
}

valid.url = function(value)
{
    //判讀http://localhost/crud有問題
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value) ;
}

valid.date = function(value)
{
    return !/Invalid|NaN/.test(new Date(value).toString()) ;
}

valid.number = function(value)
{
    return /^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(value) ;
}

valid.digits = function(value)
{
    return /^\d+$/.test(value) ;
}

valid.minlength = function(value, limit)  //最小長度
{
    limit = Number(limit) ;
    return value.length >= limit ;
}

valid.maxlength = function(value, limit) //最大長度
{
    limit = Number(limit) ;
    return value.length <= limit ;
}

valid.rangelength = function(value, min, max)
{
    min = Number( min ) ;
    max = Number( max ) ;
    return ( (value.length >= min) && (value.length<= max) )? true : false ;
}

valid.min = function(value, min)  //最小限制
{
    min = Number(min) ;
    return value >= min ;
}

valid.max = function(value, max)  //最大限制
{
    max = Number(max) ;
    return value <= max ;
}

valid.range = function(value, min, max)
{
    min = Number(min) ;
    max = Number(max) ;
    return ( (value >= min) && (value<= max) )? true : false ;
}

valid.equal = function(value, compare)
{
    return value === compare ;
}

var valid_false_msg = {} ;

valid_false_msg.required = '此欄位為必填' ;
valid_false_msg.string = '此欄位必須為英數字' ;
valid_false_msg.special = '此欄位不能為英數字' ;
valid_false_msg.email = '此欄位必須為EMAIL格式' ;
valid_false_msg.url = '此欄位必須為網址格式' ;
valid_false_msg.date = '此欄位必須為日期格式' ;
valid_false_msg.number = '此欄位必須為數字格式' ;
valid_false_msg.digits = '此欄位必須為純數字' ;
valid_false_msg.minlength = '此欄位長度小於設定值' ;
valid_false_msg.maxlength = '此欄位長度大於設定值' ;
valid_false_msg.rangelength = '此欄位長度超過範圍' ;
valid_false_msg.min = '此欄位低於設定值' ;
valid_false_msg.max = '此欄位高於設定值' ;
valid_false_msg.range = '此欄位數字超過範圍' ;
valid_false_msg.equal = '此欄位不合格' ;

$.common = 
{
      helper: helperV1
    , valid: valid
    , valid_false_msg: valid_false_msg
} ;
