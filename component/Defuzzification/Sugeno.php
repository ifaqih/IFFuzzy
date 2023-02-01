<?php

namespace Ifaqih\Component\DFZY;

class Sugeno
{
    protected static function defuzzification(string $rule, array $values)
    {
        preg_match_all('/[{][{].*?[}][}]/', $rule, $var);
        $var = array_unique($var[0]);
        $v = preg_replace("/[}{]/", '', $var);
        foreach ($v as $key => $value) {
            $rule = str_replace($var[$key], $values[$value], $rule);
        }
        return eval('return ' . $rule . ';');
    }
}
