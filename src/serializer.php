<link rel="stylesheet" href="styles.css">

<?php

class Serializer
{
    function serializer($g)
    {
        $N = $g[0];
        $T = $g[1];
        $P = array();

        foreach ($g[2] as $row) {
            $temp = explode("->", $row);

            foreach (explode("|", $temp[1]) as $temp_row) {
                // echo "row" . $temp_row . "<br>";
                if (!isset($P[$temp[0]])) {
                    $P[$temp[0]] = array();
                }
                $P[$temp[0]][] = $temp_row;
            }
        }

        $S = $g[3];

        $grammar = array("N" => $N, "T" => $T, "P" => $P, "S" => $S);

        $this->print_grammar($grammar);

        return $grammar;
    }

    function print_grammar($g)
    {
        echo "<div class='container'>";
        $temp_n = implode(",", $g['N']);
        $temp_t = implode(",", $g["T"]);

        echo "N = { $temp_n }" . "<br>";
        echo "T = { $temp_t }" . "<br>";

        echo "<br>";

        echo "Правила:" . "<br>";

        foreach ($g["P"] as $temp_n => $temp_rule) {
            echo $temp_n . " -> '" . implode("' | '", $temp_rule) . "'" . "<br>";
        }

        echo "<br>";

        echo "Начальный символ: " . $g["S"] . "<br>";
        
        echo "</div>";
    }
}
