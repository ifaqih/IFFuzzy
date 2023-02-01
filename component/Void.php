<?php

if (PHP_MAJOR_VERSION < 8) {
    throw new Exception("This library runs on php version 8.0 or above!");
    exit;
}

define('FUZZY_MEMBERSHIP_LINEAR_UP', 10);
define('FUZZY_MEMBERSHIP_LINEAR_DOWN', 11);
define('FUZZY_MEMBERSHIP_TRIANGLE', 12);
define('FUZZY_MEMBERSHIP_TRAPEZOID', 13);
define('FUZZY_MEMBERSHIP_SIGMOID_UP', 14);
define('FUZZY_MEMBERSHIP_SIGMOID_DOWN', 15);
define('FUZZY_MEMBERSHIP_PI', 16);
define('FUZZY_METHOD_MAMDANI', 'MAMDANI');
define('FUZZY_METHOD_TSUKAMOTO', 'TSUKAMOTO');
define('FUZZY_METHOD_SUGENO', 'SUGENO');
define('FUZZY_EXEC_HOLD', 1);
define('FUZZY_EXEC_GET_ALL', 2);
define('FUZZY_EXEC_AS_ARRAY', 3);


require_once __DIR__ . "/Main.php";
require_once __DIR__ . "/Fuzzification/Attribute.php";
require_once __DIR__ . "/Source/Helpers.php";
require_once __DIR__ . "/Source/Builder.php";
include_once __DIR__ . "/Defuzzification/Tsukamoto.php";
include_once __DIR__ . "/Defuzzification/Sugeno.php";
include_once __DIR__ . "/Defuzzification/Mamdani.php";
include_once __DIR__ . "/Inference/Tsukamoto.php";
include_once __DIR__ . "/Inference/Sugeno.php";
include_once __DIR__ . "/Inference/Mamdani.php";
