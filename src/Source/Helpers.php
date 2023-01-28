<?php

namespace ifaqih\Component\SRC;

class Helpers
{

    public static function array_centerer(array $array)
    {
        $c = ($array[0] + end($array)) / 2;
        array_push($array, $c);
        $array = array_unique($array);
        sort($array);
        return [
            "key_center"    =>  array_search($c, $array),
            "array"         =>  $array
        ];
    }

    public static function sigmoid_element(array $domain)
    {
        $center = self::array_centerer($domain);
        $domain = $center['array'];
        return [
            'a' =>  $domain[0],
            'b' =>  $domain[$center['key_center']],
            'c' =>  end($domain)
        ];
    }

    public static function dc(array|object $array): ?int
    {
        foreach ($array as $value) {
            return (is_array($value) || is_object($value)) ? self::dc($value) + 1 : 1;
        }
    }
}
