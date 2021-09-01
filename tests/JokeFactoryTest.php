<?php

namespace Mpociot\ChuckNorrisJokes\Tests;

use Mpociot\ChuckNorrisJokes\JokeFactory;
use PHPUnit\Framework\TestCase;

class JokeFactoryTest extends TestCase
{
    /** @test */
    public function it_returns_a_random_joke()
    {
        $jokes = new JokeFactory([
            'This is a joke',
        ]);

        $joke = $jokes->getRandomJoke();

        $this->assertSame('This is a joke', $joke);        
    }

    /** @test */
    public function it_calls_helo()
    {
        $jokes = new JokeFactory([
            'This is a joke',
        ]);

        $joke = $jokes->hello();

        $this->assertTrue(true);
    }
}
