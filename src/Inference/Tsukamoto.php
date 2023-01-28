<?php

namespace ifaqih\Component\INF;

use Exception;
use ifaqih\Component\DFZY\Tsukamoto as DFZYT;

class Tsukamoto extends DFZYT
{

    public static function inference(array $rules, array $attributes, string $result_attr)
    {
        $ap = 0;
        $apz = 0;
        foreach ($rules as $key => $value) {
            foreach ($value['rules'] as $k => $v) {
                $api[$key] = isset($api[$key]) ? ($api[$key] < $attributes[$k][$v]['fuzzification'] ? $api[$key] : $attributes[$k][$v]['fuzzification']) : $attributes[$k][$v]['fuzzification'];
            }
            $zi[$key] = self::zi($attributes[$result_attr][$value['result']], $api[$key]);
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

    private static function zi(array $attributes, int|float $ap)
    {
        switch ($attributes['membership']) {
            case FUZZY_MEMBERSHIP_LINEAR_UP:
                $value = self::linear_up($ap, $attributes['domain']);
                break;
            case FUZZY_MEMBERSHIP_LINEAR_DOWN:
                $value = self::linear_down($ap, $attributes['domain']);
                break;
            case FUZZY_MEMBERSHIP_SIGMOID_UP:
                $value = self::sigmoid_up($ap, $attributes['domain']);
                break;
            case FUZZY_MEMBERSHIP_SIGMOID_DOWN:
                $value = self::sigmoid_down($ap, $attributes['domain']);
                break;
            default:
                throw new Exception("\$membership option not found!");
                die();
                break;
        }

        return $value;
    }
}
