<?php

namespace IFaqih\AIMethods;

require_once __DIR__ . "/../component/Void.php";

use Ifaqih\Component\Main;
use Ifaqih\Component\SRC\Builder;

class Fuzzy extends Main
{

    public static function build()
    {
        return new Builder();
    }
}
