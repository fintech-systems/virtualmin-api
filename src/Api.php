<?php

namespace FintechSystems\VirtualminApi;

class Api
{
    private $host;
    private $debug;

    private $quiet = '--quiet';

    public function __construct($host = null, $debug = false)
    {
        $this->debug = $debug;

        if ($this->debug == true) {
            $this->quiet = '';
        }

        if ($host != null) {
            $this->host = $host;
        }
    }

    public function getDomains()
    {
        return $this->listDomains();
    }

    private function listDomains()
    {
        $program = 'list-domains';

        return $this->runProgram($program);
    }

    private function runProgram($program)
    {
        $host = $this->host['host'];
        $username = $this->host['username'] ?? 'root';
        $password = $this->host['password'];
        $port = $this->host['port'] ?? '10000';

        $command = "wget -O - $this->quiet --http-user='$username' --http-passwd='$password' --no-check-certificate 'https://$host:$port/virtual-server/remote.cgi?json=1&multiline&program=$program'";

        $result = shell_exec(
            $command
        );

        return json_decode($result);
    }

    // Deprecated
    public function test()
    {
        return 'The API was invoked.';
    }
}
