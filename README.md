# Программа для распознавания строки для заданной грамматики

## Запуск

```
git clone https://github.com/pudge063/mp_controller
```

```
docker compose up -d
```

```
http://localhost:80
```

## Ввод строки и грамматики

Для MP-автомата:

src/index.php:
```PHP
$G = array(
    array('S', 'R', 'F', 'Y', 'L', 'Z'),
    array('a', 'b', '{', '}', '[', ']'),
    array(
        "S->{Y|[Y",
        "R->a|{F}|bb|aL|aZ|{F}Z|bbZ|aLZ",
        "Z->aLZ|aL",
        "F->{F}|bb|}",
        "L->}|]",
        "Y->R|"
    ),
    'S'
);

$s = '{bba}';
```

Для расширенного МП-автомата:

src/prime.php:
```PHP
// правила грамматики
$rules = [
    "S" => ["{Y", "[Y"],
    "R" => ["a", "{F}", "bb", "aL", "aZ", "{F}Z", "bbZ", "aLZ"],
    "Z" => ["aLZ", "aL"],
    "F" => ["{F}", "bb", "}"],
    "L" => ["}", "]"],
    "Y" => ["R", "eps"],
];

// Исходная строка
$input = "{bba}";
```