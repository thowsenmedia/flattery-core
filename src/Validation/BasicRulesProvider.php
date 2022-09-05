<?php

namespace ThowsenMedia\Flattery\Validation;

class BasicRulesProvider
{

    public static function register()
    {
        foreach([
            'min','max','required','alpha-numeric',
        ] as $rule) {
            $method = str_replace('-', '_', $rule);
            Validator::registerRuleType($rule, [static::class, $method]);
        }
    }

    public static function required($value)
    {
        return $value ? true : false;
    }

    public static function min($value, $min)
    {
        if (is_numeric($value)) {
            return $value >= $min;
        }else if (is_string($value)) {
            return strlen($value) >= $min;
        }else if (is_array($value)) {
            return count($value) >= $min;
        }
    }

    public static function max($value, $max)
    {
        if (is_numeric($value)) {
            return $value <= $max;
        }else if (is_string($value)) {
            return strlen($value) <= $max;
        }else if (is_array($value)) {
            return count($value) <= $max;
        }
    }

    public static function number($value)
    {
        return is_numeric($value);
    }

    public static function alpha_numeric($value)
    {
        return ctype_alnum($value);
    }
    
}