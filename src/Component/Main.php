<?php

namespace ifaqih\Component;

use ifaqih\Component\FZY\Attribute as FZY;
use ifaqih\Component\SRC\Helpers as HLP;
use Exception;

class Main
{
    protected const ___methods = [
        FUZZY_METHOD_MAMDANI,
        FUZZY_METHOD_TSUKAMOTO,
        FUZZY_METHOD_SUGENO
    ];

    private static $instance;
    private static $method;
    private static $rules;
    private static $attributes;
    private static $result_attribute;
    private static $values;
    private static $inference;
    private static $result;

    protected static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function method(string $method_name): object
    {
        $method_name = strtoupper($method_name);
        if (in_array($method_name, static::___methods)) {
            static::$method = $method_name;
        } else {
            throw new Exception($method_name . " not found in method list!");
            die();
        }
        return self::getInstance();
    }

    public static function attribute(string $context_name, array $attributes, ?array $domain = null): object
    {
        foreach ($attributes as $key => $value) {
            if (is_array($value)) {
                if (isset($value['membership'])) {
                    if (isset($value['domain'])) {
                        sort($value['domain']);
                        static::$attributes[$context_name][$key] = $value;
                    } else {
                        if (!empty($domain)) {
                            sort($domain);
                            static::$attributes[$context_name][$key] = $value + ['domain' => $domain];
                        } else {
                            throw new Exception("domain key does not exist in the array!");
                            die();
                        }
                    }
                } else {
                    throw new Exception("membership key does not exist in the array!");
                    die();
                }
            } else {
                if (!empty($domain)) {
                    sort($domain);
                    static::$attributes[$context_name][$key] = ['membership' => $value, 'domain' => $domain];
                } else {
                    throw new Exception("domain argument cannot be null!");
                    die();
                }
            }
        }
        return self::getInstance();
    }

    public static function attributes(array ...$attribute_each_context): object
    {
        foreach ($attribute_each_context as $key => $value) {
            if (is_array($value)) {
                $domain = null;
                if (isset($value[0])) {
                    sort($value[0]);
                    $domain = $value[0];
                    unset($value[0]);
                }

                $k = array_keys($value);

                if (count($value) <= 0) {
                    throw new Exception("attribute in \$attribute_each_context[" . $key . "] argument must be set!");
                    die();
                }

                if (!is_string($k[0])) {
                    throw new Exception("key name of attribute in \$attribute_each_context[" . $key . "] argument must be a string!");
                    die();
                }

                self::attribute($k[0], $value[$k[0]], $domain);
            } else {
                throw new Exception("\$attribute_each_context[" . $key . "] argument must be an array!");
                die();
            }
        }
        return self::getInstance();
    }

    public static function rule(string $result, array $attribute): object
    {
        if (is_array(static::$rules)) {
            array_push(static::$rules, [$result => $attribute]);
        } else {
            static::$rules[0] = [$result => $attribute];
        }
        return self::getInstance();
    }

    public static function rules(array ...$rules): object
    {
        $dept = HLP::dc($rules);
        $k_r = array_keys($rules);

        if ($dept === 3 && is_int($k_r[0])) {
            if (is_array(static::$rules)) {
                foreach ($rules as $key => $value) {
                    array_push(static::$rules, $value);
                }
            } else {
                static::$rules = $rules;
            }
        } else {
            throw new Exception("error \$rules array format!");
            die();
        }

        return self::getInstance();
    }

    public static function set_value(string $context_name, int|float $value): object
    {
        $value = [$context_name => $value];
        static::$values = is_array(static::$values) ? static::$values + $value : $value;
        return self::getInstance();
    }

    public static function set_values(array $values): object
    {
        static::$values = is_array(static::$values) ? static::$values + $values : $values;
        return self::getInstance();
    }

    public static function execute(array|int $flags = 0): int|float|object|array|null
    {
        $return = NULL;
        $a_k = array_keys(static::$attributes);
        $v_k = array_keys(static::$values);
        $diff = array_diff($a_k, $v_k);
        static::$result_attribute = array_values($diff)[0];
        static::$attributes = FZY::fuzzification(static::$attributes, static::$values);
        $method = "ifaqih\Component\INF\\" . ucfirst(strtolower(static::$method));
        $inference = (static::$method === FUZZY_METHOD_SUGENO) ? $method::inference(static::$rules, static::$attributes, static::$values) : $method::inference(static::$rules, static::$attributes, static::$result_attribute);
        static::$result = $inference['result'];
        static::$inference = $inference['inference'];

        if (($flags && FUZZY_EXEC_GET_ALL)) {
            $return = (($flags & FUZZY_EXEC_AS_ARRAY) === FUZZY_EXEC_AS_ARRAY) ? self::get_all_values(FUZZY_EXEC_AS_ARRAY) : self::get_all_values();
        } else {
            $return = static::$result;
        }

        if (($flags & FUZZY_EXEC_HOLD) === 0) {
            self::clear();
        }

        return $return;
    }

    public static function get_all_values(int $flags = 0): array|object
    {
        $values = [
            'method'        =>  static::$method,
            'attributes'    =>  static::$attributes,
            'rules'         =>  static::$rules,
            'values'        =>  static::$values,
            'inference'     =>  static::$inference,
            'result'        =>  static::$result
        ];

        return (($flags & FUZZY_EXEC_AS_ARRAY) === FUZZY_EXEC_AS_ARRAY) ? $values : json_decode(json_encode($values));
    }

    public static function clear(): void
    {
        static::$instance = NULL;
        static::$method = NULL;
        static::$rules = NULL;
        static::$attributes = NULL;
        static::$result_attribute = NULL;
        static::$values = NULL;
        static::$inference = NULL;
        static::$result = NULL;
        return;
    }
}
