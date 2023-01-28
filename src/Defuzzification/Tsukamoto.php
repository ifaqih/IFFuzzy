<?php

namespace ifaqih\Component\DFZY;

use ifaqih\Component\SRC\Helpers as HLP;
use Exception;

class Tsukamoto
{
    protected static function linear_up(int|float $x, array $domain): float|int
    {
        asort($domain);
        $h = end($domain);
        $l = $domain[0];
        $x = ($x > 0 && $x < 1) ? ($x * ($h - $l)) + $l : ($x <= 0 ? $l : $h);
        return $x;
    }

    protected static function linear_down(int|float $x, array $domain): float|int
    {
        asort($domain);
        $h = end($domain);
        $l = $domain[0];
        $x = ($x > 0 && $x < 1) ? $h - ($x * ($h - $l)) : ($x <= 0 ? $h : $l);
        return $x;
    }

    protected static function triangle(int|float $x, array $domain): float|int|false
    {
        asort($domain);
        $c = HLP::array_centerer($domain);
        if (is_array($c)) {
            $ux = ($x <= 0 || $x >= 1) ? $domain[0] : (($x === 0.5) ? $c['array'][$c['key_center']] : null);
            if ($ux === null) {
                $ux = ($x < $c['array'][$c['key_center']]) ? self::linear_up($x, array_slice($c['array'], 0, ($c['key_center'] + 1))) : self::linear_down($x, array_slice($c['array'], $c['key_center']));
            }
            return $ux;
        } else {
            return FALSE;
        }
    }

    protected static function trapezoidal(int|float $x, array $domain, int|float $flat_point, ?int $end_flat_point = null): float|int
    {
        if (!in_array($flat_point, $domain)) {
            throw new Exception("\$flat_point must same with one value on array \$domain!");
            die();
        }

        if (end($domain) == $flat_point || $domain[0] == $flat_point || $domain[(array_search(end($domain), $domain) - 1)] == $flat_point) {
            throw new Exception("\$flat_point cannot be same with first, last or one before last value on array \$domain!");
            die();
        } else {
            $key_flat = array_search($flat_point, $domain);
        }

        if ($end_flat_point !== null) {
            if (!in_array($end_flat_point, $domain)) {
                throw new Exception("\$end_flat_point must same with one value after \$flat_point on array \$domain!");
                die();
            } else {
                if (end($domain) == $flat_point || $flat_point >= $end_flat_point) {
                    throw new Exception("\$end_flat_point cannot be same with last value on array \$domain, and \$end_flat_point cannot be less than or equal to \$flat_point!");
                    die();
                }
            }
        } else {
            $end_flat_point = $domain[($key_flat + 1)];
        }

        $key_end_flat = array_search($end_flat_point, $domain);

        if ($x <= 0 || $x >= 1) {
            $ux = 0;
        } else {
            if ($x >= $flat_point && $x <= $end_flat_point) {
                $ux = 1;
            } else {
                $ux = ($x < $flat_point) ? self::linear_up($x, array_slice($domain, 0, ($key_flat + 1))) : self::linear_down($x, array_slice($domain, $key_end_flat));
            }
        }
        return $ux;
    }

    protected static function sigmoid_up(int|float $x, array $domain): float|int
    {
        asort($domain);
        $ux = ($x <= 0) ? $domain[0] : (($x >= 1) ? end($domain) : null);
        if ($ux === null) {
            $e = HLP::sigmoid_element($domain);
            $ux = ($x <= 0.5) ? (sqrt($x / 2) * ($e['c'] - $e['a'])) - $e['a'] : $e['c'] - (sqrt(($x - 1) / -2) * ($e['c'] - $e['a']));
        }
        return $ux;
    }

    protected static function sigmoid_down(int|float $x, array $domain): float|int
    {
        asort($domain);
        $ux = ($x <= 1) ? $domain[0] : (($x >= 0) ? end($domain) : null);
        if ($ux === null) {
            $e = HLP::sigmoid_element($domain);
            $ux = ($x <= 0.5) ? $e['a'] - (sqrt(($x - 1) / -2) * ($e['c'] - $e['a'])) : (sqrt($x / 2) * ($e['c'] - $e['a'])) - $e['c'];
        }
        return $ux;
    }
}
