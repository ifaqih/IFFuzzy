<?php

namespace ifaqih\Component\INF;

use ifaqih\Component\DFZY\Mamdani as DFZYM;

class Mamdani extends DFZYM
{

    public static function inference(array $rules, array $attributes, string $result_attr)
    {
        $domain = [];
        foreach ($attributes[$result_attr] as $key => $value) {
            $domain = array_merge($domain, $value['domain']);
        }
        $domain = array_unique($domain);
        sort($domain);

        $_zi = [];
        $i = 0;
        foreach ($rules as $key => $value) {
            foreach ($value['rules'] as $k => $v) {
                $api[$value['result']][$key] = isset($api[$value['result']][$key]) ? ($api[$value['result']][$key] < $attributes[$k][$v]['fuzzification'] ? $api[$value['result']][$key] : $attributes[$k][$v]['fuzzification']) : $attributes[$k][$v]['fuzzification'];
            }
            if (isset($zi[$value['result']]['max'])) {
                if ($zi[$value['result']]['max'] < $api[$value['result']][$key]) {
                    $zi[$value['result']] = [
                        'max'   =>  $api[$value['result']][$key],
                        't'     => ($api[$value['result']][$key] * (end($domain) - $domain[0])) + $domain[0]
                    ];
                    $_zi[($i - 1)] = [
                        'max'   =>  $zi[$value['result']]['max'],
                        't'     =>  $zi[$value['result']]['t']
                    ];
                }
            } else {
                $zi[$value['result']] = [
                    'max'   =>  $api[$value['result']][$key],
                    't'     => ($api[$value['result']][$key] * (end($domain) - $domain[0])) + $domain[0]
                ];
                $_zi[$i] = [
                    'max'   =>  $zi[$value['result']]['max'],
                    't'     =>  $zi[$value['result']]['t']
                ];
                $i++;
            }
        }

        $df = self::defuzzification($domain, $_zi);

        return [
            'result'    =>  $df['zx'],
            'inference' =>  [
                'alpha_predicate'   =>  $api,
                'z'                 =>  $df['zi']
            ]
        ];
    }
}
