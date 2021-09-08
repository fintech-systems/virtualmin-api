<?php

namespace FintechSystems\VirtualminApi\Tests;

use Exception;
use FintechSystems\VirtualminApi\VirtualminApi;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

class Setup extends TestCase
{
    private function dotEnvExists()
    {
        $dotenv = new Dotenv();

        try {
            $dotenv->load(__DIR__ . '/../.env');
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    protected function getHostInformation()
    {
        if (!$this->dotEnvExists()) {
            $this->assertTrue(true);
            return false;
        }

        $host = [
            'host'     => $_ENV['VIRTUALMIN_HOST'],
            'password' => $_ENV['VIRTUALMIN_PASSWORD'],
        ];

        if (!$host['host']) {
            return false;
        }

        return $host;
    }
}
