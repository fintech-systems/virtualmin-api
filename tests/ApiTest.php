<?php

namespace FintechSystems\VirtualminApi\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;
use FintechSystems\VirtualminApi\Tests\Setup;
use FintechSystems\VirtualminApi\VirtualminApi;

class ApiTest extends Setup
{
    /** @test */
    public function it_can_read_an_env_testing_file_and_assign_it_to_an_array()
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../.env.testing');

        $host = [
            'host'     => $_ENV['VIRTUALMIN_HOST'],
            'password' => $_ENV['VIRTUALMIN_PASSWORD'],
        ];

        $this->assertEquals('hostname.example.com', $host['host']);
    }

    /** @test */
    public function it_retrieves_a_list_of_domains_on_a_live_server()
    {
        if (!$host = $this->getHostInformation()) {
            $this->assertTrue(true);
            return;
        }

        $api = new VirtualminApi($host, 'debug');

        $result = $api->getDomains();

        $this->assertEquals('success', $result->status);

        ray($result);
    }

    /** @test */
    public function it_retrieves_a_list_of_domains_on_a_live_server_and_saves_it_as_a_file()
    {
        if (!$host = $this->getHostInformation()) {
            $this->assertTrue(true);
            return;
        }

        $api = new VirtualminApi($host, 'write_cache');

        $result = $api->getDomains();

        $this->assertEquals('success', $result->status);
    }

    /** @test */
    public function it_can_retrieve_a_list_of_domains_from_json_example_on_disk()
    {
        $file = file_get_contents('storage/list-domains.json');

        $result = json_decode($file);

        $this->assertEquals('success', $result->status);
    }

    /** @test */
    public function it_retrieves_a_cached_response_for_list_domains_from_the_virtualmin_api()
    {
        if (!$host = $this->getHostInformation()) {
            $this->assertTrue(true);
            return;
        }

        $api = new VirtualminApi($host, 'read_cache');

        $result = $api->getDomains();

        $this->assertEquals('success', $result->status);
    }
}
