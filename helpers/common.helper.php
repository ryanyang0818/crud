<?php
/*
if ( ! function_exists('xxx'))
{

}
function hr()
function _echo($out)
function _htmlspecialchars($target)
function _debug()
*/

if ( ! function_exists('hr'))
{
    function hr()
    {
        echo '<HR />' ;
    }
}

if ( ! function_exists('_echo'))
{
    function _echo($out)
    {
        if (is_string($out))
        {
            echo $out ;
        }
        else
        {
            echo '<pre>' ;
            var_export($out) ;
            echo '</pre>' ;
        }
        hr() ;
    }

}

if ( ! function_exists('_htmlspecialchars'))
{
    function _htmlspecialchars($target)
    {
        if (is_string($target)) return htmlspecialchars($target, ENT_QUOTES) ;

        array_walk_recursive($target, function(&$value, $key)
        {
            $value = htmlspecialchars($value, ENT_QUOTES) ;
        }) ;
        
        return $target ;
    }

}

if ( ! function_exists('_debug'))
{
    function _debug()
    {
       echo '<pre>' ;
       debug_print_backtrace();
       echo '</pre>' ;
    }

}

if ( ! function_exists('_format'))
{
    function _format($target, $arr)
    {
        return preg_replace_callback('#{(\d+)}#', function($match) use ($arr)
        {
            return $arr[ $match['1'] ] ;
        }, $target) ;
    }

}

if ( ! function_exists('_alert'))
{
    function _alert($out)
    {
        echo '<script>alert("'.$out.'")</script>' ;
    }
}

if ( ! function_exists('_href'))
{
    function _href($url)
    {
        echo '<script>location.href="'.$url.'"</script>' ;
    }
}

