<?php

namespace ifaqih\Component\FZY;

use ifaqih\Component\SRC\Helpers as HLP;
use Exception;

class Attribute
{

    private const ___membership = [
        FUZZY_MEMBERSHIP_LINEAR_UP      =>  "Linear Up",
        FUZZY_MEMBERSHIP_LINEAR_DOWN    =>  "Linear Down",
        FUZZY_MEMBERSHIP_TRIANGLE       =>  "Triangle",
        FUZZY_MEMBERSHIP_TRAPEZOID      =>  "Trapezoidal",
        FUZZY_MEMBERSHIP_SIGMOID_UP     =>  "Sigmoid Up",
        FUZZY_MEMBERSHIP_SIGMOID_DOWN   =>  "Sigmoid Down",
        FUZZY_MEMBERSHIP_PI             =>  "Pi"
    ];

    public static function fuzzification(array $attributes, array $values)
    {
        foreach ($attributes as $key => $value) {
            if (isset($values[$key])) {
                foreach ($value as $k => $v) {
                    if (isset(static::___membership[$v['membership']])) {
                        $attributes[$key][$k]['membership'] = static::___membership[$v['membership']];
                        $method = str_replace(' ', '_', strtolower($attributes[$key][$k]['membership']));
                        $attributes[$key][$k]['fuzzification'] = in_array($v['membership'], [FUZZY_MEMBERSHIP_TRIANGLE, FUZZY_MEMBERSHIP_TRAPEZOID]) ? self::$method($values[$key], $v['domain'], ((isset($v['domains_one']) ? $v['domains_one'] : NULL))) : self::$method($values[$key], $v['domain']);
                    } else {
                        throw new Exception("\$membership option not found!");
                        exit;
                    }
                }
            }
        }

        return $attributes;
    }

    public static function linear_up(int|float $x, array $domain): float|int
    {
        $ux = ($x <= $domain[0]) ? 0 : (($x >= end($domain)) ? 1 : null);
        if ($ux === null) {
            $a = $domain[0];
            $b = end($domain);
            $ux = ($x - $a) / ($b - $a);
        }
        return $ux;
    }

    public static function linear_down(int|float $x, array $domain): float|int
    {
        $ux = ($x <= $domain[0]) ? 1 : (($x >= end($domain)) ? 0 : null);
        if ($ux === null) {
            $a = $domain[0];
            $b = end($domain);
            $ux = ($b - $x) / ($b - $a);
        }
        return $ux;
    }

    public static function triangle(int|float $x, array $domain, int|float $domains_one = null): float|int|false
    {
        if (!empty($domains_one)) {
            array_push($domain, $domains_one);
            $domain = array_unique($domain);
            sort($domain);
            $c = [
                'key_center'    =>  array_search($domains_one, $domain),
                'array'         =>  $domain
            ];
        } else {
            $c = HLP::array_centerer($domain);
        }

        if (is_array($c)) {
            $ux = ($x <= $domain[0] || $x >= end($domain)) ? 0 : (($x === $c['array'][$c['key_center']]) ? 1 : null);
            if ($ux === null) {
                $ux = ($x < $c['array'][$c['key_center']]) ? self::linear_up($x, array_slice($c['array'], 0, ($c['key_center'] + 1))) : self::linear_down($x, array_slice($c['array'], $c['key_center']));
            }
            return $ux;
        } else {
            return FALSE;
        }
    }

    public static function trapezoidal(int|float $x, array $domain, array $domains_one): float|int
    {
        $end_domain = end($domain);
        sort($domains_one);
        $domains_one = array_unique($domains_one);
        if (count($domains_one) < 2) {
            throw new Exception("\$domains_ones must be at least 2 array values!");
            die();
        }

        $start_domains_one = $domains_one[0];
        $end_domains_one = end($domains_one);

        if ($start_domains_one <= $domain[0]) {
            throw new Exception("the smallest number in the \$domains_one cannot be less than or equal to the smallest number in the \$domain array!");
            die();
        }

        if ($end_domains_one >= $end_domain) {
            throw new Exception("the largest number in the \$domains_one cannot be greater than or equal to the largest number in the \$domain array!");
            die();
        }

        if (!in_array($start_domains_one, $domain)) {
            array_push($domain, $start_domains_one);
        }

        if (!in_array($end_domains_one, $domain)) {
            array_push($domain, $end_domains_one);
        }

        sort($domain);

        $key_flat = array_search($start_domains_one, $domain);
        $key_end_flat = array_search($end_domains_one, $domain);

        if ($x <= $domain[0] || $x >= end($domain)) {
            $ux = 0;
        } else {
            if ($x >= $start_domains_one && $x <= $end_domains_one) {
                $ux = 1;
            } else {
                $ux = ($x < $start_domains_one) ? self::linear_up($x, array_slice($domain, 0, ($key_flat + 1))) : self::linear_down($x, array_slice($domain, $key_end_flat));
            }
        }

        return $ux;
    }

    public static function sigmoid_up(int|float $x, array $domain): float|int
    {
        $ux = ($x <= $domain[0]) ? 0 : (($x >= end($domain)) ? 1 : null);
        if ($ux === null) {
            $e = HLP::sigmoid_element($domain);
            $ux = ($x <= $e['b']) ? 2 * pow((($x - $e['a']) / ($e['c'] - $e['a'])), 2) : 1 - (2 * pow((($e['c'] - $x) / ($e['c'] - $e['a'])), 2));
        }
        return $ux;
    }

    public static function sigmoid_down(int|float $x, array $domain): float|int
    {
        $ux = ($x <= $domain[0]) ? 1 : (($x >= end($domain)) ? 0 : null);
        if ($ux === null) {
            $e = HLP::sigmoid_element($domain);
            $ux = ($x <= $e['b']) ? 1 - (2 * pow((($e['a'] - $x) / ($e['c'] - $e['a'])), 2)) : 2 * pow((($x - $e['c']) / ($e['c'] - $e['a'])), 2);
        }
        return $ux;
    }

    public static function pi(int|float $x, array $domain): float|int|false
    {
        $c = HLP::array_centerer($domain);
        $ux = ($x < $c['array'][0] || $x > end($c['array'])) ? 0 : (($x === $c['array'][$c['key_center']]) ? 1  : null);
        if ($ux === null) {
            $ux = ($x < $c['array'][$c['key_center']]) ? self::sigmoid_up($x, array_slice($c['array'], 0, ($c['key_center'] + 1))) : self::sigmoid_down($x, array_slice($c['array'], $c['key_center']));
        }
        return $ux;
    }
}
