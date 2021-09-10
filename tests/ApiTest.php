<?php

namespace FintechSystems\VirtualminApi\Tests;

use FintechSystems\VirtualminApi\VirtualminApi;
use Symfony\Component\Dotenv\Dotenv;

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

    /**
     * @test
     * @group live
     */
    public function it_retrieves_a_list_of_domains_on_a_live_server()
    {
        if (! $host = $this->getHostInformation()) {
            $this->assertTrue(true);

            return;
        }

        $api = new VirtualminApi($host, 'debug');

        $result = json_decode($api->listDomains());

        $this->assertEquals('success', $result->status);
    }

    /**
     * @test
     * @group live
     */
    public function it_retrieves_a_list_of_domains_on_a_live_server_and_saves_it_as_a_file()
    {
        if (! $host = $this->getHostInformation()) {
            $this->assertTrue(true);

            return;
        }

        $api = new VirtualminApi($host, 'write_cache');

        $result = json_decode($api->listDomains());

        $this->assertEquals('success', $result->status);
    }

    /** @test */
    public function it_can_retrieve_a_list_of_domains_from_a_list_domains_json_example_on_disk()
    {
        $file = file_get_contents('storage/list-domains.json');

        $result = json_decode($file);

        $this->assertEquals('success', $result->status);
    }

    /** @test */
    public function it_retrieves_a_cached_response_for_list_domains_from_the_virtualmin_api()
    {
        if (! $host = $this->getHostInformation()) {
            $this->assertTrue(true);

            return;
        }

        $api = new VirtualminApi($host, 'read_cache');

        $result = json_decode($api->listDomains());

        $this->assertEquals('success', $result->status);
    }

    /** @test */
    public function it_flattens_a_virtualmin_api_list_domains_command_and_returns_domains_ips_usernames_plans_and_statuses()
    {
        if (! $host = $this->getHostInformation()) {
            $this->assertTrue(true);

            return;
        }

        $api = new VirtualminApi($host, 'read_cache');

        $result = $api->getDomains();

        $this->assertCount(3, $result);
    }
}
