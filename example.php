<?php

include "src/IFFuzzy.php";

use ifaqih\iffuzzy\Fuzzy;

function dump($x, $exit = false)
{
    echo "<pre>";
    var_dump($x);
    echo "</pre>";

    if ($exit)
        exit;
}

// Start time test
$time = microtime(true);

/*
| ======================================================================================================================================
|  EXAMPLE 1
| ======================================================================================================================================
*/

Fuzzy::method(FUZZY_METHOD_SUGENO)
    ->attributes(
        [
            "many" =>  [
                'little'   =>  FUZZY_MEMBERSHIP_LINEAR_DOWN,
                'much'    =>  FUZZY_MEMBERSHIP_LINEAR_UP
            ],
            [40, 80]
        ],
        [
            "level" => [
                'low'    =>  [
                    'membership'    =>  FUZZY_MEMBERSHIP_LINEAR_DOWN,
                    'domain'        =>  [40, 50]
                ],
                'medium'    =>  [
                    'membership'    =>  FUZZY_MEMBERSHIP_TRIANGLE,
                    'domain'        =>  [40, 60]
                ],
                'high'    =>  [
                    'membership'    =>  FUZZY_MEMBERSHIP_LINEAR_UP,
                    'domain'        =>  [50, 60]
                ]
            ]
        ],
        [
            "speed" =>  [
                'slow'    =>  FUZZY_MEMBERSHIP_LINEAR_DOWN,
                'fast'     =>  FUZZY_MEMBERSHIP_LINEAR_UP
            ],
            [500, 1200]
        ]
    )
    ->rules(
        Fuzzy::build()->rule(["many" => "little", "level" => "low"])->result('500', true),
        Fuzzy::build()->rule(["many" => "little", "level" => "medium"])->result('10*{{level}}+100', true),
        Fuzzy::build()->rule(["many" => "little", "level" => "high"])->result('10*{{level}}+200', true),
        Fuzzy::build()->rule(["many" => "much", "level" => "low"])->result('5*{{many}}+2*{{level}}', true),
        Fuzzy::build()->rule(["many" => "much", "level" => "medium"])->result('5*{{many}}+4*{{level}}+100', true),
        Fuzzy::build()->rule(["many" => "much", "level" => "high"])->result('5*{{many}}+5*{{level}}+300', true)
    )
    ->set_values([
        'many' =>  50,
        'level' =>  58
    ])
    ->execute(FUZZY_EXEC_HOLD);

dump(Fuzzy::get_all_values()->result);
Fuzzy::clear();



/*
| ======================================================================================================================================
|  EXAMPLE 2
| ======================================================================================================================================
*/


$fuzzy = Fuzzy::method(FUZZY_METHOD_MAMDANI)
    ->attribute("many", [
        'little'   =>  FUZZY_MEMBERSHIP_LINEAR_DOWN,
        'much'    =>  FUZZY_MEMBERSHIP_LINEAR_UP
    ], [40, 80])
    ->attribute("level", [
        'low'    =>  [
            'membership'    =>  FUZZY_MEMBERSHIP_LINEAR_DOWN,
            'domain'        =>  [40, 50]
        ],
        'medium'    =>  [
            'membership'    =>  FUZZY_MEMBERSHIP_TRIANGLE,
            'domain'        =>  [40, 60]
        ],
        'high'    =>  [
            'membership'    =>  FUZZY_MEMBERSHIP_LINEAR_UP,
            'domain'        =>  [50, 60]
        ]
    ])
    ->attribute("speed", [
        'slow'    =>  FUZZY_MEMBERSHIP_LINEAR_DOWN,
        'fast'     =>  FUZZY_MEMBERSHIP_LINEAR_UP
    ], [500, 1200])
    ->rules(
        ['rules'   =>  ["many" => "little", "level" => "low"], 'result' => 'slow'],
        ['rules'   =>  ["many" => "little", "level" => "medium"], 'result' => 'slow'],
        ['rules'    =>  ["many" => "little", "level" => "high"], 'result' => 'fast'],
        ['rules'   =>  ["many" => "much", "level" => "low"], 'result' => 'slow'],
        ['rules'    =>  ["many" => "much", "level" => "medium"], 'result' => 'fast'],
        ['rules'    =>  ["many" => "much", "level" => "high"], 'result' => 'fast']
    )
    ->set_values([
        'many' =>  50,
        'level' =>  58
    ])
    ->execute(FUZZY_EXEC_AS_ARRAY);

// End time test
$time = microtime(true) - $time;


dump($fuzzy);

dump($time, true);
