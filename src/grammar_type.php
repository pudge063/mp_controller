<?php

class TypeChecker
{
    function TypeCheck($g)
    {
        $funcs = array('is_type_1', 'is_type_2', 'is_type_3');

        $type = 0;

        foreach ($funcs as $func) {

            if ($this->$func($g) === 0) {
                return $type;
            }

            $type++;
        }

        return $type;
    }


    function is_type_1($g)
    {
        // echo implode(",", $n) . "<br>" . implode(",", $t) . "<br>";

        $rules = $g["P"];

        foreach ($rules as $n => $rule) {
            foreach ($rule as $temp_rule) {
                if (strlen($n) > strlen($temp_rule)) {
                    return 0;
                }
            }
        }

        return 1;
    }

    function is_type_2($g)
    {
        $rules = $g["P"];

        foreach ($rules as $n => $rule) {
            foreach ($rule as $temp_rule) {
                if (strlen($n) > 1) {
                    return 0;
                }
            }
        }

        return 1;
    }

    function is_type_3($g)
    {
        $rules = $g["P"];

        foreach ($rules as $n => $rule) {
            foreach ($rule as $temp_rule) {
                if (
                    strlen($n) > 1 ||
                    strlen($temp_rule) > 2 ||
                    strlen($temp_rule == 2) && in_array($temp_rule[0], $g["T"]) && in_array($temp_rule[1], $g["N"]) ||
                    strlen($temp_rule == 2) && in_array($temp_rule[1], $g["T"]) && in_array($temp_rule[0], $g["N"]) ||
                    strlen($temp_rule == 1) && in_array($temp_rule[0], $g["T"])
                ) {
                    return 0;
                }
            }
        }

        return 1;
    }
}
