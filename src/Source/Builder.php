<?php

namespace ifaqih\Component\SRC;

use Exception;

class Builder
{
    private static $data;

    public function rule(string|array $data): object
    {
        if (is_array($data)) {
            static::$data['rules'] = $data;
        } else {
            $data = str_replace(' ', '', $data);
            $data = explode(',', $data);
            foreach ($data as $key => $value) {
                $s = explode('=', $value);
                static::$data['rules'] = [$s[0] => $s[1]];
            }
        }
        return $this;
    }

    public function result(string $data, bool $is_formula = false): array
    {
        if (!empty($data)) {
            $data = static::$data + [
                'result'        =>  $data,
                'is_formula'    =>  $is_formula
            ];
            static::$data = null;
            return $data;
        } else {
            throw new Exception("item not set!");
            die();
        }
    }
}
