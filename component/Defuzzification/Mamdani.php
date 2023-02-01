<?php

namespace Ifaqih\Component\DFZY;

use Exception;

class Mamdani
{
    protected static function defuzzification(array $domain, array $_zi)
    {
        try {
            $zi_c = count($_zi);
            for ($i = 0; $i <= count($_zi); $i++) {
                if ($i === 0) {
                    $zi['momentum'][$i] = $_zi[$i]['max'] * (0.5 * pow($_zi[$i]['t'], 2));
                    $zi['area'][$i] = $_zi[$i]['max'] * $_zi[$i]['t'];
                } else if ($i === $zi_c) {
                    $zi['momentum'][$i] = ($_zi[($i - 1)]['max'] * (0.5 * pow(end($domain), 2))) - ($_zi[($i - 1)]['max'] * (0.5 * pow($_zi[($i - 1)]['t'], 2)));
                    $zi['area'][$i] =  ($_zi[($i - 1)]['max'] * end($domain)) - ($_zi[($i - 1)]['max'] * $_zi[($i - 1)]['t']);
                } else {
                    $d = end($domain) - $domain[0];

                    $d1 = $d * 3;
                    $d2 = $d * 2;
                    $zi['momentum'][$i] = ((pow($_zi[$i]['t'], 3) / $d1) - (($domain[0] * pow($_zi[$i]['t'], 2)) / $d2)) - ((pow($_zi[($i - 1)]['t'], 3) / $d1) - (($domain[0] * pow($_zi[($i - 1)]['t'], 2)) / $d2));

                    $zi['area'][$i] = (((pow($_zi[$i]['t'], 2) / 2) - ($domain[0] * $_zi[$i]['t'])) / $d) - (((pow($_zi[($i - 1)]['t'], 2) / 2) - ($domain[0] * $_zi[($i - 1)]['t'])) / $d);
                }
            }

            $zx = array_sum($zi['momentum']) / array_sum($zi['area']);

            return [
                'zi'    =>  $zi,
                'zx'    =>  $zx
            ];
        } catch (Exception $e) {
            throw new Exception($e);
            die();
        }
    }
}
