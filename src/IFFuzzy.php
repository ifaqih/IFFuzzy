<?php

namespace ifaqih\IFFuzzy;

require_once "Void.php";

use ifaqih\Component\Main;
use ifaqih\Component\SRC\Builder;

class Fuzzy extends Main
{

    public static function build()
    {
        return new Builder();
    }
}
