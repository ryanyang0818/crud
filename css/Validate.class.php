<?php
class Validate
{
    static function v_required($value)
    {
        return (isset($value) && $value)? true : false ;
    }

    static function v_string($value)
    {
        return (preg_match('/^\w+$/', $value))? true : false ;
    }

    static function v_special($value)
    {
        return (preg_match('/[.!#$%&\'*+\/=?^`{|}~-]+/', $value))? true : false ;
    }

    static function v_email($value)
    {
        return (preg_match('/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/', $value))? true : false ;
    }

    static function v_url($value)
    {
        return (filter_var($value, FILTER_VALIDATE_URL))? true : false ;
    }

    static function v_date($value)
    {
        if (strlen($value) === 8)
        {
            $y = substr($value, 0, 4) ;
            $m = substr($value, 4, 2) ;
            $d = substr($value, 6, 2) ;
        }
        else
        {
            list($y, $m, $d) = preg_split('/[-\.\/ ]/', $value) ;
        }
        
        return checkdate($m, $d, $y) ;
    }

    static function v_number($value)
    {
        return (preg_match('/^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/', $value))? true : false ;
    }

    static function v_digits($value)
    {
        return (preg_match('/^\d+$/', $value))? true : false ;
    }

    static function v_minlength($value, $min)
    {
        $min = (int)$min ;
        return (strlen($value) >= $min)? true : false ;
    }

    static function v_maxlength($value, $max)
    {
        $max = (int)$max ;
        return (strlen($value) <= $max)? true : false ;
    }

    static function v_rangelength($value, $min, $max)
    {
        $min = (int)$min ;
        $max = (int)$max ;
        return ( strlen($value) >= $min && strlen($value) <= $max )? true : false ;
    }

    static function v_min($value, $min)
    {
        $min = (int)$min ;
        $value = (int)$value ;
        return ($value>=$min)? true : false ;
    }

    static function v_max($value, $max)
    {
        $max = (int)$max ;
        $value = (int)$value ;
        return ($value<=$max)? true : false ;
    }

    static function v_range($value, $min, $max)
    {
        $min = (int)$min ;
        $max = (int)$max ;
        $value = (int)$value ;
        return ($value>=$min && $value<=$max)? true : false ;
    }

    static function v_equal($value, $compare)
    {
        return ( $value === $compare )? true : false ;
    }


}
?>