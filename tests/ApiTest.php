<?php

namespace FintechSystems\VirtualminApi\Tests;

use FintechSystems\VirtualminApi\Api;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    /** @test */
    public function it_checks_if_the_debugger_is_working()
    {
        $api = new Api;
        $api->debug();
        $this->assertTrue(true);
    }
}
