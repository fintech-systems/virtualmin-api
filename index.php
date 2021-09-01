<?php

use FintechSystems\VirtualminApi\Api;
use Mpociot\ChuckNorrisJokes\JokeFactory;

require 'vendor/autoload.php';

$factory = new JokeFactory();
$factory->hello();

$api = new Api;
$api->debug();