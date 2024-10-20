<?php

// правила грамматики
// $rules = [
//     "S" => ["{R", "[R", "{", "["],
//     "R" => ["a", "{F}", "bb", "aL", "aZ", "{F}Z", "bbZ", "aLZ"],
//     "Z" => ["aLZ", "aL"],
//     "F" => ["{F}", "bb", "}"],
//     "L" => ["}", "]"],
//     // "Y" => ["R", "eps"],
// ];


// 4 var
$rules = [
    "S" => ["{R", "[R", "{", "["],
    "R" => ["a", "{F}", "bb", "aL", "aZ", "{F}Z", "bbZ", "aLZ"],
    "Z" => ["aLZ", "aL"],
    "F" => ["{F}", "bb", "}"],
    "L" => ["}", "]"],
    // "Y" => ["R", "eps"],
];

// Исходная строка
$input = "{bba}";

// Функция для поиска всех возможных замен в строке
function getReplacements($string, $rules)
{
    $replacements = [];
    foreach ($rules as $nonTerminal => $patterns) {
        foreach ($patterns as $pattern) {
            $pos = strpos($string, $pattern);
            if ($pos !== false) {
                $replacements[] = [
                    'nonTerminal' => $nonTerminal,
                    'pattern' => $pattern,
                    'pos' => $pos
                ];
            }
        }
    }
    return $replacements;
}

// Бэктрекинг
function backtracking($currentString, $rules, &$steps)
{
    global $rules;

    // Если достигли символа S, возвращаем путь
    if ($currentString === "S") {
        return true;
    }

    // Находим все возможные замены в текущей строке
    $replacements = getReplacements($currentString, $rules);
    if (empty($replacements)) {
        // Если нет замен, откатываемся назад
        return false;
    }

    foreach ($replacements as $replacement) {
        // Генерируем новую строку, заменяя правую часть на нетерминал
        $newString = substr_replace($currentString, $replacement['nonTerminal'], $replacement['pos'], strlen($replacement['pattern']));


        // Записываем шаг
        $steps[] = [
            'iteration' => count($steps) + 1,
            'state' => 'q', // Промежуточное состояние
            'string' => $newString,
            'stack' => "eps"
        ];

        // echo count($steps) . " " . $newString . "<br>";

        // Рекурсивный вызов для новой строки
        if (backtracking($newString, $rules, $steps)) {
            return true;
        }

        // если это не привело к решению, удаляем шаг
        array_pop($steps);
    }

    return false;
}

// массив для записи шагов
$steps = [];

// заполняем начальные строки
$stack = ""; // еачальное состояние стека
for ($i = 0; $i < strlen($input); $i++) {
    $currentInput = substr($input, $i); // текущая входная строка
    $steps[] = [
        'iteration' => $i + 1,
        'state' => 'q',
        'string' => $stack,
        'stack' => $currentInput
    ];
    $stack .= $input[$i]; // добавляем символ в стек
    // echo $i . " " . $input[$i] . "<br>";
}

$steps[] = [
    'iteration' => count($steps) + 1,
    'state' => 'q',
    'string' => $stack,
    'stack' => 'eps'
];
// echo count($steps) + 1 . " " . $stack . "<br>";

// Запускаем алгоритм бэктрекинга
if (backtracking($input, $rules, $steps)) {
    // Меняем состояние последней итерации на r (финальное состояние)
    if (!empty($steps)) {
        $steps[count($steps) - 1]['state'] = 'r';
    }

    // Вывод таблицы
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>Номер итерации</th>
            <th>Состояние</th>
            <th>Входящая строка</th>
            <th>Стэк</th>
          </tr>";

    // Выводим записанные шаги
    foreach ($steps as $step) {
        // Проверяем, является ли шаг финальным
        $style = ($step['state'] === 'r') ? " style='background-color: #d1ffd1;'" : "";

        echo "<tr$style>
                <td>{$step['iteration']}</td>
                <td>{$step['state']}</td>
                <td>{$step['stack']}</td>
                <td>#{$step['string']}</td>
                
              </tr>";
    }

    echo "</table>";
} else {
    echo "Не удалось привести строку к символу S.";
}
