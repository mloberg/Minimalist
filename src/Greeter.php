<?php

namespace App;

class Greeter
{
    private $greetings = [
        'Hello',
        'Bonjour',
        'Hola',
        'Hallo',
        'Ciao',
        'Olá',
        'Privét',
        'Hej',
        'Namasté',
        'Shalóm',
    ];

    public function __invoke(string $subject): string
    {
        return sprintf('%s, %s', $this->greetings[array_rand($this->greetings)], $subject);
    }
}
