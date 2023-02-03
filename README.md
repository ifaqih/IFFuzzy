# Fuzzy

Fuzzy logic is a form of many-valued logic in which the truth value of variables may be any real number between 0 and 1. It is employed to handle the concept of partial truth, where the truth value may range between completely true and completely false. By contrast, in Boolean logic.

PHP Version: 8.0 or above
|-

## Installation

### With Composer:

```ruby
composer require ifaqih/iffuzzy
```

## Class

### Namespace:

```ruby
namespace Ifaqih\Iffuzzy;
```

### Class Name:

```ruby
class Fuzzy{}
```

## Constants:

| Constant Name                   | Value         | Description                         |
| ------------------------------- | ------------- | ----------------------------------- |
| `FUZZY_METHOD_MAMDANI`          | `"MAMDANI"`   | Using the Mamdani method            |
| `FUZZY_METHOD_SUGENO`           | `"SUGENO"`    | Using the Sugeno method             |
| `FUZZY_METHOD_TSUKAMOTO`        | `"TSUKAMOTO"` | Using the Tsukamoto method          |
| `FUZZY_MEMBERSHIP_LINEAR_UP`    | `10`          | Using ascending linear membership   |
| `FUZZY_MEMBERSHIP_LINEAR_DOWN`  | `11`          | Using descending linear membership  |
| `FUZZY_MEMBERSHIP_TRIANGLE`     | `12`          | Using triangular membership         |
| `FUZZY_MEMBERSHIP_TRAPEZOID`    | `13`          | Using trapezoidal membership        |
| `FUZZY_MEMBERSHIP_SIGMOID_UP`   | `14`          | Using ascending sigmoid membership  |
| `FUZZY_MEMBERSHIP_SIGMOID_DOWN` | `15`          | Using descending sigmoid membership |
| `FUZZY_MEMBERSHIP_PI`           | `16`          | Using pi membership                 |

## Set Method

Setting the fuzzy method to be used.

```ruby
class::method()
```

- Type: static
- Parameter data type: `string $method_name`
- Return data type: `object`

### Prototype:

```ruby
IFFuzzy::method(FUZZY_METHOD_MAMDANI)
```

## Set Attribute

Set one attribute context.

```ruby
class::attribute()
```

- Type: static
- Parameter data type: `string $context_name, array $attributes, ?array $domain = null`
- Return data type: `object`

### Prototype 1:

```ruby
IFFuzzy::attribute("many", [
        "little"    =>  FUZZY_MEMBERSHIP_LINEAR_DOWN,
        "much"      =>  FUZZY_MEMBERSHIP_LINEAR_UP
    ],
    [40, 80]
)
```

### Prototype 2:

```ruby
IFFuzzy::attribute("level", [
        "low"       =>  [
            "membership"    =>  FUZZY_MEMBERSHIP_LINEAR_DOWN,
            "domain"        =>  [40, 50]
        ],
        "medium"    =>  [
            "membership"    =>  FUZZY_MEMBERSHIP_TRIANGLE,
            "domain"        =>  [40, 60]
        ],
        "high"      =>  [
            "membership"    =>  FUZZY_MEMBERSHIP_LINEAR_UP,
            "domain"        =>  [50, 60]
        ]
    ]
)
```

## Set Attributes

Set multiple context attributes.

```ruby
class::attributes()
```

- Type: static
- Parameter data type: `array ...$attribute_each_context`
- Return data type: `object`

### Prototype:

```ruby
IFFuzzy::attributes(
    [
        "many" =>  [
            "little"    =>  FUZZY_MEMBERSHIP_LINEAR_DOWN,
            "much"      =>  FUZZY_MEMBERSHIP_LINEAR_UP
        ],
        [40, 80]
    ],
    [
        "level" => [
            "low"       =>  [
                "membership"    =>  FUZZY_MEMBERSHIP_LINEAR_DOWN,
                "domain"        =>  [40, 50]
            ],
            "medium"    =>  [
                "membership"    =>  FUZZY_MEMBERSHIP_TRIANGLE,
                "domain"        =>  [40, 60]
            ],
            "high"      =>  [
                "membership"    =>  FUZZY_MEMBERSHIP_LINEAR_UP,
                "domain"        =>  [50, 60]
            ]
        ]
    ],
    [
        "speed" =>  [
            "slow"      =>  FUZZY_MEMBERSHIP_LINEAR_DOWN,
            "fast"      =>  FUZZY_MEMBERSHIP_LINEAR_UP
        ],
        [500, 1200]
    ]
)
```

## Set Rule

Set one rule.

```ruby
class::rule()
```

- Type: static
- Parameter data type: `string $result, array $attribute`
- Return data type: `object`

### Prototype:

```ruby
IFFuzzy::rule("fast", ["many" => "much", "level" => "medium"])
```

## Set Rules

Set multiple rule.

```ruby
class::rules()
```

- Type: static
- Parameter data type: `array ...$rules`
- Return data type: `object`

### Prototype:

```ruby
IFFuzzy::rules(
    ["rules"    =>  ["many" => "little", "level" => "low"], "result" => "slow"],
    ["rules"    =>  ["many" => "little", "level" => "medium"], "result" => "slow"],
    ["rules"    =>  ["many" => "little", "level" => "high"], "result" => "fast"],
    ["rules"    =>  ["many" => "much", "level" => "low"], "result" => "slow"],
    ["rules"    =>  ["many" => "much", "level" => "medium"], "result" => "fast"],
    ["rules"    =>  ["many" => "much", "level" => "high"], "result" => "fast"]
)
```

## Builder of Rules

In the `set_rules()` method you can use builder

```ruby
class::build()
```

- Type: static
- Parameter data type: no needed
- Return data type: `object`

### Object of build method

#### Set Rule Name

```ruby
class::build()->rule()
```

- Type: static
- Parameter data `string|array $data`
- Return data type: `object`

#### Set Rule Name

```ruby
class::build()->rule()->result()
```

- Type: static
- Parameter data `string $data, bool $is_formula = false`
- Return data type: `array`

#### Prototype:

```ruby
IFFuzzy::build()->rule(["many" => "much", "level" => "medium"])->result('fast')
```

## Set Value

Set value of one context attribute.

```ruby
class::set_value()
```

- Type: static
- Parameter data type: `string $context_name, int|float $value`
- Return data type: `object`

### Prototype:

```ruby
IFFuzzy::set_value("much", 50)
```

## Set Values

Set value of multiple context attribute.

```ruby
class::set_values()
```

- Type: static
- Parameter data type: `string $context_name, int|float $value`
- Return data type: `object`

### Prototype:

```ruby
IFFuzzy::set_values(
    [
        "much"  =>  50,
        "level" =>  58
    ]
)
```

## Constant Flags

| Constant Name         | Value | Description                                                       |
| --------------------- | ----- | ----------------------------------------------------------------- |
| `FUZZY_EXEC_HOLD`     | `1`   | Not reset all data after executed                                 |
| `FUZZY_EXEC_GET_ALL`  | `2`   | Getting all data has been processed of library (in object values) |
| `FUZZY_EXEC_AS_ARRAY` | `3`   | Getting all data has been processed of library in array values    |

## Executing Fuzzy Logic

Execute datas has been added from all of method.

```ruby
class::execute()
```

- Type: static
- Parameter data type: `array|int $flags = 0`
- Return data type: `int|float|object|array|null`

### Prototype:

```ruby
IFFuzzy::execute(FUZZY_EXEC_HOLD)
```

## Getting Value

Getting all data has been processed of library.

```ruby
class::get_all_values()
```

- Type: static
- Parameter data type: `int $flags = 0`
- Return data type: `array|object`

### Prototype:

```ruby
IFFuzzy::get_all_values(FUZZY_EXEC_AS_ARRAY)
```

## Clear Data

Clearing datas has been added or result of processed.

```ruby
class::clear()
```

- Type: static
- Parameter data type: no needed
- Return data type: `void`

### Prototype:

```ruby
IFFuzzy::clear()
```

## Example

### Example 1:

```ruby
IFFuzzy::method(FUZZY_METHOD_MAMDANI)
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
        ['rules'  =>  ["many" => "little", "level" => "low"], 'result' => 'slow'],
        ['rules'  =>  ["many" => "little", "level" => "medium"], 'result' => 'slow'],
        ['rules'  =>  ["many" => "little", "level" => "high"], 'result' => 'fast'],
        ['rules'  =>  ["many" => "much", "level" => "low"], 'result' => 'slow'],
        ['rules'  =>  ["many" => "much", "level" => "medium"], 'result' => 'fast'],
        ['rules'  =>  ["many" => "much", "level" => "high"], 'result' => 'fast']
    )
    ->set_values([
        'many' =>  50,
        'level' =>  58
    ])
    ->execute();
```

#### Result:

```ruby
float(782.6128545848649)
```

### Example 2:

```ruby
IFFuzzy::method(FUZZY_METHOD_MAMDANI);
IFFuzzy::attribute("many", [
    'little'   =>  FUZZY_MEMBERSHIP_LINEAR_DOWN,
    'much'    =>  FUZZY_MEMBERSHIP_LINEAR_UP
], [40, 80]);
IFFuzzy::attribute("level", [
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
]);
IFFuzzy::attribute("speed", [
    'slow'    =>  FUZZY_MEMBERSHIP_LINEAR_DOWN,
    'fast'     =>  FUZZY_MEMBERSHIP_LINEAR_UP
], [500, 1200]);
IFFuzzy::rules([
    IFFuzzy::build()->rule(["many" => "little", "level" => "low"])->result('slow'),
    IFFuzzy::build()->rule(["many" => "little", "level" => "medium"])->result('slow'),
    IFFuzzy::build()->rule(["many" => "little", "level" => "high"])->result('fast'),
    IFFuzzy::build()->rule(["many" => "much", "level" => "low"])->result('slow'),
    IFFuzzy::build()->rule(["many" => "much", "level" => "medium"])->result('fast'),
    IFFuzzy::build()->rule(["many" => "much", "level" => "high"])->result('fast')
]);
IFFuzzy::set_values([
    'many' =>  50,
    'level' =>  58
]);
IFFuzzy::execute(FUZZY_EXEC_AS_ARRAY);
```

#### Result:

```ruby
array(6) {
  ["method"]=>
  string(7) "MAMDANI"
  ["attributes"]=>
  array(3) {
    ["many"]=>
    array(2) {
      ["little"]=>
      array(3) {
        ["membership"]=>
        string(11) "Linear Down"
        ["domain"]=>
        array(2) {
          [0]=>
          int(40)
          [1]=>
          int(80)
        }
        ["fuzzification"]=>
        float(0.75)
      }
      ["much"]=>
      array(3) {
        ["membership"]=>
        string(9) "Linear Up"
        ["domain"]=>
        array(2) {
          [0]=>
          int(40)
          [1]=>
          int(80)
        }
        ["fuzzification"]=>
        float(0.25)
      }
    }
    ["level"]=>
    array(3) {
      ["low"]=>
      array(3) {
        ["membership"]=>
        string(11) "Linear Down"
        ["domain"]=>
        array(2) {
          [0]=>
          int(40)
          [1]=>
          int(50)
        }
        ["fuzzification"]=>
        int(0)
      }
      ["medium"]=>
      array(3) {
        ["membership"]=>
        string(8) "Triangle"
        ["domain"]=>
        array(2) {
          [0]=>
          int(40)
          [1]=>
          int(60)
        }
        ["fuzzification"]=>
        float(0.2)
      }
      ["high"]=>
      array(3) {
        ["membership"]=>
        string(9) "Linear Up"
        ["domain"]=>
        array(2) {
          [0]=>
          int(50)
          [1]=>
          int(60)
        }
        ["fuzzification"]=>
        float(0.8)
      }
    }
    ["speed"]=>
    array(2) {
      ["slow"]=>
      array(2) {
        ["membership"]=>
        int(11)
        ["domain"]=>
        array(2) {
          [0]=>
          int(500)
          [1]=>
          int(1200)
        }
      }
      ["fast"]=>
      array(2) {
        ["membership"]=>
        int(10)
        ["domain"]=>
        array(2) {
          [0]=>
          int(500)
          [1]=>
          int(1200)
        }
      }
    }
  }
  ["rules"]=>
  array(6) {
    [0]=>
    array(2) {
      ["rules"]=>
      array(2) {
        ["many"]=>
        string(6) "little"
        ["level"]=>
        string(3) "low"
      }
      ["result"]=>
      string(6) "slow"
    }
    [1]=>
    array(2) {
      ["rules"]=>
      array(2) {
        ["many"]=>
        string(6) "little"
        ["level"]=>
        string(6) "medium"
      }
      ["result"]=>
      string(6) "slow"
    }
    [2]=>
    array(2) {
      ["rules"]=>
      array(2) {
        ["many"]=>
        string(6) "little"
        ["level"]=>
        string(4) "high"
      }
      ["result"]=>
      string(5) "fast"
    }
    [3]=>
    array(2) {
      ["rules"]=>
      array(2) {
        ["many"]=>
        string(4) "much"
        ["level"]=>
        string(3) "low"
      }
      ["result"]=>
      string(6) "slow"
    }
    [4]=>
    array(2) {
      ["rules"]=>
      array(2) {
        ["many"]=>
        string(4) "much"
        ["level"]=>
        string(6) "medium"
      }
      ["result"]=>
      string(5) "fast"
    }
    [5]=>
    array(2) {
      ["rules"]=>
      array(2) {
        ["many"]=>
        string(4) "much"
        ["level"]=>
        string(4) "high"
      }
      ["result"]=>
      string(5) "fast"
    }
  }
  ["values"]=>
  array(2) {
    ["many"]=>
    int(50)
    ["level"]=>
    int(58)
  }
  ["inference"]=>
  array(2) {
    ["alpha_predicate"]=>
    array(2) {
      ["slow"]=>
      array(3) {
        [0]=>
        int(0)
        [1]=>
        float(0.2)
        [3]=>
        int(0)
      }
      ["fast"]=>
      array(3) {
        [2]=>
        float(0.75)
        [4]=>
        float(0.2)
        [5]=>
        float(0.25)
      }
    }
    ["z"]=>
    array(2) {
      ["momentum"]=>
      array(3) {
        [0]=>
        float(40960)
        [1]=>
        float(159037.08333333337)
        [2]=>
        float(146015.625)
      }
      ["area"]=>
      array(3) {
        [0]=>
        float(128)
        [1]=>
        float(182.875)
        [2]=>
        float(131.25)
      }
    }
  }
  ["result"]=>
  float(782.6128545848649)
}
```
