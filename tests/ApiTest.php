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

        $hostname = [
            'hostname' => $_ENV['VIRTUALMIN_HOSTNAME'],
            'password' => $_ENV['VIRTUALMIN_PASSWORD'],
        ];

        $this->assertEquals('hostname.example.com', $hostname['hostname']);
    }

    /**
     * @test
     * @group live
     */
    public function it_retrieves_a_list_of_domains_on_a_live_server_and_shows_debugging_information()
    {
        if (! $server = $this->getServerInformation()) {
            $this->assertTrue(true);

            return;
        }

        $api = new VirtualminApi($server, 'debug');

        $result = json_decode($api->listDomains());

        $this->assertEquals('success', $result->status);
    }

    /**
     * @test
     * @group live
     */
    public function it_retrieves_a_list_of_domains_on_a_live_server_and_saves_it_as_a_file()
    {
        if (! $server = $this->getServerInformation()) {
            $this->assertTrue(true);

            return;
        }

        $api = new VirtualminApi($server, 'write_cache');

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
        if (! $server = $this->getServerInformation()) {
            $this->assertTrue(true);

            return;
        }

        $api = new VirtualminApi($server, 'read_cache');

        $result = json_decode($api->listDomains());

        $this->assertEquals('success', $result->status);
    }

    /** @test */
    public function it_flattens_a_virtualmin_api_list_domains_command_and_returns_domains_ips_usernames_plans_and_statuses()
    {
        if (! $server = $this->getServerInformation()) {
            $this->assertTrue(true);

            return;
        }

        $api = new VirtualminApi($server, 'read_cache');

        $result = $api->getDomains();

        $this->assertCount(6, $result);
    }

    /** @test */
    public function it_returns_all_plans_from_a_server_and_writes_them_to_disk()
    {
        if (! $server = $this->getServerInformation()) {
            $this->assertTrue(true);

            return;
        }

        $api = new VirtualminApi($server, 'write_cache');

        $result = json_decode($api->listPlans());

        $this->assertCount(2, $result->data);
    }

    /** @test */
    public function it_returns_virtualmin_plans_in_an_user_friendly_format()
    {
        if (! $server = $this->getServerInformation()) {
            $this->assertTrue(true);

            return;
        }

        $api = new VirtualminApi($server, 'read_cache');

        $result = $api->getPlans();

        // dd($result);

        $this->assertCount(2, $result);
    }
}
