<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;

/**
 * class Formatter
 */
class Formatter
{
    const ENTER = "\n";
    const TAB2 = '  ';
    const TAB4 = '    ';
    const TAB6 = '      ';
    const TAB8 = '        ';
    const TAB10 = '         ';
    const TAB12 = '           ';
    const TAB14 = '             ';
    const TAB16 = '               ';
    
    /*
     * @param array $data
     * @return string
     */
    public static function arrayToVueJson(array $data): string
    {
        
        $json = '{';
        foreach ($data as $attr => $options) {
            $json .= "\n" . self::TAB2 . "$attr: ";
            if (!count($options)) {
                $json .= "{},";
            } else {
                $json .= "{";
                foreach ($options as $key => $val) {
                    $json .= "\n" . self::TAB4 . "$key: " . self::formatVal($val) . ",";
                }
                $json .= "\n" . self::TAB2 . "},";
            }
        }    
        $json .= "\n}";
        
        return $json;
    }    
    
    /*
     * 
     */
    public static function formatVal($val) 
    {
        $type = gettype($val);
        if (substr_count($val, '.')) {
            return $val;
        } elseif ($type === 'boolean') {
            return $val ? "true" : "false";
        } elseif ($type == 'string') {
            return "'$val'";
        } else {
            return $val;
        }
    }
    
}