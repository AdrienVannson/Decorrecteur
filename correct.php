<?php

/*
 * Lexique
 */

$phonetics = [];

function initLexique ()
{
    global $phonetics;

    $file = fopen("Lexique383", "r");
    fgets($file); // Ignore the first line

    while ($line = fgets($file)) {
        $infos = explode('	', $line);

        $phonetics[$infos[0]] = $infos[1];
    }
}

initLexique();


/*
 * Possible spellings
 */

$spellings = [
    'a' => ['a'],
    'i' => ['i'],
    'y' => ['u'],
    'u' => ['ou'],
    'o' => ['o', 'au'],
    'O' => ['o', 'au'],
    'e' => ['ai', 'é'],
    'E' => ['è', 'ai'],
    '°' => ['e'],
    '2' => ['eu'],
    '9' => ['eu'],
    '5' => ['in', 'un'],
    '1' => ['in', 'un'],
    '@' => ['an', 'en'],
    '§' => ['on'],
    '3' => ['e', 'eu'],
    'j' => ['j'],
    '8' => ['ui'],
    'w' => ['ou'],
    'p' => ['p'],
    'b' => ['b'],
    't' => ['t'],
    'd' => ['d'],
    'k' => ['k', 'qu', 'c'],
    'g' => ['g'],
    'f' => ['f'],
    'v' => ['v'],
    's' => ['s'],
    'z' => ['z'],
    'S' => ['ch'],
    'Z' => ['ge', 'j'],
    'm' => ['m'],
    'n' => ['n'],
    'N' => ['gn'],
    'l' => ['l'],
    'R' => ['r'],
    'x' => ['j'],
    'G' => ['g']
];

function correctWord ($word)
{
    global $phonetics, $spellings;

    if (!isset($phonetics[strtolower($word)])) {
        return $word;
    }

    $phonetic = $phonetics[strtolower($word)];

    $res = "";

    for ($i=0; $i<mb_strlen($phonetic); $i++) {
        $c = mb_substr($phonetic, $i, 1);

        if (!isset($spellings[$c])) {
            echo "ERREUR, caractere non défini ($c)";
            exit();
        }

        $possibilites = $spellings[$c];

        $res = $res . $possibilites[ rand(0, count($possibilites)-1) ];
    }

    if (ctype_upper($word[0])) {
        $res[0] = strtoupper($res[0]);
    }

    return $res;
}

function correctText ($text)
{
    $res = '';

    $word = "";

    for ($i=0; $i<mb_strlen($text); $i++) {
        $c = mb_substr($text, $i, 1);

        if (in_array($c, [' ', ','])) {
            $res .= correctWord($word) . $c;
            $word = "";
        }
        else {
            $word .= $c;
        }
    }

    $res .= correctWord($word);

    return $res;
}


/*
 * Text correction
 */

echo correctText($_GET['text']);
