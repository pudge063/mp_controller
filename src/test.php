<?php

$a = 1;
$b = 2;
$inp = '==';

echo "$a $inp $b" . "<br>";

switch ($inp) {
    case '!=':
        if ($a != $b) {
            echo "True.";
        } else {
            echo "False";
        }
        break;

    case '==':
        if ($a == $b) {
            echo "True";
        } else {
            echo "False";
        }

        break;

    case '<':
        if ($a < $b) {
            echo "True";
        } else {
            echo "False";
        }
        break;

    case '<=':
        if ($a <= $b) {
            echo "True";
        } else {
            echo "False";
        }
        break;

    case '>':
        if ($a > $b) {
            echo "True";
        } else {
            echo "False";
        }
        break;
    case '>=':
        if ($a >= $b) {
            echo "True";
        } else {
            echo "False";
        }
        break;

    default:
        echo "error";
        break;
}
