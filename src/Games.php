<?php

namespace BrainGames\Games;

use function BrainGames\Engine\startGame;

$autoloadPath1 = __DIR__ . '/../../../autoload.php';
$autoloadPath2 = __DIR__ . '/../vendor/autoload.php';

if (file_exists($autoloadPath1)) {
    require_once $autoloadPath1;
} else {
    require_once $autoloadPath2;
}

function generateRandomNumber(int $end = 100): int
{
    return rand(0, $end);
}

function checkIfEven($num): string
{
    return $num % 2 === 0 ? 'yes' : 'no';
}

function generateEvenRoundItem(): array
{
    $result = [];

    $randNum = generateRandomNumber();
    $result['question'] = $randNum;
    $result['answer'] = checkIfEven($randNum);

    return $result;
}

function calculate(int $firstRand, int $secondRand, string $randAction): int
{
    $result = null;

    switch ($randAction) {
        case '+':
            $result = $firstRand + $secondRand;
            break;
        case '-':
            $result = $firstRand - $secondRand;
            break;
        case '*':
            $result = $firstRand * $secondRand;
            break;
    }

    return $result;
}

function generateCalcRoundItem(): array
{
    $result = [];
    $actionEnum = ['+', '-', '*'];

    $firstRand = generateRandomNumber();
    $secondRand = generateRandomNumber();
    $randAction = $actionEnum[generateRandomNumber(count($actionEnum) - 1)];

    $result['question'] = "{$firstRand} {$randAction} {$secondRand}";
    $result['answer'] = calculate($firstRand, $secondRand, $randAction);

    return $result;
}

function generateRoundItem(string $game): array
{
    $result = null;

    switch ($game) {
        case 'even':
            $result = generateEvenRoundItem();
            break;
        case 'calc':
            $result = generateCalcRoundItem();
            break;
    }

    return $result;
}

function generateGameRounds(string $gameName, int $numOfRounds = 3): array
{
    $result = [];

    for ($i = 0; $i < $numOfRounds; $i++) {
        $result[] = generateRoundItem($gameName);
    }

    return $result;
}


function startEvenGame()
{
    $rules = 'Answer "yes" if the number is even, otherwise answer "no".';
    $roundsItems = generateGameRounds('even');

    startGame($roundsItems, $rules);
}

function startCalcGame()
{
    $rules = 'What is the result of the expression?';
    $roundsItems = generateGameRounds('calc');

    startGame($roundsItems, $rules);
}