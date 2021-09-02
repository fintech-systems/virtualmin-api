<?php

namespace FintechSystems\VirtualminApi\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;
use FintechSystems\VirtualminApi\Api;

class ApiTest extends TestCase
{
    /** @test */
    public function it_checks_if_the_api_is_instantiable()
    {
        $api = new Api();
        $result = $api->test();
        $this->assertEquals('The API was invoked.', $result);
    }

    /** @test */
    public function it_can_read_the_env_file_and_assign_it_to_an_array()
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../.env.test');
        
        $host = [
            'host'     => $_ENV['VIRTUALMIN_HOST'],
            'password' => $_ENV['VIRTUALMIN_PASSWORD'],
        ];
        
        $this->assertEquals('hostname.example.com', $host['host']);
    }

    /** @test */
    public function it_retrieves_a_list_of_domains_on_a_live_server() {
        $dotenv = new Dotenv();

        try {
            $dotenv->load(__DIR__ . '/../.env');
        } catch (Exception $e) {
            $this->assertTrue(true);
            return;
        }
                        
        $host = [
            'host'     => $_ENV['VIRTUALMIN_HOST'],
            'password' => $_ENV['VIRTUALMIN_PASSWORD'],
        ];

        if (!$host['host']) {
            $this->assertTrue(true);
            return;
        }
        
        $api = new Api($host, true);

        $result = $api->getDomains();

        $this->assertEquals('success', $result->status);

        ray($result);        
    }
}
