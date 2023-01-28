<?php

namespace ifaqih\iffuzzy;

require_once "Component/Void.php";

use ifaqih\Component\Main;
use ifaqih\Component\SRC\Builder;

class Fuzzy extends Main
{

    public static function build()
    {
        return new Builder();
    }
}
