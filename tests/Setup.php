<?php

namespace FintechSystems\VirtualminApi\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

class Setup extends TestCase
{
    // public $host;

    // public function __construct() {
    //     $this->host = $this->getHostInformation();
    // }

    private function dotEnvExists()
    {
        $dotenv = new Dotenv();

        try {
            $dotenv->load(__DIR__.'/../.env');
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    protected function getServerInformation()
    {
        if (! $this->dotEnvExists()) {
            $this->assertTrue(true);

            return false;
        }

        $server = [
            'hostname' => env('VIRTUALMIN_HOSTNAME'),
            'username' => env('VIRTUALMIN_USERNAME'),
            'password' => env('VIRTUALMIN_PASSWORD'),
        ];

        if (! $server['hostname']) {
            return false;
        }

        return $server;
    }
}
