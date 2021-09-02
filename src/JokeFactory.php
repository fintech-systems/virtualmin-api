<?php

namespace Mpociot\ChuckNorrisJokes;

class JokeFactory
{
    protected $jokes = [
        'haha',
        'lol',
    ];

    public function __construct(array $jokes = null)
    {
        if ($jokes) {
            $this->jokes = $jokes;
        }
    }

    public function getRandomJoke()
    {
        return $this->jokes[array_rand($this->jokes)];
    }

    public function hello()
    {
        echo 'chuck norris joke goes here'.PHP_EOL;
    }
}
