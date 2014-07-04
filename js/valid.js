var valid = {} ;
/*
valid.url = function(value)
{
    
}
*/
valid.required = function(value)
{
    return $.trim(value).length > 0;
}

valid.string = function(value)
{
    return /^\w+$/.test(value) ;
}


valid.email = function(value)
{
    return /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(value);
}

valid.url = function(value)
{
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

valid.minlength = function(value, limit)
{
    limit = limit || 10 ;
    
    return value.length >= limit ;
}

valid.maxlength = function(value, limit)
{
    limit = limit || 10 ;
    
    return value.length <= limit ;
}

valid.rangelength = function(value, min, max)
{
    min = min || 5 ;
    max = max || 10 ;
    
    return ( (value.length >= min) && (value.length<= max) )? true : false ;
}

valid.min = function(value, min)
{
    min = min || 10 ;
    
    return value < min ;
}

valid.max = function(value, max)
{
    max = max || 10 ;
    
    return value > max ;
}

valid.range = function(value, min, max)
{
    min = min || 5 ;
    max = max || 10 ;
    
    return ( (value >= min) && (value<= max) )? true : false ;
}

valid.equal = function(value, compare)
{
    compare = compare || 'abc' ;
    
    return value === compare ;
}