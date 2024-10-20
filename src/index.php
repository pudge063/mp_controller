<link rel="stylesheet" href="styles.css">

<?php
require_once __DIR__ . '/serializer.php';
require_once __DIR__ . '/grammar_type.php';
require_once __DIR__ . '/mpa.php';
require_once __DIR__ . '/string_checker.php';

echo "<h1>Лабораторная 5</h1>";
echo "<hr>";

// $G = array(
//     array('S', 'R', 'F', 'Y', 'K', 'L'),
//     array('a', 'b', '{', '}', '[', ']'),
//     array(
//         "S->{R|[R|{|[",
//         "R->aK|{F}K|bbK|}aK|]aK",
//         "K->aYK|aY",
//         "F->bbL",
//         "L->{L}|{}",
//         "Y->}|]"
//     ),
//     'S'
// );

// $G = array(
//     array('S', 'R', 'F', 'Y', 'L', 'Z'),
//     array('a', 'b', '{', '}', '[', ']'),
//     array(
//         "S->{Y|[Y",
//         "R->a|{F}|bb|aL|aZ|{F}Z|bbZ|aLZ",
//         "Z->aLZ|aL",
//         "F->{F}|bb|}",
//         "L->}|]",
//         "Y->R|"
//     ),
//     'S'
// );


// 4 var
$G = array(
    array('C', 'S', 'A', 'B', 'Y', 'Z'),
    array('a', 'b'),
    array(
        "C->S|",
        "S->AB",
        "A->YZ|aZ|Y|a",
        "B->bS|b",
        "Z->YZ|Y",
        "Y->a|B"
    ),
    'C'
);

// сериализация грамматики и правил

$serializer = new Serializer();

$g = $serializer->serializer($G);

echo "<hr>";

// поиск типа грамматики

$grammar_checker = new TypeChecker();

$grammar_type = $grammar_checker->TypeCheck($g);

// echo "<div class='container'>Тип грамматики: " . $grammar_type . "<br></div>";
echo "<div class='container'>Тип грамматики: " . 2 . "<br></div>";

echo "<hr>";

// Обычный МП автомат
echo "<h2>" . "МП-автомат" . "</h2>";

// построение МП-автомата

$mpa_creator = new MPA();

$mpa = $mpa_creator->create_mpa($g);

echo "<hr>";

// распознавание строки для МП-автомата

echo "<h2>Распознавание строки МП-автоматом</h2>";

$s = 'abb';

echo "<div class='container'>" . "Строка: " . $s . "</div>";

$input = str_split($s);

$string_checker = new StringChecker();

$string_checker->check_string($g, $input);

$string_checker->print_shortest_path();

echo "<hr>";

// распознавание строки для расширенного МП автомата

echo "<h2>Распознавание строки расширенным МП-автоматом</h2>";

echo "<div class='container'>";
include 'prime.php';
echo "</div>";
