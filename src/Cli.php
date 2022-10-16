<?php

namespace BrainGames\Cli;

use function cli\line;
use function cli\prompt;

function getUserName(): string
{
    line('Welcome to the Brain Game!');
    return prompt('May I have your name?');
}

function greetUser(string $name)
{
    line("Hello, %s!", $name);
}
