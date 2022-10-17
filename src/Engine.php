<?php

namespace BrainGames\Engine;

use function cli\line;
use function cli\prompt;
use function BrainGames\Cli\getUserName;
use function BrainGames\Cli\greetUser;

function showRules($rules)
{
    line($rules);
}

function showQuestion($question)
{
    line("Question: {$question}");
}

function getAnswer(): string
{
    return prompt('Your answer');
}

function showLooseRound(string $answer, string $correctAnswer)
{
    line("'{$answer}' is wrong answer ;(. Correct answer was '{$correctAnswer}'.");
}

function showWinRound()
{
    line('Correct!');
}

function showLooseGame(string $name)
{
    line("Let's try again, {$name}!");
}

function showWinGame(string $name)
{
    line("Congratulations, {$name}!");
}

function makeRound($question, string $correctAnswer): bool
{
    showQuestion($question);

    $answer = getAnswer();

    if ($answer !== $correctAnswer) {
        showLooseRound($answer, $correctAnswer);

        return false;
    }

    showWinRound();

    return true;
}

function startGame(array $questionsArr, string $rules)
{
    $name = getUserName();
    greetUser($name);

    showRules($rules);

    $numOfCorrectAnswers = 0;
    $numOfQuestions = count($questionsArr);

    foreach ($questionsArr as $questionItem) {
        $isRoundPassed = makeRound($questionItem['question'], $questionItem['answer']);

        if (!$isRoundPassed) {
            break;
        }

        $numOfCorrectAnswers++;
    }

    if ($numOfQuestions === $numOfCorrectAnswers) {
        showWinGame($name);
    } else {
        showLooseGame($name);
    }
}
