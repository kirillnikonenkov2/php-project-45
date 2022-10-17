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

function findGsd(int $firstRand, int $secondRand): int
{
    if ($secondRand > 0) {
        return findGsd($secondRand, $firstRand % $secondRand);
    } else {
        return abs($firstRand);
    }
}

function generateGsdRoundItem(): array
{
    $result = [];

    $firstRand = generateRandomNumber();
    $secondRand = generateRandomNumber();

    $result['question'] = "{$firstRand} {$secondRand}";
    $result['answer'] = findGsd($firstRand, $secondRand);

    return $result;
}

function generateProgressionRoundItem(): array
{
    $result = [];
    $progressionLength = 10;
    $question = '';

    $startingNum = generateRandomNumber();
    $progressionStep = generateRandomNumber();
    $missingIndex = generateRandomNumber($progressionLength - 1);
    $missingValue = 0;

    for ($i = 0; $i < $progressionLength; $i++) {
        $val = $startingNum + $i * $progressionStep;
        if ($i === $missingIndex) {
            $question .= ".. ";
            $missingValue = $val;
        } else {
            $question .= "{$val} ";
        }
    }

    $result['question'] = "{$question}";
    $result['answer'] = $missingValue;

    return $result;
}

function isPrime(int $num): string
{
    for ($x = 2; $x < $num; $x++) {
        if ($num % $x === 0) {
            return 'no';
        }
    }
    return 'yes';
}

function generatePrimeRoundItem(): array
{
    $result = [];

    $randNum = generateRandomNumber();

    $result['question'] = "{$randNum}";
    $result['answer'] = isPrime($randNum);

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
        case 'gcd':
            $result = generateGsdRoundItem();
            break;
        case 'progression':
            $result = generateProgressionRoundItem();
            break;
        case 'prime':
            $result = generatePrimeRoundItem();
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

function startGcdGame()
{
    $rules = 'Find the greatest common divisor of given numbers.';
    $roundsItems = generateGameRounds('gcd');

    startGame($roundsItems, $rules);
}

function startProgressionGame()
{
    $rules = 'What number is missing in the progression?';
    $roundsItems = generateGameRounds('progression');

    startGame($roundsItems, $rules);
}

function startPrimeGame()
{
    $rules = 'Answer "yes" if given number is prime. Otherwise answer "no".';
    $roundsItems = generateGameRounds('prime');

    startGame($roundsItems, $rules);
}
