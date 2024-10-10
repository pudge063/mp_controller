<link rel="stylesheet" href="table.css">
<?php

class StringChecker
{
    private $iterations = 0;
    private $paths = [];

    public $g;

    public function check_string($grammar, $input)
    {
        echo "<div class='container'>";
        $stack = array($grammar['S']); // Инициализация магазина с начальным символом
        $this->backtrack($input, $stack, $grammar, []);
        echo "</div>";
    }

    private function backtrack($input, $stack, $grammar, $history)
    {
        $this->iterations++;
        echo "i: " . $this->iterations . ", ";
        echo implode("", $input) . ", ";
        echo implode("", $stack) . "<br>";

        // записываем текущее состояние в историю
        $history[] = [
            'iteration' => $this->iterations,
            'input' => implode("", $input),
            'stack' => implode("", array_reverse($stack))
        ];

        // если магазин и строка пусты, строка принадлежит грамматике
        if (empty($stack) && empty($input)) {
            echo "<div class='container'>" . "Строка подходит!<br></div>";
            $this->paths[] = $history; // сохраняем путь
            return true;
        }

        // если магазин пуст, а строка еще не разобрана, или наоборот
        if (empty($stack) || empty($input)) {
            return false;
        }

        $top = array_pop($stack); // берем верхний символ из магазина

        // Если это терминал
        if (in_array($top, $grammar['T'])) {
            if ($top == $input[0]) {
                array_shift($input); // Убираем символ из входной строки
                return $this->backtrack($input, $stack, $grammar, $history);
            } else {
                return false; // не совпадает, возвращаемся назад
            }
        }

        // если это нетерминал
        if (in_array($top, $grammar['N'])) {
            if (isset($grammar['P'][$top])) {
                foreach ($grammar['P'][$top] as $rule) {
                    // добавляем в магазин правило справа налево
                    $new_stack = array_merge($stack, array_reverse(str_split($rule)));
                    if ($this->backtrack($input, $new_stack, $grammar, $history)) {
                        return true;
                    }
                }
            }
        }

        return false; // если все варианты испробованы и не подошли
    }

    // функция для вывода кратчайшего пути
    public function print_shortest_path()
    {
        if (empty($this->paths)) {
            echo "Строка не подходит.<br>";
            return;
        }

        $shortest = array_reduce($this->paths, function ($carry, $item) {
            return count($item) < count($carry) ? $item : $carry;
        }, $this->paths[0]);

        echo "<div class='container'>";
        echo "<h3 style='text-align:center;'>Итоговая таблица распознавания</h3>";
        echo "<table border='1'>
                <tr>
                    <th>Номер итерации</th>
                    <th>Состояние автомата</th>
                    <th>Входная строка</th>
                    <th>Состояние магазина</th>
                </tr>";
        $i = 0;
        foreach ($shortest as $step) {
            $i++;
            echo "<tr>
                    <td>$i ({$step['iteration']})</td>
                    <td>q</td>
                    <td>{$step['input']}</td>
                    <td>{$step['stack']}</td>
                  </tr>";
        }
        echo "</table>";
        echo "</div>";
    }
}