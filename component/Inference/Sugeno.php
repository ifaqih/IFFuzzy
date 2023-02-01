<?php

namespace Ifaqih\Component\INF;

use Ifaqih\Component\DFZY\Sugeno as DFZYS;

class Sugeno extends DFZYS
{
    public static function inference(array $rules, array $attributes, array $values)
    {
        $ap = 0;
        $apz = 0;
        foreach ($rules as $key => $value) {
            foreach ($value['rules'] as $k => $v) {
                $api[$key] = isset($api[$key]) ? ($api[$key] < $attributes[$k][$v]['fuzzification'] ? $api[$key] : $attributes[$k][$v]['fuzzification']) : $attributes[$k][$v]['fuzzification'];
            }
            $zi[$key] = self::defuzzification($value['result'], $values);
            $apz = $apz + ($api[$key] * $zi[$key]);
            $ap = $ap + $api[$key];
        }
        $zx = $apz / $ap;
        return [
            'result'    =>  $zx,
            'inference' =>  [
                'alpha_predicate'   =>  $api,
                'z'                 =>  $zi
            ]
        ];
    }
}
