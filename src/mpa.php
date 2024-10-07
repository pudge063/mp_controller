<?php

class MPA {

    private $iterations = 0;

    function create_mpa($g) {
        $m = array();

        $m["Q"] = array('q');
        $m["q0"] = "q";
        $m["Z"] = array();

        $m["N"] = $g["N"] + $g["T"];
        $m["T"] = $g["T"];

        $m["N0"] = $g["S"];

        $m["F"] = array();

        foreach ($g["P"] as $temp_n => $temp_rules) {
            foreach ($temp_rules as $temp_rule) {
                $m["F"][] = [['q', 'eps', $temp_n], ['q', $temp_rule]];
            }
        }

        foreach ($m["T"] as $t) {
            $m["F"][] = [['q', $t, $t], ['q', 'eps']];
        }

        $this->print_mpa($m);

        return $m;
    }

    function print_mpa($m) {
        echo "<div class='container'>";
        foreach ($m["F"] as $f) {
            $temp_f = implode(",", $f[0]);
            $temp_res = implode(",", $f[1]);
            echo "F($temp_f) = ($temp_res)" . "<br>";
        }
        echo "</div>";
    }
}
